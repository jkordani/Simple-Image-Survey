<?php
require_once('config.php');
require_once('helpers.php');
session_start();
	#check for session state
	#if state is blank redirect to index
	if(!isset($_SESSION['state'])){
		header('Location: index.php');
	}
	#if state is training,
	#initialize question array to the first 10 images
	#while there are still images in the array
	#pop one off display it below
	if($_SESSION['state'] == 'training_start'){
		$_SESSION['question_array'] = $g_training_array;
		$_SESSION['state'] = 'training';
	}

	#if state is start
	if($_SESSION['state'] == 'start'){

	        	
		#check for submission of age and gender
		if( isset($_SESSION['age']) && isset($_SESSION['gender'])){
			$mysqli = new mysqli($g_db_hostname, $g_db_username, $g_db_password, $g_db_dbname);
			if ($mysqli->connect_error) {
				die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
			}

		 	#submit to database
			$stmt = $mysqli->prepare("INSERT into users (age, gender, survey_name) VALUES (?,?,?)");
			$stmt->bind_param( "iss",
					   $_SESSION['age'],
					   $_SESSION['gender'],
					   $g_current_survey
					 );
			$stmt->execute();

		 	#fetch last id
		 	#set session user id
			$_SESSION['user_id'] = $mysqli->insert_id;

		 	#initialize survey numbering stack/list/array
		 	$_SESSION['question_array'] = init_survey($g_current_survey); 

 		}
		else{ #either age or gender wasn't passed, or age is blank or not a number'
			header('Location: index.php');
		}
		$_SESSION['state'] = 'live';
	}

     	#if question has been answered, submit it.
	if(isset($_POST['answer']) && $_SESSION['state'] == 'live'){
		$mysqli = new mysqli($g_db_hostname, $g_db_username, $g_db_password, $g_db_dbname);
		if ($mysqli->connect_error) {
			die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
		}
		$stmt = $mysqli->prepare("INSERT into results (picture_id, user_id, answer) VALUES (?,?,?)");
		$stmt->bind_param("iii", $_POST['pic_num'], $_SESSION['user_id'], $_POST['answer']);
                #The above statememnt is poor form.
		#answer is an enum column of 0 through 7, so I am passing in an index, not a value.
		#the mysql documentation outlines this
		#this is an accident and I intend to fix it.

		$stmt->execute();
	}
	#set the base image directory, if training then images_training, if live then images_live
	if($_SESSION['state'] == 'training'){
		$img_folder = $g_training_images_folder;
	}
	elseif($_SESSION['state'] == 'live'){
		$img_folder = $g_current_survey;
	}
	
     	#pop next question number
	$current_question_filename = array_shift($_SESSION['question_array']);
	if(isset($current_question_filename)){
		$info = pathinfo($current_question_filename);
		$current_question_number = (int) basename($current_question_filename,'.'.$info['extension']);
	}
	#if there are no more questions, and we're training, go to training_complete, else go to finish.'
	if(!isset($current_question_filename)){ 
		if($_SESSION['state'] == 'training'){
		        header('Location: training_complete.php');
		}
		if($_SESSION['state'] == 'live'){
			$_SESSION['state'] = 'finish';
		}
	}
		
	if($_SESSION['state'] == 'finish'){
		header('Location: finish.php');
	}

?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<link rel="stylesheet" href="css/survey.css" type="text/css" media="screen">
<script type="text/javascript">
function clickHandle(buttonNum){
    disableButtons(true);
    document.forms['survey'].answer.value = buttonNum;
    document.forms['survey'].submit();
}

function disableButtons(truefalse) {
    //var number = document.forms['survey'].answer;
    var buttons = document.getElementsByClassName('surveybutton');
    for(var i=0; i<buttons.length; i++){
	buttons[i].disabled = truefalse;
    }
}

window.onload = function() {
   var image = document.getElementById('survey_image');
   if(!image.complete){
       var refresh = window.setTimeout('function\(\)', 100);
   }
   else{
       window.setTimeout('enableButtons\(true\)', <?php echo $g_button_disable_time_ms;?>); 
       window.setTimeout('document.forms[\'survey\'].submit\(\)', 5000);
   }

}

</script>
</head>
<body>
<div id="Content">
<div id="survey">
     <?php #print_r($_SESSION['question_array']);?>
     <?php #echo "The current survey is " . $g_current_survey . '.';?>
     <?php #echo $current_question_filename;?>
     <img id="survey_image" src="<?php echo $img_folder . '/' . $current_question_filename;?>" /> 
     <div id="controls_and_anchors">
     <div id="controls">
          <form id="survey" method="post" action="start.php">
 	  <input type="hidden" name="answer" value='0' />
	  <input type="hidden" name="pic_num" value="<?php echo $current_question_number;?>" />
	  <button type="button" class="surveybutton" onclick="clickHandle(1)" disabled="true">1</button>
	  <button type="button" class="surveybutton" onclick="clickHandle(2)" disabled="true">2</button>
	  <button type="button" class="surveybutton" onclick="clickHandle(3)" disabled="true">3</button>
	  <button type="button" class="surveybutton" onclick="clickHandle(4)" disabled="true">4</button>
	  <button type="button" class="surveybutton" onclick="clickHandle(5)" disabled="true">5</button>
          <button type="button" class="surveybutton" onclick="clickHandle(6)" disabled="true">6</button>
	  <button type="button" class="surveybutton" onclick="clickHandle(7)" disabled="true">7</button>
	  </form>
      </div>
      <div id="anchors">
           <div id="anchor_left">NOT AT ALL<br />ATTRIBUTE</div>
	   <div id="anchor_right">VERY<br />ATTRIBUTE</div>
	   <a id="quit" href="index.php">QUIT</a>
      </div>
      </div>
</div>
</div>
</body>
</html>

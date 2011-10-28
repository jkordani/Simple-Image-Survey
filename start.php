<?php
require_once('config.php');
#require_once('helpers.php');
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
		$_SESSION['question_array'] = array(1,2,3,4,5,6);
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
			$stmt = $mysqli->prepare("INSERT into users (age, gender) VALUES (?,?)");
			$stmt->bind_param("is", $_SESSION['age'], $_SESSION['gender']);
			$stmt->execute();

		 	#fetch last id
		 	#set session user id
			$_SESSION['user_id'] = $mysqli->insert_id;

		 	#initialize survey numbering stack/list/array
		 	#$questions = init_survey(); this checks for ordering file, if exist read in, otherwise make and then read in.
			$_SESSION['question_array'] = array(1,2,3,4,5,6);

 		}
		else{ #either age or gender wasn't passed, or age is blank or not a number
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
		$stmt->execute();
	}

     	#pop next question number
	$current_question = array_shift($_SESSION['question_array']);

	#if there are no more questions, and we're training, go to training_complete, else go to finish.
	if(!isset($current_question)){ 
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
<script type="text/javascript">
window.onload = function() {

   var image = document.getElementById('survey_image');
   if(!image.complete){
	window.setTimeout('function\(\)', 100);
   }
   else{
	window.setTimeout('document.forms[\'survey\'].submit\(\)', 5000);
   }

}

</script>
<style type="text/css">

button.surveybutton
{
   width:13.8%;
   height:50px;
}

#survey {
  position:relative;
  width:600px;
}
#anchor_left {
  float:left;
}
#anchor_right {
  float:right;
}

</style>

</head>
<body>
<?php echo $_SESSION['state']; echo $current_question;?>
<div id="survey">
<img id="survey_image" src="./images/<?php echo $current_question . ".jpg";?>" /> 
<form id="survey" method="post" action="start.php">
 <input type="hidden" name="answer" value="0" />
 <input type="hidden" name="pic_num" value="<?php echo $current_question;?>" />
 <button type="submit" name="answer" class="surveybutton" value="1">1</button>
 <button type="submit" name="answer" class="surveybutton" value="2">2</button>
 <button type="submit" name="answer" class="surveybutton" value="3">3</button>
 <button type="submit" name="answer" class="surveybutton" value="4">4</button>
 <button type="submit" name="answer" class="surveybutton" value="5">5</button>
 <button type="submit" name="answer" class="surveybutton" value="6">6</button>
 <button type="submit" name="answer" class="surveybutton" value="7">7</button>

</form>

<div id="anchor_left">NOT AT ALL<br />ATTRIBUTE</div>
<div id="anchor_right">VERY <br />ATTRIBUTE</div>
</div>
</body>
</html>
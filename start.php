<?php
require_once('config.php');
session_start();
	#check for session state
	#if state is blank redirect to index
	if(!isset($_SESSION['state'])){
		header('Location: index.php');
	}
	
	#if state is start
	if($_SESSION['state'] == 'start'){
		#check for submission of age and gender
		if( isset($_POST['age']) && $_POST['age'] != '' && is_numeric($_POST['age']) && isset($_POST['gender'])){
			$mysqli = new mysqli($g_db_hostname, $g_db_username, $g_db_password, $g_db_dbname);
			if ($mysqli->connect_error) {
				die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
			}
			#submit to database
			$stmt = $mysqli->prepare("INSERT into users (age, gender) VALUES (?,?)");
			$stmt->bind_param("is", $_POST['age'], $_POST['gender']);
			$stmt->execute();
			#fetch last id
			#set session user id
			$_SESSION['user_id'] = $mysqli->insert_id;
			#initialize survey numbering stack/list/array
			#$questions = init_survey(); this checks for ordering file, if exist read in, otherwise make and then read in.
			$_SESSION['question_array'] = array(1,2,3,4,5,6);
			#set state to number of first quiz
			$current_question = array_shift($_SESSION['question_array']);
			if(!isset($current_question)){ #if there are no more questions
				$_SESSION['state'] = 'finish';
			}
			else{
				$_SESSION['state'] = $current_question;
			}
			header('Location: start.php');
		}
		else{ #either age or gender wasn't passed, or age is blank or not a number
			header('Location: index.php');
		}
	}
	#else if state is a number
	elseif(is_numeric($_SESSION['state'])){
	     #if question has been answered
		 if(isset($_POST['answer'])){
			$mysqli = new mysqli($g_db_hostname, $g_db_username, $g_db_password, $g_db_dbname);
			if ($mysqli->connect_error) {
				die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
			}
			$stmt = $mysqli->prepare("INSERT into results (picture_id, user_id, answer) VALUES (?,?,?)");
			$stmt->bind_param("iii", $_SESSION['state'], $_SESSION['user_id'], $_POST['answer']);
			$stmt->execute();

	     	#submit the answer
	     	#pop next question number
			$current_question = array_shift($_SESSION['question_array']);
			if(!isset($current_question)){ #if there are no more questions
				$_SESSION['state'] = 'finish';
			}
			else{
				$_SESSION['state'] = $current_question;
			}
			header('Location: start.php');
		}
		#else question has not been answered
		
	     	   #then we are starting our quiz and display it below
			   #do nothing...?
		 
	}
	#if state is null, indicating that there are no more questions
	if($_SESSION['state'] == 'finish'){
		header('Location: finish.php');
	}
?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<body>
<img onload="window.alert('welcome to my home page!');" src="./images/<?php echo $_SESSION['state'] . ".jpg";?>" /> 
<form id='survey' method='post' action='start.php'>
<!-- <input type="hidden" name="redirect" value="start.php" /> -->
 <label for="low">Not Very</label> <input type="radio" id="low" name="answer" value="1" />
 <input type="radio" name="answer" value="2" />
 <input type="radio" name="answer" value="3" />
 <input type="radio" name="answer" value="4" />
 <input type="radio" name="answer" value="5" />
 <input type="radio" name="answer" value="6" />
 <input type="radio" id="high" name="answer" value="7" />
 <label for ="high">Very</label>

 <input type="submit" value="Submit" />
</body>
</html>
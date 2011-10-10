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
			#$questions = init_survey();
			$questions = array(1,2,3,4,5,6);
			#set state to number of first quiz
			$_SESSION['state'] = array_pop($questions);
			#redirect here
		}
		else{ #either age or gender wasn't passed, or age is blank or not a number
			header('Location: index.php');
		}
	}
	#else if state is a number
	else if(is_numeric($_SESSION['state']){
	     #if question has been answered
	     	 #submit the answer
	     	 #pop next question number
	     	 #the page will load with the proper info for the form below
	     
	     #else if question has not been answered
	     	   #then we are starting our quiz and display it below
		   #do nothing here
	}
	#if state is null, indicating that there are no more questions
	#redirect to finish.php
	if( $_SESSION['state'] == 






	#submit to this form?

?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<body>
The user's age is <?php echo $_POST['age']?> 
and gender is <?php echo $_POST['gender']?> 
and db id is <?php echo $_SESSION['user_id']?>
</body>
</html>
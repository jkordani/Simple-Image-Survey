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
		if(isset($_POST['age']) && isset($_POST['gender'])){
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
			#set state to number of first quiz
			#redirect here
		}
	}
	#else if state is a number
		#display image survey form using state number


	#submit to this form?


?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<body>
The user's age is <?php echo $_POST['age']?> 
and gender is <?php echo $_POST['gender']?> 
and db id is <?php echo $_SESSION['user_id']?>!
</body>
</html>
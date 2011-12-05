<?php
require_once('config.php');
require_once('helpers.php');
if(isset($_POST['export'])){
	#create 3 csv files in the reports directory
	#assume 200 survey questions, assume that images repeat at 101
	$mysqli = new mysqli($g_db_hostname, $g_db_username, $g_db_password, $g_db_dbname);
			if ($mysqli->connect_error) {
				die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
			}
	$mysqli2 = new mysqli($g_db_hostname, $g_db_username, $g_db_password, $g_db_dbname);
			if ($mysqli->connect_error) {
				die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
			}
			
foreach ($g_survey_array as $survey){
  $survey_fh = fopen("$survey.csv", "w+");
  #get list of users for that survey
  $stmt = $mysqli->prepare("SELECT id, age, gender FROM users WHERE survey_name = (?)");
  $stmt->bind_param("s",
	            $survey
		   );
  $stmt->execute();
  $stmt->bind_result($user_id,$user_age,$user_gender);
  #for each user in the survey
  while($stmt->fetch()){
    $output = array();
    #get a list of questions that user submitted, ordered by question number,
    $stmt2 = $mysqli2->prepare("SELECT picture_id, answer FROM results WHERE user_id=? ORDER BY picture_id");
    $stmt2->bind_param("i",$user_id);
    $stmt2->execute();
    $stmt2->bind_result($picture_id,$answer);
    while($stmt2->fetch()){
       if ($answer != ""){
       	  $answer+=1; //if the answer is not blank, assume its a number and increment it
       }
       $output[$picture_id] = $answer;
       
    }
    #all submitted results have been captured,
    #now I need to process the array to handle questions that weren't seen by the database
    #e.g. user quit early, or a question got skipped somehow.
    #also, if any one of a pair of answers was blank or not submitted, set its pair to blank as well
    #Assuming 200 questions
    for($i = 1; $i <= 200; $i++){
    	   if(!isset($output[$i]) || $output[$i] == ""){
	      $output[$i] = "";
	      $output[(($i - 1 + 100) % 200) + 1] = "";
	   }
    }
    #print strings of user demographics to survey file
    ksort($output);
    fputs($survey_fh, "$user_id, $user_age, $user_gender," . implode(",",$output) . "\n");
  }
  fclose($survey_fh);
}
}

?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<title>Data Export</title>
</head>
<body>
Click this to export your surveys into individual csv files
<form id="export-survey" method="post" action="export.php">
  <input type="submit" name="export" value="Export" />
</form>
</body>
</html>

<?php
require_once('config.php');
require_once('helpers.php');
if(isset($_POST['survey_title'])){
   set_string_to_file($_POST['survey_title'],$g_current_survey_file);
}

$current_survey = get_string_from_file($g_current_survey_file);
if(!isset($current_survey) || $current_survey == ''){
        $temp_survey_array = $g_survey_array;
	$current_survey = array_shift($temp_survey_array);
	set_string_to_file($current_survey, $g_current_survey_file);
}

?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<title>Administration</title>
</head>
<body>
Pick the name of the survey here.
<form id="generate-survey" method="post" action="admin.php">
 <select name="survey_title">
    <?php foreach($g_survey_array as $survey_dir){
	      echo "<option>" . $survey_dir . "</option>\n";
	  }
    ?>
 </select>
 <input type="submit" value="Set" />
</form>
The current survey is <?php echo $current_survey;?>
</body>
</html>

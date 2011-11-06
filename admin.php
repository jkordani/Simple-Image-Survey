<?php
require_once('config.php');
require_once('helpers.php');
if(isset($_POST['survey_title'])){
   set_string_to_file($_POST['survey_title'],$g_current_survey_file);
}
$current_survey = get_string_from_file($g_current_survey_file);
?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<title>Administration</title>
</head>
<body>
Pick the name of the survey here.  In the future there will be a drop down of already enumerated.
<form id="generate-survey" method="post" action="admin.php">
 <input type="text" name="survey_title" />
 <input type="submit" value="Set" />
</form>
The current survey is <?php echo ($current_survey == '') ? "blank" : $current_survey;?>
</body>
</html>

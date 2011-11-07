<?php
require_once('config.php');
require_once('helpers.php');



?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<title>Cache charge</title>
</head>
<body>
<?php
foreach($g_survey_array as $survey){
	$imagelist = init_survey($survey);
	foreach($imagelist as $image){
		echo '<img src="' . $survey . '/' . $image .'" />'; 
	}
}
?>
</body>
</html>

<?php
session_start();
$_SESSION['state'] = 'start';
?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
	<title>Emotional Eye Study Training</title>

</head>

<body>

<h3>ATTRIBUTE Study Training</h3>
<p>Training is complete. Nicely done!</p>

<p>It is time to begin the study.</p>



<p>Remember</p>

<p>THERE ARE NO RIGHT OR WRONG ANSWERS. YOUR FIRST IMPRESSION IS THE BEST ONE.</p>

<p>ONCE THE STUDY HAS STARTED, YOU CANNOT PAUSE OR GO BACK.</p>

<p>If you have any remaining questions, please ask the research assistant
now. If not, you can begin by clicking on the START button.</p>

<FORM NAME="training_done" ACTION="start.php" METHOD="POST">
<input type="submit" value="Start">
</FORM>


</html>

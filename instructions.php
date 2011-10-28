<?php
session_start();
if( isset($_POST['age']) && $_POST['age'] != '' && is_numeric($_POST['age']) && isset($_POST['gender'])){
    $_SESSION['age'] = $_POST['age'];
    $_SESSION['gender'] = $_POST['gender'];
}
else{
    header('Location: index.php');
}
?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<body>
<h1> Attribute Study!</h1>
<p>Your task is to FILL IN THE BLANK . There are no right or wrong answers in the study. The entire survey will take about 20 minutes.</p>

<p>During the study, you will be viewing images of people on this computer screen. Each image will be visible for about 5 seconds, then another image will automatically appear.</p>

<p>You will rate the ATTRIBUTE of each image by using the following rating scale that will appear on the screen beneath each image.</p>

<p>You will use the mouse to enter your rating by clicking on the number that corresponds to the rating of your choice.</p>

1----------2----------3----------4----------5----------6----------7
NOT OLD	 	EXTREMELY
AT ALL 	 	OLD
<p>Be sure that you point the cursor to a number, not the spaces in between.</p>

<p>Your rating will be highlighted when your response has been correctly entered.</p>

<p>If you miss the opportunity to rate an image for any reason, don't worry about it. Just continue on to the next image.</p>

<p>You cannot pause or go back and change a rating once a new image appears.</p>

<p>You are now ready to participate in a brief training session. As in the survey, an image will appear on the screen for about 5-seconds and you will enter your rating by clicking on the number that corresponds to the rating of your choice.</p>

<p>The training session will begin when you click on the START button.</p>
<form id="start_survey" method="post" action="start.php">
<input type ="submit" value="Start" />
</form>
</body>
</html>
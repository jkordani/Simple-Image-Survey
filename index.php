<?php
session_start();
$_SESSION['state']='training_start';
?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<link rel="stylesheet" href="css/survey.css" type="text/css" media="screen">
<title>Emotional Eye Start Page</title>
</head>
<body>
<div id="Content">
<div id="banner">
Emotional Eye Study
</div>
<div id="instructions">
Please fill out the form below
</div>
<div id="login">
<p>Please enter your age and gender.</p>
<form id="new-user" action="instructions.php" method="post">
 <label for="age">Age:</label>
 <input type="text" id="age" name="age" maxlength="2"/>
 <label for="male-gender">Male</label>
 <input type="radio" id="male-gender" name="gender" value="male" />
 <label for="female-gender">Female</label>
 <input type="radio" id="female-gender" name="gender" value="female" />
 <input type="submit" value="Start" />
</form>
</div>
</div>
</body>
</html>
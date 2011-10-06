<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<title>Survey Start Page</title>
</head>
<body>
<div id="banner">
A Banner
</div>
<div id="instructions">
Fill out the form below
</div>
<div id="login">
<p> Results of the form</p>
<?php
echo 'The age is ' . $_POST['age'] . ' and the gender is ' . $_POST['gender'];
?>
</form>
</div>
</body>
</html>
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
<p> A form will be here. </p>
<form id="new-user" action="start.php" method="post">
 <input type="hidden" name="redirect" value="start.php" />
 <label for="age">Age:</label>
 <input type="text" id="age" name="age" maxlength="2"/>
 <label for="male-gender">Male</label>
 <input type="radio" id="male-gender" name="gender" value="male" />
 <label for="female-gender">Female</label>
 <input type="radio" id="female-gender" name="gender" value="female" />
 <input type="submit" value="Start" />
</form>
</div>
</body>
</html>
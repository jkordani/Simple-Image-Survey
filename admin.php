<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<title>Administration</title>
</head>
<body>
This will read in all images in the folder "survey-images" into the database and create a random ordering file
<form id="generate-survey" method="post" action="initialize.php">
 <input type="hidden" name="redirect" value="admin.php" />
 <input type="submit" value="Initialize" />
</form>
After the images are read in, use this button to tag images with desired research attributes
</body>
</html>
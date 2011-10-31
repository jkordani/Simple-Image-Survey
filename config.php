<?php
	#globals section
	$g_db_username = 'sis';
	$g_db_password = 'jessica';
	$g_db_dbname = 'test';


	#Note, there is no restriction to the names these images can take.
	#The order they will appear will be from top to bottom
	#The below are examples.  Modify them to suit your needs
	$g_training_array = array( "t_one.jpg",
			    	   "t_two.jpg",
				   "t_three.jpg",
				   "t_four.jpg",
				   "t_five.jpg",
				   "t_six.jpg"   #note this item doesn't get a trailing comma
				 );

	#MODIFY THE BELOW ITEMS AT YOUR OWN PERIL
	$g_db_hostname = 'localhost';
	$g_training_images_folder = 'images_training';

	#these images must be named with a number e.g. '1.jpg' '2.bmp'.  Their extension is immaterial.
	$g_live_images_folder = 'images_live';


?>
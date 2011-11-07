<?php
require_once('helpers.php');

	#globals section
	$g_db_username = 'root';
	$g_db_password = 'root';
	$g_db_dbname = 'test';


	#Note, there is no restriction to the names these images can take.
	#The order they will appear will be from top to bottom
	#The below are examples.  Modify them to suit your needs
	$g_training_array = array( "t_one.jpg",
			    	   "t_two.jpg",
				   "t_three.jpg",
				   "t_four.jpg",
				   "t_five.jpg",
				   "t_six.jpg"   #note this last item doesn't get a trailing comma'
				 );

	#MODIFY THE BELOW ITEMS AT YOUR OWN PERIL
	$g_db_hostname = 'localhost';
	$g_training_images_folder = 'images_training';

	$g_current_survey_file = 'survey';

	#Array of survey image directories
	$g_survey_array = array( "Attractiveness_red",
			  	 "Attractiveness_white",
				 "Attractiveness_yellow" #note the last item doesn't get a trailing comma
			       );

	$g_current_survey = get_string_from_file($g_current_survey_file);
	if(!isset($g_current_survey) || $g_current_survey == ''){
        	$temp_survey_array = $g_survey_array;
		$current_survey = array_shift($temp_survey_array);
		set_string_to_file($g_current_survey, $g_current_survey_file);
	}



?>
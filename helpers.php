<?php
function init_survey($images_directory){
	# #if ordering file exists, read it in and return it
	# if(file_exists('ordering')){
	#	$ordering_fh = fopen("ordering","r");
	#	$ordering_sstring = fgets($ordering_fh);
	#	fclose($ordering_fh);
	#	return unserialize($ordering_sstring);
	#
	# }
	##else read in a list of files from the array, mod it, store it
	#else{
		$ordering_array = scandir($images_directory);

		#do this twice to get rid of . and .. from listing.
		array_shift($ordering_array);
		array_shift($ordering_array);

		#do this to remove the thumbs file from the listing if present
		$thumbs = array_search("Thumbs.db", $ordering_array);
		if($thumbs !== FALSE){
			   unset($ordering_array[$thumbs]);
		}

	#	shuffle($ordering_array);
	#	$ordering_fh = fopen("ordering","w+");
	#	$ordering_sstring = serialize($ordering_array);
	#	fputs($ordering_fh, $ordering_sstring);
	#	fclose($ordering_fh);
		return $ordering_array;
	#}

}

function get_string_from_file($filename){
	 if(!file_exists($filename)){
		return '';
	}
	$file_h = fopen($filename,"r");
	$survey = fgets($file_h);
	fclose($file_h);
	return $survey;
}

function set_string_to_file($string, $filename){
	$file_h = fopen($filename, "w+");
	fputs($file_h, $string);
	fclose($file_h);
}

#$sstring =  get_string_from_file('test');
#echo "There should be nothing in between the braces (" . $sstring . ")\n";
#printf("%s", $sstring);
#echo "Sending test string to file.\n"; set_string_to_file('teststring', 'test');
#echo "There should be the word teststring between the braces (" . get_string_from_file('test') . ")";

#$arrays = init_survey('images_live');
#print_r($arrays);
#print_r(unserialize(serialize($arrays)));

#$ordering_fh = fopen("ordering","w+");
#$ordering_sstring = serialize($arrays);
#fputs($ordering_fh, $ordering_sstring);
#fclose($ordering_fh);

#$ordering_fh = fopen("ordering","r");
#$ordering_sstring2 = fgets($ordering_fh);
#fclose($ordering_fh);
#echo $ordering_sstring2;
#print_r(unserialize($ordering_sstring2));


?>
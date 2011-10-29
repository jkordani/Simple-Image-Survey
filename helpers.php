<?php
function init_survey(){
	 #if ordering file exists, read it in and return it
	 if(file_exists('ordering')){
		$ordering_fh = fopen("ordering","r");
		$ordering_sstring = fgets($ordering_fh);
		fclose($ordering_fh);
		return unserialize($ordering_sstring);

	 }
	 #else read in a list of files from the array, mod it, store it
	 else{
		$ordering_array = scandir('images');
		#do this twice to get rid of . and .. from listing.
		array_shift($ordering_array);
		array_shift($ordering_array);
		shuffle($ordering_array);
		$ordering_fh = fopen("ordering","w+");
		$ordering_sstring = serialize($ordering_array);
		fputs($ordering_fh, $ordering_sstring);
		fclose($ordering_fh);
	 	return $ordering_array;
	 }

}
#$arrays = init_survey();
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
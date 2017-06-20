<?php

function convertUTC2TimeStamp($time_utc){
	//convert UTC time with milisecond to a Year-month-day hour-minite-second.milisecond format
	$time_origin = (string)$time_utc;
	$time_utc = substr($time_origin,0,10);
	$mili_sec = substr($time_origin,10,13);
	return date("Y-m-d H:i:s",(int)$time_utc).'.'.$mili_sec;
}

function checkFileIsSettedValue($file_name, $setted_value){
	// check the first character in the file is or not equal to the setted string value
	$content = file_get_contents($file_name);
	if(strlen($content)==0){
		return false;
	}else if(substr($content,0,1)==$setted_value){
		return true;
	}else{
		return false;
	}
}

function writeFileWithValue($file_name, $value){
	// write file with value
	$file = fopen($file_name, "w") or die("Unable to open file!");
	fwrite($file, $value);
	fclose($file);
}

?>
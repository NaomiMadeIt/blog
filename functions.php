<?php

//a function to convert ugly timestamps to human friendly dates
function convertTimestamp( $ugly ){
	$date = new DateTime( $ugly );
	return $date->format('l, F jS, Y');
}

//a function to convert ugly timestamps to human friendly dates
function convertTimeRSS( $ugly ){
	$date = new DateTime( $ugly );
	return $date->format('r');
}

//clean any input string
function clean_string( $untrusted ){
	global $db;
	return mysqli_real_escape_string($db, filter_var( $untrusted , FILTER_SANITIZE_STRING ));
}
function clean_integer( $untrusted ){
	global $db;
	return mysqli_real_escape_string($db, filter_var( $untrusted , FILTER_SANITIZE_NUMBER_INT ));
}
function clean_email( $untrusted ){
	global $db;
	return mysqli_real_escape_string($db, filter_var( $untrusted , FILTER_SANITIZE_EMAIL ));
}
function clean_url( $untrusted ){
	global $db;
	return mysqli_real_escape_string($db, filter_var( $untrusted , FILTER_SANITIZE_URL ));
}


//no close PHP here

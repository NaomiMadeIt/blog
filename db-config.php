<?php
$host 		= 'localhost';
$username = 'naomi_blog';
$password = 'SftaeE52AtKTxCAd';
$database = 'naomi_blog';

//connect to database
$db = new mysqli( $host, $username, $password, $database );

//check to make sure it worked
if( $db->connect_errno > 0 ){
	die( 'Cannot connect to Database. Try again later.' );
}

//salt for making our passwords stronger. Keep salts a secret!
define('SALT', 'ldsjflajlfkj@suajldf$$$$$ha7fjs()DSFSJKELFiejafji*$91113344osi7jaesa!FS(1i#a#flndfdksdfjaaakfj');

<?php
error_reporting( E_ALL & ~E_NOTICE );
//security check! If the user does not have a valid key, send them back to the login form
$user_id = $_SESSION['user_id'];
$security_key = $_SESSION['security_key'];
$query = "SELECT *
					FROM users
					WHERE user_id = $user_id
					AND security_key = '$security_key'
					LIMIT 1";
$result = $db->query($query);
if( !$result ){
	header('Location:../login.php');
}

if( $result->num_rows == 1 ){
	//this person is allowed into the admin panel
	$row = $result->fetch_assoc();
	define('USERNAME', $row['username']);
	define('IS_ADMIN', $row['is_admin']);
	define('USER_ID', $row['user_id']);
}else{
	echo 'no rows';
	header('Location:../login.php');
}
?>
<!doctype html>
<html>
<head>
	<title>Admin Panel</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css">
	<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,700' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" type="text/css" href="css/admin-style.css">
</head>
<body>
	<header role="banner">
  <h1>Admin Panel</h1>
  <ul class="utilities">
    <li class="users"><a href="#">Logged in as: <?php echo USERNAME; ?></a></li>
		<li class="blog"><a href="../">Back to Blog</a></li>
    <li class="logout warn"><a href="../login.php?action=logout">Log Out</a></li>
  </ul>
</header>

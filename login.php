<?php require('login_parser.php'); ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Login to your account</title>
  <link rel="stylesheet" type="text/css" href="admin/css/admin-style.css">
</head>
<body class="login">
  <!-- <pre>
    <?php
    //lets just look at the post array
    print_r($_POST); ?>
  </pre> -->

  <h1>Log In to Your Account</h1>

  <?php
  echo $feedback;
  ?>

  <form method="post" action="login.php">
 
    <label for="the_username">Username</label>
    <input type="text" name="username" id="the_username">

    <label for="the_password">Password</label>
    <input type="password" name="password" id="the_password">

    <input type="submit" value="Log In">

    <input type="hidden" name="did_login" value="true">
  </form>
</body>
</html>

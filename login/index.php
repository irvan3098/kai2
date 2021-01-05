<?php session_start(); ?>
<!DOCTYPE html>
<html >
  <head>
    <meta charset="UTF-8">
    <title>Flat Login Form 3.0</title>
    <?php //include("../../cek.php"); ?>
    <?php  include("func_login.php");?>
    <link rel="stylesheet" href="#">
	<link rel="stylesheet" href="css/css.css">
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<link rel="stylesheet" href="css/style.css">
 </head>
  <body>

    
<!-- Form Mixin-->
<!-- Input Mixin-->
<!-- Button Mixin-->
<!-- Pen Title-->
<div class="pen-title">
  <h1>Flat Login Form</h1><span>Pen <i class="fa fa-paint-brush"></i> + <i class="fa fa-code"></i> by <a href="#">Andy Tran</a></span>
</div>
<!-- Form Module-->
<div class="module form-module">
  <div class="toggle"><i class="fa fa-times fa-pencil"></i>
    <div class="tooltip">Click Me</div>
  </div>
  <div class="form">
    <h2>Login to your account</h2>
    <form name="login" method="post">
      <input type="text" placeholder="Email" name="user"/>
      <input type="password" placeholder="Password" name="pass"/>
      <input type="submit" name="login" value="login" class="btn"/>
    </form>
    <?php cek_login();?>
  </div>
  <div class="form">
    <h2>Create an account</h2>
    <form>
      <input type="text" placeholder="Username"/>
      <input type="password" placeholder="Password"/>
      <input type="email" placeholder="Email Address"/>
      <input type="tel" placeholder="Phone Number"/>
      <input type="submit" name="login" value="login" class="btn"/>
    </form>
  </div>
</div>
    <script src="js/jquery.min.js"></script>
<script src="js/vLmRVp.js"></script>

        <script src="js/index.js"></script>

    
    
    
  </body>
</html>

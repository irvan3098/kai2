<?php
session_start(); 
include("login/func_login.php");
?>
<!DOCTYPE html>
<html >
  <head>
    <meta charset="UTF-8">
    <title>Material logistik</title>
    <link rel="stylesheet" href="#">
	<link rel="stylesheet" href="login/css/css.css">
	<link rel="stylesheet" href="login/css/font-awesome.min.css">
	<link rel="stylesheet" href="login/css/style.css">
    <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.css">
 </head>
  <body>

    
<!-- Form Mixin-->
<!-- Input Mixin-->
<!-- Button Mixin-->
<!-- Pen Title-->
<div class="pen-title">
  <h1>Material logistik</h1>
  <p>PT. KERETA API INDONESIA(PERSERO)</p>
</div>
<!-- Form Module-->
<div class="module form-module">
  <div class="toggle">
  </div>
  <div class="form">
    <h2>Login to your account</h2>
    <form name="login" method="post">
      <input type="number" placeholder="Nip" name="nip"/>
      <input type="password" placeholder="Password" name="pass"/>
      <input type="submit" name="login" value="login" class="btn"/>
    </form>
    <?php cek_login(); ?>
  </div>
</div>
<script src="login/js/jquery.min.js"></script>
<script src="login/js/vLmRVp.js"></script>
<script src="login/js/index.js"></script>
</body>
</html>

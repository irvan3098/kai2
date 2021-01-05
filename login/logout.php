<?php
	session_start();
	unset($_SESSION['namauser'],$_SESSION['namamember'],$_SESSION['sudahloginmember'],$_SESSION['loginterakhir'],$_SESSION['level']);
	header("Location: ../index.php");
?>
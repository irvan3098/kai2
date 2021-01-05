<?php
	session_start();
	error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
	include("../../../conn.php");
	$link =koneksi();
	$id=(int)$_GET['id'];
	$matauang=$_GET["nama"];
	$sql="delete from mata_uang where id_matauang = '$id'";
	$res=mysqli_query($link,$sql);
	if(isset($res))
	{
		echo "<script>window.location = '../index.php'; </script>";
	}
	
?>
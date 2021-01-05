<?php
	session_start();
	error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
	include("../../../conn.php");
	$link =koneksi();
	$id=(int)$_GET['id'];
	$namadata=$_GET["nama"];
	$sql="delete from vendor where id_vendor = '$id'";
	$res=mysqli_query($link,$sql);
	if(isset($res))
	{
		echo "<script>window.location = '../index.php'; </script>";
	}else
	{
		echo "gagal";
	}
	
?>
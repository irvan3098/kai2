<?php
	session_start();
	error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
	include("../../../conn.php");
	$link =koneksi();
	$id=(int)$_GET['id'];
	$namasatuan=$_GET['nama'];
	$sql="delete from satuan where id_satuan = '$id'";
	$res=mysqli_query($link,$sql);
	if(isset($res))
	{
		echo "<script>window.location = '../index.php'; </script>";
	}
	
?>
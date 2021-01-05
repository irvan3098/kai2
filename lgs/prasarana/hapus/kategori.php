<?php
	session_start();
	error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
	include("../../../conn.php");
	$link =koneksi();
	$id=(int)$_GET['id'];
	$nama=$_GET["nama"];
	$sql="delete from kategori where id_kategori = '$id'";
	$res=mysqli_query($link,$sql);
	if(isset($res))
	{
		header("Location: ../index.php");
	}
	
?>
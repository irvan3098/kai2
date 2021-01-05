<?php
	session_start();
	error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
	include("../../../conn.php");
	$link =koneksi();
	$id=$_GET['id'];
	$back=$_GET["back"];
	$kat=$_GET["kat"];
	$namabrg=$_GET["nama"];
	$judul=$_GET["judul"];
	$sql="delete from sarana_dan_fasilitas where id_sarfas = '$id'";
	$res=mysqli_query($link,$sql);
	if(isset($res))
	{
		
		if (is_numeric($back)) 
		{
        	echo "<script>window.location = '../detail_judul.php?id=$back&judul=$judul'; </script>";
		}
		elseif(isset($kat))
		{
			echo "<script>window.location = '../detail_judul.php?id=$back&judul=$judul'; </script>";
		}
		else
		{
			echo "<script>window.location = '../hasilcari.php?cari=$back&judul=$judul'; </script>";
		}
	}
	
?>
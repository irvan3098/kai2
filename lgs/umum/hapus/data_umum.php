<?php
	include("../../../conn.php");
	error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
	$link =koneksi();
	$id=$_GET['id'];
	$back=$_GET['back'];
	$sub=$_GET['sub'];
	$judul=$_GET['judul'];
	$namabrg=$_POST["nama"];
	$sql="delete from umum where id_data = '$id'";
	$res=mysqli_query($link,$sql);
	if(isset($res))
	{
		if (is_numeric($back)) 
		{
        	echo "<script>window.location = '../detail.php?id=$back&judul=$judul'; </script>";
		}
		else
		{
			echo "<script>window.location = '../hasilcari.php?cari=$back'; </script>";
		}
	}
	
?>
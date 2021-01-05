<?php
	session_start();
	error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
	include("../../../conn.php");
	$link =koneksi();
	$id=$_POST['id'];
	$data=$_POST['check_list'];
	$back=$_POST["back"];
	$kat=$_POST["kat"];
	$namadata=$_GET["nama"];
	$judul=$_POST["judul"];
	if(isset($_POST["semua"]))
	{
		$sql="delete from judul where id_judul= '$id'";//sub judul
		$res=mysqli_query($link,$sql);
		if(isset($res))
		{
			if (is_numeric($back)) 
			{
				echo "<script>window.location = '../detail_hapus_judul.php?id=$back&judul=$judul'; </script>";
			}
			elseif(isset($kat))
			{
				echo "<script>window.location = '../detail_hapus_judul.php?id=$back&judul=$judul'; </script>";
			}
			else
			{
				echo "<script>window.location = '../hasilcari.php?cari=$back&judul=$judul'; </script>";
			}
		}
	}
	elseif(!empty($data))//data
	{
		foreach($data as $selected) 
		{
			$res=mysqli_query($link,"delete from sub_judul where id_sub = '$selected'");
		}
			if (is_numeric($back)) 
			{
				echo "<script>window.location = '../detail_hapus_judul.php?id=$back&judul=$judul'; </script>";
			}
			elseif(isset($kat))
			{
				echo "<script>window.location = '../detail_hapus_judul.php?id=$back&judul=$judul'; </script>";
			}
			else
			{
				echo "<script>window.location = '../hasilcari.php?cari=$back&judul=$judul'; </script>";
			}
	}
	else
	{
		if (is_numeric($back)) 
			{
				echo "<script>window.location = '../detail_hapus_judul.php?id=$back&judul=$judul'; </script>";
			}
			elseif(isset($kat))
			{
				echo "<script>window.location = '../detail_hapus_judul.php?id=$back&judul=$judul'; </script>";
			}
			else
			{
				echo "<script>window.location = '../hasilcari.php?cari=$back&judul=$judul'; </script>";
			}
	}
	
?>
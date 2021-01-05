<?php
	session_start();
	error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
	include("../../../conn.php");
	$link =koneksi();
	$id=$_POST['id'];
	$judul=$_POST["judul"];
	$back=$_POST["back"];
	$kat=$_POST["kat"];
	$data=$_POST['check_list'];
	if(isset($_POST["semua"]))
	{
		$cari = "select * from judul where id_judul='$id'";
		$hasil = mysqli_query($link,$cari);
		if(mysqli_num_rows($hasil) > 0 )
		{
			$data = mysqli_fetch_array($hasil);
			
			//delete file
			unlink('../../../info_pdf/'.$data['file']);
			
			//delete data di database
			$sql="delete from judul where id_judul = '$id'";
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
		}
	}
	elseif(!empty($data))
	{
		foreach($data as $selected) 
		{
			$res=mysqli_query($link,"delete from sarana_dan_fasilitas where id_sarfas = '$selected'");
		}
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
	}else
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
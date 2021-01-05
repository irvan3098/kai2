<?php
	session_start();
	error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
	include("../../../conn.php");
	$link =koneksi();
	
	//$judul=$_GET["judul"];
	
	$id=$_POST['id'];//judul
	$data=$_POST['check_list'];
	$back=$_POST["back"];
	$kat=$_POST["kat"];
	$namadata=$_GET["nama"];
	$judul=$_POST["judul"];
	
	if(isset($_POST["semua"]))
	{
		$sql="delete from judul where id_judul = '$id'";//hapus judul
		$res=mysqli_query($link,$sql);
		if(isset($res))
		{
				$nama=$_SESSION['namauser'];
				$aktivitas="hapus data judul pekerjaan : $judul";
				$level=$_SESSION['level'];
				$sqlhis="insert into history_pengguna (id_history,level,nama,aktivitas,waktu)values(NULL,'$level','$nama','$aktivitas',now())";
				$reshis=mysqli_query($link,$sqlhis);
				if (is_numeric($back)) 
				{
					echo "<script>window.location = '../detail.php?id=$back&judul=$judul'; </script>";
				}
				elseif(isset($kat))
				{
					echo "<script>window.location = '../detail.php?id=$back&judul=$judul'; </script>";
				}
				else
				{
					echo "<script>window.location = '../hasilcari.php?cari=$back&judul=$judul'; </script>";
				}
		}
	}
	elseif(!empty($data))
	{
		foreach($data as $selected) 
		{
			$res=mysqli_query($link,"delete from kode_pekerjaan where id_kode = '$selected'");
		}
		
		$jumhap=count($data);
		$nama=$_SESSION['namauser'];
		$aktivitas="hapus data di judul : $judul jumlah data : $jumhap";
		$level=$_SESSION['level'];
		$sqlhis="insert into history_pengguna (id_history,level,nama,aktivitas,waktu)values(NULL,'$level','$nama','$aktivitas',now())";
		$reshis=mysqli_query($link,$sqlhis);
		if (is_numeric($back)) 
		{
        	echo "<script>window.location = '../detail.php?id=$back&judul=$judul'; </script>";
		}
		elseif(isset($kat))
		{
			echo "<script>window.location = '../detail.php?id=$back&judul=$judul'; </script>";
		}
		else
		{
			echo "<script>window.location = '../hasilcari.php?cari=$back&judul=$judul'; </script>";
		}
	}
?>
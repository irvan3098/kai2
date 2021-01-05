<?php
	session_start();
	error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
	include("../../../conn.php");
	$link =koneksi();
	$id_satuan=$_GET['id_satuan'];
	$id_peker=$_GET["id_peker"];
	$nam_dat=$_GET["nam_dat"];
	$judul=$_GET["judul"];
	$back=$_GET["back"];
	$kat=$_GET["kat"];
	
	$sql="delete from nama_pekerjaan where id_pekerjaan = '$id_peker'";
	$res=mysqli_query($link,$sql);
	if(isset($res))
	{
		$cek_sat=mysqli_query($link,"select * from satuan_pekerjaan where id_satuan='$id_satuan'");
		$cek_jum=mysqli_num_rows($cek_sat);
		if($cek_jum > 0)
		{
			$nama=$_SESSION['namauser'];
			$aktivitas="hapus data di judul : $judul > $nam_dat";
			$level=$_SESSION['level'];
			$sqlhis="insert into history_pengguna (id_history,level,nama,aktivitas,waktu)values(NULL,'$level','$nama','$aktivitas',now())";
			$reshis=mysqli_query($link,$sqlhis);
			if (is_numeric($back)) 
			{
				echo "<script>window.location = '../detail.php?id=$back&judul=$judul'; </script>";
			}
			elseif(isset($kat))
			{
				echo "<script>window.location = '../detail.php?id=$back&judul=$kat'; </script>";
			}
			else
			{
				echo "<script>window.location = '../hasilcari.php?cari=$back&judul=$judul'; </script>";
			}
		}
		elseif($cek_jum == 0)
		{
			$hap_satuan=mysqli_query($link,"delete from nama_satuan where id_satuan = '$id_satuan'");
			$res2=mysqli_query($link,$hap_satuan);
			if(isset($res2))
			{
				$nama=$_SESSION['namauser'];
				$aktivitas="hapus data di judul : $judul > $nam_dat";
				$level=$_SESSION['level'];
				$sqlhis="insert into history_pengguna (id_history,level,nama,aktivitas,waktu)values(NULL,'$level','$nama','$aktivitas',now())";
				$reshis=mysqli_query($link,$sqlhis);
				if (is_numeric($back)) 
				{
					echo "<script>window.location = '../detail.php?id=$back&judul=$judul'; </script>";
				}
				elseif(isset($kat))
				{
					echo "<script>window.location = '../detail.php?id=$back&judul=$kat'; </script>";
				}
				else
				{
					echo "<script>window.location = '../hasilcari.php?cari=$back&judul=$judul'; </script>";
				}
			}
		}
		
	}
		
?>
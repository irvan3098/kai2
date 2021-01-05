<?php
	session_start();
	error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
	include("../../../conn.php");
	$link =koneksi();
	$id=$_POST['id'];
	$data=$_POST['check_list'];
	$namadata=$_GET["nama"];
	$judul=$_POST["judul"];
	if(isset($_POST["semua"]))
	{
		$sql="delete from sub_judul where id_sub= '$id'";//sub judul
		$res=mysqli_query($link,$sql);
		if(isset($res))
		{
			echo "<script>window.location = '../index.php'; </script>";
		}
	}
	elseif(!empty($data))//data
	{
		foreach($data as $selected) 
		{
			$res=mysqli_query($link,"delete from umum where id_data = '$selected'");
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
		else
		{
			echo "<script>window.location = '../hasilcari.php?cari=$back'; </script>";
		}
		
	}else
	{
		echo "gagagal";
	}
	
?>
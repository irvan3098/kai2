<?php
	session_start();
	error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
	include("../../../conn.php");
	$link =koneksi();
	$id=(int)$_GET['id'];
	$data=$_GET["nama"];
	$sql="delete from pengguna where id_pengguna = '$id'";
	$res=mysqli_query($link,$sql);
	if(isset($res))
	{
		$nama=$_SESSION['namauser'];
		$aktivitas="hapus data mata uang : $data";
		$level=$_SESSION['namauser'];
		$sqlhis="insert into history_pengguna (id_history,level,nama,aktivitas,waktu)values(NULL,'$level','$nama','$aktivitas',now())";
		$reshis=mysqli_query($link,$sqlhis);
		echo "<script>window.location = '../data_pengguna.php';</script>";
	}
	
?>
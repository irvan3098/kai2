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
		$nama=$_SESSION['namauser'];;
		$aktivitas="hapus data kategori : $matauang";
		$level=$_SESSION['level'];;
		$sqlhis="insert into history_pengguna (id_history,level,nama,aktivitas,waktu)values(NULL,'$level','$nama','$aktivitas',now())";
		$reshis=mysqli_query($link,$sqlhis);
		header("Location: ../index.php");
	}
	
?>
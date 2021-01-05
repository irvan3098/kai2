<?php
	error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
	include("../lib_func.php");
	$link =koneksi();
	$id=(int)$_GET['id'];
	$matauang=$_GET["nama"];
	$sql="delete from mata_uang where id_matauang = '$id'";
	$res=mysqli_query($link,$sql);
	if(isset($res))
	{
		$nama="irvan";
		$aktivitas="hapus data mata uang : $matauang";
		$level="lgs";
		$sqlhis="insert into history_pengguna (id_history,level,nama,aktivitas,waktu)values(NULL,'$level','$nama','$aktivitas',now())";
		$reshis=mysqli_query($link,$sqlhis);
		header("Location: ../sempel2.php");
	}
	
?>
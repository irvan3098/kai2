<?php
	include("../../conn.php");
	$id=(int)$_GET["id"];
	$status=$_GET["status"];
	$link=koneksi();
	if($status == "T")
	{
		$sql="update pengguna set status= 'Y' where id_pengguna = '$id'"; 
		$res=mysqli_query($link,$sql);
		if(isset($res))
		{
			echo "<script>window.location = 'data_pengguna.php';</script>";
		}
	}
	elseif($status == "Y")
	{
		$sql="update pengguna set status= 'T' where id_pengguna = '$id'"; 
		$res=mysqli_query($link,$sql);
		if(isset($res))
		{
			echo "<script>window.location = 'data_pengguna.php';</script>";
		}
	}
?>
<?
	error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
	include("../lib_sempel.php");
	$link =koneksi();
	$id=(int)$_GET['id'];
	$namadata=$_GET["nama"];
	$sql="delete from vendor where id_vendor = '$id'";
	$res=mysqli_query($link,$sql);
	if(isset($res))
	{
		$nama="irvan";
		$aktivitas="hapus data vendor : $namadata";
		$level="lgs";
		$sqlhis="insert into history_pengguna (id_history,level,nama,aktivitas,waktu)values(NULL,'$level','$nama','$aktivitas',now())";
		$reshis=mysqli_query($link,$sqlhis);
		header("Location: ../sempel2.php");
	}else
	{
		echo "gagal";
	}
	
?>
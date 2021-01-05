<?
	error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
	include("../lib_sempel.php");
	$link =koneksi();
	$id=(int)$_GET['id'];
	$namjud=$_GET["nama"];
	$sql="delete from judul where id_judul = '$id'";
	$res=mysqli_query($link,$sql);
	if(isset($res))
	{
		//hapus data sardas
		$sql2="delete from sarana_dan_fasilitas where id_judul = '$id'";
		$res2=mysqli_query($link,$sql2);
		if(isset($res2))
		{
			$nama="irvan";
			$aktivitas="hapus data judul : $namjud";
			$level="lgs";
			$sqlhis="insert into history_pengguna (id_history,level,nama,aktivitas,waktu)values(NULL,'$level','$nama','$aktivitas',now())";
			$reshis=mysqli_query($link,$sqlhis);
			header("Location: ../sempel2.php");
		}
	}
?>
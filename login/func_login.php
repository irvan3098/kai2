<?php include("conn.php"); ?>
<?php
	function cek_login()
	{
		error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
		$link=koneksi();
		$nip=$_POST["nip"];
		$pass=$_POST["pass"];
		$res=mysqli_query($link,"select * from pengguna where nip = '$nip' and password='$pass' and status='Y'");		
		if(!$res){
			die("Query error! : ".mysqli_error($link));
		}
		if(isset($_POST["login"]))
			{
				if(mysqli_num_rows($res)==1)
				{
					$data=mysqli_fetch_array($res);
					if($data["level"] == "lgs")
					{
						$_SESSION['namauser']=$data['username'];
						$_SESSION['level']=$data['level'];
						$_SESSION['sudahloginmember']=true;
						header("Location: lgs/sarana_dan_fasilitas/index.php");
					}
					else if($data["level"] == "user")
					{
						$_SESSION['namauser']=$data['username'];
						$_SESSION['level']=$data['level'];
						$_SESSION['sudahloginmember']=true;
						header("location: user/index.php");
					}else
					{
						echo "username tidak terdaftar";
					}
				}
				else
				{
					echo "nipatau password salah";
				}
			}
			
	}
?>

<?php
	function buat_akun()
	{
		error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
		$nip=$_POST["nip"];
		$user=$_POST["user"];
		$pass=$_POST["pass"];
		$level=$_POST["level"];
		$link=koneksi();
		if(isset($_POST["create"]))
		{
			if(empty($nip) || empty($user) || empty($pass) || empty($level))
			{
				echo "tolong isi semua form";
			}
			else
			{	
				$sql="insert into pengguna values(NULL,'$nip','$user','$pass','$level','T')"; 
				$res=mysqli_query($link,$sql);
				if(isset($res))
				{
					echo "tunggu persetujuan hak akses";
				}
					else
				{
					echo "gagal";                            
				}
			}
					
		}
	}
?>
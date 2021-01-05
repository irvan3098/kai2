<?php include("../../conn.php"); ?>
<?php
	function progres_bar()
	{ 
		if (isset($_POST['submit'])) 
		{
?>
            <div id="progress" style="width:500px;border:1px solid #ccc;"></div>
            <div id="info"></div>
<?php
		}

	}
?>
 
 
<?php
	function proses_import()
	{
		$link=koneksi();
		require "excel_reader.php";
		 
		//jika tombol import ditekan
		if(isset($_POST['submit']))
		{ 
			$target = basename($_FILES['filepegawaiall']['name']) ;
			move_uploaded_file($_FILES['filepegawaiall']['tmp_name'], $target);
			$data = new Spreadsheet_Excel_Reader($_FILES['filepegawaiall']['name'],false);
			
		//    menghitung jumlah baris file xls
			$baris = $data->rowcount($sheet_index=0);
			
		//    import data excel mulai baris ke-2 (karena tabel xls ada header pada baris 1)
			for ($i=2; $i<=$baris; $i++)
			{
				//menghitung jumlah real data. Karena kita mulai pada baris ke-2, maka jumlah baris yang sebenarnya adalah 
				//jumlah baris data dikurangi 1. Demikian juga untuk awal dari pengulangan yaitu i juga dikurangi 1
						$barisreal = $baris-1;
						$k = $i-1;
						
				// menghitung persentase progress
						$percent = intval($k/$barisreal * 100)."%";
				 
				// mengupdate progress
						echo '<script language="javascript">
						document.getElementById("progress").innerHTML="<div style=\"width:'.$percent.'; background-color:lightblue\">&nbsp;</div>";
						document.getElementById("info").innerHTML="'.$k.' data berhasil diinsert ('.$percent.' selesai).";
						</script>';
				 
				//       membaca data (kolom ke-1 sd terakhir)
					  //$kategori           = $data->val($i, 1);
					  //$judul   = $data->val($i, 2);
					  $nama_brg  = $data->val($i, 1);
					  $merk           = $data->val($i, 2);
					  $spesifikasi           = $data->val($i, 3);
					  $satuan           = $data->val($i, 4);
					  $mata_uang           = $data->val($i, 5);
					  $harga_satuan           = $data->val($i, 6);
					  $keterangan           = $data->val($i, 7);
				 	  
					  $subjudul=$_POST["subjudul"];
					  
					  $query = "INSERT into umum (id_data,id_sub,nama_brg,merk,spesifikasi,satuan,mata_uang,harga_satuan,keterangan)
					  values
					  (NULL,'$subjudul','$nama_brg','$merk','$spesifikasi','$satuan','$mata_uang','$harga_satuan','$keterangan')";
					  $hasil = mysqli_query($link,$query);
					  if(empty($hasil))
					  {
						  echo "kosong";
					  }
					  flush();
					  
				 
					  //sleep(1);
			}
						 
						$nama="irvan";
						 $aktivitas="import $k data umum ke sub";
						 $level="user";
						 $sql="insert into history_pengguna (id_history,level,nama,aktivitas,waktu)values(NULL,'$level','$nama','$aktivitas',now())";
						 $res=mysqli_query($link,$sql);
						 
						 if(empty($res))
						 {
							 echo "kosong";
						}		
		//    hapus file xls yang udah dibaca
			unlink($_FILES['filepegawaiall']['name']);
		}
	}
?>

<?php
	function nav()
	{
		error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
		$link=koneksi();
		$res=mysqli_query($link,"select * from judul where kategori='pekerjaan'");		
		if(!$res){
			die("Query error! : ".mysqli_error($link));
		}
		$i=1;
			while ($data=mysqli_fetch_array($res))
			{
				$id=$data["id_judul"];
				$resjum=mysqli_query($link,"SELECT id_kode,kode,satuan,nama_pkj,pokok_kegiatan from judul
		join kode_pekerjaan using(id_judul)
		join satuan_pekerjaan using(id_kode)
		join nama_pekerjaan using(id_satuan) where id_judul='$id'");
				
		?>
        		<li>
                	<a href="detail.php?id=<?php echo $id;?>&judul=<?php echo $data["judul"]; ?>"><i class="fa fa-circle fa-fw"></i> <?php echo $data["judul"]; ?> (<?php echo mysqli_num_rows($resjum);?>)</a>
               	</li>
        <?php
			}
		
	
	}
?>

<?php
	function jum_t_konformasi()
	{
		error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
		$link=koneksi();
		$id=(int)$_GET['id'];
		$res=mysqli_query($link,"SELECT * from pengguna where status = 'T'");		
		if(!$res){
			die("Query error! : ".mysqli_error($link));
		}
			echo mysqli_num_rows($res);
	}
?>

<?php
	function his_user()
	{
		error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
		$link=koneksi();
		$res=mysqli_query($link,"select * from history_pengguna where level ='user' ORDER BY id_history DESC limit 5");		
		if(!$res){
			die("Query error! : ".mysqli_error($link));
		}
		$i=1;
			while ($data=mysqli_fetch_array($res))
			{
		?>
        		<tr>
                	<td><?php echo $i++; ?></td>
                	<td><?php echo $data["nama"]; ?></td>
                    <td><?php echo $data["aktivitas"]; ?></td>
                    <td><?php echo $data["waktu"]; ?></td>
           		</tr>                                             
        <?php
			}
		
	}
?>

<?php
	function his_lgs()
	{
		error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
		$link=koneksi();
		$res=mysqli_query($link,"select * from history_pengguna where level ='lgs' ORDER BY id_history DESC limit 5");		
		if(!$res){
			die("Query error! : ".mysqli_error($link));
		}
		$i=1;
			while ($data=mysqli_fetch_array($res))
			{
		?>
        		<tr>
                	<td><?php echo $i++; ?></td>
                	<td><?php echo $data["nama"]; ?></td>
                    <td><?php echo $data["aktivitas"]; ?></td>
                    <td><?php echo $data["waktu"]; ?></td>
           		</tr>                                             
        <?php
			}
		
	}
?>

<?php
	function his_pbj()
	{
		error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
		$link=koneksi();
		$res=mysqli_query($link,"select * from history_pengguna where level ='pbj' ORDER BY id_history DESC limit 5");		
		if(!$res){
			die("Query error! : ".mysqli_error($link));
		}
		$i=1;
			while ($data=mysqli_fetch_array($res))
			{
		?>
        		<tr>
                	<td><?php echo $i++; ?></td>
                	<td><?php echo $data["nama"]; ?></td>
                    <td><?php echo $data["aktivitas"]; ?></td>
                    <td><?php echo $data["waktu"]; ?></td>
           		</tr>                                             
        <?php
			}
		
	}
?>

<?php
	function data_sarfas()
	{
		error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
		$link=koneksi();
		$res=mysqli_query($link,"SELECT * from umum
		join sub_judul using(id_sub)
		join judul using(id_judul) where kategori = 'umum'");		
		if(!$res){
			die("Query error! : ".mysqli_error($link));
		}
		$i=1;
		$j=1;
			while ($data=mysqli_fetch_array($res))
			{
				$i++;
				$i=$i+1;
		?>
        			<tr class="odd gradeX">
                        <td><?php echo $j++;?></td>
                        <td><?php echo $data["no_sap"]; ?></td>
                        <td><?php echo $data["nama_brg"]; ?></td>
                        <td><?php echo $data["spesifikasi"]; ?></td>
                        <td><?php echo $data["satuan"]; ?></td>
                        <td><?php echo $data["mata_uang"]; ?></td>
                        <td><?php echo $data["harga_satuan"]; ?></td>
                        <td><?php echo $data["vendor"]; ?></td>
                        <td>
                        	<div class="tooltip-demo">
                            	 <!-- hapus data dilampiran -->
                            <button class="btn btn-danger btn-circle" data-toggle="modal" data-target="#myModal<?php echo $i+1; ?>" data-placement="top" title="Hapus">
                             <i class="fa fa-trash"></i>
                            </button>
                            <!-- Modal -->
                            <div class="modal fade" id="myModal<?php echo $i+1; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="myModalLabel">Yakin akan menghapus data ini :</h4>
                                        </div>
                                        <div class="modal-body">
                                            <form name="hapus" method="post" >
                                           		<table class="table">
                                                	<tbody>
                                                    	<tr class="danger">
                                                            <td>No sap</td>
                                                            <td><?php echo $data["no_sap"]; ?></td>
                                                        </tr>
                                                        <tr class="danger">
                                                            <td>Nama Barang</td>
                                                            <td><?php echo $data["nama_brg"]; ?></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                        </div>
                                        <div class="modal-footer">
                                        	<input type="hidden" name="id" value="<?php echo $data["id_sarfas"]; ?>">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                                            <button type="submit" class="btn btn-danger" name="hapus">Hapus</button>
                                            <?php //hapus_data_dilampiran() ?>
                                            </form>
                                        </div>
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>
                            </div>
                        </td>
<?php
			}
	}
?>

<?php
	function data_hasilcari()
	{
		error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
		$link=koneksi();
		$cari=$_POST["cari"];
		$res=mysqli_query($link,"SELECT id_data, nama_brg, merk, spesifikasi, satuan, mata_uang, harga_satuan, keterangan from umum 
		join sub_judul using(id_sub)
		join judul using(id_judul)
		where nama_brg like '%$cari%' and kategori='umum'");		
		if(!$res){
			die("Query error! : ".mysqli_error($link));
		}
		$i=1;
		$j=1;
			while ($data=mysqli_fetch_array($res))
			{
				$i++;
				$i=$i+1;
		?>
        			<tr class="odd gradeX">
                        <td><?php echo $j++;?></td>
                        <td><?php echo $data["nama_brg"]; ?></td>
                        <td><?php echo $data["merk"]; ?></td>
                        <td><?php echo $data["spesifikasi"]; ?></td>
                        <td><?php echo $data["satuan"]; ?></td>
                        <td><?php echo $data["mata_uang"]; ?></td>
                        <td><?php echo $data["harga_satuan"]; ?></td>
                        <td><?php echo $data["keterangan"]; ?></td>
                        <td>
                        	<div class="tooltip-demo">
                            	 <!-- hapus data dilampiran -->
                            <button class="btn btn-danger btn-circle" data-toggle="modal" data-target="#myModal<?php echo $i+1; ?>" data-placement="top" title="Hapus">
                             <i class="fa fa-trash"></i>
                            </button>
                            <!-- Modal -->
                            <div class="modal fade" id="myModal<?php echo $i+1; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="myModalLabel">Yakin akan menghapus data ini :</h4>
                                        </div>
                                        <div class="modal-body">
                                            <form name="data_sarfas" method="post" action="hapus/data_sarfas.php">
                                           		<table class="table">
                                                	<tbody>
                                                    	<tr class="danger">
                                                            <td>No sap</td>
                                                            <td><?php echo $data["no_sap"]; ?></td>
                                                        </tr>
                                                        <tr class="danger">
                                                            <td>Nama Barang</td>
                                                            <td><?php echo $data["nama_brg"]; ?></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                        </div>
                                        <div class="modal-footer">
                                        	<input type="hidden" name="id" value="<?php echo $data["id_sarfas"];?>">
                                            <input type="hidden" name="namabrg" value="<?php echo $data["nama_brg"]; ?>">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                                            <button type="submit" class="btn btn-danger" name="hapus">Hapus</button>
                                            </form>
                                        </div>
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>
                            </div>
                        </td>
<?php
			}
	}
?>


<?php
	function pilih_judul()
	{
		error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
		$link=koneksi();
		$res=mysqli_query($link,"select * from judul where kategori='pekerjaan'");		
		if(!$res){
			die("Query error! : ".mysqli_error($link));
		}
			while  ($data=mysqli_fetch_array($res)) 
			{
		?>
        		<option value="<?php echo $data["id_judul"];?>"><?php echo $data["judul"];?></option>
       <?php	
			}
	}
?>

<?php
	function pilih_kode()
	{
		error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
		$link=koneksi();
		$res=mysqli_query($link,"select * from kode_pekerjaan join judul using(id_judul) where kategori='pekerjaan'");		
		if(!$res){
			die("Query error! : ".mysqli_error($link));
		}
			while  ($data=mysqli_fetch_array($res)) 
			{
		?>
        		<option><?php echo $data["kode"];?></option>
       <?php	
			}
	}
?>

<?php
	function pilih_satuan()
	{
		error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
		$link=koneksi();
		$res=mysqli_query($link,"select * from satuan_pekerjaan join kode_pekerjaan using(id_kode) ");		
		if(!$res){
			die("Query error! : ".mysqli_error($link));
		}
			while  ($data=mysqli_fetch_array($res)) 
			{
		?>
        		<option ><?php echo $data["satuan"];?></option>
       <?php	
			}
	}
?>

<?php
	function tambah_kode()
	{
		error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
		$tjudul=$_POST["tjudul"];
		$tkode=$_POST["tkode"];
		$link=koneksi();
		if(isset($_POST["tambah"]))
		{
			if(empty($tsubjudul))
			{
				echo "tidak ada data yang tersimpan";
			}
			else
			{	
				$sql="insert into kode_pekerjaan values(NULL,'$tjudul','$tkode')"; 
				$res=mysqli_query($link,$sql);
				if(isset($res))
				{
					$nama="irvan";
					$aktivitas="tambah sub judul : $tkode di judul $tjudul";
					$level="lgs";
					$sqlhis="insert into history_pengguna (id_history,level,nama,aktivitas,waktu)values(NULL,'$level','$nama','$aktivitas',now())";
					$reshis=mysqli_query($link,$sqlhis);
						echo "<script>window.location = 'index.php'; </script>";
					   
				}
			}
					
		}
	}
?>

<?php
	function tambah_judul()
	{
		error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
		$judul=$_POST["tjudul"];
		$link=koneksi();
		if(isset($_POST["tambahjudul"]))
		{
			if(empty($judul))
			{
				echo "tidak ada data yang tersimpan";
			}
			else
			{	
				$kategori="pekerjaan";
				$sql="insert into judul values(NULL,'$kategori','$judul','NULL','NULL','NULL')"; 
				$res=mysqli_query($link,$sql);
				if(isset($res))
				{
					$nama="irvan";
					$aktivitas="tambah judul : $judul";
					$level="lgs";
					$sqlhis="insert into history_pengguna (id_history,level,nama,aktivitas,waktu)values(NULL,'$level','$nama','$aktivitas',now())";
					$reshis=mysqli_query($link,$sqlhis);
					if(isset($reshis))
					{
						echo "<script>window.location = 'index.php'; </script>";
					}else
					{
						echo "gagal cuy";
					}                            
				}
			}
					
		}
	}
?>


<?php
	function pilih_satuan2()
	{
		error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
		$link=koneksi();
		$res=mysqli_query($link,'select * from satuan');		
		if(!$res){
			die("Query error! : ".mysqli_error($link));
		}
			while  ($data=mysqli_fetch_array($res)) 
			{
		?>
        		<option><?php echo $data["nama_satuan"];?></option>
       <?php	
			}
	}
?>

<?php
	function tambah_satuan()
	{
		error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
		$satuan=$_POST["satuan"];
		$link=koneksi();
		if(isset($_POST["tambah"]))
		{
			if(empty($satuan))
			{
				echo "tidak ada data yang tersimpan";
			}
			else
			{	$sql="insert into satuan values(NULL,'$satuan')"; 
				$res=mysqli_query($link,$sql);
				if(empty($res))
				{
					echo "sasassa ";
				}
					elseif($res)
				{
					$nama="irvan";
					$aktivitas="tambah satuan : $satuan";
					$level="lgs";
					$sqlhis="insert into history_pengguna (id_history,level,nama,aktivitas,waktu)values(NULL,'$level','$nama','$aktivitas',now())";
					$reshis=mysqli_query($link,$sqlhis);
					if(isset($reshis))
					{
						echo "<script>window.location = 'index.php'; </script>";
					}                             
				}
			}
					
		}
	}
?>


<?php
	function pilih_matauang()
	{
		error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
		$link=koneksi();
		$res=mysqli_query($link,'select * from mata_uang');		
		if(!$res){
			die("Query error! : ".mysqli_error($link));
		}
			while  ($data=mysqli_fetch_array($res)) 
			{
		?>
        		<option><?php echo $data["nama_matauang"];?></option>
       <?php	
			}
	}
?>

<?php
	function tambah_matauang()
	{
		error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
		$tambah=$_POST["matauang"];
		$link=koneksi();
		if(isset($_POST["tambah"]))
		{
			if(empty($tambah))
			{
				echo "tidak ada data yang tersimpan";
			}
			else
			{	$sql="insert into mata_uang values(NULL,'$tambah')"; 
				$res=mysqli_query($link,$sql);
				if(empty($res))
				{
					echo "kosong";
				}
					elseif($res)
				{
					$nama="irvan";
					$aktivitas="tambah mata uang : $tambah";
					$level="lgs";
					$sqlhis="insert into history_pengguna (id_history,level,nama,aktivitas,waktu)values(NULL,'$level','$nama','$aktivitas',now())";
					$reshis=mysqli_query($link,$sqlhis);
					if(isset($reshis))
					{
						echo "<script>window.location = 'index.php'; </script>";
					}          
				}
			}
					
		}
	}
?>

<?php
	function data_sub_judul()
	{
		error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
		$link=koneksi();
		$res=mysqli_query($link,"SELECT * from sub_judul join judul using(id_judul) where kategori='umum'");		
		if(!$res){
			die("Query error! : ".mysqli_error($link));
		}
		$i=1;
			while ($data=mysqli_fetch_array($res))
			{
		?>
        			<tr class="odd gradeX">
                        <td><?php echo $i++;?></td>
                        <td><?php echo $data["judul"]; ?></td>
                        <td><?php echo $data["nama_sub"]; ?></td>
                        <td>
                        	<a href="hapus/sub_judul.php?id=<?php echo $data["id_sub"];?>&nama=<?php echo $data["nama_sub"];?>" class="btn btn-danger btn-circle" data-placement="top" title="Hapus" onclick="return confirm('Anda yakin, ingin menghapus data ini?');">
                             <i class="fa fa-trash"></i>
                            </a>
                            <!-- Modal -->
                        </td>
                   </tr>
<?php
			}
	}
?>


<?php
	function data_satuan()
	{
		error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
		$link=koneksi();
		$res=mysqli_query($link,"SELECT * from satuan_pekerjaan");		
		if(!$res){
			die("Query error! : ".mysqli_error($link));
		}
		$i=1;
			while ($data=mysqli_fetch_array($res))
			{
		?>
        			<tr class="odd gradeX">
                        <td><?php echo $i++;?></td>
                        <td><?php echo $data["satuan"]; ?></td>
                        <td>
                        	<a href="hapus/satuan.php?id=<?php echo $data["id_satuan"]; ?>&nama=<?php echo $data["satuansatuan"];?>" class="btn btn-danger btn-circle" data-placement="top" title="Hapus" onclick="return confirm('Anda yakin, ingin menghapus data ini?');">
                             <i class="fa fa-trash"></i>
                            </a>
                            <!-- Modal -->
                        </td>
                   </tr>
<?php
			}
	}
?>

<?php
	function data_matauang()
	{
		error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
		$link=koneksi();
		$res=mysqli_query($link,"SELECT * from mata_uang");		
		if(!$res){
			die("Query error! : ".mysqli_error($link));
		}
		$i=1;
		$j=1;
			while ($data=mysqli_fetch_array($res))
			{
				$i++;
				$i=$i+1;
		?>
        			<tr class="odd gradeX">
                        <td><?php echo $j++;?></td>
                        <td><?php echo $data["nama_matauang"]; ?></td>
                        <td>
                        	<a href="hapus/mata_uang.php?id=<?php echo $data["id_matauang"];?>&nama=<?php echo $data["nama_matauang"]; ?>" class="btn btn-danger btn-circle" data-placement="top" title="Hapus" onclick="return confirm('Anda yakin, ingin menghapus data ini?');">
                             <i class="fa fa-trash"></i>
                            </a>
                        </td>
                   </tr>
<?php
			}
	}
?>

<?php
	function data_judul()
	{
		error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
		$link=koneksi();
		$res=mysqli_query($link,"SELECT * from judul where kategori='pekerjaan'");		
		if(!$res){
			die("Query error! : ".mysqli_error($link));
		}
		$j=1;
			while ($data=mysqli_fetch_array($res))
			{
		?>
        			<tr class="odd gradeX">
                        <td><?php echo $j++;?></td>
                        <td>
                        	<a href="detail.php?id=<?php echo $data["id_judul"]?>&judul=<?php echo $data["judul"]; ?>">
								<?php echo $data["judul"]; ?>
                            </a>
                       	</td>
                        <td>
                        	<a href="detail.php?id=<?php echo $data["id_judul"];?>&judul=<?php echo $data["judul"]; ?>" class="btn btn-danger btn-circle" data-placement="top" title="Hapus">
                             <i class="fa fa-trash"></i>
                            </a>
                            <!-- ubah-->
                            <?php
								$id_jud=$data["id_judul"];
								$data=$data["judul"];
								 
							?>
                            <button class="btn btn-success btn-circle" data-toggle="modal" data-target="#myModal<?php echo $id_jud;?>">
                                <i class="fa fa-edit"></i>
                            </button>
                            <div class="modal fade" id="myModal<?php echo $id_jud;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="myModalLabel">Ubah data <?php echo $data;?></h4>
                                        </div>
                                        <form method="post">
                                            <div class="modal-body">
                                            	Data sebelumnya <strong><?php echo $data;?></strong> 
                                                <input type="text" class="form-control" type="text" value="<?php echo $data;?>" name="newjudul">
                                                <input type="hidden" value="<?php echo $data;?>" name="lastjudul">
                                                <input type="hidden" value="<?php echo $id_jud; ?>" name="id">
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                                                <button type="submit" class="btn btn-primary" name="ubahjudul">Ubah</button>
                                            </div>
                                            <?php ubah_data_judul();?>
                                        </form>
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>
                            <!-- /ubah -->
                        </td>
                   </tr>
<?php
			}
	}
?>

<?php
	function ubah_data_judul()
	{
		$last=$_POST["lastjudul"];
		$new=$_POST["newjudul"];
		$id=$_POST["id"];
		$link=koneksi();
		if(isset($_POST['ubahjudul']))
			{ 
					$sql="UPDATE judul SET judul = '$new' WHERE id_judul = '$id'"; 
					$res=mysqli_query($link,$sql);
					if(isset($res))
					{
						$nama=$_SESSION['namauser'];
						$aktivitas="Ubah judul pekerjaan $last > $new";
						$level=$_SESSION['level'];
						$sqlhis="insert into history_pengguna (id_history,level,nama,aktivitas,waktu)values(NULL,'$level','$nama','$aktivitas',now())";
						$reshis=mysqli_query($link,$sqlhis);
						if(isset($reshis))
						{
							echo " <meta http-equiv=\"refresh\" content=\"0\" /> ";
						}
					}
			}
	}
?>

<?php
	function data_pekerjaan()
	{
		error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
		$link=koneksi();
		$res=mysqli_query($link,"SELECT * from pekerjaan where id_sub = '$id'");		
		if(!$res){
			die("Query error! : ".mysqli_error($link));
		}
		$i=1;
		$j=1;
			while ($data=mysqli_fetch_array($res))
			{
				$i++;
				$i=$i+1;
		?>
        			<tr class="odd gradeX">
                        <td><?php echo $j++;?></td>
                        <td><?php echo $data["nama_brg"]; ?></td>
                        <td><?php echo $data["merk"]; ?></td>
                        <td><?php echo $data["spesifikasi"]; ?></td>
                        <td><?php echo $data["satuan"]; ?></td>
                        <td><?php echo $data["mata_uang"]; ?></td>
                        <td><?php echo $data["harga_satuan"]; ?></td>
                        <td><?php echo $data["keterangan"]; ?></td>
                        <td>
                             <button class="btn btn-success btn-circle"  data-placement="top" title="Ubah">
                             <i class="fa fa-edit"></i>
                            </button>
                           <a href="hapus/data_sarfas.php?id=<?php echo $data["id_data"];?>&nama=<?php echo $data["nama_brg"]; ?>" class="btn btn-danger btn-circle" data-placement="top" title="Hapus">
                             <i class="fa fa-trash"></i>
                            </a>
                        </td>
                   	</tr>
        <?php	
		}
	}
	
?>

<?php
	function simpan_data_pekerjaan()
	{
		error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
		$id_judul=$_POST["idjudul"];
		$kode=$_POST["kode"];
		$kategori=$_POST["kategori"];
		$satuan=$_POST["satuan"];
		$nampek=$_POST["nampek"];
		$kegpok=$_POST["kegpok"];
		$link=koneksi();
		if(isset($_POST["simpan"]))
		{
			if(empty($kode))
			{
				echo "tidak ada data yang tersimpan";
			}
			else
			{	
				//cek data jika ada yg sama
				$cek=mysqli_query($link,"select * from kode_pekerjaan join judul using(id_judul) where kode ='$kode' and id_judul='$id_judul'");	
				if(mysqli_num_rows($cek) == 1)
				{
					while ($data=mysqli_fetch_array($cek))
					{
						$namkod=$data["kode"];
						$idkode=$data["id_kode"];
						$judul=$data["judul"];
					}
					$cek2=mysqli_query($link,"select * from satuan_pekerjaan 
					where id_kode ='$idkode' and satuan ='$satuan'");//cek satuan
					while ($data2=mysqli_fetch_array($cek2))
					{
						$namsat=$data2["satuan"];
						$idsatuan=$data2["id_satuan"];
					}
					if(mysqli_num_rows($cek2) == 0)
					{
						$sql="insert into satuan_pekerjaan values(NULL,'$idkode','$satuan')"; 
						$res2=mysqli_query($link,$sql);
						$last_id_satuan=mysqli_insert_id($link);
						if(isset($res2))
						{
							$sql2=mysqli_query($link,"insert into nama_pekerjaan values(NULL,'$last_id_satuan','$nampek','$kegpok')");
							if(isset($sql2))
							{
								$nama=$_SESSION['namauser'];
								$aktivitas="Tambah data pekerjaan di : $judul ";
								$level=$_SESSION['level'];
								$sqlhis="insert into history_pengguna (id_history,level,nama,aktivitas,waktu)values(NULL,'$level','$nama','$aktivitas',now())";
								$reshis=mysqli_query($link,$sqlhis);
								if(isset($reshis))
								{
									?>
                                    	<div class="alert alert-success">
                                            Data sudah tersimpan.
                                        </div>
                                    <?php
								}
							}
						}
					}
					elseif(mysqli_num_rows($cek2) == 1)
					{
						$sql2=mysqli_query($link,"insert into nama_pekerjaan 
						values(NULL,'$idsatuan','$nampek','$kegpok')");
							if(isset($sql2))
							{
								$nama=$_SESSION['namauser'];
								$aktivitas="Tambah data pekerjaan di : $judul ";
								$level=$_SESSION['level'];
								$sqlhis="insert into history_pengguna (id_history,level,nama,aktivitas,waktu)values(NULL,'$level','$nama','$aktivitas',now())";
								$reshis=mysqli_query($link,$sqlhis);
								if(isset($reshis))
								{
									?>
                                    	<div class="alert alert-success">
                                            Data sudah tersimpan.
                                        </div>
                                    <?php
								}
							}
					}
				}
				elseif(mysqli_num_rows($cek) == 0)//jika kode tidak ada
				{
					$tampil_judul=mysqli_query($link,"select * from kode_pekerjaan join judul using(id_judul) where id_judul='$id_judul'");
					while($dat_jud=mysqli_fetch_array($tampil_judul))
					{
						$namkod=$dat_jud["kode"];
						$idkode=$dat_jud["id_kode"];
						$judul=$dat_jud["judul"];
					}
					
					$sql="insert into kode_pekerjaan values(NULL,'$id_judul','$kategori','$kode')"; 
					$res=mysqli_query($link,$sql);
					$last_id_kode=mysqli_insert_id($link);
					if(isset($res))
					{
							$cek=mysqli_query($link,"select * from satuan_pekerjaan 
						where id_kode ='$last_id_kode' and satuan ='$satuan'");//cek satuan
						while ($data=mysqli_fetch_array($cek))
						{
							$namsat=$data["satuan"];
							$idsatuan=$data["id_satuan"];
						}
						if(mysqli_num_rows($cek) == 0)
						{
							$sql2="insert into satuan_pekerjaan values(NULL,'$last_id_kode','$satuan')"; 
							$res2=mysqli_query($link,$sql2);
							$last_id_satuan=mysqli_insert_id($link);
							if(isset($res2))
							{
								$sql3=mysqli_query($link,"insert into nama_pekerjaan values(NULL,'$last_id_satuan','$nampek','$kegpok')");
								if(isset($sql2))
								{
									$nama=$_SESSION['namauser'];
									$aktivitas="Tambah data pekerjaan di : $judul ";
									$level=$_SESSION['level'];
									$sqlhis="insert into history_pengguna (id_history,level,nama,aktivitas,waktu)values(NULL,'$level','$nama','$aktivitas',now())";
									$reshis=mysqli_query($link,$sqlhis);
									if(isset($reshis))
									{
										?>
                                    	<div class="alert alert-success">
                                            Data sudah tersimpan.
                                        </div>
                                    <?php
									}
								}
							}
						}
						elseif(mysqli_num_rows($cek2) == 1)
							{
								$sql3=mysqli_query($link,"insert into nama_pekerjaan 
								values(NULL,'$idsatuan','$nampek','$kegpok')");
									if(isset($sql3))
									{
										$nama=$_SESSION['namauser'];
										$aktivitas="Tambah data pekerjaan di : $judul ";
										$level=$_SESSION['level'];
										$sqlhis="insert into history_pengguna (id_history,level,nama,aktivitas,waktu)values(NULL,'$level','$nama','$aktivitas',now())";
										$reshis=mysqli_query($link,$sqlhis);
										if(isset($reshis))
										{
											?>
                                                <div class="alert alert-success">
                                                    Data sudah tersimpan.
                                                </div>
                                            <?php
										}
									}
							}
					}
				}
				
			}
					
		}
	}
?>

<?php
	function tampil_data_cetak()
	{
		error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
		$link=koneksi();
		$id=$_POST["judul"];
		$res=mysqli_query($link,"SELECT id_kode,id_satuan,id_pekerjaan,kode,satuan,nama_pkj,pokok_kegiatan,judul from judul
		join kode_pekerjaan using(id_judul)
		join satuan_pekerjaan using(id_kode)
		join nama_pekerjaan using(id_satuan)
		where id_judul='$id'
		order by satuan desc
		");
		if(!$res){
			die("Query error! : ".mysqli_error($link));
		}
		$i=1;
			while ($data=mysqli_fetch_array($res))//tampil kode
			{
				$id_kode=$data["id_kode"];
				$nam_kod=$data["kode"];
				$jumkode=mysqli_query($link,"SELECT count(kode) as jumkod,kode,id_kode from judul
		join kode_pekerjaan using(id_judul)
		join satuan_pekerjaan using(id_kode)
		join nama_pekerjaan using(id_satuan)
		where kode='$nam_kod' group by kode
		");
				while ($data2=mysqli_fetch_array($jumkode))//tampil kode
				{
					$resjumkod=$data2["jumkod"];
				}
				if($cekkode != $data["kode"])//cek kode
				{
		?>
					<tr>
                        <td rowspan="<?php echo $resjumkod;?>"><?php echo $i++; ?></td>
                        <td rowspan="<?php echo $resjumkod;?>"><?php echo $nam_kod; ?></td>
                        <?php
							$nam_satuan=$data["satuan"];
							$jumsat=mysqli_query($link,"SELECT count(satuan) as jumsat,kode from judul 
							join kode_pekerjaan using(id_judul)
							join satuan_pekerjaan using(id_kode)
							join nama_pekerjaan using(id_satuan)
							where satuan='$nam_satuan' and kode='$nam_kod' group by satuan");
							while ($data2=mysqli_fetch_array($jumsat))//tampil satuan
							{
								$resjumsat=$data2["jumsat"];
							}
							if($ceksat != $data["satuan"] || $cek_id_sat != $data["id_satuan"])//cek satuan
							{
						?>
                        		<td rowspan="<?php echo $resjumsat;?>"><?php echo $data["satuan"]; ?></td>
                                <td>
									<?php echo $data["nama_pkj"];?>
                                    <?php echo $data["pokok_kegiatan"]; ?>
                                </td>
                                
                        <?php
							}elseif($ceksat == $data["satuan"] && $cek_id_sat == $data["id_satuan"])
							{
						?>
                        		<td>
									<?php echo $data["nama_pkj"];?>
                                    <?php echo $data["pokok_kegiatan"]; ?>
                                </td>
                                
                        <?php		
							}
                        ?>
                    </tr>
                <?php
				}
				elseif($cekkode == $data["kode"])
				{
				?>
                	<tr>
                        <?php
							if($ceksat != $data["satuan"])//cek satuan
							{
						?>
                        		<td><?php echo $data["satuan"]; ?></td>
                                <td>
									<?php echo $data["nama_pkj"];?>
                                    <?php echo $data["pokok_kegiatan"]; ?>
                                </td>
                                
                        <?php
							}elseif($ceksat == $data["satuan"])
							{
						?>
                        		<td>
									<?php echo $data["nama_pkj"];?>
                                    <?php echo $data["pokok_kegiatan"]; ?>
                                </td>
                                
                        <?php		
							}
                        ?>
                    </tr>
                    
                <?php
                }//cek kode
				$cek_id_sat=$data["id_satuan"];
				$ceksat=$data["satuan"];
				$cekkode=$data["kode"];
			}//kode
	}
	
?>

<?php
	function ditail_pekerjaan()
	{
		error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
		$link=koneksi();
		$id=$_GET["id"];//judul
		$kat=$_GET["kat"];
		$judul=$_GET["judul"];
		$res=mysqli_query($link,"SELECT kode.id_kode,satuan.id_satuan,nama.id_pekerjaan,kode.kategori,kode.kode,satuan.satuan,nama.nama_pkj,nama.pokok_kegiatan,judul FROM judul j
JOIN kode_pekerjaan kode ON(kode.id_judul = j.id_judul)
JOIN satuan_pekerjaan satuan ON(satuan.id_kode = kode.id_kode)
JOIN nama_pekerjaan nama ON(nama.id_satuan = satuan.id_satuan)
		where j.id_judul='$id' or kode.kategori='$id'
		order by kode.id_kode desc
		");
		if(!$res){
			die("Query error! : ".mysqli_error($link));
		}
		$i=1;
			while ($data=mysqli_fetch_array($res))//tampil kode
			{
				$id_kode=$data["id_kode"];
				$nam_kod=$data["kode"];
				$jumkode=mysqli_query($link,"SELECT count(kode) as jumkod,kode,id_kode from judul
		join kode_pekerjaan using(id_judul)
		join satuan_pekerjaan using(id_kode)
		join nama_pekerjaan using(id_satuan)
		where kode='$nam_kod' group by kode
		");
				while ($data2=mysqli_fetch_array($jumkode))//tampil kode
				{
					$resjumkod=$data2["jumkod"];
				}
				if($cekkode != $data["kode"])//cek kode
				{
		?>
					<tr>
                    	<td rowspan="<?php echo $resjumkod;?>">
                        	<input type="checkbox" name="check_list[]" value="<?php echo $id_kode;?>">
                        </td>
                        <td rowspan="<?php echo $resjumkod;?>"><?php echo $i++; ?></td>
                        <td rowspan="<?php echo $resjumkod;?>"><?php echo $nam_kod; ?></td>
                        <?php
							$nam_satuan=$data["satuan"];
							$jumsat=mysqli_query($link,"SELECT count(satuan) as jumsat,kode from judul 
							join kode_pekerjaan using(id_judul)
							join satuan_pekerjaan using(id_kode)
							join nama_pekerjaan using(id_satuan)
							where satuan='$nam_satuan' and kode='$nam_kod' group by satuan");
							while ($data2=mysqli_fetch_array($jumsat))//tampil satuan
							{
								$resjumsat=$data2["jumsat"];
							}
							if($ceksat != $data["satuan"] || $cek_id_sat != $data["id_satuan"])//cek satuan
							{
						?>
                        		<td rowspan="<?php echo $resjumsat;?>"><?php echo $data["satuan"]; ?></td>
                                <td>
									<p>
									<strong><em><?php echo $data["nama_pkj"];?></em></strong>
                                    <?php echo $data["pokok_kegiatan"]; ?>
                               		</p>
                                </td>
                                <td>
                                     <a href="hapus/data_pekerjaan.php?id_jud=<?php echo $id;?>&id_satuan=<?php echo $data["id_satuan"];?>&id_peker=<?php echo $data["id_pekerjaan"]?>&nam_dat=<?php echo $data["nama_pkj"];?>&judul=<?php echo $data["judul"];?>&back=<?php echo $_GET["id"];?>&kat=<?php echo $_GET["kat"];?>" class="btn btn-danger btn-circle" data-placement="top" title="Hapus">
                                     <i class="fa fa-trash"></i>
                                    </a>
                                    <a href="form_ubah.php?id_jud=<?php echo $id;?>&id_satuan=<?php echo $data["id_satuan"];?>&id_peker=<?php echo $data["id_pekerjaan"];?>&judul=<?php echo $judul;?>&back=<?php echo $_GET["id"];?>&kat=<?php echo $_GET["kat"];?>" class="btn btn-primary btn-circle" data-placement="top" title="Ubah">
                                     <i class="fa fa-edit"></i>
                                    </a>
                                </td>
                        <?php
							}elseif($ceksat == $data["satuan"] && $cek_id_sat == $data["id_satuan"])
							{
						?>
                        		<td>
                                	<p>
									<strong><em><?php echo $data["nama_pkj"];?></em></strong>
                                    <?php echo $data["pokok_kegiatan"]; ?>
                                	</p>
                                </td>
                                <td>
                                     <a href="hapus/data_pekerjaan.php?id_jud=<?php echo $id;?>&id_satuan=<?php echo $data["id_satuan"];?>&id_peker=<?php echo $data["id_pekerjaan"]?>&nam_dat=<?php echo $data["nama_pkj"];?>&judul=<?php echo $data["judul"];?>&back=<?php echo $_GET["id"];?>&kat=<?php echo $_GET["kat"];?>" class="btn btn-danger btn-circle" data-placement="top" title="Hapus">
                                     <i class="fa fa-trash"></i>
                                    </a>
                                    <a href="form_ubah.php?id_jud=<?php echo $id;?>&id_satuan=<?php echo $data["id_satuan"];?>&id_peker=<?php echo $data["id_pekerjaan"];?>&judul=<?php echo $judul;?>&back=<?php echo $_GET["id"];?>&kat=<?php echo $_GET["kat"];?>" class="btn btn-primary btn-circle" data-placement="top" title="Ubah">
                                     <i class="fa fa-edit"></i>
                                    </a>
                                </td>
                        <?php		
							}
                        ?>
                    </tr>
                <?php
				}
				elseif($cekkode == $data["kode"])
				{
				?>
                	<tr>
                        <?php
							if($ceksat != $data["satuan"])//cek satuan
							{
						?>
                        		<td><?php echo $data["satuan"]; ?></td>
                                <td>
                                	<p>
									<strong><em><?php echo $data["nama_pkj"];?></em></strong>
                                    <?php echo $data["pokok_kegiatan"]; ?>
                                	</p>
                                </td>
                                <td>
                                     <a href="hapus/data_pekerjaan.php?id_jud=<?php echo $id;?>&id_satuan=<?php echo $data["id_satuan"];?>&id_peker=<?php echo $data["id_pekerjaan"]?>&nam_dat=<?php echo $data["nama_pkj"];?>&judul=<?php echo $data["judul"];?>&back=<?php echo $_GET["id"];?>&kat=<?php echo $_GET["kat"];?>" class="btn btn-danger btn-circle" data-placement="top" title="Hapus">
                                     <i class="fa fa-trash"></i>
                                    </a>
                                    <a href="form_ubah.php?id_jud=<?php echo $id;?>&id_satuan=<?php echo $data["id_satuan"];?>&id_peker=<?php echo $data["id_pekerjaan"];?>&judul=<?php echo $judul;?>&back=<?php echo $_GET["id"];?>&kat=<?php echo $_GET["kat"];?>" class="btn btn-primary btn-circle" data-placement="top" title="Ubah">
                                     <i class="fa fa-edit"></i>
                                    </a>
                                </td>
                        <?php
							}elseif($ceksat == $data["satuan"])
							{
						?>
                        		<td>
                                	<p>
									<strong><em><?php echo $data["nama_pkj"];?></em></strong>
                                    <?php echo $data["pokok_kegiatan"]; ?>
                                	</p>
                                </td>
                                <td>
                                     <a href="hapus/data_pekerjaan.php?id_jud=<?php echo $id;?>&id_satuan=<?php echo $data["id_satuan"];?>&id_peker=<?php echo $data["id_pekerjaan"]?>&nam_dat=<?php echo $data["nama_pkj"];?>&judul=<?php echo $data["judul"];?>&back=<?php echo $_GET["id"];?>&kat=<?php echo $_GET["kat"];?>" class="btn btn-danger btn-circle" data-placement="top" title="Hapus">
                                     <i class="fa fa-trash"></i>
                                    </a>
                                    <a href="form_ubah.php?id_jud=<?php echo $id;?>&id_satuan=<?php echo $data["id_satuan"];?>&id_peker=<?php echo $data["id_pekerjaan"];?>&judul=<?php echo $judul;?>&back=<?php echo $_GET["id"];?>&kat=<?php echo $_GET["kat"];?>" class="btn btn-primary btn-circle" data-placement="top" title="Ubah">
                                     <i class="fa fa-edit"></i>
                                    </a>
                                </td>
                        <?php		
							}
                        ?>
                    </tr>
                    
                <?php
                }//cek kode
				$cek_id_sat=$data["id_satuan"];
				$ceksat=$data["satuan"];
				$cekkode=$data["kode"];
			}//kode
	}
?>

<?php
	function hascar_pekerjaan()
	{
		error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
		$link=koneksi();
		$id=$_GET["cari"];
		$res=mysqli_query($link,"SELECT id_kode,id_satuan,judul,id_pekerjaan,kode,satuan,nama_pkj,pokok_kegiatan from judul
		join kode_pekerjaan using(id_judul)
		join satuan_pekerjaan using(id_kode)
		join nama_pekerjaan using(id_satuan)
		where pokok_kegiatan or nama_pkj like '%$id%'");
		if(!$res){
			die("Query error! : ".mysqli_error($link));
		}
		$i=1;
			while ($data=mysqli_fetch_array($res))//tampil kode
			{
	?>
					<tr>
                        <td><?php echo $i++; ?></td>
                        <td><?php echo $data["kode"];; ?></td>
                        		<td><?php echo $data["satuan"]; ?></td>
                                <td>
                                	<p>
									<strong><em><?php echo $data["nama_pkj"];?></em></strong>
                                    <?php echo $data["pokok_kegiatan"]; ?>
                                	</p>
                                </td>
                                <td>
                                     <a href="hapus/data_pekerjaan.php?id_satuan=<?php echo $data["id_satuan"];?>&id_peker=<?php echo $data["id_pekerjaan"];?>&judul=<?php echo $data["judul"];?>&back=<?php echo $_GET["cari"];?>" class="btn btn-danger btn-circle" data-placement="top" title="Hapus">
                                     <i class="fa fa-trash"></i>
                                    </a>
                                    <a href="form_ubah.php?id_satuan=<?php echo $data["id_satuan"];?>&id_peker=<?php echo $data["id_pekerjaan"];?>&judul=<?php echo $data["judul"];?>&back=<?php echo $_GET["cari"];?>" class="btn btn-primary btn-circle" data-placement="top" title="Ubah">
                             <i class="fa fa-edit"></i>
                            </a>
                    </tr>
                    
                <?php
                }
	}
	
?>

<?php
	function tampil_ubah_pekerjaan()
	{
		error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
		$id_s=$_GET["id_satuan"];
		$id_p=$_GET["id_peker"];
		$judul=$_GET["judul"];
		$back=$_GET["back"];
		$kat=$_GET["kat"];
		$link=koneksi();
		$res=mysqli_query($link,"SELECT * FROM satuan_pekerjaan
JOIN nama_pekerjaan USING(id_satuan)
join kode_pekerjaan using(id_kode)
where id_satuan='$id_s' and id_pekerjaan='$id_p'
");		
		if(!$res){
			die("Query error! : ".mysqli_error($link));
		}
			while ($data=mysqli_fetch_array($res))
			{
		?>
        			<form name="pekerjaan" method="post" action="" >	
                                    	<div class="panel-body">
                                <div class="form-group">
                                	 <table width="80%">
                                    	<tr>
                                        	<td><label>Kategori</label></td>
                                            <td>
                                            	<div class="form-group">
                                            	 <select class="form-control" name="kategori">
                                                	<option><?php echo $data["kategori"];?></option>
                                               		<?php pilih_kategori();?>
                                                </select>
                                                </div>
                                           	</td>
                                      	</tr>
                                        <tr>
                                        	<td><label>Kode</label></td>
                                            <td>
                                            	<div class="form-group">
                                            	<input class="form-control" type="text" name="kode" value="<?php echo $data["kode"];?>">
                                                </div>
                                           	</td>
                                      	</tr>
                                        <tr>
                                        	<td><label>Satuan</label></td>
                                            <td>
                                            	<div class="form-group">
                                            	<input class="form-control" type="text" name="satuan" value="<?php echo $data["satuan"];?>">
                                                </div>
                                           	</td>
                                      	</tr>
                                        <tr>
                                    		<td><label>Nama pekerjaan</label></td>
                                    		<td>
                                            	<div class="form-group">
                                            	<input class="form-control" type="text" name="nampek" value="<?php echo $data["nama_pkj"];?>">
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                    		<td><label>Pokok kegiatan</label></td>
                                    		<td>
                                            	<div class="form-group">
                                            	 <textarea id="editor1" name="kegpok"><?php echo $data["pokok_kegiatan"];?></textarea>
                                                    <script type="text/javascript">
													if ( typeof CKEDITOR == 'undefined' )
													{
														document.write('CKEditor not found');
													}
													else
													{
														var editor = CKEDITOR.replace( 'editor1' );	
															CKFinder.setupCKEditor( editor, '' ) ;
													}
													</script>
                                                </div>
                                            </td>
                                        </tr>
                                     </table>
                               </div>
                            </div>
                            
                                	
                            <div class="panel-footer">
                            	<input type="hidden" name="id_kode" value="<?php echo $data["id_kode"];?>">
                                <button type="submit" class="btn btn-primary" name="ubah">Ubah</button>
                                 <?php
										if (is_numeric($back)) 
											{
									?>
												<a href="detail.php?id=<?php echo $back;?>&judul=<?php echo $judul?>" class="btn btn-warning">
												Kembali
												</a>
									<?php	
											}
											elseif(isset($kat))
											{
									?>	
											<a href="detail.php?id=<?php echo $back;?>&judul=<?php echo $judul?>&kat=<?php echo $kat?>" class="btn btn-warning">Kembali</a>
									<?php	
											}else
											{
									?>
												<a href="hasilcari.php?cari=<?php echo $back;?>&judul=<?php echo $judul?>" class="btn btn-warning">Kembali</a>
									<?php		
											}
										
									 ?>
                            </div>
                            </form>
                       <?php ubah_data_pekerjaan();?>
        <?php	
			}
	}
?>

<?php
	function ubah_data_pekerjaan()
	{
		$id_jud=$_GET["id_jud"];
		$jud=$_GET["judul"];
		$id_s=$_GET["id_satuan"];
		$id_p=$_GET["id_peker"];
		$id_k=$_POST["id_kode"];
		$kategori=$_POST["kategori"];
		$kode=$_POST["kode"];
		$satuan=$_POST["satuan"];
		$nampek=$_POST["nampek"];
		$kegpok=$_POST["kegpok"];
		$back=$_GET["id_jud"];
		$link=koneksi();
		if(isset($_POST['ubah']))
		{
			$sql_up_kode=mysqli_query($link,"update kode_pekerjaan set kategori='$kategori',kode='$kode' where id_kode='$id_k'");
			if(isset($sql_up_kode))
			{
				$sql_up_sat=mysqli_query($link,"update satuan_pekerjaan set satuan='$satuan' where id_kode='$id_k' and id_satuan='$id_s'");
				if(isset($sql_up_sat))
				{
					$sql_up_nampek=mysqli_query($link,"update nama_pekerjaan set nama_pkj='$nampek', pokok_kegiatan='$kegpok' where id_satuan='$id_s' and id_pekerjaan='$id_p'");
					if(isset($sql_up_nampek))
					{
						if (is_numeric($back)) 
						{
							echo "<script>window.location = 'detail.php?id=$back&judul=$jud'; </script>";
						}elseif(isset($kat))
						{
							echo "<script>window.location = 'detail.php?id=$back&judul=$jud&kat=$kat'; </script>";
						}else
						{
							echo "<script>window.location = 'hasilcari.php?cari=$back&judul=$jud'; </script>";
						}
					}else
					{
						echo "gagal";
					}
				}
			}else
			{
				echo "gagal";
			}	 
		}
			
	}
?>

<?php
	function pekerjaan_cetak()
	{
		error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
		$link=koneksi();
		$res=mysqli_query($link,"SELECT * from judul where kategori='pekerjaan' ");		
		if(!$res){
			die("Query error! : ".mysqli_error($link));
		}
		$i=1;
			while ($data=mysqli_fetch_array($res))
			{
				$id=$data["id_judul"];
		?>
				<tr class="odd gradeX">
                    <td><?php echo $i++; ?></td>
                    <td>
                        <div class="form-group">
                        <label class="checkbox-inline">
                            <input type="checkbox" class="checkbox-inline" name="check_list[]" value="<?php echo $id;?>" >
                            <?php echo $data["judul"];?>
                        </label>
                    </div>
                    </td>
                </tr>
       <?php
			}
	}
?>

<?php
function ditail_cetak()
{
		if(!empty($_POST['check_list']))
		{
			$checked_count = count($_POST['check_list']);
			echo "Anda memilih ".$checked_count." judul <br/>";
		?>
        <form action="../../tcpdf/examples/pdf.php" method="post">
       	<textarea id="" name="data">
       <?php
			foreach($_POST['check_list'] as $selected) 
			{
				error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
				$link=koneksi();
				//untuk menampilkan data
				$res=mysqli_query($link,"SELECT id_kode,id_satuan,id_pekerjaan,kode,satuan,nama_pkj,pokok_kegiatan,judul from judul
				join kode_pekerjaan using(id_judul)
				join satuan_pekerjaan using(id_kode)
				join nama_pekerjaan using(id_satuan)
				where id_judul='$selected'
				order by satuan desc
				");
				if(!$res){
					die("Query error! : ".mysqli_error($link));
				}
				//tampilkan judul
				$jud=mysqli_query($link,"SELECT * FROM judul where id_judul='$selected'");
				while($judul=mysqli_fetch_array($jud))
				{
					$h1=$judul["judul"];
				}
				$i=1;
		?>
                 <h1 align="center"><?php echo $h1;?></h1>
                 <table border="1">
               	 	     <tr>
                         <td width="25" align="center">NO</td>
                         <td width="45" align="center">KODE</td>
                         <td width="50" align="center">SATUAN</td>
                         <td width="520" align="center">ANALISA HARGA SATUAN <?php echo $h1;?></td>
                         </tr>
	                	 <?php
                 				while ($data=mysqli_fetch_array($res))//tampil kode
								{
									$id_kode=$data["id_kode"];
									$nam_kod=$data["kode"];
									$jumkode=mysqli_query($link,"SELECT count(kode) as jumkod,kode,id_kode from judul
											join kode_pekerjaan using(id_judul)
											join satuan_pekerjaan using(id_kode)
											join nama_pekerjaan using(id_satuan)
											where kode='$nam_kod' group by kode");
									while ($data2=mysqli_fetch_array($jumkode))//tampil kode
									{
										$resjumkod=$data2["jumkod"];
									}
									if($cekkode != $data["kode"])//cek kode
									{
						 ?>
                         			<tr>
                                        <td rowspan="<?php echo $resjumkod;?>" align="center"><?php echo $i++; ?></td>
                                        <td rowspan="<?php echo $resjumkod;?>" align="center"><?php echo $nam_kod; ?></td>
                                        <?php
                                            $nam_satuan=$data["satuan"];
                                            $jumsat=mysqli_query($link,"SELECT count(satuan) as jumsat,kode from judul 
                                            join kode_pekerjaan using(id_judul)
                                            join satuan_pekerjaan using(id_kode)
                                            join nama_pekerjaan using(id_satuan)
                                            where satuan='$nam_satuan' and kode='$nam_kod' group by satuan");
                                            while ($data2=mysqli_fetch_array($jumsat))//tampil satuan
                                            {
                                                $resjumsat=$data2["jumsat"];
                                            }
                                            if($ceksat != $data["satuan"] || $cek_id_sat != $data["id_satuan"])//cek satuan
                                            {
                                        ?>
                                                <td rowspan="<?php echo $resjumsat;?>" align="center"><?php echo $data["satuan"]; ?></td>
                                                <td>
                                                    <?php echo $data["nama_pkj"];?>
                                                    <?php echo $data["pokok_kegiatan"]; ?>
                                                </td>
                                                
                                        <?php
                                            }elseif($ceksat == $data["satuan"] && $cek_id_sat == $data["id_satuan"])
                                            {
                                        ?>
                                                <td>
                                                    <?php echo $data["nama_pkj"];?>
                                                    <?php echo $data["pokok_kegiatan"]; ?>
                                                </td>
                                                
                                        <?php		
                                            }
                                        ?>
                                    </tr>
                                    <?php
									}
									elseif($cekkode == $data["kode"])
									{
									?>
										<tr>
											<?php
												if($ceksat != $data["satuan"])//cek satuan
												{
											?>
													<td align="center"><?php echo $data["satuan"]; ?></td>
													<td>
														<?php echo $data["nama_pkj"];?>
														<?php echo $data["pokok_kegiatan"]; ?>
													</td>
													
											<?php
												}elseif($ceksat == $data["satuan"])
												{
											?>
													<td>
														<?php echo $data["nama_pkj"];?>
														<?php echo $data["pokok_kegiatan"]; ?>
													</td>
													
											<?php		
												}
											?>
										</tr>
										
									<?php
									}//cek kode
									$cek_id_sat=$data["id_satuan"];
									$ceksat=$data["satuan"];
									$cekkode=$data["kode"];
								}//kode
								?>
						</tbody>
                 </table>          
<?php
				$coba="$h1";
				$i=0;
			}
?>
		</textarea>
        <script type="text/javascript">
				if ( typeof CKEDITOR == 'undefined' )
				{
				document.write('CKEditor not found');
				}
				else
				{
				var editor = CKEDITOR.replace( 'cetak_sarfas' );	
				CKFinder.setupCKEditor( editor, '' ) ;
				}
				</script>
        <input type="hidden" name="judul" value="<?php echo $h1;?>">
        <input type="submit" name="cetak_" value="Cetak">
        </form>
<?php		
		}
		
	}
?>   

<?php
	function menu_sarfas()
	{
		error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
		$link=koneksi();
		$res=mysqli_query($link,"SELECT sar.kategori as katsar, j.kategori 
FROM sarana_dan_fasilitas sar
JOIN judul j ON (sar.id_judul = j.id_judul)
GROUP BY sar.kategori 
HAVING j.kategori = 'sarana dan fasilitas'");		
		if(!$res){
			die("Query error! : ".mysqli_error($link));
		}
		?>
         	<ul class="dropdown-menu">
        <?php	
			while  ($data=mysqli_fetch_array($res)) 
			{
		?>
                    <li>
                        <a href="../sarana_dan_fasilitas/detail_judul.php?id=<?php echo $data["katsar"];?>&judul=<?php echo $data["katsar"];?>"><?php echo $data["katsar"];?></a>
                    </li>
       <?php
			}
			?>
            </ul>
       <?php
	}
?>

<?php
	function menu_prasarana()
	{
		error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
		$link=koneksi();
		$res=mysqli_query($link,"SELECT j.judul,sar.kategori AS katsar, j.kategori 
FROM sarana_dan_fasilitas sar
JOIN judul j ON (sar.id_judul = j.id_judul)
GROUP BY katsar
HAVING j.kategori = 'prasarana'");		
		if(!$res){
			die("Query error! : ".mysqli_error($link));
		}
		?>
         	<ul class="dropdown-menu">
        <?php	
			while  ($data=mysqli_fetch_array($res)) 
			{
		?>
                    <li>
                        <a href="../prasarana/detail_judul.php?id=<?php echo $data["katsar"];?>&judul=<?php echo $data["katsar"];?>&kat=<?php echo $data["katsar"];?>">
						<?php echo $data["katsar"];?>
                        </a>
                    </li>
       <?php
			}
			?>
            </ul>
       <?php
	}
?>


<?php
	function menu_pekerjaan()
	{
		error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
		$link=koneksi();
		$res=mysqli_query($link,"SELECT j.judul,sar.kategori AS katsar, j.kategori 
FROM kode_pekerjaan sar
JOIN judul j ON (sar.id_judul = j.id_judul)
GROUP BY katsar
HAVING j.kategori = 'pekerjaan'");		
		if(!$res){
			die("Query error! : ".mysqli_error($link));
		}
		?>
         	<ul class="dropdown-menu">
        <?php	
			while  ($data=mysqli_fetch_array($res)) 
			{
		?>
                    <li>
                        <a href="detail.php?id=<?php echo $data["katsar"];?>&judul=<?php echo $data["katsar"];?>&kat=<?php echo $data["katsar"];?>">
						<?php echo $data["katsar"];?></a>
                    </li>
       <?php
			}
			?>
            </ul>
       <?php
	}
?>

<?php
	function tambah_kategori()
	{
		error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
		$kategori=$_POST["tkategori"];
		$link=koneksi();
		if(isset($_POST["tambahkategori"]))
		{
			if(empty($kategori))
			{
				echo "tidak ada data yang tersimpan";
			}
			else
			{	
				$sql="insert into kategori values(NULL,'$kategori')"; 
				$res=mysqli_query($link,$sql);
				if(isset($res))
				{
					$nama=$_SESSION['namauser'];
					$aktivitas="tambah kategori : $kategori";
					$level=$_SESSION['level'];
					$sqlhis="insert into history_pengguna (id_history,level,nama,aktivitas,waktu)values(NULL,'$level','$nama','$aktivitas',now())";
					$reshis=mysqli_query($link,$sqlhis);
					echo "<script>window.location = 'index.php'; </script>";
				}
					else
				{
					echo "gagal";                            
				}
			}
					
		}
	}
?>
<?php
	function pilih_kategori()
	{
		error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
		$link=koneksi();
		$res=mysqli_query($link,"select * from kategori ");		
		if(!$res){
			die("Query error! : ".mysqli_error($link));
		}
			while  ($data=mysqli_fetch_array($res)) 
			{
		?>
        		<option value="<?php echo $data["kategori"];?>"><?php echo $data["kategori"];?></option>
       <?php	
			}
	}
?>

<?php
	function data_kategori()
	{
		error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
		$link=koneksi();
		$res=mysqli_query($link,"SELECT * from kategori");		
		if(!$res){
			die("Query error! : ".mysqli_error($link));
		}
		$i=1;
			while ($data=mysqli_fetch_array($res))
			{
		?>
        			<tr class="odd gradeX">
                        <td><?php echo $i++;?></td>
                        <td><?php echo $data["kategori"]; ?></td>
                        <td>
                        	<a href="hapus/kategori.php?id=<?php echo $data["id_kategori"];?>&nama=<?php echo $data["kategori"];?>" class="btn btn-danger btn-circle" data-placement="top" title="Hapus" onclick="return confirm('Anda yakin, ingin menghapus data ini?');">
                             <i class="fa fa-trash"></i>
                            </a>
                            <!-- ubah-->
                            <?php
								$obj=$data["kategori"];
								$id=$data["id_kategori"]; 
							?>
                            <button class="btn btn-success btn-circle" data-toggle="modal" data-target="#myModal<?php echo $obj;?>">
                                <i class="fa fa-edit"></i>
                            </button>
                            <div class="modal fade" id="myModal<?php echo $obj;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="myModalLabel">Ubah data</h4>
                                        </div>
                                        <form method="post">
                                            <div class="modal-body">
                                            	Data sebelumnya <strong><?php echo $obj;?></strong> 
                                                <input class="form-control" type="text" value="<?php echo $obj;?>" name="newkategori">
                                                <input type="hidden" value="<?php echo $obj;?>" name="kategori">
                                                <input type="hidden" value="<?php echo $id; ?>" name="id">
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                                                <button type="submit" class="btn btn-primary" name="ubahkategori">Ubah</button>
                                            </div>
                                            <?php ubah_data_kategori();?>
                                        </form>
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>
                            <!-- /ubah -->
                        </td>
                   </tr>
<?php
			}
	}
?>

<?php
	function ubah_data_kategori()
	{
		error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
		$link=koneksi();
		$last=$_POST["kategori"];
		$new=$_POST["newkategori"];
		$id=$_POST["id"];
		if(isset($_POST['ubahkategori']))
			{ 
					$sql="UPDATE kategori SET kategori = '$new' WHERE id_kategori = '$id'"; 
					$res=mysqli_query($link,$sql);
					if(isset($res))
					{
						$nama=$_SESSION['namauser'];
						$aktivitas="Ubah kategori $last > $new";
						$level=$_SESSION['level'];
						$sqlhis="insert into history_pengguna (id_history,level,nama,aktivitas,waktu)values(NULL,'$level','$nama','$aktivitas',now())";
						$reshis=mysqli_query($link,$sqlhis);
						if(isset($reshis))

						{
							echo "<script>window.location = 'index.php'; </script>";
						}
					}
					
		}
	}
?>



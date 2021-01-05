<?php 
	include("../../conn.php");
?>

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
					  $kategori  = $data->val($i, 1);
					  $no_sap  = $data->val($i, 2);
					  $nama_brg           = $data->val($i, 3);
					  $spesifikasi           = $data->val($i, 4);
					  $satuan           = $data->val($i, 5);
					  $mata_uang           = $data->val($i, 6);
					  $harga_satuan           = $data->val($i, 7);
					  $vendor           = $data->val($i, 8);
				 	  
					  $judul=$_POST["judul"];
					  
					  $query = "INSERT into sarana_dan_fasilitas (id_sarfas,id_judul,kategori,no_sap,nama_brg,spesifikasi,satuan,mata_uang,harga_satuan,vendor)values(NULL,'$judul','$kategori','$no_sap','$nama_brg','$spesifikasi','$satuan','$mata_uang','$harga_satuan','$vendor')";
					  $hasil = mysqli_query($link,$query);
					  flush();
					  
				 
					  //sleep(1);
			}
						 
		//    hapus file xls yang udah dibaca
			//unlink($_FILES['filepegawaiall']['name']);
		}
	}
?>

<?php
	function nav()
	{
		error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
		$link=koneksi();
		$res=mysqli_query($link,"select * from judul where kategori='prasarana'");		
		if(!$res){
			die("Query error! : ".mysqli_error($link));
		}
		$i=1;
			while ($data=mysqli_fetch_array($res))
			{
				$id=$data["id_judul"];
				$resjum=mysqli_query($link,"select * from sarana_dan_fasilitas where id_judul = '$id' ");
				
		?>
        		<li>
                	<a href="detail_judul.php?id=<?php echo $id;?>&judul=<?php echo $data["judul"];?>"><i class="fa fa-circle fa-fw"></i> <?php echo $data["judul"]; ?> (<?php echo mysqli_num_rows($resjum);?>)</a>
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
	function sarfas_cetak()
	{
		error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
		$link=koneksi();
		$res=mysqli_query($link,"SELECT * from judul where kategori='prasarana' ");		
		if(!$res){
			die("Query error! : ".mysqli_error($link));
		}
		$i=1;
			while ($data=mysqli_fetch_array($res))
			{
				$id=$data["id_judul"];
				$res2=mysqli_query($link,"SELECT * from sarana_dan_fasilitas where id_judul = '$id'");
				$total=mysqli_num_rows($res2);
		?>
				<tr class="odd gradeX">
                    <td><?php echo $i;?></td>
                    <td>
                        <div class="form-group">
                        	<label class="checkbox-inline">
                        		<input type="checkbox" name="check_list[]" value="<?php echo $id;?>">
                        		<?php echo $data["judul"];?>
                        	</label>
                        </div>
                    </td>
               </tr>
        <?php
				$i++;		
			}
	}
?>

<?php
	function data_sarfas()
	{
		error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
		$link=koneksi();
		$res=mysqli_query($link,"SELECT no_sap, nama_brg,spesifikasi, satuan, mata_uang, harga_satuan, vendor from sarana_dan_fasilitas
		join judul using(id_judul) where kategori = 'sarana dan fasiltas'");		
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
		$cari=$_GET["cari"];
		$res=mysqli_query($link,"SELECT 
judul.judul,
judul.kategori, 
judul.tanggal, 
judul.no_kontrak, 
judul.file,
sar.id_sarfas,
sar.no_sap,
sar.kategori, 
sar.nama_brg, 
sar.spesifikasi, 
sar.satuan, 
sar.mata_uang, 
sar.harga_satuan, 
sar.vendor
		FROM sarana_dan_fasilitas sar
		JOIN judul ON (judul.id_judul = sar.id_judul) 
		WHERE judul.kategori='prasarana' AND sar.nama_brg LIKE '%$cari%' OR sar.no_sap LIKE '%$cari%'");		
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
                        <td><?php echo $data["judul"]; ?></td>
                        <td><?php echo $data["tanggal"]; ?></td>
                        <td>
                        	<?php 
								if(empty($data["file"]))
								{
									echo $data["no_kontrak"];
								}
								else
								{
								?>
                                	<a href="../../info_pdf/<?php echo $data["file"];?>"  title="Info">
                                    	<?php echo $data["no_kontrak"]; ?>
                                    </a>
								<?php
                                }
							?>
                        </td>
                        <td><?php echo $data["kategori"]; ?></td>
                        <td><?php echo $data["no_sap"]; ?></td>
                        <td><?php echo $data["nama_brg"]; ?></td>
                        <td><?php echo $data["spesifikasi"]; ?></td>
                        <td><?php echo $data["satuan"]; ?></td>
                        <td><?php echo $data["mata_uang"]; ?></td>
                        <td>
                        	<?php
							if($data["mata_uang"] != "IDR")
							{
								echo number_format($data["harga_satuan"], 2 , '.' , ',' ); 
							}
							elseif($data["mata_uang"] == "IDR")
							{
								echo number_format($data["harga_satuan"],0,".",".");
							}
							?>
                        </td>
                        <td><?php echo $data["vendor"]; ?></td>
                        <td>
                        	 <a href="hapus/data_sarfas.php?id=<?php echo $data["id_sarfas"];?>&nama=<?php echo $data["nama_brg"];?>&judul=<?php echo $data["judul"];?>&back=<?php echo $cari;?>" class="btn btn-danger btn-circle" data-placement="top" title="Hapus">
                             <i class="fa fa-trash"></i>
                            </a>
                            <a href="form_ubah.php?id=<?php echo $data["id_sarfas"];?>&nama=<?php echo $data["nama_brg"];?>&judul=<?php echo $data["judul"];?>&back=<?php echo $cari;?>" class="btn btn-primary btn-circle" data-placement="top" title="Ubah">
                             <i class="fa fa-edit"></i>
                            </a>
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
		$res=mysqli_query($link,"select * from judul where kategori='prasarana'");		
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
	function tambah_judul()
	{
		error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
		$judul=$_POST["tjudul"];
		$no_kontrak=$_POST["no_kontrak"];
		$tgl=$_POST["tgl"];
		
		$type =pathinfo($_FILES["file"]["name"]);
		$link=koneksi();
		
		$cek=$_FILES["file"]["name"];
		
		
		if(isset($_POST["tambahjudul"]))
		{
			//data
			$cekdata="select file from judul where file ='$cek'";
			$ada=mysqli_query($link,$cekdata) or die("salah bro");
			
			if(empty($judul) && empty($no_kontrak) && empty($tgl))//cek isian form(mysqli_num_rows($ada)>0)//cek kesamaan data di folder 
			{ 
				echo "<script>alert('Tolong lengkapi isi form judul')</script>";
			}
			elseif(mysqli_num_rows($ada)>0)//cek kesamaan data di folder		
			{
				echo "<script>alert('Nama file sudah ada, coba ganti dengan nama file yang baru')</script>";	
			}
			elseif($type["extension"] != "pdf" && !empty($_FILES["file"]["name"]) )// cek tipe file
			{
				echo "<script>alert('Tipe file bukan PDF')</script>";	
			}
			else
			{
				if(empty($_FILES["file"]["name"]))
				{
					$sql="insert into judul values(NULL,'prasarana','$judul','$no_kontrak','$tgl',NULL)"; 
					$res=mysqli_query($link,$sql);
					if(isset($res))
					{
						echo "<script>window.location = 'index.php'; </script>";
					}
				}else
				{
					$file=$_FILES["file"]["name"];
					$sql="insert into judul values(NULL,'prasarana','$judul','$no_kontrak','$tgl','$file')"; 
					move_uploaded_file($_FILES['file']['tmp_name'], "../../info_pdf/".$_FILES['file']['name']);
					$res=mysqli_query($link,$sql);
					if(isset($res))
					{
						echo "<script>window.location = 'index.php'; </script>";
					}
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
						echo "<script>window.location = 'index.php'; </script>";
					}
					
		}
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
					echo "<script>window.location = 'index.php'; </script>";
				}
			}
					
		}
	}
?>


<?php
	function pilih_satuan()
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
		$satuan=$_POST["tsatuan"];
		$link=koneksi();
		if(isset($_POST["tambahsatuan"]))
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
					echo "<script>window.location = 'index.php'; </script>";                            
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
		$tambah=$_POST["tmatauang"];
		$link=koneksi();
		if(isset($_POST["tambahmatauang"]))
		{
			if(empty($tambah))
			{
				echo "tidak ada data yang tersimpan";
			}
			else
			{	$sql="insert into mata_uang values(NULL,'$tambah')"; 
				$res=mysqli_query($link,$sql);
				if(iseet($res))
				{
					echo "<script>window.location = 'index.php'; </script>";                            
				}
			}
					
		}
	}
?>


<?php
	function pilih_vendor()
	{
		error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
		$link=koneksi();
		$res=mysqli_query($link,'select * from vendor');		
		if(!$res){
			die("Query error! : ".mysqli_error($link));
		}
			while  ($data=mysqli_fetch_array($res)) 
			{
		?>
        		<option><?php echo $data["nama_vendor"];?></option>
       <?php	
			}
	}
?>

<?php
	function tambah_vendor()
	{
		error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
		$tambah=$_POST["tvendor"];
		$link=koneksi();
		if(isset($_POST["tambahvendor"]))
		{
			if(empty($tambah))
			{
				echo "tidak ada data yang tersimpan";
			}
			else
			{	$sql="insert into vendor values(NULL,'$tambah')"; 
				$res=mysqli_query($link,$sql);
				if(isset($res))
				{
					echo "<script>window.location = 'index.php'; </script>";                          
				}
			}
					
		}
	}
?>

<?php
	function data_vendor()
	{
		error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
		$link=koneksi();
		$res=mysqli_query($link,"SELECT * from vendor");		
		if(!$res){
			die("Query error! : ".mysqli_error($link));
		}
		$i=1;
			while ($data=mysqli_fetch_array($res))
			{
		?>
        			<tr class="odd gradeX">
                        <td><?php echo $i++;?></td>
                        <td><?php echo $data["nama_vendor"]; ?></td>
                        <td>
                        	<a href="hapus/vendor.php?id=<?php echo $data["id_vendor"];?>&nama=<?php echo $data["nama_vendor"];?>" class="btn btn-danger btn-circle" data-placement="top" title="Hapus" onclick="return confirm('Anda yakin, ingin menghapus data ini?');">
                             <i class="fa fa-trash"></i>
                            </a>
                            <!-- ubah-->
                            <?php
								$obj=$data["nama_vendor"];
								$id=$data["id_vendor"]; 
							?>
                            <button class="btn btn-success btn-circle" data-toggle="modal" data-target="#myModal<?php echo $id;?>">
                                <i class="fa fa-edit"></i>
                            </button>
                            <div class="modal fade" id="myModal<?php echo $id;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="myModalLabel">Ubah data</h4>
                                        </div>
                                        <form method="post">
                                            <div class="modal-body">
                                            	Data sebelumnya <strong><?php echo $obj;?></strong> 
                                                <input class="form-control" type="text" value="<?php echo $obj;?>" name="newvendor">
                                                <input type="hidden" value="<?php echo $obj;?>" name="vendor">
                                                <input type="hidden" value="<?php echo $id; ?>" name="id">
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                                                <button type="submit" class="btn btn-primary" name="ubahvendor">Ubah</button>
                                            </div>
                                            <?php ubah_data_vendor();?>
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
	function ubah_data_vendor()
	{
		$satuan_sebelumnya=$_POST["vendor"];
		$obj=$_POST["newvendor"];
		$id=$_POST["id"];
		$link=koneksi();
		if(isset($_POST['ubahvendor']))
			{ 
				if(empty($obj))
				{
				?>
                	<div class="alert alert-danger alert-dismissable">
                    	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        Tolong isi semua form
                    </div>
				<?php
				}
				else
				{	
					$sql="UPDATE vendor SET nama_vendor = '$obj' WHERE id_vendor = '$id'"; 
					$res=mysqli_query($link,$sql);
					if(isset($res))
					{
						echo " <meta http-equiv=\"refresh\" content=\"0\" /> ";
					}
				}	
		}
	}
?>

<?php
	function data_satuan()
	{
		error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
		$link=koneksi();
		$res=mysqli_query($link,"SELECT * from satuan");		
		if(!$res){
			die("Query error! : ".mysqli_error($link));
		}
		$i=1;
			while ($data=mysqli_fetch_array($res))
			{
		?>
        			<tr class="odd gradeX">
                        <td><?php echo $i++;?></td>
                        <td><?php echo $data["nama_satuan"]; ?></td>
                        <td>
                        	<a href="hapus/satuan.php?id=<?php echo $data["id_satuan"]; ?>&nama=<?php echo $data["nama_satuan"];?>" class="btn btn-danger btn-circle" data-placement="top" title="Hapus" onclick="return confirm('Anda yakin, ingin menghapus data ini?');">
                             <i class="fa fa-trash"></i>
                            </a>
                            <!-- ubah-->
                            <?php
								$obj=$data["nama_satuan"];
								$id=$data["id_satuan"]; 
							?>
                            <button class="btn btn-success btn-circle" data-toggle="modal" data-target="#myModal<?php echo $id;?>">
                                <i class="fa fa-edit"></i>
                            </button>
                            <div class="modal fade" id="myModal<?php echo $id;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="myModalLabel">Ubah data</h4>
                                        </div>
                                        <form method="post">
                                            <div class="modal-body">
                                            	Data sebelumnya <strong><?php echo $obj;?></strong> 
                                                <input class="form-control" type="text" value="<?php echo $obj;?>" name="newsat">
                                                <input type="hidden" value="<?php echo $obj;?>" name="sat">
                                                <input type="hidden" value="<?php echo $id; ?>" name="id">
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                                                <button type="submit" class="btn btn-primary" name="ubahsat">Ubah</button>
                                            </div>
                                            <?php ubah_data_satuan();?>
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
	function ubah_data_satuan()
	{
		$satuan_sebelumnya=$_POST["sat"];
		$obj=$_POST["newsat"];
		$id=$_POST["id"];
		$link=koneksi();
		if(isset($_POST['ubahsat']))
			{ 
				if(empty($obj))
				{
				?>
                	<div class="alert alert-danger alert-dismissable">
                    	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        Tolong isi semua form
                    </div>
				<?php
				}
				else
				{	
					$sql="UPDATE satuan SET nama_satuan = '$obj' WHERE id_satuan = '$id'"; 
					$res=mysqli_query($link,$sql);
					if(isset($res))
					{
						echo " <meta http-equiv=\"refresh\" content=\"0\" /> ";
					}
				}	
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
                            <!-- ubah-->
                            <?php
								$data=$data["nama_matauang"];
								$id=$data["id_matauang"]; 
							?>
                            <button class="btn btn-success btn-circle" data-toggle="modal" data-target="#myModal<?php echo $id;?>">
                                <i class="fa fa-edit"></i>
                            </button>
                            <div class="modal fade" id="myModal<?php echo $id;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="myModalLabel">Ubah data</h4>
                                        </div>
                                        <form method="post">
                                            <div class="modal-body">
                                            	Data sebelumnya <strong><?php echo $data;?></strong> 
                                                <input class="form-control" type="text" value="<?php echo $data;?>" name="newmatu">
                                                <input type="hidden" value="<?php echo $data;?>" name="matu">
                                                <input type="hidden" value="<?php echo $id; ?>" name="id">
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                                                <button type="submit" class="btn btn-primary" name="ubahmat">Ubah</button>
                                            </div>
                                        </form>
                                        <?php ubah_data_matua();?>
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
	function ubah_data_matua()
	{
		error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
		$link=koneksi();
		$last=$_POST["matu"];
		$new=$_POST["newmatu"];
		$id_matu=$_POST["id"];
		if(isset($_POST['ubahmat']))
			{ 
					$sql="UPDATE mata_uang SET mata_uang = '$matu' WHERE id_matauang = '$id_matu'"; 
					$res=mysqli_query($link,$sql);
					if(isset($res))
					{
						echo " <meta http-equiv=\"refresh\" content=\"0\" /> ";
					}
					
		}
	}
?>
<?php
	function data_judul()
	{
		error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
		$link=koneksi();
		$res=mysqli_query($link,"SELECT id_judul,judul,no_kontrak,tanggal,REPLACE(judul,' ','') AS kode, file from judul 
		where kategori='prasarana'");		
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
                        <a href="detail_judul.php?id=<?php echo $data["id_judul"];?>&judul=<?php echo $data["judul"];?>"><?php echo $data["judul"];?></a>
                        </td>
                        <td>
                        	<?php 
								if(empty($data["file"]))
								{
									echo $data["no_kontrak"];
								}
								else
								{
								?>
                                	<a href="../../info_pdf/<?php echo $data["file"];?>"  title="Info">
                                    	<?php echo $data["no_kontrak"]; ?>
                                    </a>
								<?php
                                }
							?>
                        </td>
                        <td><?php echo $data["tanggal"];?></td>
                        <td>
                        
                        	<a href="detail_judul.php?id=<?php echo $data["id_judul"];?>&judul=<?php echo $data["judul"]; ?>" class="btn btn-danger btn-circle" data-placement="top" title="Hapus">
                             <i class="fa fa-trash"></i>
                            </a>
                            <!-- ubah-->
                            <?php $id3=$data["id_judul"];?>
							<?php
								$kode=$data["kode"];
								$judul=$data["judul"];
								$no_kontrak=$data["no_kontrak"];
								$tgl=$data["tanggal"];
							?>
                            <button class="btn btn-success btn-circle" data-toggle="modal" data-target="#myModal<?php echo $kode;?>">
                                <i class="fa fa-edit"></i>
                            </button>
                            <div class="modal fade" id="myModal<?php echo $kode;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="myModalLabel">Ubah data <?php echo $judul;?></h4>
                                        </div>
                                        <form method="post" enctype="multipart/form-data">
                                            <div class="modal-body">
                                            	<table class="table">
                                                <tr>
                                                	 <td>
                                                        <input class="form-control" type="text" value="<?php echo $judul;?>" name="newjudul">
                                                    </td>
                                               </tr>
                                               <tr>     
                                                    <td>
                                                        <input class="form-control" type="text" value="<?php echo $data["no_kontrak"];?>" name="new_nokon">
                                                    </td>
                                               </tr>
                                               <tr>   
                                                    <td>
                                                    	<input class="form-control" type="date" value="<?php echo $tgl;?>" name="newtgl">
                                                    </td>
                                               </tr>
                                               <tr>   
                                                     <td>
                                                    	<input class="form-control" type="file" name="newfile"> <?php echo $data["file"];?>
                                                    </td>
                                                </tr>
                                                    <input type="hidden" value="<?php echo $data;?>" name="lastjudul">
                                                    <input type="hidden" value="<?php echo $id3; ?>" name="id">
                                                </table>
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
                            <?php 
								if(isset($data["file"]))
								{
							?>
                            		<a href="info_pdf/<?php echo $data["file"];?>" class="btn btn-info btn-circle" title="Info">
                                    	<i class="fa fa-file-text-o"></i>
                                    </a>
                            <?php		
								}
							?>
                            
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
		$new_nokon=$_POST["new_nokon"];
		$new_tgl=$_POST["newtgl"];
		$new_file=$_FILES["newfile"]["name"];
		$id=$_POST["id"];
		$link=koneksi();
		$type =pathinfo($_FILES["newfile"]["name"]);
		
		if(isset($_POST['ubahjudul']))
			{
				if(empty($new_file))
				{
					$sql="UPDATE judul SET judul = '$new',no_kontrak = '$new_nokon',tanggal = '$new_tgl' 
					WHERE id_judul = '$id'"; 
					$res=mysqli_query($link,$sql);
					if(isset($res))
					{
						echo "<script>window.location = 'index.php'; </script>";
					}
				}else
				{
					//data
					$cekdata="select file from judul where file ='$new_file'";
					$ada=mysqli_query($link,$cekdata) or die("salah bro");
					
					
					if(mysqli_num_rows($ada)>0)//cek kesamaan data di folder		
					{
						echo "<script>alert('Nama file sudah ada, coba ganti dengan nama file yang baru')</script>";	
					}
					elseif($type["extension"] != "pdf" )// cek tipe file
					{
						echo "<script>alert('Tipe file bukan PDF')</script>";	
					}
					else
					{
						$sql="UPDATE judul SET judul = '$new',no_kontrak = '$new_nokon',tanggal = '$new_tgl', file='$new_file' 
						WHERE id_judul = '$id'"; 
						
						//simpan file
						move_uploaded_file($_FILES['newfile']['tmp_name'], "../../info_pdf/".$_FILES['newfile']['name']);
						
						//delete file
						unlink('../../info_pdf/'.$data['file']);
						$res=mysqli_query($link,$sql);
						if(isset($res))
						{
							echo "<script>window.location = 'index.php'; </script>";
						}
					}
				}
			}
	}
?>

<?php
	function data_sarana()
	{
		error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
		$link=koneksi();
		$id=$_GET['id'];
		$kat=$_GET['kat'];
		$judul=$_GET['judul'];
		$res=mysqli_query($link,"SELECT j.judul,sar.id_sarfas,sar.kategori, sar.no_sap, sar.nama_brg, sar.spesifikasi, sar.satuan, sar.mata_uang, sar.harga_satuan, sar.vendor
		from sarana_dan_fasilitas sar 
		join judul j on(sar.id_judul = j.id_judul) 
		where sar.id_judul = '$id' or sar.kategori='$id'");		
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
                        <td>
                        	<input type="checkbox" name="check_list[]" value="<?php echo $data["id_sarfas"];?>">
                        </td>
                        <td><?php echo $j++;?></td>
                       	<td><?php echo $data["kategori"]; ?></td>
                        <td><?php echo $data["no_sap"]; ?></td>
                        <td><?php echo $data["nama_brg"]; ?></td>
                        <td><?php echo $data["spesifikasi"]; ?></td>
                        <td><?php echo $data["satuan"]; ?></td>
                        <td><?php echo $data["mata_uang"]; ?></td>
                        <td>
							<?php
							if($data["mata_uang"] != "IDR")
							{
								echo number_format($data["harga_satuan"], 2 , '.' , ',' ); 
							}
							elseif($data["mata_uang"] == "IDR")
							{
								echo number_format($data["harga_satuan"],0,".",".");
							}
							?>
                        </td>
                        <td><?php echo $data["vendor"]; ?></td>
                        <td>
                            <a href="hapus/data_sarfas.php?id=<?php echo $data["id_sarfas"];?>&nama=<?php echo $data["nama_brg"];?>&judul=<?php echo $judul;?>&back=<?php echo $id;?>&kat=<?php echo $kat;?>" class="btn btn-danger btn-circle" data-placement="top" title="Hapus" onclick="return confirm('Anda yakin, ingin menghapus data ini? ');">
                             <i class="fa fa-trash"></i>
                            </a>
                           <a href="form_ubah.php?id=<?php echo $data["id_sarfas"];?>&nama=<?php echo $data["nama_brg"];?>&judul=<?php echo $judul;?>&back=<?php echo $id;?>&kat=<?php echo $kat;?>" class="btn btn-primary btn-circle" data-placement="top" title="Ubah">
                             <i class="fa fa-edit"></i>
                            </a>
                        </td>
                   	</tr>
        <?php
		}
	}
?>

<?php
	function tambah_sarfas()
	{
		error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
		$judul=$_POST["namajudul"];
		$nosap=$_POST["nosap"];
		$kategori=$_POST["kategori"];
		$nama=$_POST["namabrg"];
		$spesifikasi=$_POST["spesifikasi"];
		$satuan=$_POST["satuan"];
		$matauang=$_POST["matauang"];
		$hargasatuan=$_POST["hargasatuan"];
		$vendor=$_POST["vendor"];
		$link=koneksi();
		if(isset($_POST["simpan"]))
		{
			if(empty($nama) || empty($hargasatuan))
			{
				?>
				<div class="alert alert-danger">
                	Tolong isi nama atau harga
                </div>
				<?php
            }
			else
			{
				$sql="insert into sarana_dan_fasilitas values(NULL,'$judul','$kategori','$nosap','$nama','$spesifikasi','$satuan','$matauang','$hargasatuan','$vendor')"; 
				$res=mysqli_query($link,$sql);
				if(empty($res))
				{
					echo "kosong";
				}
					elseif($res)
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
?>

<?php
	function tampil_ubah_sarfas()
	{
		error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
		$id=$_GET["id"];
		$back=$_GET["back"];
		$kat=$_GET["kat"];
		$nama=$_GET["nama"];
		$judul=$_GET["judul"];
		$link=koneksi();
		$res=mysqli_query($link,"SELECT * from sarana_dan_fasilitas join judul using(id_judul) where id_sarfas = $id");		
		if(!$res){
			die("Query error! : ".mysqli_error($link));
		}
			while ($data=mysqli_fetch_array($res))
			{
		?>
        			<form name="sarfas" method="post">	
                    	<div class="panel-body">
                        	<div class="form-group">
                                	 <table>
                                    	<tr>
                                        	<td><label>judul</label></td>
                                            <td>
                                            	<div class="form-group input-group">
                                                <select class="form-control" name="namajudul">
                                                	<option value="<?php echo $data["id_judul"];?>"><?php echo $data["judul"];?></option>
                                               		<?php pilih_judul()?>
                                                </select>    
                                            	</div>
                                           	</td>
                                      	</tr>
                                        <tr>
                                    		<td><label>Nomor sap </label></td>
                                    		<td>
                                                <div class="form-group">
                                                <input class="form-control" type="text" name="nosap" value="<?php echo $data["no_sap"]; ?>">
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                    		<td><label>Nama barang </label></td>
                                    		<td>
                                            	<div class="form-group">
                                                <input class="form-control" type="text" name="namabrg" value="<?php echo $data["nama_brg"]; ?>">
                                                <div class="form-group input-group">
                                            </td>
                                        </tr>
                                        <tr>
                                    		<td><label>Spesifikasi teknik/Katalog </label></td>
                                    		<td>
                                                <div class="form-group ">
                                                <input class="form-control" type="text" name="spesifikasi" value="<?php echo $data["spesifikasi"]; ?>">
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                    		<td><label>Satuan</label></td>
                                    		<td>
                                            	<div class="form-group input-group">
                                               <select class="form-control" name="satuan">
                                               		<option><?php echo $data["satuan"];?></option>
													<?php pilih_satuan()?>
                                                </select>
                                                </div>               
                                            </td>
                                        </tr>
                                        <tr>
                                    		<td><label>Mata uang</label></td>
                                    		<td>
                                            	<div class="form-group input-group">
                                               <select class="form-control" name="matauang">
                                               		<option><?php echo $data["mata_uang"];?></option>
                                               		<?php pilih_matauang() ?>
                                                </select>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                    		<td><label>Harga satuan</label></td>
                                    		<td>
                                            	<div class="form-group input-group">
                                            	<input class="form-control" type="text" name="hargasatuan" value="<?php echo $data["harga_satuan"]; ?>">
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                    		<td><label>Vendor/suplair</label></td>
                                    		<td>
                                                <div class="form-group input-group">
                                               <select class="form-control" name="vendor">
                                               		<option><?php echo $data["vendor"];?></option>
													<?php pilih_vendor() ?>
                                                </select>
                                                </div>
                                           	</td>
                                        </tr>   
                                     </table>
                               </div>
                            </div>
                             <button type="submit" class="btn btn-primary" name="ubah">Ubah</button>
                             <?php
							 	if (is_numeric($back)) 
									{
							?>
										<a href="detail_judul.php?id=<?php echo $back;?>&judul=<?php echo $judul?>" class="btn btn-warning">
                                        Kembali
                                        </a>
							<?php	
                                	}
									elseif(isset($kat))
									{
							?>	
									<a href="detail_judul.php?id=<?php echo $back;?>&judul=<?php echo $judul?>&kat=<?php echo $kat?>" class="btn btn-warning">Kembali</a>
							<?php	
                                	}else
									{
							?>
                            			<a href="hasilcari.php?cari=<?php echo $back;?>&judul=<?php echo $judul?>" class="btn btn-warning">Kembali</a>
                            <?php		
									}
                             	
							 ?>
                       <?php ubah_data_sarfas();?>
        <?php	
			}
	}
?>

<?php
	function ubah_data_sarfas()
	{
		$id=$_GET["id"];
		$back=$_GET["back"];
		$judul=$_POST["namajudul"];
		$nosap=$_POST["nosap"];
		$namabrg=$_POST["namabrg"];
		$spesifikasi=$_POST["spesifikasi"];
		$satuan=$_POST["satuan"];
		$matauang=$_POST["matauang"];
		$hargasatuan=$_POST["hargasatuan"];
		$vendor=$_POST["vendor"];
		$link=koneksi();
		if(isset($_POST['ubah']))
			{ 
					$sql="UPDATE sarana_dan_fasilitas SET id_judul='$judul', no_sap= '$nosap', nama_brg='$namabrg', spesifikasi='$spesifikasi', satuan='$satuan', mata_uang='$matauang', harga_satuan='$hargasatuan', vendor='$vendor'   
					WHERE id_sarfas = '$id'"; 
					$res=mysqli_query($link,$sql);
					if(isset($res))
					{
						if (is_numeric($back)) 
						{
							echo "<script>window.location = 'detail_judul.php?id=$back'; </script>";
						}
						else
						{
							echo "<script>window.location = 'hasilcari.php?cari=$back'; </script>";
						}
					}				
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
        <form action="../../phpword/example.php" method="post">
                <textarea id="cetak_sarfas" name="data">
       <?php
			
			foreach($_POST['check_list'] as $selected) 
			{
				error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
				$link=koneksi();
				$res=mysqli_query($link,"SELECT * from sarana_dan_fasilitas where id_judul='$selected'");		
				$jud=mysqli_query($link,"SELECT * from sarana_dan_fasilitas join judul using(id_judul)where id_judul='$selected'");
				if(!$res){
					die("Query error! : ".mysqli_error($link));
				}
				$i=1;
				while($judul=mysqli_fetch_array($jud))
				{
					$h1=$judul["judul"];
				}
				?>
                	<h1 align="center"><?php echo $h1;?></h1>
                    <table width="100%">
                    <tr>
                    <th>NO</th>
                    <th>NOMOR MATERIAL SAP</th>
                    <th>KATEGORI</th>
                    <th>NAMA BARANG</th>
                    <th>SPESIFIKASI TEKNIK/KATALOG</th>
                    <th>SATUAN</th>
                    <th>MATA UANG</th>
                    <th>HARGA SATUAN</th>
                    <th>VENDOR/SUPLIER</th>
                    </tr>
					 <?php	
						while ($data=mysqli_fetch_array($res))
						{
					?>
						<tr>
							<td><?php echo $i++;?></td>
							<td><?php echo $data["no_sap"]; ?></td>
                            <td><?php echo $data["kategori"]; ?></td>
							<td><?php echo $data["nama_brg"]; ?></td>
							<td><?php echo $data["spesifikasi"]; ?></td>
							<td><?php echo $data["satuan"]; ?></td>
							<td><?php echo $data["mata_uang"]; ?></td>
							<td>
								<?php
							if($data["mata_uang"] != "IDR")
							{
								echo number_format($data["harga_satuan"], 2 , '.' , ',' ); 
							}
							elseif($data["mata_uang"] == "IDR")
							{
								echo number_format($data["harga_satuan"],0,".",".");
							}
							?>
                            </td>
							<td><?php echo $data["vendor"]; ?></td>
						</tr>         
							
				<?php
						}
					?>
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
        <input type="hidden" name="jumdat" value="<?php echo $checked_count;?>">
        <input type="hidden" name="kat" value="sarfas">
        <input type="submit" name="cetak_sarfas" value="Cetak">
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
                        <a href="../sarana_dan_fasilitas/detail_judul.php?id=<?php echo $data["katsar"];?>&judul=<?php echo $data["katsar"];?>&kat=<?php echo $data["katsar"];?>"><?php echo $data["katsar"];?></a>
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
                        <a href="../pekerjaan/detail.php?id=<?php echo $data["katsar"];?>&judul=<?php echo $data["katsar"];?>&kat=<?php echo $data["katsar"];?>">
						<?php echo $data["katsar"];?></a>
                    </li>
       <?php
			}
			?>
            </ul>
       <?php
	}
?>
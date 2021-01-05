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
		$res=mysqli_query($link,"select * from judul where kategori='umum'");		
		if(!$res){
			die("Query error! : ".mysqli_error($link));
		}
		$i=1;
			while ($data=mysqli_fetch_array($res))
			{	
				$id_judul=$data["id_judul"];	
		?>
        	    <li>     
                      <a href="#">
                            <i class="fa fa-circle fa-fw"></i>
                            <?php echo $data["judul"]; ?>
                            <span class="fa arrow"></span>
                        </a>
                <ul class="nav nav-third-level">
				<?php
					$sub=mysqli_query($link,"select * from sub_judul where id_judul = '$id_judul' ");
					while ($data2=mysqli_fetch_array($sub))
					{
						$id_sub=$data2["id_sub"];
						$resjum=mysqli_query($link,"select * from umum where id_sub = '$id_sub'");
						
                ?>
                
                		<li>
                        	<a href="detail.php?id=<?php echo $id_sub;?>&judul=<?php echo $data["judul"].' '.$data2["nama_sub"];?>">
								<i class="fa fa-circle-o fa-fw"></i>
								<?php echo $data2["nama_sub"];?>
                                (<?php echo mysqli_num_rows($resjum);?>)
                            </a>
                        </li>
                <?php
					}
          ?>
				</ul>
        <?php
			}
		?>
		</li>
			
            <?php
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
	function umum_cetak()
	{
		error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
		$link=koneksi();
		$res=mysqli_query($link,"SELECT * from judul where kategori='umum' ");		
		if(!$res){
			die("Query error! : ".mysqli_error($link));
		}
			while ($data=mysqli_fetch_array($res))
			{
				$i++;
				$id=$data["id_judul"];
				$res2=mysqli_query($link,"SELECT * from sarana_dan_fasilitas where id_judul = '$id'");
				$total=mysqli_num_rows($res2);
		?>
				<tr class="odd gradeX">
                    <td><?php echo $i++;?></td>
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
		$cari=$_GET["cari"];
		$res=mysqli_query($link,"SELECT * from umum 
		join sub_judul using(id_sub)
		join judul using(id_judul)
		where kategori='umum' and nama_brg like '%$cari%'");		
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
                        <td><?php echo $data["keterangan"]; ?></td>
                        <td>
                        	<ul>
								<li><strong><em>JUDUL :</em></strong></li>
                                <?php echo $data["judul"];?>
								<li><strong><em>SUB :</em></strong></li>
                                <?php echo $data["nama_sub"];?>
								<li><strong><em>NO KONTRAK :</em></strong></li>
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
								<li><strong><em>TANGGAL :</em></strong></li>
                                <?php echo $data["tanggal"];?>
                        	</ul>
                        </td>
                        <td>
                        	 <a href="hapus/data_umum.php?id=<?php echo $data["id_data"];?>&nama=<?php echo $data["nama_brg"];?>&sub=<?php echo $data["nama_sub"];?>&judul=<?php echo $data["judul"];?>&back=<?php echo $_GET["cari"];?>" class="btn btn-danger btn-circle" data-placement="top" title="Hapus">
                             <i class="fa fa-trash"></i>
                            </a>
                            <a href="form_ubah.php?id=<?php echo $data["id_data"];?>&nama=<?php echo $data["nama_brg"];?>&judul=<?php echo $data["judul"];?>&back=<?php echo $_GET["cari"];?>" class="btn btn-primary btn-circle" data-placement="top" title="Ubah">
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
		$res=mysqli_query($link,"select * from judul where kategori='umum'");		
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
	function pilih_subjudul()
	{
		error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
		$link=koneksi();
		$res=mysqli_query($link,"select * from sub_judul join judul using(id_judul) where kategori='umum'");		
		if(!$res){
			die("Query error! : ".mysqli_error($link));
		}
			while  ($data=mysqli_fetch_array($res)) 
			{
		?>
        		<option value="<?php echo $data["id_sub"];?>"><?php echo $data["nama_sub"];?></option>
       <?php	
			}
	}
?>

<?php
	function tambah_subjudul()
	{
		error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
		$tjudul=$_POST["tjudul"];
		$tsubjudul=$_POST["tsubjudul"];
		$link=koneksi();
		if(isset($_POST["tambahsubjud"]))
		{
			if(empty($tsubjudul))
			{
				echo "tidak ada data yang tersimpan";
			}
			else
			{	
				$sql="insert into sub_judul values(NULL,'$tjudul','$tsubjudul')"; 
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
					$sql="insert into judul values(NULL,'umum','$judul','$no_kontrak','$tgl',NULL)"; 
					$res=mysqli_query($link,$sql);
					if(isset($res))
					{
						echo "<script>window.location = 'index.php'; </script>";
					}
				}else
				{
					$file=$_FILES["file"]["name"];
					$sql="insert into judul values(NULL,'umum','$judul','$no_kontrak','$tgl','$file')"; 
					move_uploaded_file($_FILES['file']['tmp_name'], "info_pdf/".$_FILES['file']['name']);
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
		if(isset($_POST["tambahsats"]))
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
		if(isset($_POST["tambahmatu"]))
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
					echo "<script>window.location = 'index.php'; </script>";
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
		$res=mysqli_query($link,"SELECT id_sub,id_judul,judul,nama_sub,CONCAT(id_sub,id_judul) AS sujud FROM sub_judul JOIN judul USING(id_judul) WHERE kategori='umum'");		
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
                        	<a href="detail.php?id=<?php echo $data["id_sub"];?>&judul=<?php echo $data["judul"].' '.$data["nama_sub"];?>" class="btn btn-danger btn-circle" data-placement="top" title="Hapus" >
                             <i class="fa fa-trash"></i>
                            </a>
                            <!-- ubah-->
                            <?php
								$id4=$data["id_sub"];
								$sujud=$data["sujud"];
								$data=$data["nama_sub"];
								 
							?>
                            <button class="btn btn-success btn-circle" data-toggle="modal" data-target="#myModal<?php echo $sujud;?>">
                                <i class="fa fa-edit"></i>
                            </button>
                            <div class="modal fade" id="myModal<?php echo $sujud;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="myModalLabel">Ubah data<?php //echo var_dump($id4,$data);?></h4>
                                        </div>
                                        <form method="post">
                                            <div class="modal-body">
                                            	Data sebelumnya <strong><?php echo $data;?></strong> 
                                                <input type="text" value="<?php echo $data;?>" name="newsubjudul">
                                                <input type="hidden" value="<?php echo $data;?>" name="lastsubjudul">
                                                <input type="hidden" value="<?php echo $id4; ?>" name="id">
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                                                <button type="submit" class="btn btn-primary" name="ubahsubjudul">Ubah</button>
                                            </div>
                                            <?php ubah_data_subjudul();?>
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
	function ubah_data_subjudul()
	{
		$last=$_POST["lastsat"];
		$new=$_POST["newsat"];
		$id=$_POST["id"];
		$link=koneksi();
		if(isset($_POST['ubahsat']))
			{ 
					$sql="UPDATE sub_judul SET nama_sub = '$new' WHERE id_sub = '$id'"; 
					$res=mysqli_query($link,$sql);
					if(isset($res))
					{
						echo "<script>window.location = 'index.php'; </script>";
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
								$data=$data["nama_satuan"];
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
                                            	Data sebelumnya <strong><?php echo $data;?></strong> 
                                                <input type="text" value="<?php echo $data;?>" name="newsat">
                                                <input type="hidden" value="<?php echo $data;?>" name="lastsat">
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
		$last=$_POST["lastsat"];
		$new=$_POST["newsat"];
		$id=$_POST["id"];
		$link=koneksi();
		if(isset($_POST['ubahsat']))
			{ 
					$sql="UPDATE satuan SET nama_satuan = '$new' WHERE id_satuan = '$id'"; 
					$res=mysqli_query($link,$sql);
					if(isset($res))
					{
						echo "<script>window.location = 'index.php'; </script>";
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
                                                <input type="text" value="<?php echo $data;?>" name="newmatu">
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
				
					$sql="UPDATE mata_uang SET mata_uang = '$new' WHERE id_matauang = '$id_matu'"; 
					$res=mysqli_query($link,$sql);
					if(isset($res))
					{
						echo "<script>window.location = 'index.php'; </script>";
					}
					
		}
	}
?>

<?php
	function data_judul()
	{
		error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
		$link=koneksi();
		$res=mysqli_query($link,"SELECT * from judul where kategori='umum'");		
		if(!$res){
			die("Query error! : ".mysqli_error($link));
		}
		$j=1;
			while ($data=mysqli_fetch_array($res))
			{
		?>
        			<tr class="odd gradeX">
                        <td><?php echo $j++;?></td>
                        <td><?php echo $data["judul"]; ?></td>
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
                        <td><?php echo $data["tanggal"]; ?></td>
                        <td>
                        	<a href="detail_hapus_judul.php?id=<?php echo $data["id_judul"];?>&judul=<?php echo $data["judul"]; ?>" class="btn btn-danger btn-circle" data-placement="top" title="Hapus">
                             <i class="fa fa-trash"></i>
                            </a>
                            <!-- ubah-->
                            <?php 
								$id3=$data["id_judul"];
								$data2=$data["judul"];
							?>
                            <button class="btn btn-success btn-circle" data-toggle="modal" data-target="#myModal<?php echo $id3;?>">
                                <i class="fa fa-edit"></i>
                            </button>
                            <div class="modal fade" id="myModal<?php echo $id3;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="myModalLabel">Ubah data</h4>
                                        </div>
                                        <form method="post" enctype="multipart/form-data">
                                            <div class="modal-body">
                                            	<table class="table">
                                                <tr>
                                                	 <td>
                                                        <input class="form-control" type="text" value="<?php echo $data2;?>" name="newjudul">
                                                    </td>
                                               </tr>
                                               <tr>     
                                                    <td>
                                                        <input class="form-control" type="text" value="<?php echo $data["no_kontrak"];?>" name="new_nokon">
                                                    </td>
                                               </tr>
                                               <tr>   
                                                    <td>
                                                    	<input class="form-control" type="date" value="<?php echo $data["tanggal"];?>" name="newtgl">
                                                    </td>
                                               </tr>
                                               <tr>   
                                                     <td>
                                                    	<input class="form-control" type="file" name="newfile"><?php echo $data["file"];?>
                                                    </td>
                                                </tr>
                                                </table>
                                                <input type="hidden" value="<?php echo $data;?>" name="lastjudul">
                                                <input type="hidden" value="<?php echo $id3; ?>" name="id">
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
                            		<a href="../../info_pdf/<?php echo $data["file"];?>" class="btn btn-info btn-circle" title="Info">
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
		$link=koneksi();
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
	function data_umum()
	{
		error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
		$link=koneksi();
		$id=(int)$_GET['id'];
		$judul=$_GET["judul"];
		$res=mysqli_query($link,"SELECT * from umum join sub_judul using(id_sub) join judul using(id_judul) where id_sub = '$id'");		
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
                        	<input type="checkbox" name="check_list[]" value="<?php echo $data["id_data"];?>">
                        </td>
                        <td><?php echo $j++;?></td>
                        <td><?php echo $data["nama_brg"]; ?></td>
                        <td><?php echo $data["merk"]; ?></td>
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
                        <td><?php echo $data["keterangan"]; ?></td>
                        <td>
                            <a href="hapus/data_umum.php?id=<?php echo $data["id_data"];?>&nama=<?php echo $data["nama_brg"];?>&sub=<?php echo $data["nama_sub"];?>&judul=<?php echo $judul;?>&back=<?php echo $id;?>" class="btn btn-danger btn-circle" data-placement="top" title="Hapus">
                             <i class="fa fa-trash"></i>
                            </a>
                            <a href="form_ubah.php?id=<?php echo $data["id_data"];?>&nama=<?php echo $data["nama_brg"];?>&judul=<?php echo $judul;?>&back=<?php echo $id;?>" class="btn btn-primary btn-circle" data-placement="top" title="Ubah">
                             <i class="fa fa-edit"></i>
                            </a>
                        </td>
                   	</tr>
        <?php	
		}
	}
	
?>
<?php
function tambah_umum()
{

	error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
		$judul=$_POST["namajudul"];
		$subjudul=$_POST["subjudul"];
		$merk=$_POST["merk"];
		$namabrg=$_POST["namabrg"];
		$spesifikasi=$_POST["spesifikasi"];
		$satuan=$_POST["satuan"];
		$matauang=$_POST["matauang"];
		$hargasatuan=$_POST["hargasatuan"];
		$keterangan=$_POST["keterangan"];
		$link=koneksi();
		$carjud=mysqli_query($link,"select * from sub_judul join judul using(id_judul) where id_sub = '$subjudul'");
		while($data=mysqli_fetch_array($carjud))
		{
			$judul2=$data["judul"];
			$sub=$data["nama_sub"];
		}
		if(isset($_POST["simpan"]))
		{
				$sql="insert into umum values(NULL,'$subjudul','$namabrg','$merk','$spesifikasi','$satuan','$matauang','$hargasatuan','$keterangan')"; 
				$res=mysqli_query($link,$sql);
				
				if(isset($res))
				{
				?>	
						<div class="alert alert-success">
                        	Data sudah tersimpan.
                        </div>
				<?php
				}else
				{
					echo "eror";
				}
					
		}
}
?>

<?php
	function tampil_ubah_umum()
	{
		error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
		$id=$_GET["id"];
		$back=$_GET["back"];
		$nama=$_GET["nama"];
		$judul=$_GET["judul"];
		$link=koneksi();
		$res=mysqli_query($link,"SELECT * from umum where id_data = $id");		
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
                                    		<td><label>Nama barang</label></td>
                                    		<td>
                                                <div class="form-group">
                                                <input class="form-control" type="text" name="namabrg" value="<?php echo $data["nama_brg"]; ?>">
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                    		<td><label>Merk</label></td>
                                    		<td>
                                            	<div class="form-group">
                                                <input class="form-control" type="text" name="merk" value="<?php echo $data["merk"];?>">
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
													<?php pilih_satuan();?>
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
                                               		<?php pilih_matauang(); ?>
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
                                    		<td><label>Keterangan</label></td>
                                    		<td>
                                                <div class="form-group input-group">
                     	                          <input class="form-control" type="text" name="keterangan" value="<?php echo $data["keterangan"]; ?>">
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
										<a href="detail.php?id=<?php echo $back;?>&judul=<?php echo $judul?>" class="btn btn-warning">Kembali</a>
							<?php	
                                	}
									else
									{
							?>	
									<a href="hasilcari.php?cari=<?php echo $back;?>&judul=<?php echo $judul?>" class="btn btn-warning">Kembali</a>
							<?php	
                                	}
                             	
							 ?>
                       </form>
                       <?php ubah_data_umum()?>
        <?php	
			}
	}
?>

<?php
	function ubah_data_umum()
	{
		$id=$_GET["id"];
		$back=$_GET["back"];
		$judul=$_GET["judul"];
		$nama_brg=$_POST["namabrg"];
		$merk=$_POST["merk"];
		$spesifikasi=$_POST["spesifikasi"];
		$satuan=$_POST["satuan"];
		$matauang=$_POST["matauang"];
		$hargasatuan=$_POST["hargasatuan"];
		$keterangan=$_POST["keterangan"];
		$link=koneksi();
		if(isset($_POST['ubah']))
			{ 
					$sql="UPDATE umum SET nama_brg= '$nama_brg', merk='$merk', spesifikasi='$spesifikasi', satuan='$satuan', mata_uang='$matauang', harga_satuan='$hargasatuan', keterangan='$keterangan'   
					WHERE id_data = '$id'"; 
					$res=mysqli_query($link,$sql);
					if(isset($res))
					{
						if (is_numeric($back)) 
						{
							echo "<script>window.location = 'detail.php?id=$back&judul=$judul'; </script>";
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
				$res=mysqli_query($link,"SELECT * FROM judul j
JOIN sub_judul sb ON sb.id_judul = j.id_judul
JOIN umum u ON u.id_sub = sb.id_sub where j.id_judul='$selected'");		
				$jud=mysqli_query($link,"SELECT * FROM judul j
JOIN sub_judul sb ON sb.id_judul = j.id_judul where j.id_judul='$selected'");
				if(!$res){
					die("Query error! : ".mysqli_error($link));
				}
				$i=1;
				while($judul=mysqli_fetch_array($jud))
				{
					$h1=$judul["judul"];
				}
				//tampilkan sub dan data
				?>
				<h1 align="center"><?php echo $h1;?></h1>
				
				<?php
                $sub=mysqli_query($link,"select * from sub_judul where id_judul = $selected");
				while($q_sub=mysqli_fetch_array($sub))
				{
					$nama_sub=$q_sub["nama_sub"];
					$id_sub=$q_sub["id_sub"];
				?>
                	<h2 align="center"><?php echo $nama_sub;?></h2>
                	<table width="100%">
                        <tr>
                            <th>NO</th>
                            <th>NAMA BARANG</th>
                            <th>MERK</th>
                            <th>SPESIFIKASI</th>
                            <th>SATUAN</th>
                            <th>MATA UANG</th>
                            <th>HARGA SATUAN</th>
                            <th>KETERANGAN</th>
                        </tr>
				<?php
					$dat_sub=mysqli_query($link,"select * from umum where id_sub='$id_sub'");
					while($data=mysqli_fetch_array($dat_sub))
					{
				?>
                  		<tr>
							<td><?php echo $i++;?></td>
							<td><?php echo $data["nama_brg"]; ?></td>
							<td><?php echo $data["merk"]; ?></td>
							<td><?php echo $data["spesifikasi"]; ?></td>
							<td><?php echo $data["satuan"]; ?></td>
							<td><?php echo $data["mata_uang"]; ?></td>
							<td><?php echo $data["harga_satuan"]; ?></td>
							<td><?php echo $data["keterangan"]; ?></td>
						</tr>		      
                <?php    
					}
				?>
                	</table>
                <?php	
				}
				?>
                
                
                          
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
        <input type="hidden" name="kat" value="umum">
        <input type="submit" name="cetak_sarfas" value="Cetak">
        </form>
<?php		
		}
		
	}
?>

<?php
	function detail_hapus_judul()
	{
		error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
		$link=koneksi();
		$id=$_GET["id"];
		$res=mysqli_query($link,"SELECT id_sub,id_judul,judul,nama_sub,CONCAT(id_sub,id_judul) AS sujud FROM sub_judul JOIN judul USING(id_judul) WHERE kategori='umum' and id_judul ='$id'");		
		if(!$res){
			die("Query error! : ".mysqli_error($link));
		}
		$i=1;
			while ($data=mysqli_fetch_array($res))
			{
		?>
        			<tr class="odd gradeX">
                         <td>
                        	<input type="checkbox" name="check_list[]" value="<?php echo $data["id_sub"];?>">
                        </td>
                        <td><?php echo $i++;?></td>
                        <td><?php echo $data["nama_sub"]; ?></td>
                        <td>
                        	<a href="detail.php?id=<?php echo $data["id_sub"];?>&judul=<?php echo $data["judul"].' '.$data["nama_sub"];?>" class="btn btn-danger btn-circle" data-placement="top" title="Hapus" >
                             <i class="fa fa-trash"></i>
                            </a>
                            <!-- ubah-->
                            <?php
								$id4=$data["id_sub"];
								$sujud=$data["sujud"];
								$data=$data["nama_sub"];
								 
							?>
                            <button class="btn btn-success btn-circle" data-toggle="modal" data-target="#myModal<?php echo $sujud;?>">
                                <i class="fa fa-edit"></i>
                            </button>
                            <div class="modal fade" id="myModal<?php echo $sujud;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="myModalLabel">Ubah data<?php //echo var_dump($id4,$data);?></h4>
                                        </div>
                                        <form method="post">
                                            <div class="modal-body">
                                            	Data sebelumnya <strong><?php echo $data;?></strong> 
                                                <input type="text" value="<?php echo $data;?>" name="newsubjudul">
                                                <input type="hidden" value="<?php echo $data;?>" name="lastsubjudul">
                                                <input type="hidden" value="<?php echo $id4; ?>" name="id">
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                                                <button type="submit" class="btn btn-primary" name="ubahsubjudul">Ubah</button>
                                            </div>
                                            <?php ubah_data_subjudul();?>
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
                        <a href="../sarana_dan_fasilitas/detail_judul.php?id=<?php echo $data["katsar"];?>&judul=<?php echo $data["katsar"];?>""><?php echo $data["katsar"];?></a>
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
                        <a href="../prasarana/detail_judul.php?id=<?php echo $data["katsar"];?>&judul=<?php echo $data["katsar"];?>""><?php echo $data["katsar"];?></a>
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
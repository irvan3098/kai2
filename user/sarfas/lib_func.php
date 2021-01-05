<?php 
	include("../../conn.php");
	include("../../url.php");
?>

<?php
	function menu_sarfas()
	{
		error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
		$link=koneksi();
		$thn_=date('Y');
		$res=mysqli_query($link,"SELECT * FROM v_sarfas 
		WHERE judkat ='sarana dan fasilitas' AND YEAR(tanggal)='$thn_' 
		GROUP BY kategori
		");		
		if(!$res){
			die("Query error! : ".mysqli_error($link));
		}
		?>
         	<ul>
        <?php	
			while  ($data=mysqli_fetch_array($res)) 
			{
		?>
                    <li>
                        <a href="detail_data.php?id=<?php echo $data["kategori"];?>&judul=<?php echo $data["kategori"];?>">
						<?php echo $data["kategori"];?></a>
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
         	<ul>
        <?php	
			while  ($data=mysqli_fetch_array($res)) 
			{
		?>
                    <li>
                        <a href="../prasarana/detail_data.php?id=<?php echo $data["katsar"];?>&judul=<?php echo $data["katsar"];?>""><?php echo $data["katsar"];?></a>
                    </li>
       <?php
			}
			?>
            </ul>
       <?php
	}
?>

<?php
	function sarfas()
	{
		error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
		$link=koneksi();
		$thn_=date('Y');
		$res=mysqli_query($link,"select id_judul,judul,no_kontrak,tanggal,file from judul 
		where kategori='sarana dan fasilitas' and year(tanggal) = '$thn_'");
		if(!$res){
			die("Query error! : ".mysqli_error($link));
		}
			$i=1;
			while ($data=mysqli_fetch_array($res))
			{
				$id=$data["id_judul"];
				$judul=$data["judul"];
?>
				<tr class="odd gradeX">
                    <td><?php echo $i;?></td>
                    <td><?php echo $data["judul"];?></td>
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
                    <?php 
                        $jum=mysqli_query($link,"select * from sarana_dan_fasilitas where id_judul = '$id'");
                    ?>
                    <td><?php echo mysqli_num_rows($jum);?></td>
                    <td>
                        <a href="#" onClick="window.open('http://<?php url();?>user/sarfas/detail_cetak.php?id=<?php echo $id; ?>&judul=<?php echo $judul;?>','popuppage','width=500,toolbar=0,resizable=0,scrollbars=no,height=400,top=100,left=100');" >
                        Download
                        </a>
                        <a class="btn btn-info" href="detail_data.php?id=<?php echo $id;?>&judul=<?php echo $judul;?>">Lihat data
                    </td>
                </tr>
		<?php	
			$i++;
    		}
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
         	<ul>
        <?php	
			while  ($data=mysqli_fetch_array($res)) 
			{
		?>
                    <li>
                        <a href="../pekerjaan/detail_data.php?id=<?php echo $data["katsar"];?>&judul=<?php echo $data["katsar"];?>&kat=<?php echo $data["katsar"];?>">
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
function ditail_cetak()
{
		error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
		$id=$_GET["id"];
		$judul=$_GET["judul"];
		$link=koneksi();
		$res=mysqli_query($link,"SELECT judul.tanggal, judul.judul, judul.kategori katjud, judul.no_kontrak, judul.file,sar.id_sarfas, sar.no_sap, sar.kategori, sar.nama_brg, sar.spesifikasi, sar.satuan, sar.mata_uang, sar.harga_satuan, sar.vendor
		FROM sarana_dan_fasilitas sar
		JOIN judul ON (judul.id_judul = sar.id_judul) 
		WHERE judul.kategori='sarana dan fasilitas' AND YEAR(judul.tanggal)=YEAR(NOW()) and judul.id_judul='$id' or sar.kategori='$id'");		
		if(!$res){
			die("Query error! : ".mysqli_error($link));
		}
		$i=1;
		?>
        <form action="../../tcpdf/examples/pdf.php" method="post">
        <input type="hidden" name="id" value="<?php echo $id;?>">
        <input type="hidden" name="judul" value="<?php echo $judul;?>">
        <textarea id="" name="data">
        <h1><?php echo $judul;?></h1>
  		<table border="1">
        <tr>
        <td width="20" align="center">NO</td>
        <td width="70" align="center">KATEGORI</td>
        <td width="70" align="center">NOMOR MATERIAL</td>
        <td width="90" align="center">NAMA BARANG</td>
        <td width="95" align="center">SPESIFIKASI TEKNIK/KATALOG</td>
        <td width="50" align="center">SATUAN</td>
        <td width="50" align="center">MATA UANG</td>
        <td width="85" align="center">HARGA SATUAN</td>
        <td width="105" align="center">VENDOR/SUPLIER</td>
        </tr>
        <tbody>
		<?php 
		while ($data=mysqli_fetch_array($res))
			{
		?>
				<tr class="odd gradeX">
                	<td align="center"><?php echo $i++;?> </td>
                    <td align="center"><?php echo $data["kategori"];?> </td>
                    <td align="center"><?php echo $data["no_sap"];?> </td>
                    <td align="center"><?php echo $data["nama_brg"];?> </td>
                    <td align="center"><?php echo $data["spesifikasi"];?> </td>
                    <td align="center"><?php echo $data["satuan"]; ?> </td>
                    <td align="center"><?php echo $data["mata_uang"];?> </td>
                    <td align="right">
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
                    <td align="center"><?php echo $data["vendor"]; ?></td>
           		</tr>         
                    
        <?php
			}
		?>
        </tbody>
        </table>

		</textarea>
        <input type="submit" name="cetak_" value="Cetak">
        </form>
<?php
	}
?>

<?php
function ditail_data()
{
		error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
		$id=$_GET["id"];
		$link=koneksi();
		$thn_=date('Y');
		$res=mysqli_query($link,"SELECT judul.tanggal, judul.judul, judul.kategori katjud, judul.no_kontrak, judul.id_judul, judul.file,sar.id_sarfas, sar.no_sap, sar.kategori, sar.nama_brg, sar.spesifikasi, sar.satuan, sar.mata_uang, sar.harga_satuan, sar.vendor
		FROM sarana_dan_fasilitas sar
		JOIN judul ON (judul.id_judul = sar.id_judul) 
		WHERE 
		judul.kategori='sarana dan fasilitas' AND YEAR(judul.tanggal)=YEAR(NOW()) and judul.id_judul='$id' or sar.kategori='$id'");		
		if(!$res){
			die("Query error! : ".mysqli_error($link));
		}
		$i=1;
		$total=mysqli_num_rows($res);
			while ($data=mysqli_fetch_array($res))
			{
		?>
				<tr class="odd gradeX">
                	<td><?php echo $i++;?></td>
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
           		</tr>         
                    
        <?php
			}

	}
?>

<?php
	function detail_hascar()
	{
		error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
		$cari=$_GET["id"];
		$link=koneksi();
		$thn_=date('Y');
		$res=mysqli_query($link,"SELECT judul.tanggal, judul.judul, judul.kategori, judul.no_kontrak, judul.file,sar.id_sarfas, sar.no_sap, sar.kategori, sar.nama_brg, sar.spesifikasi, sar.satuan, sar.mata_uang, sar.harga_satuan, sar.vendor
		from sarana_dan_fasilitas sar
		join judul on (judul.id_judul = sar.id_judul) 
		where judul.kategori='sarana dan fasilitas' and YEAR(judul.tanggal)=YEAR(NOW()) and sar.nama_brg like '%$cari%' or sar.no_sap like '%$cari%'");		
		if(!$res){
			die("Query error! : ".mysqli_error($link));
		}
		$i=1;
		$total=mysqli_num_rows($res);
			while ($data=mysqli_fetch_array($res))
			{
		?>
				<tr class="odd gradeX">
                	<td><?php echo $i++;?></td>
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
                    	<ul>
                        	<li><strong><em>JUDUL :</em></strong></li>
                            <?php echo $data["judul"]; ?>
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
                            <?php echo $data["tanggal"]; ?>
                        </ul>
                    </td>
           		</tr>         
                    
        <?php
			}
	}
?>

<?php
function cetak_hascar()
{
		error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
		$id=$_GET["id"];
		$judul=$_GET["judul"];
		$link=koneksi();
		$res=mysqli_query($link,"SELECT judul.tanggal, judul.judul, judul.kategori katjud, judul.no_kontrak, judul.file,sar.id_sarfas, sar.no_sap, sar.kategori, sar.nama_brg, sar.spesifikasi, sar.satuan, sar.mata_uang, sar.harga_satuan, sar.vendor
		FROM sarana_dan_fasilitas sar
		JOIN judul ON (judul.id_judul = sar.id_judul) 
		WHERE judul.kategori='sarana dan fasilitas' AND YEAR(judul.tanggal)=YEAR(NOW()) and sar.nama_brg like '%$id%'");		
		if(!$res){
			die("Query error! : ".mysqli_error($link));
		}
		$i=1;
		?>
        <form action="../../tcpdf/examples/pdf.php" method="post">
        <input type="hidden" name="id" value="<?php echo $id;?>">
        <input type="hidden" name="judul" value="<?php echo $judul;?>">
        <textarea id="" name="data">
        <h1><?php echo $judul;?></h1>
  		<table border="1">
        <tr>
        <td width="20" align="center">NO</td>
        <td width="70" align="center">KATEGORI</td>
        <td width="70" align="center">NOMOR MATERIAL</td>
        <td width="90" align="center">NAMA BARANG</td>
        <td width="95" align="center">SPESIFIKASI TEKNIK/KATALOG</td>
        <td width="50" align="center">SATUAN</td>
        <td width="50" align="center">MATA UANG</td>
        <td width="85" align="center">HARGA SATUAN</td>
        <td width="105" align="center">VENDOR/SUPLIER</td>
        </tr>
        <tbody>
		<?php 
		while ($data=mysqli_fetch_array($res))
			{
		?>
				<tr class="odd gradeX">
                	<td align="center"><?php echo $i++;?> </td>
                    <td align="center"><?php echo $data["kategori"];?> </td>
                    <td align="center"><?php echo $data["no_sap"];?> </td>
                    <td align="center"><?php echo $data["nama_brg"];?> </td>
                    <td align="center"><?php echo $data["spesifikasi"];?> </td>
                    <td align="center"><?php echo $data["satuan"]; ?> </td>
                    <td align="center"><?php echo $data["mata_uang"];?> </td>
                    <td align="right">
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
                    <td align="center"><?php echo $data["vendor"]; ?></td>
           		</tr>         
                    
        <?php
			}
		?>
        </tbody>
        </table>

		</textarea>
        <input type="submit" name="cetak_" value="Cetak">
        </form>
<?php
	}
?>
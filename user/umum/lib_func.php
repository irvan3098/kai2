<?php 
	include("../../conn.php");
	include("../../url.php");
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
         	<ul>
        <?php	
			while  ($data=mysqli_fetch_array($res)) 
			{
		?>
                    <li>
                        <a href="../sarfas/detail_data.php?id=<?php echo $data["katsar"];?>&judul=<?php echo $data["katsar"];?>""><?php echo $data["katsar"];?></a>
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
                        <a href=".../prasarana/detail_data.php?id=<?php echo $data["katsar"];?>&judul=<?php echo $data["katsar"];?>""><?php echo $data["katsar"];?></a>
                    </li>
       <?php
			}
			?>
            </ul>
       <?php
	}
?>

<?php
	function judul()
	{
		error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
		$link=koneksi();
		$thn_=date('Y');
		$res=mysqli_query($link,"select * from judul where kategori='umum' AND year(tanggal) = $thn_");
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
                    <td>
                    	<ul>
						<?php
							$carisub=mysqli_query($link,"select * from sub_judul where id_judul='$id'");
							while($sub=mysqli_fetch_array($carisub))
								{
									$id_sub=$sub["id_sub"];
									$sub_nama=$sub["nama_sub"];
						?>
                        			<li>
                                    	<?php $jum=mysqli_query($link,"select * from umum where id_sub = '$id_sub'");?>
                                        <?php echo $sub["nama_sub"];?>
                                         (<?php echo mysqli_num_rows($jum);?>)
                                        <?php
										$sumber=mysqli_query($link,"select id_sub,keterangan from umum 
										group by keterangan having id_sub='$id_sub'");
										while($sum=mysqli_fetch_array($sumber))
											{
												$ket=$sum["keterangan"];
											}
										?>
                                        <a href="#" onClick="window.open('http://<?php url();?>user/umum/detail_cetak.php?id=<?php echo $id_sub; ?>&judul=<?php echo $sub_nama;?>','popuppage','width=500,toolbar=0,resizable=0,scrollbars=no,height=400,top=100,left=100');">
                        Download
                        </a>
                        				<a href="detail_data.php?id=<?php echo $id_sub;?>&judul=<?php echo $sub_nama;?>&sumber=<?php echo $ket;?>">Lihat data</a>
                                    </li>
						<?php
                        		}
                        ?>
                        </ul>
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

<?php
function ditail_cetak()
{
		error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
		$id=$_GET["id"];
		$judul=$_GET["judul"];
		$link=koneksi();
		$res=mysqli_query($link,"SELECT j.id_judul,j.kategori, j.no_kontrak, j.tanggal, j.file, s.nama_sub, s.id_sub,
u.nama_brg, u.merk, u.spesifikasi, u.satuan, u.mata_uang, u.harga_satuan, u.keterangan
FROM judul j
JOIN sub_judul s ON(s.id_judul=j.id_judul)
JOIN umum u ON(u.id_sub=s.id_sub)
WHERE YEAR(j.tanggal)=YEAR(NOW()) and s.id_sub='$id'");		
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
        <td width="30" align="center">NO</td>
       	<td width="110" align="center">NAMA BARANG</td>
        <td width="90" align="center">MERK</td>
        <td width="120" align="center">SPESIFIKASI TEKNIK/KATALOG</td>
        <td width="50" align="center">SATUAN</td>
        <td width="50" align="center">MATA UANG</td>
        <td width="85" align="center">HARGA SATUAN</td>
        <td width="95" align="center">KETERANGAN</td>
        </tr>
        <tbody>
		<?php 
		while ($data=mysqli_fetch_array($res))
			{
		?>
				<tr class="odd gradeX">
                	<td align="center"><?php echo $i++;?></td>
                    <td><?php echo $data["nama_brg"]; ?></td>
                    <td align="center"><?php echo $data["merk"]; ?></td>
                    <td align="center"><?php echo $data["spesifikasi"]; ?></td>
                    <td align="center"><?php echo $data["satuan"]; ?></td>
                    <td align="center"><?php echo $data["mata_uang"]; ?></td>
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
                    <td align="center"><?php echo $data["keterangan"]; ?></td>
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
		$res=mysqli_query($link,"SELECT j.id_judul,j.kategori, j.no_kontrak, j.tanggal, j.file, s.nama_sub, s.id_sub,
u.nama_brg, u.merk, u.spesifikasi, u.satuan, u.mata_uang, u.harga_satuan, u.keterangan
FROM judul j
JOIN sub_judul s ON(s.id_judul=j.id_judul)
JOIN umum u ON(u.id_sub=s.id_sub)
WHERE YEAR(j.tanggal)=YEAR(NOW()) and s.id_sub='$id'");		
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
		$res=mysqli_query($link,"SELECT j.id_judul,j.kategori, j.no_kontrak, j.tanggal, j.file, s.nama_sub, s.id_sub,
u.nama_brg, u.merk, u.spesifikasi, u.satuan, u.mata_uang, u.harga_satuan, u.keterangan
FROM judul j
JOIN sub_judul s ON(s.id_judul=j.id_judul)
JOIN umum u ON(u.id_sub=s.id_sub)
WHERE YEAR(j.tanggal)=YEAR(NOW()) and nama_brg like '%$id%'");		
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
        <td width="30" align="center">NO</td>
       	<td width="110" align="center">NAMA BARANG</td>
        <td width="90" align="center">MERK</td>
        <td width="120" align="center">SPESIFIKASI TEKNIK/KATALOG</td>
        <td width="50" align="center">SATUAN</td>
        <td width="50" align="center">MATA UANG</td>
        <td width="85" align="center">HARGA SATUAN</td>
        <td width="95" align="center">KETERANGAN</td>
        </tr>
        <tbody>
		<?php 
		while ($data=mysqli_fetch_array($res))
			{
		?>
				<tr class="odd gradeX">
                	<td align="center"><?php echo $i++;?></td>
                    <td><?php echo $data["nama_brg"]; ?></td>
                    <td align="center"><?php echo $data["merk"]; ?></td>
                    <td align="center"><?php echo $data["spesifikasi"]; ?></td>
                    <td align="center"><?php echo $data["satuan"]; ?></td>
                    <td align="center"><?php echo $data["mata_uang"]; ?></td>
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
                    <td align="center"><?php echo $data["keterangan"]; ?></td>
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
function ditail_hascar()
{
		error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
		$id=$_GET["id"];
		$link=koneksi();
		$thn_=date('Y');
		$res=mysqli_query($link,"SELECT j.id_judul, j.judul,j.kategori, j.no_kontrak, j.tanggal, j.file, s.nama_sub, s.id_sub,
u.nama_brg, u.merk, u.spesifikasi, u.satuan, u.mata_uang, u.harga_satuan, u.keterangan
FROM judul j
JOIN sub_judul s ON(s.id_judul=j.id_judul)
JOIN umum u ON(u.id_sub=s.id_sub)
WHERE YEAR(j.tanggal)=YEAR(NOW()) and  u.nama_brg like '%$id%'");		
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
                            <?php echo $data["judul"]; ?>
                            <li><strong><em>SUB JUDUL :</em></strong></li>
                            <?php echo $data["nama_sub"]; ?>
                            <li><strong><em>NO KONTRAK :</em></strong></li>
                            <?php 
								if(empty($data["file"]))
								{
									echo $data["no_kontrak"];
								}
								else
								{
								?>
                                	<a href="../info_pdf/<?php echo $data["file"];?>"  title="Info">
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
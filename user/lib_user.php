<?php 
	include("../conn.php");
	include("../url.php");
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
                        <a href="sarfas/detail_data.php?id=<?php echo $data["katsar"];?>&judul=<?php echo $data["katsar"];?>""><?php echo $data["katsar"];?></a>
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
                        <a href="prasarana/detail_data.php?id=<?php echo $data["katsar"];?>&judul=<?php echo $data["katsar"];?>""><?php echo $data["katsar"];?></a>
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
                        <a href="pekerjaan/detail_data.php?id=<?php echo $data["katsar"];?>&judul=<?php echo $data["katsar"];?>&kat=<?php echo $data["katsar"];?>">
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
	function hascar_sarfas()
	{
		error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
		$cari=$_GET["cari"];
		$link=koneksi();
		$thn_=date('Y');
		$res=mysqli_query($link,"SELECT judul.tanggal, judul.judul, judul.kategori katjud, judul.no_kontrak, judul.file,sar.id_sarfas, sar.no_sap, sar.kategori, sar.nama_brg, sar.spesifikasi, sar.satuan, sar.mata_uang, sar.harga_satuan, sar.vendor
		FROM sarana_dan_fasilitas sar
		JOIN judul ON (judul.id_judul = sar.id_judul) 
		WHERE judul.kategori='sarana dan fasilitas' AND YEAR(judul.tanggal)=YEAR(NOW()) and sar.nama_brg like '%$cari%' or sar.no_sap like '%$cari%' limit 3");		
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
								echo $data["harga_satuan"]; 
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

<?php
	function hascar_prasarana()
	{
		error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
		$cari=$_GET["cari"];
		$link=koneksi();
		$res=mysqli_query($link,"SELECT judul.tanggal, judul.judul, judul.kategori katjud, judul.no_kontrak, judul.file,sar.id_sarfas, sar.no_sap, sar.kategori, sar.nama_brg, sar.spesifikasi, sar.satuan, sar.mata_uang, sar.harga_satuan, sar.vendor
		FROM sarana_dan_fasilitas sar
		JOIN judul ON (judul.id_judul = sar.id_judul) 
		WHERE judul.kategori='prasarana' AND YEAR(judul.tanggal)=YEAR(NOW()) and sar.nama_brg like '%$cari%' or sar.no_sap like '%$cari%' limit 3");		
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
								echo $data["harga_satuan"]; 
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

<?php
	function hascar_umum()
	{
		error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
		$cari=$_GET["cari"];
		$link=koneksi();
		$res=mysqli_query($link,"SELECT j.judul,j.id_judul,j.kategori, j.no_kontrak, j.tanggal, j.file, s.nama_sub, s.id_sub,
u.nama_brg, u.merk, u.spesifikasi, u.satuan, u.mata_uang, u.harga_satuan, u.keterangan
FROM judul j
JOIN sub_judul s ON(s.id_judul=j.id_judul)
JOIN umum u ON(u.id_sub=s.id_sub)
WHERE YEAR(j.tanggal)=YEAR(NOW()) and u.nama_brg like '%$cari%' limit 3");		
		if(!$res){
			die("Query error! : ".mysqli_error($link));
		}
		$i=1;
		$total=mysqli_num_rows($res);
			while ($data=mysqli_fetch_array($res))
			{
		?>
				<tr class="gradeA">
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
								echo $data["harga_satuan"]; 
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

<?php
	function hascar_pekerjaan()
	{
		error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
		$link=koneksi();
		$id=$_GET["cari"];
		$res=mysqli_query($link,"SELECT id_kode,kode,satuan,nama_pkj,pokok_kegiatan from judul
		join kode_pekerjaan using(id_judul)
		join satuan_pekerjaan using(id_kode)
		join nama_pekerjaan using(id_satuan)
		where pokok_kegiatan or nama_pkj like '%$id%' limit 3");
		if(!$res){
			die("Query error! : ".mysqli_error($link));
		}
		$i=1;
			while ($data=mysqli_fetch_array($res))//tampil kode
			{
				
		?>
					<tr>
                        <td><?php echo $i++; ?></td>
                        <td><?php echo $data["kode"]; ?></td>
                       	<td><?php echo $data["satuan"]; ?></td>
                                <td>
									<strong><em><?php echo $data["nama_pkj"];?><strong><em>
                                    <?php echo $data["pokok_kegiatan"]; ?>
                                </td>
                    </tr>
                   
                <?php
                //cek kode
				$ceksat=$data["satuan"];
				$cekkode=$data["kode"];
			}//kode
	}
	
?>
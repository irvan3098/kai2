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
	function judul()
	{
		error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
		$link=koneksi();
		$thn_=date('Y');
		$res=mysqli_query($link,"select * from judul where kategori='pekerjaan' ");		
		if(!$res){
			die("Query error! : ".mysqli_error($link));
		}
		$i=1;
			while ($data=mysqli_fetch_array($res))
			{
				$id=$data["id_judul"];
				$judul=$data["judul"];
				$resjum=mysqli_query($link,"SELECT judul,id_kode,kode,satuan,nama_pkj,pokok_kegiatan from judul
		join kode_pekerjaan using(id_judul)
		join satuan_pekerjaan using(id_kode)
		join nama_pekerjaan using(id_satuan) where id_judul='$id'");
				
		?>
        		<tr>
        		<td><?php echo $i++;?></td>
                <td>
                	<?php echo $data["judul"]; ?>
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
                <td>
                	<?php echo $data["tanggal"];?>
                </td>
                <td><?php echo mysqli_num_rows($resjum);?></td>
                <td>
                        <a href="#" onClick="window.open('http://<?php url();?>/user/pekerjaan/detail_cetak.php?id=<?php echo $id; ?>&judul=<?php echo $judul;?>','popuppage','width=500,toolbar=0,resizable=0,scrollbars=no,height=400,top=100,left=100');" >
                        Download
                        </a>
                        <a class="btn btn-info" href="detail_data.php?id=<?php echo $id;?>&judul=<?php echo $judul;?>">Lihat data
                    </td>
                </tr>
        <?php
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
                        <a href="detail_data.php?id=<?php echo $data["katsar"];?>&judul=<?php echo $data["katsar"];?>&kat=<?php echo $data["katsar"];?>">
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
		?>
        <form action="../../tcpdf/examples/pdf.php" method="post">
        <input type="hidden" name="id" value="<?php echo $id;?>">
        <input type="hidden" name="judul" value="<?php echo $judul;?>">
        <textarea id="" name="data">
       <?php
	   			//untuk menampilkan data
				$res=mysqli_query($link,"SELECT kode.id_kode,satuan.id_satuan,nama.id_pekerjaan,kode.kategori,kode.kode,satuan.satuan,nama.nama_pkj,nama.pokok_kegiatan,judul FROM judul j
JOIN kode_pekerjaan kode ON(kode.id_judul = j.id_judul)
JOIN satuan_pekerjaan satuan ON(satuan.id_kode = kode.id_kode)
JOIN nama_pekerjaan nama ON(nama.id_satuan = satuan.id_satuan)
		where j.id_judul='$id' or kode.kategori='$id' or nama.nama_pkj like '%$id%'
				");
				if(!$res){
					die("Query error! : ".mysqli_error($link));
				}
				
				$i=1;
		?>
                 <h1 align="center"><?php echo $judul;?></h1>
                 <table border="1">
               	 	     <tr>
                         <td width="25" align="center">NO</td>
                         <td width="65" align="center">KODE</td>
                         <td width="65" align="center">SATUAN</td>
                         <td width="475" align="center">ANALISA HARGA SATUAN <?php echo $judul;?></td>
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
		$link=koneksi();
		$id=$_GET["id"];
		//$kat=$_GET["kat"];
		$judul=$_GET["judul"];
		$res=mysqli_query($link,"SELECT kode.id_kode,satuan.id_satuan,nama.id_pekerjaan,kode.kategori,kode.kode,satuan.satuan,nama.nama_pkj,nama.pokok_kegiatan,judul FROM judul j
JOIN kode_pekerjaan kode ON(kode.id_judul = j.id_judul)
JOIN satuan_pekerjaan satuan ON(satuan.id_kode = kode.id_kode)
JOIN nama_pekerjaan nama ON(nama.id_satuan = satuan.id_satuan)
		where j.id_judul='$id' or kode.kategori='$id' or nama.nama_pkj like '%$id%'
		order by kode.id_kode asc
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
									<p>
									<strong><em><?php echo $data["nama_pkj"];?></em></strong>
                                    <?php echo $data["pokok_kegiatan"]; ?>
                               		</p>
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
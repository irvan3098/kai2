<?php include("../conn.php"); ?>

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
	function jum_y_konformasi()
	{
		error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
		$link=koneksi();
		$id=(int)$_GET['id'];
		$res=mysqli_query($link,"SELECT * from pengguna where status = 'Y'");		
		if(!$res){
			die("Query error! : ".mysqli_error($link));
		}
			echo mysqli_num_rows($res);
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
	function jum_his_pengguna()
	{
		error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
		$link=koneksi();
		$id=(int)$_GET['id'];
		$res=mysqli_query($link,"SELECT * from history_pengguna ");		
		if(!$res){
			die("Query error! : ".mysqli_error($link));
		}
			echo mysqli_num_rows($res);
	}
?>

<?php
	function data_konfirmasi_y()
	{
		error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
		$link=koneksi();
		$id=(int)$_GET['id'];
		$res=mysqli_query($link,"SELECT * from pengguna where status = 'T'");		
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
                        <td><?php echo $data["email"]; ?></td>
                        <td><?php echo $data["username"]; ?></td>
                        <td><?php echo $data["password"]; ?></td>
                        <td><?php echo $data["level"]; ?></td>
                        <td>
                             <?php
							 	if($data["status"] == "Y" )
								{
							?>
                            		<a href="konfirmasi.php?id=<?php echo $data["id_pengguna"];?>&status=<?php echo $data["status"]; ?>" class="btn btn-danger" data-placement="top" title="Hapus">
                                    Non-aktifkan
                            		</a>
                        	<?php
								}
								elseif($data["status"] == "T")
								{
                             ?>
                                     <a href="konfirmasi.php?id=<?php echo $data["id_pengguna"];?>&status=<?php echo $data["status"]; ?>" class="btn btn-success "  data-placement="top" title="Ubah">
                                     Aktifkan
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
	function data_konfirmasi_t()
	{
		error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
		$link=koneksi();
		$id=(int)$_GET['id'];
		$res=mysqli_query($link,"SELECT * from pengguna where status = 'Y'");		
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
                        <td><?php echo $data["email"]; ?></td>
                        <td><?php echo $data["username"]; ?></td>
                        <td><?php echo $data["password"]; ?></td>
                        <td><?php echo $data["level"]; ?></td>
                        <td>
                             <?php
							 	if($data["status"] == "Y" )
								{
							?>
                            		<a href="konfirmasi.php?id=<?php echo $data["id_pengguna"];?>&status=<?php echo $data["status"]; ?>" class="btn btn-danger" data-placement="top" title="Hapus">
                                    Non-aktifkan
                            		</a>
                        	<?php
								}
								elseif($data["status"] == "T")
								{
                             ?>
                                     <a href="konfirmasi.php?id=<?php echo $data["id_pengguna"];?>&status=<?php echo $data["status"]; ?>" class="btn btn-success "  data-placement="top" title="Ubah">
                                     Aktifkan
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
                        <a href="sarana_dan_fasilitas/detail_judul.php?id=<?php echo $data["katsar"];?>&judul=<?php echo $data["katsar"];?>"><?php echo $data["katsar"];?></a>
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
                        <a href="prasarana/detail_judul.php?id=<?php echo $data["katsar"];?>&judul=<?php echo $data["katsar"];?>&kat=<?php echo $data["katsar"];?>">
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
                        <a href="pekerjaan/detail.php?id=<?php echo $data["katsar"];?>&judul=<?php echo $data["katsar"];?>&kat=<?php echo $data["katsar"];?>">
						<?php echo $data["katsar"];?></a>
                    </li>
       <?php
			}
			?>
            </ul>
       <?php
	}
?>

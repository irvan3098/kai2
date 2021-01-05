<?php
include("../../conn.php");
$link=koneksi();
$prop = $_POST['judul'];
$query= mysqli_query($link,'select * from sub_judul where id_judul="'.$prop.'"');
while($data=mysqli_fetch_array($query))
{
	echo '<option value="'.$data['id_sub'].'">'.$data['nama_sub'].'</option>';
}

?>
<?php
	function koneksi()
	{
		$host = "localhost";
		$database = "new_kai";
		$user = "root";
		$password = "";
		$link = mysqli_connect($host,$user,$password);
		mysqli_select_db($link, $database);
		if(!$link)
			echo "Error : ".mysqli_connect_error();
		return $link;
	}
?>
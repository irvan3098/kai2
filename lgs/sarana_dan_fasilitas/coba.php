<form method="post" enctype="multipart/form-data">
<input type="file" name="file">
<input type="submit" >
</form>
<?php 

	$file=pathinfo($_FILES["file"]["name"]);
	echo var_dump($_FILES["file"]["name"]);
	echo "<br>";
	echo $_FILES["file"]["type"];
	echo "<br>";
	echo $file["extension"];
?>
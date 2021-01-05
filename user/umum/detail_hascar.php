<?php 
	session_start();
	include("lib_func.php"); 
	if(!isset($_SESSION['namauser']))
	{
		echo "<script>window.location = '../index.php'; </script>";
		//header("Location: ../index.php");
	}
	if($_SESSION["level"] !="user")
	{
		echo "<script>window.location = '../index.php'; </script>";
		//header("Location: ../index.php");
	}
?>
<!DOCTYPE HTML>
<!--
	Alpha by HTML5 UP
	html5up.net | @n33co
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
	<head>
		<title>MATERIAL LOGISTIK</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<!--[if lte IE 8]><script src="assets/js/ie/html5shiv.js"></script><![endif]-->
		<link rel="stylesheet" href="../assets/css/main.css" />
        <link rel="stylesheet" href="../assets/css/table.css" />
		<!--[if lte IE 8]><link rel="stylesheet" href="assets/css/ie8.css" /><![endif]-->
	 </head>
	<body class="landing">
		<div id="page-wrapper">

			<!-- Header -->
				<header id="header" class="alt">
					<h1><a href="../index.php">MATERIAL LOGISTIK</a></h1>
					<nav id="nav">
						<ul>
							<li><a href="../index.php">Home</a></li>
							<li>
								<a href="../sarfas/index.php" class="icon fa-angle-down">Sarana dan fasilitas</a>
								<?php menu_sarfas();?>
							</li>
                            <li>
								<a href="../prasarana/index.php" class="icon fa-angle-down">Prasarana</a>
								<?php menu_prasarana();?>
							</li>
                            <li><a href="index.php">Umum</a></li>
                            <li>
                            	<a href="../pekerjaan/index.php" class="icon fa-angle-down">Pekerjaan</a>
                            	<?php menu_pekerjaan();?>
                            </li>
                            <li><a href="https://e-katalog.lkpp.go.id/">E-catalog LKPP</a></li>
							<li><a href="../../login/logout.php" class="button">Logout</a></li>
						</ul>
					</nav>
				</header>

			<!-- Banner -->
				<section id="banner">
					<h2>MATERIAL LOGISTIK</h2>
					<p>PT KERETA API INDONESIA (PERSERO)</p>
				</section>

			<!-- Main -->
				<section id="main" class="container">

					<section class="box special">
                       
    					<span class="image featured">
                        <section id="cta">
                        <form action="../hasil_cari.php" method="get">
                            <div class="row uniform 50%">
                                <div class="8u 12u(mobilep)">
                                    <input type="text" name="cari" id="" />
                                </div>
                                <div class="4u 12u(mobilep)">
                                    <input type="submit" value="Cari" class="fit" />
                                </div>
                            </div>
                        </form>
                   		</section>
                        </span>
                   
						<header class="major">
                        	<h2><strong>Umum</strong></h2>
							<h3>Data hasil cari :<strong><em><?php echo $_GET["judul"];?></em></strong></h3>
                            <p>
                                    Untuk cetak klick icon ini
                                    <a href="#" onClick="window.open('http://<?php url();?>user/umum/cetak_hascar.php?id=<?php echo $_GET["id"];; ?>&judul=<?php echo $_GET["judul"];?>','popuppage','width=500,toolbar=0,resizable=0,scrollbars=no,height=400,top=100,left=100');">
                                    <i class=" fa fa-2x fa-print"></i>
                                    </a>
                                </p>
                            <div class="12u">
								
                                <p>
                                <table width="100%" class="table table-striped " id="dataTables-example">
                                    <thead>
                                    <tr>
                                        <th>NO</th>
                                        <th>NAMA BARANG</th>
                                        <th>MERK</th>
                                        <th>SPESIFIKASI TEKNIK/KATALOG</th>
                                        <th>SATUAN</th>
                                        <th>MATA UANG</th>
                                        <th>HARGA SATUAN</th>
                                        <th>KETERANGAN</th>
                                        <th>DESKRIPSI</th>
                                    </tr>
                                    </thead>
                                    <tbody>
	                                    <?php ditail_hascar();?>
                                    </tbody>
                                </table>
                                </p>
						
						</div>
						</header>
					</section>

					

					</section>
<!-- Footer -->
				<footer id="footer">
					<ul class="copyright">
						<li>&copy; Untitled. All rights reserved.</li><li>Design: <a href="http://html5up.net">HTML5 UP</a></li>
					</ul>
				</footer>

		</div>

		<!-- Scripts -->
			<script src="../assets/js/jquery.min.js"></script>
			<script src="../assets/js/jquery.dropotron.min.js"></script>
			<script src="../assets/js/jquery.scrollgress.min.js"></script>
			<script src="../assets/js/skel.min.js"></script>
			<script src="../assets/js/util.js"></script>
			<!--[if lte IE 8]><script src="assets/js/ie/respond.min.js"></script><![endif]-->
			<script src="../assets/js/main.js"></script>	
            
             <script src="../../bower_components/datatables/media/js/jquery.dataTables.min.js"></script>
			<script src="../../bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>
            <script src="../../bower_components/datatables-responsive/js/dataTables.responsive.js"></script>
	
    <script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
                responsive: true
        });
    });
	 $(document).ready(function() {
        $('#dataTables-umum').DataTable({
                responsive: true
        });
    });
    </script>

	</body>
</html>
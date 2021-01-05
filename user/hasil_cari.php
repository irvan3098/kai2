<?php 
	session_start();
	include("lib_user.php"); 
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
		<link rel="stylesheet" href="assets/css/main.css" />
        <link rel="stylesheet" href="assets/css/table.css" />
		<!--[if lte IE 8]><link rel="stylesheet" href="assets/css/ie8.css" /><![endif]-->
	 </head>
	<body class="landing">
		<div id="page-wrapper">

			<!-- Header -->
				<header id="header" class="alt">
					<h1><a href="../index.php">MATERIAL LOGISTIK</a></h1>
					<nav id="nav">
						<ul>
							<li><a href="index.php">Home</a></li>
							<li>
								<a href="sarfas/index.php" class="icon fa-angle-down">Sarana dan fasilitas</a>
								<?php menu_sarfas();?>
							</li>
                            <li>
								<a href="prasarana/index.php" class="icon fa-angle-down">Prasarana</a>
								<?php menu_prasarana();?>
							</li>
                            <li><a href="umum/index.php">Umum</a></li>
                            <li>
                            	<a href="pekerjaan/index.php" class="icon fa-angle-down">Pekerjaan</a>
                            	<?php menu_pekerjaan();?>
                            </li>
                            <li><a href="https://e-katalog.lkpp.go.id/">E-catalog LKPP</a></li>
							<li><a href="../login/logout.php" class="button">Logout</a></li>
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
                                <form method="get" action="hasil_cari.php">
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
							<h2>HASIL CARI DARI <strong><em><?php echo $_GET["cari"]; ?></em></strong></h2>
						</header>
					</section>
                	
                   
			      	<section class="box special">
                        <header class="major">
                        	<h2><strong>Sarana dan fasilitas</strong></h2>
							<ul class="actions">
                            	<li>
                                	<a href=""  onClick="window.open('http://<?php url();?>user/sarfas/detail_hascar.php?id=<?php echo $_GET["cari"]; ?>&judul=<?php echo $_GET["cari"];?>','popuppage','width=500,toolbar=0,resizable=0,scrollbars=no,height=400,top=100,left=100');"class="button alt">Lihat semua
                                    </a>
                               	</li>
                      			<li>
                                	<a href="#" onClick="window.open('http://<?php url();?>user/sarfas/cetak_hascar.php?id=<?php echo $_GET["cari"]; ?>&judul=<?php echo $_GET["cari"];?>','popuppage','width=500,toolbar=0,resizable=0,scrollbars=no,height=400,top=100,left=100');">
                                    <i class=" fa fa-2x fa-print"></i>
                                    </a>
                               </li>
                            </ul>
                            <div class="12u">
								<p>
                                <table width="100%" class="table table-striped " id="dataTables-sarfas">
                                    <thead>
                                    <tr>
                                        <th>NO</th>
                                        <th>KATEGORI</th>
                                        <th>NOMOR MATERIAL SAP</th>
                                        <th>NAMA BARANG</th>
                                        <th>SPESIFIKASI TEKNIK/KATALOG</th>
                                        <th>SATUAN</th>
                                        <th>MATA UANG</th>
                                        <th>HARGA SATUAN</th>
                                        <th>VENDOR/SUPLIER</th>
                                        <th>DESKRIPSI</th>
                                    </tr>
                                    </thead>
                                    <tbody>
	                                    <?php hascar_sarfas();?>
                                    </tbody>
                                </table>
                                </p>
							</div>
						</header>
                        </section><!-- section box sarfas-->
                        
                        
                        <section class="box special">
                        <header class="major">
                        	<h2><strong>Prasrana</strong></h2>
							<ul class="actions">
                            	<li>
                                	<a href=""  onClick="window.open('http://<?php url();?>user/prasarana/detail_hascar.php?id=<?php echo $_GET["cari"]; ?>&judul=<?php echo $_GET["cari"];?>','popuppage','width=500,toolbar=0,resizable=0,scrollbars=no,height=400,top=100,left=100');"class="button alt">
                                    Lihat semua
                                    </a>
                               	</li>
                                <li>
                                	<a href="#" onClick="window.open('http://<?php url();?>user/prasarana/detail_cetak.php?id=<?php echo $_GET["cari"]; ?>&judul=<?php echo $_GET["cari"];?>','popuppage','width=500,toolbar=0,resizable=0,scrollbars=no,height=400,top=100,left=100');">
                                		<i class=" fa fa-2x fa-print"></i>
                                   	</a>
                             	</li>
                            </ul>
                            <div class="12u">
								<p>
                                <table width="100%" class="table table-striped " id="dataTables-prasarana">
                                    <thead>
                                    <tr>
                                        <th>NO</th>
                                        <th>KATEGORI</th>
                                        <th>NOMOR MATERIAL SAP</th>
                                        <th>NAMA BARANG</th>
                                        <th>SPESIFIKASI TEKNIK/KATALOG</th>
                                        <th>SATUAN</th>
                                        <th>MATA UANG</th>
                                        <th>HARGA SATUAN</th>
                                        <th>VENDOR/SUPLIER</th>
                                        <th>DESKRIPSI</th>
                                    </tr>
                                    </thead>
                                    <tbody>
	                                    <?php hascar_prasarana();?>
                                    </tbody>
                                </table>
                                </p>
							</div>
						</header>
                        </section><!-- section box prasarna-->
                        
                        <section class="box special">
                        <header class="major">
                        	<h2><strong>Umum</strong></h2>
							<ul class="actions">
                            	<li>
                                	<a href=""  onClick="window.open('http://<?php url();?>user/umum/detail_hascar.php?id=<?php echo $_GET["cari"]; ?>&judul=<?php echo $_GET["cari"];?>','popuppage','width=500,toolbar=0,resizable=0,scrollbars=no,height=400,top=100,left=100');"class="button alt">
                                    Lihat semua
                                    </a>
                              	</li>
                                	<a href="#" onClick="window.open('http://<?php url();?>user/umum/cetak_hascar.php?id=<?php echo $_GET["cari"]; ?>&judul=<?php echo $_GET["cari"];?>','popuppage','width=500,toolbar=0,resizable=0,scrollbars=no,height=400,top=100,left=100');">
                                    	<i class=" fa fa-2x fa-print"></i>
                                    </a>
                                </li>
                            </ul>
                            <div class="12u">
								<p>
                                <table width="100%" class="table table-striped " id="dataTables-umum">
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
	                                    <?php hascar_umum();?>
                                    </tbody>
                                </table>
                                </p>
							</div>
						</header>
                        </section><!-- section box umum-->
                        
                        <section class="box special">
                        <header class="major">
                        	<h2><strong>Pekerjaan</strong></h2>
							<ul class="actions">
                            	<li>
                                	<a href=""  onClick="window.open('http://<?php url();?>user/pekerjaan/detail_data.php?id=<?php echo $_GET["cari"]; ?>&judul=<?php echo $_GET["cari"];?>','popuppage','width=500,toolbar=0,resizable=0,scrollbars=no,height=400,top=100,left=100');"class="button alt">
                                    Lihat semua
                                    </a>
                               	</li>
                                <li>
                                	<a href="#" onClick="window.open('http://<?php url();?>user/pekerjaan/detail_cetak.php?id=<?php echo $_GET["cari"]; ?>&judul=<?php echo $_GET["cari"];?>','popuppage','width=500,toolbar=0,resizable=0,scrollbars=no,height=400,top=100,left=100');">
                                    	<i class=" fa fa-2x fa-print"></i>
                                   	</a>
                             	</li>
                           	</ul>
                            <div class="12u">
								<p>
                                <table width="100%" class="table table-striped align-left" id="dataTables-pekerjaan">
                                    <thead>
                                    <tr>
                                        <th>NO</th>
                                        <th>KODE</th>
                                        <th>SATUAN</th>
                                        <th>HARGA SATUAN PEKERJAAN</th>
                                    </tr>
                                    </thead>
                                    <tbody>
	                                    <?php hascar_pekerjaan();?>
                                    </tbody>
                                </table>
                                </p>
							</div>
						</header>
                        </section><!-- section box pekerjaan-->
                        
                        
					</section><!-- section main-->

					

				
<!-- Footer -->
				<footer id="footer">
					<ul class="copyright">
						<li>&copy; 2017</li><li>Powered by: HTML5 UP</li>
					</ul>
				</footer>

		</div>

		<!-- Scripts -->
			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/jquery.dropotron.min.js"></script>
			<script src="assets/js/jquery.scrollgress.min.js"></script>
			<script src="assets/js/skel.min.js"></script>
			<script src="assets/js/util.js"></script>
			<!--[if lte IE 8]><script src="assets/js/ie/respond.min.js"></script><![endif]-->
			<script src="assets/js/main.js"></script>	
            
             <script src="../bower_components/datatables/media/js/jquery.dataTables.min.js"></script>
			<script src="../bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>
            <script src="../bower_components/datatables-responsive/js/dataTables.responsive.js"></script>
	
    <script>
    $(document).ready(function() {
        $('#dataTables-sarfas').DataTable({
                responsive: true
        });
    });
	$(document).ready(function() {
        $('#dataTables-prasarana').DataTable({
                responsive: true
        });
    });
	$(document).ready(function() {
        $('#dataTables-umum').DataTable({
                responsive: true
        });
    });
	$(document).ready(function() {
        $('#dataTables-pekerjaan').DataTable({
                responsive: true
        });
    });
    </script>

	</body>
</html>
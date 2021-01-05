<?php
	include("lib_func.php");
	session_start();
	if(!isset($_SESSION['namauser']))
	{
		echo "<script>window.location = '../../index.php'; </script>";
	}
	if($_SESSION["level"] !="lgs")
	{
		echo "<script>window.location = '../../index.php'; </script>";
		//header("Location: ../index.php");
	}
	?>

<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Material logistik</title>

    <!-- Bootstrap Core CSS -->
    <link href="../../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../../bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../../bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
   


</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#"><?php echo $_SESSION['namauser']; ?></a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
            	<li>
                	<a href="../sarana_dan_fasilitas/index.php">Sarana dan fasilitas</a>
                    <li>
                        <a class="dropdown-toggle" data-toggle="dropdown" href="index.php">
                          <i class="fa fa-caret-down"></i>
                        </a>
                       <?php menu_sarfas();?>
                        <!-- /.dropdown-user -->
                    </li>
                </li> 
                <li>
                	<a href="../prasarana/index.php">Prasarana</a>
                    <li>
                        <a class="dropdown-toggle" data-toggle="dropdown" href="../prasarana/index.php">
                          <i class="fa fa-caret-down"></i>
                        </a>
                       <?php menu_prasarana();?>
                        <!-- /.dropdown-user -->
                    </li>
                </li> 
                <li>
                    <a href="../umum/index.php">
                        Umum
                    </a>
                </li>
                <li>
                    <a href="../pekerjaan/index.php">Pekerjaan</a>
                    <li>
                        <a class="dropdown-toggle" data-toggle="dropdown" href="index.php">
                          <i class="fa fa-caret-down"></i>
                        </a>
                       <?php menu_pekerjaan();?>
                       <!-- /.dropdown-user -->
                    </li>
                </li>
                <li>
                    <a href="https://e-katalog.lkpp.go.id/">
                        E-catalog LKPP
                    </a>
                </li>
                <li>
                    <a href="https://e-katalog.lkpp.go.id/">
                        E-catalog LKPP
                    </a>
                </li>
                <li>
                    <a  href="../pengguna/index.php"><i class="fa fa-users fa-fw"></i>
                        Pengguna
                    </a>
                </li>
                  <li><a href="../../login/logout.php"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                </li>
            </ul>
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                       <li>
                            <a href="#"><i class="fa fa-sitemap fa-fw"></i>Umum<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <?php nav(); ?>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Form ubah</h1>
                    </div>
                    <?php tampil_ubah_umum(); ?>
               </div>                 
        	</div>
        </div>
                    
  	</div>

    <!-- jQuery -->
    <script src="../../bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../../bower_components/metisMenu/dist/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../../dist/js/sb-admin-2.js"></script>
    
     <!-- DataTables JavaScript -->
    <script src="../../bower_components/datatables/media/js/jquery.dataTables.min.js"></script>
    <script src="../../bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>
    <script src="../../bower_components/datatables-responsive/js/dataTables.responsive.js"></script>
    
    <!-- Custom Theme JavaScript -->
    <script src="../../dist/js/sb-admin-2.js"></script>

    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
	// tooltip demo
    $('.tooltip-demo').tooltip({
        selector: "[data-toggle=tooltip]",
        container: "body"
    })
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
                responsive: true
        });
    });
	$(document).ready(function() {
        $('#dataTables-example-datasatuan').DataTable({
                responsive: true
        });
    });
	$(document).ready(function() {
        $('#dataTables-example-datamatauang').DataTable({
                responsive: true
        });
    });
	$(document).ready(function() {
        $('#dataTables-example-datavendor').DataTable({
                responsive: true
        });
    });
	$(document).ready(function() {
        $('#dataTables-example-datajudul').DataTable({
                responsive: true
        });
    });
    </script>

</body>

</html>

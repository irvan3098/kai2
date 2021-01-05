<!DOCTYPE html>
<html lang="en">
<?php
	include("func_index.php");
	session_start();
	if(!isset($_SESSION['namauser']))
	{
		header("Location: ../index.php");
	}
	if($_SESSION["level"] !="lgs")
	{
		header("Location: ../index.php");
	}
?>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Material logistik</title>

    <!-- Bootstrap Core CSS -->
    <link href="../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

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
                	<a href="sarana_dan_fasilitas/index.php">Sarana dan fasilitas</a>
                    <li>
                        <a class="dropdown-toggle" data-toggle="dropdown" href="index.php">
                          <i class="fa fa-caret-down"></i>
                        </a>
                       <?php menu_sarfas();?>
                        <!-- /.dropdown-user -->
                    </li>
                </li> 
                <li>
                	<a href="prasarana/index.php">Prasarana</a>
                    <li>
                        <a class="dropdown-toggle" data-toggle="dropdown" href="../prasarana/index.php">
                          <i class="fa fa-caret-down"></i>
                        </a>
                       <?php menu_prasarana();?>
                        <!-- /.dropdown-user -->
                    </li>
                </li> 
                <li>
                    <a href="umum/index.php">
                        Umum
                    </a>
                </li>
                <li>
                    <a  href="pekerjaan/index.php">
                        Pekerjaan
                    </a>
                    <li>
                        <a class="dropdown-toggle" data-toggle="dropdown" href="../prasarana/index.php">
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
                    <a  href="pengguna/index.php"><i class="fa fa-users fa-fw"></i>
                        Pengguna
                    </a>
                </li>
                  <li><a href="../login/logout.php"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                </li>
            </ul>
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                      
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
                        <h1 class="page-header">Selamat datang admin <?php echo $_SESSION['namauser']; ?></h1>
                    </div>
                    <!-- /.col-lg-12 -->
              		<div class="col-lg-4 col-md-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-users fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge"><?php jum_y_konformasi()?></div>
                                        <div>Sudah dikonfirmasi</div>
                                    </div>
                                </div>
                            </div>
                                <a href="pengguna/data_pengguna.php">
                                <div class="panel-footer">
                                    <span class="pull-left">Lihat</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                                </a>
                            
                        </div>
                    </div>
                   <div class="col-lg-4 col-md-6">
                        <div class="panel panel-red">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-users fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge"><?php jum_t_konformasi() ?></div>
                                        <div>Belum dikonfirmasi</div>
                                    </div>
                                </div>
                            </div>
                            <a href="pengguna/data_pengguna.php">
                                <div class="panel-footer">
                                    <span class="pull-left">Lihat</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="panel panel-green">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa  fa-folder-open fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge"><?php jum_his_pengguna()?></div>
                                        <div>Aktivitas</div>
                                    </div>
                                </div>
                            </div>
                            <a href="pengguna/index.php">
                                <div class="panel-footer">
                                	<span class="pull-left">Lihat</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                	</div>
                    <div class="col-lg-8">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            History pengguna
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#1" data-toggle="tab">User</a>
                                </li>
                                <li><a href="#2" data-toggle="tab">LGS</a>
                                </li>
                                <li><a href="#3" data-toggle="tab">PBJ</a>
                                </li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div class="tab-pane fade in active" id="1">
                                    <p>
                                    	<div class="table-responsive">
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Nama</th>
                                                        <th>Aktifitas</th>
                                                        <th>Waktu</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php his_user() ?>
                                                </tbody>
                                            </table>
                                        </div>
                            <!-- /.table-responsive -->
                                   	</p>
                                </div>
                                <div class="tab-pane fade" id="2">
                                    <p>
                                    	<div class="table-responsive">
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Nama</th>
                                                        <th>Aktifitas</th>
                                                        <th>Waktu</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php his_lgs() ?>
                                                </tbody>
                                            </table>
                                        </div>
                            <!-- /.table-responsive -->
                                    </p>
                                </div>
                                <div class="tab-pane fade" id="3">
                                    <p>
                                    	<div class="table-responsive">
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Nama</th>
                                                        <th>Aktifitas</th>
                                                        <th>Waktu</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php his_pbj() ?>
                                                </tbody>
                                            </table>
                                        </div>
                            <!-- /.table-responsive -->
                                    </p>
                                </div>
                               
                            </div>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                </div>
                <!-- /.row -->
           		 </div>
            <!-- /.container-fluid -->
        	</div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

 <!-- jQuery -->
    <script src="../bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../bower_components/metisMenu/dist/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>

</body>

</html>

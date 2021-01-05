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

    <title>Material Logistik</title>

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
                <a class="navbar-brand" href="#"><?php echo $_SESSION['namauser'];?></a>
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
                    <a  href="../umum/index.php">
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
                    <a  href="index.php"><i class="fa fa-users fa-fw"></i>
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
                       <li class="active">
                            <a href="index.php"><i class="fa fa-sitemap fa-fw"></i>History penguna</a>
                        </li>
                        <li><strong></strong>
                            <a href="data_pengguna.php"><i class="fa fa-sitemap fa-fw"></i>Data pengguna</a>
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
                        <h1 class="page-header">Data pengguna</h1>
                    </div>
                    <!-- /.col-lg-12 -->
                       <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    Data pengguna
                                </div>
                                <!-- /.panel-heading -->
                                <div class="panel-body">
                                    <!-- Nav tabs -->
                                    <ul class="nav nav-tabs">
                                        <li class="active"><a href="#1" data-toggle="tab">Konfirmasi</a>
                                        </li>
                                        <li><a href="#2" data-toggle="tab">Tambah data</a>
                                        </li>
                                        <li><a href="#3" data-toggle="tab">Data<br>
pengguna</a>
                                        </li>
                                    </ul>
        
                                    <!-- Tab panes -->
                                    <div class="tab-content">
                                        <div class="tab-pane fade in active" id="1"><br>

                                                <div class="table-responsive">
                                                    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-konfirmasi">
                                                        <thead>
                                                            <tr>
                                                                <td>No</td>
                                                                <td>NIP</td>
                                                                <td>Username</td>
                                                                <td>Password</td>
                                                                <td>Level</td>
                                                                <td>Konfirmasi</td>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php data_konfirmasi(); ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                    <!-- /.table-responsive -->
                                        </div>
                                        <div class="tab-pane fade" id="2">
                                            <p>
                                                <form name="tambah_pengguna" method="post">	
                                                <div class="panel-body">
                                                <div class="form-group">
                                                     <table width="80%">
                                                        <tr>
                                                            <td><label>NIP </label></td>
                                                            <td>
                                                                <div class="form-group">
                                                                <input class="form-control" type="number" name="nip">
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td><label>Username </label></td>
                                                            <td>
                                                                <div class="form-group">
                                                                <input class="form-control" type="text" name="user">
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td><label>Password </label></td>
                                                            <td>
                                                                <div class="form-group">
                                                                <input class="form-control" type="text" name="pass">
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td><label>Level </label></td>
                                                            <td>
                                                                <div class="form-group">
                                                                <select name="level" class="form-control">
                                                                	<option>user</option>
                                                                    <option>lgs</option>
                                                                </select>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                           
                                                     </table>
                                               </div>
                                            </div>
                                            <div class="panel-footer">
                                                <button type="submit" class="btn btn-primary" name="daftar">Simpan</button>
                                                <button type="reset" class="btn btn-danger">Reset</button>
                                            </div>
                                            </form>
                                            <?php tambah_pengguna(); ?>
                                     </div>
                                     
                                        <div class="tab-pane fade" id="3"><br>

                                               <div class="table-responsive">
                                                    <table width="100%" class="table table-striped table-bordered table-hover" id="datamatauang">
                                                        <thead>
                                                            <tr>
                                                                <th>No</th>
                                                                <th>NIP</th>
                                                                <th>Username</th>
                                                                <th>Password</th>
                                                                <th>Level</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        	<?php data_pengguna(); ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                   
                                        </div>
                                       
                                    </div>
                                </div>
                                <!-- /.panel-body -->
                            </div>
                        </div>
                
				
                    
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
        $('#dataTables-konfirmasi').DataTable({
                responsive: true
        });
    });
	$(document).ready(function() {
        $('#dataTables-data_pengguna').DataTable({
                responsive: true
        });
    });
	$(document).ready(function() {
        $('#datamatauang').DataTable({
                responsive: true
        });
    });
    </script>

</body>

</html>

<!DOCTYPE html>
<html lang="en">
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
<head>
	<script src="../../ckeditor/ckeditor.js"></script>
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
                    <a href="../umum/index.php">
                        Umum
                    </a>
                </li>
                <li>
                    <a  href="index.php">
                        Pekerjaan
                    </a>
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
                            <a href="#"><i class="fa fa-sitemap fa-fw"></i> Pekerjaan<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                            <li>  
                                    <?php nav(); ?>
                            </li>
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
                    <div class="col-lg-8">
                        <h1 class="page-header">Data pekerjaan</h1>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        </br>
						<div class="panel panel-red">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-users fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge"><?php jum_t_konformasi(); ?></div>
                                        <div>Belum dikonfirmasi</div>
                                    </div>
                                </div>
                            </div>
                            <a href="../pengguna/data_pengguna.php">
                                <div class="panel-footer">
                                    <span class="pull-left">Lihat</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <!-- /.col-lg-12 -->
                    <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#home" data-toggle="tab">Pencarian</a>
                                </li>
                                <li><a href="#tambahdata" data-toggle="tab">Tambah<br>
data</a>
                                </li>
                                <li><a href="#cetak" data-toggle="tab">Cetak</a>
                                </li>
                                <li><a href="#judul" data-toggle="tab">Data<br>
judul</a>
                                </li>
                                  <li><a href="#kategori" data-toggle="tab">Data<br>
kategori</a>
                                </li>
                               
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content">
                            	<div class="tab-pane fade in active" id="home">
                                    <h4></h4>
                                    <p>
                                    	<div class="form-group input-group col-lg-4 center-block">
                                        	<form name="cari" method="get" action="hasilcari.php">
                                                 <input type="text" class="form-control" name="cari" placeholder="Cari..">
                                                    <span class="input-group-btn center-block">
                                                        <button class="btn btn-default" type="button"><i class="fa fa-search"></i>
                                                        </button>
                                                    </span>
                                            </form>
                                        </div>
                                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                                <thead>
                                                    <tr>
                                                        <th>NO</th>
                                                        <th>KODE</th>
                                                        <th>SATUAN</th>
                                                        <th>NAMA PEKERJAAN</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                    </p>
                                </div>
                                <div class="tab-pane fade" id="tambahdata">
                                    <h4></h4>
                                    <p>
                                    <form name="umum" method="post" action="" >	
                                    	<div class="panel-body">
                                <div class="form-group">
                                	 <table width="80%">
                                    	<tr>
                                        	<td><label>judul</label></td>
                                            <td>
                                            	<div class="form-group input-group">
                                                <select class="form-control" name="idjudul">
                                               		<?php pilih_judul();?>
                                                </select>
                                                <span class="input-group-btn">
                                                   <a class="btn btn-warning" data-toggle="modal" data-target="#myModal2" data-placement="top" title="Tambah satuan">
                             <i class="fa fa-plus"></i>
                                                    </a>
                                                    <!-- Modal -->
                                                    <div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                                    <h4 class="modal-title" id="myModalLabel">Tambah judul</h4>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form name="okl" method="post">
                                                                        <table class="table">
                                                                                <tr>
                                                                                     <td>
                                                                            		<input class="form-control" type="text" name="tjudul" />
                                                                                    </td>
                                                                                </tr>
                                                                            </table>
                                                                </div>
                                                                <div class="modal-footer">
                                                                     <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                                                                    <button type="submit" class="btn btn-primary" name="tambahjudul">Tambah</button>
                                                                    </form>
                                                                    <?php tambah_judul(); ?>
                                                                </div>
                                                            </div>
                                                            <!-- /.modal-content -->
                                                        </div>
                                                        <!-- /.modal-dialog -->
                                                    </div>
                                                </span>
                                            	</div>
                                           	</td>
                                      	</tr>
                                        <tr>
                                        	<td><label>Kategori</label></td>
                                            <td>
                                            	<div class="form-group input-group">
                                                <select class="form-control" name="kategori">
                                                	<option></option>
                                               		<?php pilih_kategori();?>
                                                </select>
                                                <span class="input-group-btn">
                                                   <a class="btn btn-warning" data-toggle="modal" data-target="#myModalkat" data-placement="top" title="Tambah satuan">
                             <i class="fa fa-plus"></i>
                                                    </a>
                                                    <!-- Modal -->
                                                    <div class="modal fade" id="myModalkat" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                                    <h4 class="modal-title" id="myModalLabel">Tambah kategori</h4>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form name="tjudul" method="post">
                                                                        <table class="table">
                                                                                <tr>
                                                                                     <td>
                                                                            		<input class="form-control" type="text" name="tkategori" />
                                                                                    </td>
                                                                                </tr>
                                                                            </table>
                                                                </div>
                                                                <div class="modal-footer">
                                                                     <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                                                                    <button type="submit" class="btn btn-primary" name="tambahkategori">Tambah</button>
                                                                    <?php tambah_kategori();?>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                            <!-- /.modal-content -->
                                                        </div>
                                                        <!-- /.modal-dialog -->
                                                    </div>
                                                </span>
                                            	</div>
                                           	</td>
                                      	</tr>
                                        <tr>
                                        	<td><label>Kode</label></td>
                                            <td>
                                            	<div class="form-group">
                                            	<input class="form-control" type="text" name="kode">
                                                </div>
                                           	</td>
                                      	</tr>
                                        <tr>
                                        	<td><label>Satuan</label></td>
                                            <td>
                                            	<div class="form-group">
                                            	<input class="form-control" type="text" name="satuan">
                                                </div>
                                           	</td>
                                      	</tr>
                                        <tr>
                                    		<td><label>Nama pekerjaan</label></td>
                                    		<td>
                                            	<div class="form-group">
                                            	<input class="form-control" type="text" name="nampek">
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                    		<td><label>Pokok kegiatan</label></td>
                                    		<td>
                                            	<div class="form-group">
                                            	 <textarea name="kegpok" class="ckeditor"></textarea>
                                                    
                                                </div>
                                            </td>
                                        </tr>
                                           
                                     </table>
                               </div>
                            </div>
                            
                                	
                            <div class="panel-footer">
                                <button type="submit" class="btn btn-primary" name="simpan">Simpan</button>
                                <button type="reset" class="btn btn-danger">Reset</button>
                            </div>
                            <?php simpan_data_pekerjaan();?>
                            </form><!-- tambah sarfas -->
                            
                                    </p>
                                </div>
                                <div class="tab-pane fade" id="cetak">
                                    <br>
									<form name="cetak" method="post" action="detail_cetak.php">
                                    <div class="col-lg-6">
                                         <div class="panel panel-primary">
                                            <div class="panel-heading">
                                                Cetak judul
                                            </div>
                                            <div class="panel-body">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered" id="datacetak">
                                                       <thead>
                                                       		<tr>
                                                            	<td>NO</td>
                                                                <td>JUDUL</td>
                                                            </tr>
                                                       </thead>
                                                       <tbody>
                                                                <?php pekerjaan_cetak();?>
                                                       </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="panel-footer">
                                            <input class="btn btn-primary" type="submit" name="submit" value="Cetak" />
                                            </div>
                                        </div>
									</div>
                                    </form>
                                </div>
                                 <div class="tab-pane fade" id="satuan">
                                    <h4></h4>
                                    <p>
                                    	<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example-datasatuan">
                                                <thead>
                                                    <tr>
                                                        <th>NO</th>
                                                        <th>NAMA SATUAN</th>
                                                        <th>ACTION</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                	<?php //data_satuan() ?>
                                                </tbody>
                                            </table>
                                    </p>
                                </div>
                                <div class="tab-pane fade" id="matauang">
                                    <h4></h4>
                                    <p>
                                    	<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example-datamatauang">
                                                <thead>
                                                    <tr>
                                                        <th>NO</th>
                                                        <th>NAMA MATA UANG</th>
                                                        <th>ACTION</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                	<?php //data_matauang()?>
                                                </tbody>
                                            </table>
                                    </p>
                                </div>
                                <div class="tab-pane fade" id="judul">
                                    <p>
                                   		<div class="alert alert-danger">
                                            Data yang berkaitan dengan nama judul, maka akan terhapus
                                        </div>
                                   </p>
                                    <p>
                                    	<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example-datajudul">
                                                <thead>
                                                    <tr>
                                                        <th>NO</th>
                                                        <th>JUDUL</th>
                                                        <th>ACTION</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                	<?php data_judul();?>
                                                </tbody>
                                            </table>
                                    </p>
                                </div>
                                <div class="tab-pane fade" id="subjudul">
                                      <p>
                                   		<div class="alert alert-danger">
                                            Data yang berkaitan dengan nama sub judul, maka akan terhapus
                                        </div>
                                   </p>
                                    <p>
                                    	<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example-datasub">
                                                <thead>
                                                    <tr>
                                                        <th>NO</th>
                                                        <th>JUDUL</th>
                                                        <th>NAMA SUB</th>
                                                        <th>ACTION</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                	<?php //data_sub_judul()?>
                                                </tbody>
                                            </table>
                                    </p>
                                </div>
                                <div class="tab-pane fade" id="kategori">
                                    <p>
                                   		<div class="alert alert-danger">
                                            Data yang berkaitan dengan nama judul, maka akan terhapus
                                        </div>
                                   </p>
                                    <p>
                                    	<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example-datajudul">
                                                <thead>
                                                    <tr>
                                                        <th>NO</th>
                                                        <th>KATEGORI</th>
                                                        <th>ACTION</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                	<?php data_kategori();?>
                                                </tbody>
                                            </table>
                                    </p>
                                </div>
                                
                            </div>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    
                    <!-- /.panel -->
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
        $('#datacetak').DataTable({
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

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
    <meta http-equiv=\"refresh\" content=\"0\" />
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
   
   	<script type="text/javascript" src="../../bower_components/jquery-1.7.2.min.js"></script>
	<script type="text/javascript">
    function pilih_judul(namajudul)
    {
        $.ajax({
            url: 'sub.php',
            data : 'judul='+namajudul,
            type: "post", 
            dataType: "html",
            timeout: 10000,
            success: function(response){
                $('#sub_judul').html(response);
            }
        });
    }
	
	function pilih_judul_excel(judul)
    {
        $.ajax({
            url: 'sub.php',
            data : 'judul='+judul,
            type: "post", 
            dataType: "html",
            timeout: 10000,
            success: function(response){
                $('#excel').html(response);
            }
        });
    }
	function pilih_judul_cetak(judul)
    {
        $.ajax({
            url: 'sub.php',
            data : 'judul='+judul,
            type: "post", 
            dataType: "html",
            timeout: 10000,
            success: function(response){
                $('#sub_judul_cetak').html(response);
            }
        });
    }
    </script>


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
                            <a href="#"><i class="fa fa-sitemap fa-fw"></i> Umum<span class="fa arrow"></span></a>
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
                        <h1 class="page-header">Data umum</h1>
                    </div>
                    <div class="col-lg-4 ">
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
                         <i class="fa-gear fa"> Pengolahaan data</i>
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
                                <li><a href="#import" data-toggle="tab">Import</a>
                                </li>
                                <li><a href="#cetak" data-toggle="tab">Cetak</a>
                                </li>
                                <li><a href="#judul" data-toggle="tab">Data<br>
judul</a>
                                </li>
                                <li><a href="#subjudul" data-toggle="tab">Data<br>
sub judul</a>
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
                                                        <th>NAMA BARANG</th>
                                                        <th>MERK</th>
                                                        <th>SPESIFIKASI</th>
                                                        <th>SATUAN</th>
                                                        <th>MATA UANG</th>
                                                        <th>HARGA SATUAN</th>
                                                        <th>KETERANGAN</th>
                                                        <th>DESKRIPSI</th>
                                                        <th>ACTION</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                	<?php data_hasilcari();?>
                                                </tbody>
                                            </table>
                                    </p>
                                </div>
                                <div class="tab-pane fade" id="tambahdata">
                                    <h4></h4>
                                    <p>
                                    <form name="umum" method="post" action="" enctype="multipart/form-data">	
                                    	<div class="panel-body">
                                <div class="form-group">
                                	 <div class="well">
                                     <table>
                                    	<tr>
                                        	<td><label>judul</label></td>
                                            <td>
                                            	<div class="form-group input-group">
                                                <select class="form-control" name="namajudul" onchange="pilih_judul(this.value);">
                                               		<option value="#">Pilih judul</option>
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
                                                                    <form name="tjudul" method="post">
                                                                       <table class="table">
                                                                                <tr>
                                                                                    <td>
                                                                                    <div class="form-group">
                                                                            		<input class="form-control" type="text" name="tjudul" placeholder="Judul"/>
                                                                                    </div>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>
                                                                                        <div class="form-group">
                                                                                        <input class="form-control" type="text" name="no_kontrak" placeholder="No kontrak">
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>
                                                                                        <div class="form-group">
                                                                                        <input class="form-control" type="date" name="tgl">
                                                                                        </div>
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
                                        	<td><label>sub judul</label></td>
                                            <td>
                                            	<div class="form-group input-group">
                                                <select class="form-control" name="subjudul" id="sub_judul">
                                               		<option value="#">Pilih sub judul</option>
                                                </select>
                                                <span class="input-group-btn">
                                                   <a class="btn btn-warning" data-toggle="modal" data-target="#myModal7" data-placement="top" title="Tambah satuan">
                             <i class="fa fa-plus"></i>
                                                    </a>
                                                    <!-- Modal -->
                                                    <div class="modal fade" id="myModal7" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                                    <h4 class="modal-title" id="myModalLabel">Tambah sub judul</h4>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form name="tsubjudul" method="post">
                                                                        <table class="table">
                                                                                <tr>
                                                                                	<td>
                                                                                    	 <select class="form-control" name="tjudul">
																							<?php pilih_judul();?>
                                                                                        </select>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                     <td>
                                                                            		<input class="form-control" type="text" name="tsubjudul" />
                                                                                    </td>
                                                                                </tr>
                                                                            </table>
                                                                </div>
                                                                <div class="modal-footer">
                                                                     <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                                                                    <button type="submit" class="btn btn-primary" name="tambahsubjud">Tambah</button>
                                                                    <?php tambah_subjudul();?>
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
                                        </table>
                                        </div>
                                        <div class="well">
                                        <table>
                                        <tr>
                                    		<td><label>Nama barang </label></td>
                                    		<td>
                                            	<div class="form-group">
                                                <input class="form-control" type="text" name="namabrg">
                                                <div class="form-group input-group">
                                            </td>
                                        </tr>
                                        <tr>
                                    		<td><label>Merk </label></td>
                                    		<td>
                                                <div class="form-group">
                                                <input class="form-control" type="text" name="merk">
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                    		<td><label>Spesifikasi teknik/Katalog </label></td>
                                    		<td>
                                                <div class="form-group ">
                                                <textarea class="form-control"  name="spesifikasi"></textarea>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                    		<td><label>Satuan</label></td>
                                    		<td>
                                            	<div class="form-group input-group">
                                               <select class="form-control" name="satuan">
                                               		<?php pilih_satuan();?>
                                                </select>
                                                <span class="input-group-btn">
                                                   <a class="btn btn-warning" data-toggle="modal" data-target="#myModal3" data-placement="top" title="Tambah satuan">
                             <i class="fa fa-plus"></i>
                                                    </a>
                                                    <!-- Modal -->
                                                    <div class="modal fade" id="myModal3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                                    <h4 class="modal-title" id="myModalLabel">Tambah satuan</h4>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form name="tsatuan" method="post">
                                                                        <table class="table">
                                                                                <tr>
                                                                                     <td>
                                                                            		<input class="form-control" type="text" name="tsatuan" />
                                                                                    </td>
                                                                                </tr>
                                                                            </table>
                                                                </div>
                                                                <div class="modal-footer">
                                                                     <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                                                                    <button type="submit" class="btn btn-primary" name="tambahsat">Tambah</button>
                                                                    <?php tambah_satuan();?>
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
                                    		<td><label>Mata uang</label></td>
                                    		<td>
                                            	<div class="form-group input-group">
                                               <select class="form-control" name="matauang">
                                               		<?php pilih_matauang(); ?>
                                                </select>
                                                <span class="input-group-btn">
                                                   <a class="btn btn-warning" data-toggle="modal" data-target="#myModal4a" data-placement="top" title="Tambah satuan">
                             <i class="fa fa-plus"></i>
                                                    </a>
                                                    <!-- Modal -->
                                                    <div class="modal fade" id="myModal4a" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                                    <h4 class="modal-title" id="myModalLabel">Tambah mata uang</h4>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form name="tmatauang" method="post">
                                                                        <table class="table">
                                                                                <tr>
                                                                                     <td>
                                                                            		<input class="form-control" type="text" name="tmatauang" />
                                                                                    </td>
                                                                                </tr>
                                                                            </table>
                                                                </div>
                                                                <div class="modal-footer">
                                                                     <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                                                                    <button type="submit" class="btn btn-primary" name="tambahmatu">Tambah</button>
                                                                    <?php tambah_matauang();?>
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
                                    		<td><label>Harga satuan</label></td>
                                    		<td>
                                            	<div class="form-group">
                                            	<input class="form-control" type="text" name="hargasatuan">
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                    		<td><label>Keterangan</label></td>
                                    		<td>
                                            	<div class="form-group">
                                            	<input class="form-control" type="text" name="keterangan">
                                                </div>
                                            </td>
                                        </tr>
                                           
                                     </table>
                                     </div>
                               </div>
                            </div>
                            <div class="panel-footer">
                                <button type="submit" class="btn btn-primary" name="simpan">Simpan</button>
                                <button type="reset" class="btn btn-danger">Reset</button>
                            </div>
                            <?php tambah_umum();?>
                            </form><!-- tambah sarfas -->
                            
                                    </p>
                                </div>
                                <div class="tab-pane fade" id="import">
                                   
                                    <p>
                                     <div class="alert alert-info">
                                		Jika anda ingin meng-import data dari excel, download dulu template yg sudah disediakan <a href="template.xls" class="alert-link">Disini</a>.
                           			 </div>
                                    	<form name="myForm" id="myForm" onSubmit="return validateForm()" action="" method="post" enctype="multipart/form-data">
                                        <div class="table-responsive">
                                            <table class="table table-hover">
                                               <tbody>
                                                    
                                                    <tr>
                                                     <td>judul</td>
                                                        <td>
                                                        	<select class="form-control" name="judul" onchange="pilih_judul_excel(this.value);">
                                                            	<option value="#">Pilih judul</option>
                                                            	<?php pilih_judul(); ?>
                                                            </select>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>sub judul</td>
                                                        <td>
                                                        	<select class="form-control" name="subjudul" id="excel">
                                                            	<option value="#">Pilih sub judul</option>
                                                            </select>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                    	<td>pilih file</td>
                                                        <td><input type="file" id="filepegawaiall" name="filepegawaiall" /></td>
                                                    </tr>
                                                    <tr>
                                                    	<td></td>
                                                        <td><input class="btn btn-primary" type="submit" name="submit" value="Import" /><br/></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </form>
									<?php 
										progres_bar();
										proses_import();
									 ?>
                                </div>
                                <div class="tab-pane fade" id="cetak">
                                    <h4>Cetak per-sub judul</h4>
                                    <p>
                                    <form name="cetak" method="post" action="report_data.php">
                                    <div class="col-lg-6">
                                         <div class="panel panel-yellow">
                                            <div class="panel-heading">
                                                Cetak Sub judul
                                            </div>
                                            <div class="panel-body">
                                                <div class="table-responsive">
                                                    <table class="table table-hover">
                                                       <tbody>
                                                            <tr>
                                                                <td>judul</td>
                                                                <td>
                                                                    <select class="form-control" name="judul" onchange="pilih_judul_cetak(this.value);">
                                                                        <option value="#">Pilih judul</option>
                                                                        <?php pilih_judul(); ?>
                                                                    </select>
                                                                </td>
                                                            </tr>
                                                            <tr> 
                                                            	<td>Sub judul</td>   
                                                                <td>    
                                                                    <select class="form-control" name="subjudul" id="sub_judul_cetak">
                                                                        <option value="#">Pilih sub judul</option>
                                                                    </select>
                                                                </td>
                                                            </tr>
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
                                    </p>
                                    <form name="cetak" method="post" action="detail_cetak.php">
                                    <div class="col-lg-6">
                                         <div class="panel panel-primary">
                                            <div class="panel-heading">
                                                Cetak beberapa judul
                                            </div>
                                            <div class="panel-body">
                                                <div class="table-responsive">
                                                     <table class="table table-bordered table-hover table-striped" id="cetak_kuy">
                                                       <thead>
                                                       		<tr>
                                                            	<td>NO </td>
                                                                <td>JUDUL</td>
                                                            </tr>
                                                       </thead>
                                                       <tbody>
                                                                <?php umum_cetak();?>
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
                                                	<?php data_sub_judul();?>
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
                
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                         <i class="fa-list-alt fa"> Pengolahaan list</i>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs">
                               <li><a href="#satuan" data-toggle="tab">Data<br>
satuan</a>
                                </li>
                                <li><a href="#matauang" data-toggle="tab">Data<br>
mata uang</a>
                                </li>
                                
                                
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content">
                            	
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
                                                	<?php data_satuan(); ?>
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
                                                	<?php data_matauang();?>
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
        $('#dataTables-example-datasub').DataTable({
                responsive: true
        });
    });
	$(document).ready(function() {
        $('#dataTables-example-datajudul').DataTable({
                responsive: true
        });
    });
	$(document).ready(function() {
        $('#cetak_kuy').DataTable({
                responsive: true
        });
    });
    </script>

</body>

</html>

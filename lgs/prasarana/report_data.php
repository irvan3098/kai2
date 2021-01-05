<?php
session_start();
/**
 * PHPExcel
 *
 * Copyright (C) 2006 - 2012 PHPExcel
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA
 *
 * @category PHPExcel
 * @package PHPExcel
 * @copyright Copyright (c) 2006 - 2012 PHPExcel (http://www.codeplex.com/PHPExcel)
 * @license http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt LGPL
 * @version 1.7.7, 2012-05-19
 */
 
/** Error reporting */
error_reporting(E_ALL);
 
date_default_timezone_set('Europe/London');
 
/** Include PHPExcel */
require_once '../../phpexcel/PHPExcel.php';

//lampiran
include ("../../conn.php");
$link=koneksi();
$id_judul=$_POST['judul'];
$sql=mysqli_query($link,"select judul,no_kontrak,tanggal from judul where id_judul ='$id_judul'");
while($data = mysqli_fetch_array($sql, MYSQL_ASSOC))
{
	$judul = $data["judul"];
	$no_kontrak= $data["no_kontrak"];
	$tgl= $data["tanggal"];
}
$nama=$_SESSION['namauser'];
$aktivitas="cetak data $judul";
$level=$_SESSION['level'];
$sqlhis="insert into history_pengguna (id_history,level,nama,aktivitas,waktu)values(NULL,'$level','$nama','$aktivitas',now())";
$reshis=mysqli_query($link,$sqlhis);




// Create new PHPExcel object
$objPHPExcel = new PHPExcel();
  
// Create the worksheet
$objPHPExcel->setActiveSheetIndex(0);

// mulai judul kolom dengan row 12
$objPHPExcel->getActiveSheet()->setCellValue('A11', "NO")
							  ->setCellValue('B11', "KATEGORI")
							  ->setCellValue('C11', "NOMOR MATERIAL")
							  ->setCellValue('D11', "NAMA BARANG")
							  ->setCellValue('E11', "SPESIFIKASI TEKNIK/KATALOG")
							  ->setCellValue('F11', "SATUAN")
							  ->setCellValue('G11', "MATA UANG")
							  ->setCellValue('H11', "HARGA SATUAN")
							  ->setCellValue('I11', "VENDOR/SUPLIER");

// koneksi database
//include ("conn.php");
//include("../lib_func.php"); 
//$link=koneksi();

// query database
$SQL = mysqli_query($link,"SELECT no_sap,kategori, nama_brg,spesifikasi, satuan, mata_uang, harga_satuan, vendor from sarana_dan_fasilitas where id_judul='$id_judul'");

// jumlah data
$jumlah = mysqli_num_rows($SQL);
  
$dataArray= array();
$no=0;

// menampilkan data, susunan field sesuai dengan urutan judul kolom 
while($row = mysqli_fetch_array($SQL, MYSQL_ASSOC)){
	$no++;
	$row_array['no'] 		  = $no;
	$row_array['kategori']    	  = $row['kategori'];
	$row_array['nomor_sap'] 	  	  = $row['no_sap'];
	$row_array['nama_barang']    	  = $row['nama_brg'];
	$row_array['spesifikasi_teknik']    	  = $row['spesifikasi'];
	$row_array['nama_satuan']    	  = $row['satuan'];
	$row_array['nama_mataunag']    	  = $row['mata_uang'];
	$row_array['harga_satuan']    	  = $row['harga_satuan'];
	$row_array['nama_vendor']    	  = $row['vendor'];
	
	array_push($dataArray,$row_array);
}

// Mulai record dengan row 8
$nox=$no+11;
$objPHPExcel->getActiveSheet()->fromArray($dataArray, NULL, 'A12'); 

// Set page orientation and size
$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LEGAL);
$objPHPExcel->getActiveSheet()->getPageMargins()->setTop(0.75);
$objPHPExcel->getActiveSheet()->getPageMargins()->setRight(0.75);
$objPHPExcel->getActiveSheet()->getPageMargins()->setLeft(0.75);
$objPHPExcel->getActiveSheet()->getPageMargins()->setBottom(0.75);
$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&L&B' . $objPHPExcel->getProperties()->getTitle() . '&RPage &P of &N');
 
// Set title row bold;
$objPHPExcel->getActiveSheet()->getStyle('A11:H14')->getFont()->setBold(true);
// Set fills
$objPHPExcel->getActiveSheet()->getStyle('A11:H11')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$objPHPExcel->getActiveSheet()->getStyle('A11:H12')->getFill()->getStartColor()->setARGB('FF808080');

//untuk auto size colomn 
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(13);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(27);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(28);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(12);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(30);
 
// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);
 
$sharedStyle1 = new PHPExcel_Style();
$sharedStyle2 = new PHPExcel_Style();
 
$sharedStyle1->applyFromArray(
 array('borders' => array(
 'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
 'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
 'right' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM),
 'left' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM)
 ),
 ));
 
$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle1, "A11:I$nox");
 
// Set style for header row using alternative method
$objPHPExcel->getActiveSheet()->getStyle('A11:I11')->applyFromArray(
 array(
 'font' => array(
 'bold' => true
 ),
 'alignment' => array(
 'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
 ),
 'borders' => array(
 'top' => array(
 'style' => PHPExcel_Style_Border::BORDER_THIN
 )
 ),
 'fill' => array(
 'rotation' => 90,
 'startcolor' => array(
 'argb' => 'FFA0A0A0'
 ),
 'endcolor' => array(
 'argb' => 'FFFFFFFF'
 )
 )
 )
);
 
$objDrawing = new PHPExcel_Worksheet_Drawing();
$objDrawing->setName('Logo');
$objDrawing->setDescription('Logo');
$objDrawing->setPath('../../images/logo_kai.jpg');
$objDrawing->setCoordinates('A2');
$objDrawing->setHeight(100);
$objDrawing->setWidth(100);
$objDrawing->setWorksheet($objPHPExcel->getActiveSheet()->setCellValue('D1'));

//format align
$objPHPExcel->getActiveSheet()->getStyle("A1:A$nox")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle("B1:B$nox")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle("C1:C$nox")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle("D1:D$nox")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$objPHPExcel->getActiveSheet()->getStyle("E1:E$nox")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle("F1:F$nox")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle("G1:G$nox")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle("H1:H$nox")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
$objPHPExcel->getActiveSheet()->getStyle("I1:H$nox")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);


//HEADER
$objPHPExcel->getActiveSheet()->mergeCells('E2:F2');
$objPHPExcel->getActiveSheet()->setCellValue('E2',"PRASARANA");
$objPHPExcel->getActiveSheet()->getStyle('E2:F2')->getFont()->setSize(18);
$objPHPExcel->getActiveSheet()->getStyle('E2:F2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

$objPHPExcel->getActiveSheet()->mergeCells('E3:F3');
$objPHPExcel->getActiveSheet()->setCellValue('E3',"PT KERETA API INDONESIA (PERSERO)");
$objPHPExcel->getActiveSheet()->getStyle('E3:F3')->getFont()->setSize(12);
$objPHPExcel->getActiveSheet()->getStyle('E3:F3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


//judul
$objPHPExcel->getActiveSheet()->mergeCells('D10:f10');
$objPHPExcel->getActiveSheet()->setCellValue('D10',"$judul");
$objPHPExcel->getActiveSheet()->getStyle('D10:F10')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
  
//untuk font dan size data
$objPHPExcel->getActiveSheet()->getStyle('A10:I1000')->getFont()->setName('Arial');
$objPHPExcel->getActiveSheet()->getStyle('A10:I1000')->getFont()->setSize(9);
 
$objPHPExcel->getActiveSheet()->mergeCells('D10:f10');
//$objPHPExcel->getActiveSheet()->setCellValue('D7', "$judul");

$objPHPExcel->getActiveSheet()->getStyle('D10:F10')->getFont()->setName('Arial');
$objPHPExcel->getActiveSheet()->getStyle('D10:F10')->getFont()->setSize(16);
$objPHPExcel->getActiveSheet()->getStyle('D10:F10')->getFont()->setBold(true);
//$objPHPExcel->getActiveSheet()->getStyle('D3:I5')->getFont()->setSize(13);

// untuk sub judul

//$objPHPExcel->getActiveSheet()->setCellValue('H7', "Jumlah Data : ");
$BulanIndo = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
$tahun = substr($tgl, 0, 4);
$bulan = substr($tgl, 5, 2);
$tanggal   = substr($tgl, 8, 2);
$result = $tanggal . " " . $BulanIndo[(int)$bulan-1] . " ". $tahun;		

$objPHPExcel->getActiveSheet()->setCellValue('H6', "LAMPIRAN ");
$objPHPExcel->getActiveSheet()->setCellValue('H7', "KEPUTUSAN DIREKSI PT KERETA API(PERSERO)");
$objPHPExcel->getActiveSheet()->setCellValue('H8', "NOMOR : $no_kontrak");
$objPHPExcel->getActiveSheet()->setCellValue('H9', "TANGGAL : $result");

$objPHPExcel->getActiveSheet()->getStyle('A10:H10')->getFont()->setName('Arial');
$objPHPExcel->getActiveSheet()->getStyle('A10:H10')->getFont()->setSize(9);

// Judul Center
$objPHPExcel->getActiveSheet()->getStyle('A4:H9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
 

						 		


// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="'.$judul.date("d-F-Y").'".xlsx"');
header('Cache-Control: max-age=0');
 
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
 
// Save Excel 2007 file
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save(str_replace('.php', '.xlsx', __FILE__));


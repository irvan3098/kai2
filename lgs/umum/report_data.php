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
$id_j=$_POST['judul'];
$id_s=$_POST['subjudul'];
$sql=mysqli_query($link,"select judul,nama_sub,no_kontrak,tanggal from judul join sub_judul using(id_judul)
where id_sub ='$id_s'");
while($data = mysqli_fetch_array($sql, MYSQL_ASSOC))
{
	$judul = $data["judul"];
	$sub = $data["nama_sub"];
	$nokon=$data["no_kontrak"];
	$tgl=$data["tanggal"];
}
$nama=$_SESSION['namauser'];
$aktivitas="cetak data $sub > $judul";
$level=$_SESSION['level'];
$sqlhis="insert into history_pengguna (id_history,level,nama,aktivitas,waktu)values(NULL,'$level','$nama','$aktivitas',now())";
$reshis=mysqli_query($link,$sqlhis);

// Create new PHPExcel object
$objPHPExcel = new PHPExcel();
  
// Create the worksheet
$objPHPExcel->setActiveSheetIndex(0);

// mulai judul kolom dengan row 12
$objPHPExcel->getActiveSheet()->setCellValue('A11', "NO")
							  ->setCellValue('B11', "NAMA BARANG")
							  ->setCellValue('C11', "MERK")
							  ->setCellValue('D11', "SPESIFIKASI TEKNIK/KATALOG")
							  ->setCellValue('E11', "SATUAN")
							  ->setCellValue('F11', "MATA UANG")
							  ->setCellValue('G11', "HARGA SATUAN")
							  ->setCellValue('H11', "KETERANGAN");



// query database
$SQL = mysqli_query($link,"SELECT nama_brg,merk,spesifikasi, satuan, mata_uang, harga_satuan, keterangan from umum
where id_sub='$id_s'");

// jumlah data
$jumlah = mysqli_num_rows($SQL);
  
$dataArray= array();
$no=0;

// menampilkan data, susunan field sesuai dengan urutan judul kolom 
while($row = mysqli_fetch_array($SQL, MYSQL_ASSOC)){
	$no++;
	$row_array['no'] 		  = $no;
	$row_array['nama_brg'] 	  	  = $row['nama_brg'];
	$row_array['merk']    	  = $row['merk'];
	$row_array['spesifikasi_teknik']    	  = $row['spesifikasi'];
	$row_array['nama_satuan']    	  = $row['satuan'];
	$row_array['nama_mataunag']    	  = $row['mata_uang'];
	$row_array['harga_satuan']    	  = $row['harga_satuan'];
	$row_array['keterangan']    	  = $row['keterangan'];
	
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
$objPHPExcel->getActiveSheet()->getStyle('A11:H11')->getFont()->setBold(true);
// Set fills
$objPHPExcel->getActiveSheet()->getStyle('A11:H11')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$objPHPExcel->getActiveSheet()->getStyle('A11:H11')->getFill()->getStartColor()->setARGB('FF808080');

//untuk auto size colomn 
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(22);;
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(12);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(19);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(30);
 
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
 
$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle1, "A11:H$nox");
 
// Set style for header row using alternative method
$objPHPExcel->getActiveSheet()->getStyle('A11:H11')->applyFromArray(
 array(
 'font' => array(
 'bold' => true
 ),
 'alignment' => array(
 'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
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


//HEADER
$objPHPExcel->getActiveSheet()->mergeCells('D2:E2');
$objPHPExcel->getActiveSheet()->setCellValue('D2',"UMUM");
$objPHPExcel->getActiveSheet()->getStyle('D2:E2')->getFont()->setSize(18);
$objPHPExcel->getActiveSheet()->getStyle('D2:E2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

$objPHPExcel->getActiveSheet()->mergeCells('D3:E3');
$objPHPExcel->getActiveSheet()->setCellValue('D3',"PT KERETA API INDONESIA (PERSERO)");
$objPHPExcel->getActiveSheet()->getStyle('D3:D3')->getFont()->setSize(12);
$objPHPExcel->getActiveSheet()->getStyle('D3:D3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);



//format align
$objPHPExcel->getActiveSheet()->getStyle("A11:A$nox")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle("B11:B$nox")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$objPHPExcel->getActiveSheet()->getStyle("C11:C$nox")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle("D11:D$nox")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle("E11:E$nox")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle("F11:F$nox")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle("G11:G$nox")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
$objPHPExcel->getActiveSheet()->getStyle("H11:H$nox")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);



//judul
$objPHPExcel->getActiveSheet()->mergeCells('D10:f10');
$objPHPExcel->getActiveSheet()->setCellValue('D10',"$sub");
$objPHPExcel->getActiveSheet()->getStyle('D10:F10')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 


//untuk font dan size data
$objPHPExcel->getActiveSheet()->getStyle('A11:H1000')->getFont()->setName('Arial');
$objPHPExcel->getActiveSheet()->getStyle('A11:H1000')->getFont()->setSize(9);
 


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
$objPHPExcel->getActiveSheet()->setCellValue('G5', "LAMPIRAN ");
$objPHPExcel->getActiveSheet()->setCellValue('G6', "KEPUTUSAN DIREKSI PT KERETA API(PERSERO)");
$objPHPExcel->getActiveSheet()->setCellValue('G7', "NOMOR : $nokon");
$objPHPExcel->getActiveSheet()->setCellValue('G8', "TANGGAL : $result");

$objPHPExcel->getActiveSheet()->getStyle('A10:H12')->getFont()->setName('Arial');
$objPHPExcel->getActiveSheet()->getStyle('A10:H12')->getFont()->setSize(9);

 

// Redirect output to a client’s web browser (Excel2007)
$ip="dsdsds";
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="'.$judul.' > '.$sub.date("d-F-Y").'".xlsx"');
header('Cache-Control: max-age=0');
 
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
 
// Save Excel 2007 file
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save(str_replace('.php', '.xlsx', __FILE__));


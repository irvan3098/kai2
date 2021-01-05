<?php
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
$id_judul=18;

// Create new PHPExcel object
$objPHPExcel = new PHPExcel();
 
// Set document properties
$objPHPExcel->getProperties()->setCreator("Agus Sumarna")
							 ->setLastModifiedBy("Agus Sumarna")
							 ->setTitle("Data Guru RI32 Education")
							 ->setSubject("Data Guru RI32 Education")
							 ->setDescription("Menampilkan Data Guru RI32 Education dalam file excel")
							 ->setKeywords("Data Guru RI32 Education")
							 ->setCategory("Data Guru");
 
// Create the worksheet
$objPHPExcel->setActiveSheetIndex(0);

// mulai judul kolom dengan row 12
$objPHPExcel->getActiveSheet()->setCellValue('A8', "NO")
							  ->setCellValue('B8', "NOMOR MATERIAL SAP")
							  ->setCellValue('C8', "KATEGORI")
							  ->setCellValue('D8', "NAMA BARANG")
							  ->setCellValue('E8', "SPESIFIKASI TEKNIK/KATALOG")
							  ->setCellValue('F8', "SATUAN")
							  ->setCellValue('G8', "MATA UANG")
							  ->setCellValue('H8', "HARGA SATUAN")
							  ->setCellValue('I8', "VENDOR/SUPLIER");

// koneksi database

//include("../lib_func.php"); 
//$link=koneksi();

// query database


// jumlah data

  

$no=0;

// menampilkan data, susunan field sesuai dengan urutan judul kolom 


// Mulai record dengan row 8
$nox=$no+8;
//$objPHPExcel->getActiveSheet()->fromArray($dataArray, NULL, 'A9'); 

// Set page orientation and size
$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LEGAL);
$objPHPExcel->getActiveSheet()->getPageMargins()->setTop(0.75);
$objPHPExcel->getActiveSheet()->getPageMargins()->setRight(0.75);
$objPHPExcel->getActiveSheet()->getPageMargins()->setLeft(0.75);
$objPHPExcel->getActiveSheet()->getPageMargins()->setBottom(0.75);
$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&L&B' . $objPHPExcel->getProperties()->getTitle() . '&RPage &P of &N');
 
// Set title row bold;
$objPHPExcel->getActiveSheet()->getStyle('A8:H11')->getFont()->setBold(true);
// Set fills
$objPHPExcel->getActiveSheet()->getStyle('A8:H8')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$objPHPExcel->getActiveSheet()->getStyle('A8:H9')->getFill()->getStartColor()->setARGB('FF808080');

//untuk auto size colomn 
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(30);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(10);
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
 
$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle1, "A8:I$nox");
 
// Set style for header row using alternative method
$objPHPExcel->getActiveSheet()->getStyle('A8:H8')->applyFromArray(
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
 
// Add a drawing to the worksheet
$objDrawing = new PHPExcel_Worksheet_Drawing();
$objDrawing->setName('Logo');
$objDrawing->setDescription('Logo');
$objDrawing->setPath('../../images/logo_kai.jpg');
$objDrawing->setCoordinates('D2');
$objDrawing->setHeight(100);
$objDrawing->setWidth(100);
$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
 
//untuk font dan size data
$objPHPExcel->getActiveSheet()->getStyle('A8:H1000')->getFont()->setName('Arial');
$objPHPExcel->getActiveSheet()->getStyle('A8:H1000')->getFont()->setSize(9);
 
// Mulai Merge cells Judul
$objPHPExcel->getActiveSheet()->mergeCells('D2:I2');
$objPHPExcel->getActiveSheet()->setCellValue('D2', "DAFTAR DATA GURU RI32 COMMUNITY");

$objPHPExcel->getActiveSheet()->mergeCells('D3:I3');
$objPHPExcel->getActiveSheet()->setCellValue('D3', "Pemilihan Guru Teladan");

$objPHPExcel->getActiveSheet()->mergeCells('D4:I4');
$objPHPExcel->getActiveSheet()->setCellValue('D4', "Tingkat SD-SMP-SMA");

$objPHPExcel->getActiveSheet()->mergeCells('D5:I5');
$objPHPExcel->getActiveSheet()->setCellValue('D5', "Tahun 2013");

$objPHPExcel->getActiveSheet()->getStyle('D2:I5')->getFont()->setName('Arial');
$objPHPExcel->getActiveSheet()->getStyle('D2:I5')->getFont()->setSize(14);
$objPHPExcel->getActiveSheet()->getStyle('D2:I5')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('D3:I5')->getFont()->setSize(13);

// untuk sub judul

$objPHPExcel->getActiveSheet()->setCellValue('H7', "Jumlah Data : $jumlah");

$objPHPExcel->getActiveSheet()->setCellValue('A8', "Kota : Karawang");
$objPHPExcel->getActiveSheet()->setCellValue('A9', "Propinsi : Jawa Barat");

$objPHPExcel->getActiveSheet()->setCellValue('H2', "LAMPIRAN $id_lampiran");
$objPHPExcel->getActiveSheet()->setCellValue('H3', "KEPUTUSAN DIREKSI PT KERETA API(PERSERO)");
$objPHPExcel->getActiveSheet()->setCellValue('H4', "NOMOR :");
$objPHPExcel->getActiveSheet()->setCellValue('H5', "TANGGAL :");

$objPHPExcel->getActiveSheet()->getStyle('A7:H9')->getFont()->setName('Arial');
$objPHPExcel->getActiveSheet()->getStyle('A7:H9')->getFont()->setSize(9);

// Judul Center
$objPHPExcel->getActiveSheet()->getStyle('A1:H1000')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
 

// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="DATA_GURU"'.date("d-F-Y").'".xlsx"');
header('Cache-Control: max-age=0');
 
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
 
// Save Excel 2007 file
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save(str_replace('.php', '.xlsx', __FILE__));
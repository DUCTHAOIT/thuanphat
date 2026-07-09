<?php
	global $db,$lang,$lable;
	$sql="SELECT *, DATE_FORMAT(date_create, '".format_date()."') as date FROM user ORDER BY id DESC LIMIT 1,2";
	$rs=$db->Execute($sql);
	
	
	
	
	

/**
 * PHPExcel
 *
 * Copyright (c) 2006 - 2015 PHPExcel
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @category   PHPExcel
 * @package    PHPExcel
 * @copyright  Copyright (c) 2006 - 2015 PHPExcel (http://www.codeplex.com/PHPExcel)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt	LGPL
 * @version    ##VERSION##, ##DATE##
 */

/** Error reporting */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Europe/London');

if (PHP_SAPI == 'cli')
	die('This example should only be run from a Web Browser');

/** Include PHPExcel */
require_once dirname(__FILE__) . '/../../phpexcel/Classes/PHPExcel.php';


// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

// Set document properties
$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
							 ->setLastModifiedBy("Maarten Balliauw")
							 ->setTitle("Office 2007 XLSX Test Document")
							 ->setSubject("Office 2007 XLSX Test Document")
							 ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
							 ->setKeywords("office 2007 openxml php")
							 ->setCategory("Test result file");


// Add some data
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Ngày đăng ký')
            ->setCellValue('B1', 'Họ và tên')
            ->setCellValue('C1', 'Số CMND')
            ->setCellValue('D1', 'Email')
			->setCellValue('E1', 'Điện thoại')
            ->setCellValue('F1', 'Địa chỉ')
            ->setCellValue('G1', 'TK Ngân Hàng')
            ->setCellValue('H1', 'Ngân hàng')
			->setCellValue('I1', 'Loại thành viên')
            ->setCellValue('J1', 'Người giới thiệu');

// Miscellaneous glyphs, UTF-8



			$j=2;
			while(!$rs->EOF){
			$sql="SELECT *, DATE_FORMAT(date_create, '".format_date()."') as date FROM user ORDER BY id DESC";
			$rs=$db->Execute($sql);
			
			if($rs->fields("loai")==0){
				$loai='Thành viên Vip1';
			}
			
			if($rs->fields("loai")==2){
				$loai='Thành viên Vip2';
			}
			
			if($rs->fields("loai")==1){
				$loai='Thành viên thường';
			}
    
		
			///////
$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('A'.$j.'', ''.$rs->fields("date").'')
            ->setCellValue('B'.$j.'', ''.$rs->fields("name").'')
            ->setCellValue('C'.$j.'', ''.$rs->fields("cmt").'')
            ->setCellValue('D'.$j.'', ''.$rs->fields("email").'')
			->setCellValue('E'.$j.'', ''.$rs->fields("mobile").'')
            ->setCellValue('F'.$j.'', ''.$rs->fields("address").'')
			->setCellValue('G'.$j.'', ''.$rs->fields("tknh").'')
            ->setCellValue('H'.$j.'', ''.$rs->fields("nganhangtknh").' - '.$rs->fields("chinhanhtknh").'')
			->setCellValue('I'.$j.'', ''.$loai.'')
            ->setCellValue('J'.$j.'', ''.$rs->fields("gioithieu").'');
			///////

			$j++;
			$rs->MoveNext();
		 }


// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('Danh sách khách hàng');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="user-list'.gmdate('d M Y').'.xlsx"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;

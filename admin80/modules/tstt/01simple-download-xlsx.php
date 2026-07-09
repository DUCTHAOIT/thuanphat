<?php
	global $db,$lang,$lable;	
	
	
	$sql="SELECT sys_userorder.*, DATE_FORMAT(sys_userorder.date_create, '".format_date()."') as date_create, TO_DAYS(sys_userorder.date_create) as today, user.name as tenkh, user.gioithieu";
	$sql.=" FROM user, sys_userorder";
	$sql.=" WHERE (user.id = sys_userorder.userid) AND (sys_userorder.ctrl=0) AND (sys_userorder.tinh_trang=1) AND (sys_userorder.loai=1)";
	$sql.=" ORDER BY sys_userorder.id DESC";
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
            ->setCellValue('A1', 'Hợp đồng muốn rút vốn')
            ->setCellValue('B1', 'Tên KH')
            ->setCellValue('C1', 'Ngày mua trong HĐ')
            ->setCellValue('D1', 'Ngày đặt lệnh')
			->setCellValue('E1', 'Số lượng ĐVĐT')
            ->setCellValue('F1', 'Giá mua 1 ĐVĐT bình quân')
            ->setCellValue('H1', 'Tổng giá trị')
            ->setCellValue('I1', 'Số lượng ĐVĐT bán')
			->setCellValue('J1', 'Giá bán 1 ĐVĐT')
            ->setCellValue('K1', 'Tổng giá trị bán') 
		 	->setCellValue('L1', 'Phí ứng trước tiền bán') 
		  	->setCellValue('M1', 'Tổng giá trị bán thực tế')            
            ->setCellValue('N1', 'Lãi/Lỗ')
			->setCellValue('O1', 'Phí hợp tác đầu tư')
			->setCellValue('P1', 'Chi phí rút trước hạn')
			->setCellValue('Q1', 'Hoa hồng CK')
			->setCellValue('R1', 'Thuế thu nhập cá nhân')
			->setCellValue('S1', 'Thực nhận')
			->setCellValue('T1', 'Người giới thiệu')
			->setCellValue('U1', 'Hoa hồng giới thiệu')
			->setCellValue('V1', 'Thuế hoa hồng giới thiệu')
			->setCellValue('W1', 'Người GT Thực nhận')
			->setCellValue('X1', 'Trạng thái');

// Miscellaneous glyphs, UTF-8



			$j=2;
			while(!$rs->EOF){
			
			$sql="SELECT sys_userorder.*, sys_userorder.id as mahd, DATE_FORMAT(sys_userorder.date_create, '".format_date()."') as date_create, TO_DAYS(sys_userorder.date_create) as today";
			$sql.=" FROM user, sys_userorder";
			$sql.=" WHERE (user.id = sys_userorder.userid) AND (sys_userorder.ctrl&1=1) AND (sys_userorder.id=".$rs->fields("hdban").")";
			$rshdban=$db->Execute($sql);
			
			if($rs->fields("price")){$giadvdtchot=$rs->fields("price");}else{$giadvdtchot=0;};
			//echo $rshdban->fields("price")."<br>";
			$tongbanhopdong=$giadvdtchot*$rs->fields("model");
			$phirut=$tongbanhopdong*0.003;
			
			$tongban=$tongbanhopdong*0.997;
			
			//$tongban=$giadvdtchot*$rs->fields("model");
			//$lailo=($giadvdtchot-$rshdban->fields("price"))*$rs->fields("model");
			//$lailo=$tongban-$rshdban->fields("price_old");
			
			$lailo=$tongban-($rs->fields("model")*$rshdban->fields("price"));
			
			//$phamtram=($lailo/$tongban)*100;
			
			$phamtramlailo=($giadvdtchot-$rshdban->fields("price"))/$rshdban->fields("price");
			
			$songay=$rs->fields("today")-$rshdban->fields("today");
			
			if($songay<90){$phiruttruochan=$tongban*0.01;}
			if(90<=$songay && $songay<180){$phiruttruochan=$tongban*0.005;}
			if($songay>=180){$phiruttruochan=$tongban*0;}
			if($tongban>1000000000&&738489<$rs->fields("today")){$phiruttruochan=$phiruttruochan*0.5;}
			
			if($phamtramlailo<0.1){
				$hoahongck=0;
			}
			if(0.1<= $phamtramlailo && $phamtramlailo <0.5){
				$hoahongck=$lailo*0.025;
				
			}
			if(0.5<=$phamtramlailo && $phamtramlailo<1){
				$hoahongck=$lailo*0.03;
			}
			if(1<=$phamtramlailo){
				$hoahongck=$lailo*0.04;
			}
			//
			//
			if(!$rs->fields("gioithieu")){
				$hoahongck=0;
			}
			//
			
			$tysuatloinhuan=$giadvdtchot/$rshdban->fields("price");
			if($tysuatloinhuan<1.1){$phihoptac=0;}
			if(1.1<=$tysuatloinhuan && $tysuatloinhuan<1.5){$phihoptac=$lailo*0.15;}
			if(1.5<=$tysuatloinhuan && $tysuatloinhuan<2){$phihoptac=$lailo*0.2;}
			if(2<$tysuatloinhuan){$phihoptac=$lailo*0.25;}
			//
			if(($lailo-$phihoptac-$phiruttruochan+$hoahongck)>0){
				//$phihoptac=$lailo*0.15;	
				$tncn=($lailo-$phihoptac-$phiruttruochan+$hoahongck)*0.05;
			}else{
				//$phihoptac=0;
				$tncn=0;
			}
			
			
			
			$thucnhan=$tongban-$phihoptac-$phiruttruochan-$tncn+$hoahongck;
			
			if($giadvdtchot>0){
				
			}else{
				$tongban=0;
				$lailo=0;
			}
			
			if($rs->fields("price")){
				$trangthai='Đã xác thực';
				if($rs->fields("trangthai")==1){$trangthai='Đã xác thực (Đã chuyển khoản)';}else{$trangthai='Đã xác thực (Chưa chuyển khoản)';}
			}else{
				$trangthai='Chờ người dùng xác thực';
			}	
    		
			//$tenkh='<strong style="text-transform:uppercase"'.$rs->fields("tenkh").'<strong>';
		
			///////
$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('A'.$j.'', ''.$rshdban->fields("name").'')
            ->setCellValue('B'.$j.'', ''.$rs->fields("tenkh").'')
            ->setCellValue('C'.$j.'', ''.$rshdban->fields("date_create").'')
            ->setCellValue('D'.$j.'', ''.$rs->fields("date_create").'')
			->setCellValue('E'.$j.'', ''.number_format($rshdban->fields("delivery"), 0, '.', ',').'')
            ->setCellValue('F'.$j.'', ''.number_format($rshdban->fields("price"), 0, '.', ',').'')
            ->setCellValue('H'.$j.'', ''.number_format($rshdban->fields("price_old"), 0, '.', ',').'')
            ->setCellValue('I'.$j.'', ''.number_format($rs->fields("model"), 0, '.', ',').'')
			->setCellValue('J'.$j.'', ''.number_format($giadvdtchot, 0, '.', ',').'')
            ->setCellValue('K'.$j.'', ''.number_format($tongbanhopdong, 0, '.', ',').'')   
			->setCellValue('L'.$j.'', ''.number_format($phirut, 0, '.', ',').'')  
			->setCellValue('M'.$j.'', ''.number_format($tongban, 0, '.', ',').'')           
            ->setCellValue('N'.$j.'', ''.number_format($lailo, 0, '.', ',').'')
			->setCellValue('O'.$j.'', ''.number_format($phihoptac, 0, '.', ',').'')
			->setCellValue('P'.$j.'', ''.number_format($phiruttruochan, 0, '.', ',').'')
			->setCellValue('Q'.$j.'', ''.number_format($hoahongck, 0, '.', ',').'')
			->setCellValue('R'.$j.'', ''.number_format($tncn, 0, '.', ',').'')
			->setCellValue('S'.$j.'', ''.number_format($thucnhan, 0, '.', ',').'')
			->setCellValue('T'.$j.'', ''.$rs->fields("gioithieu").'')
			->setCellValue('U'.$j.'', ''.number_format($hoahongck, 0, '.', ',').'')
			->setCellValue('V'.$j.'', ''.number_format($hoahongck*0.1, 0, '.', ',').'')
			->setCellValue('W'.$j.'', ''.number_format($hoahongck*0.9, 0, '.', ',').'')
			->setCellValue('X'.$j.'', ''.$trangthai.'');
			///////

			$j++;
			$rs->MoveNext();
		 }


// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('Hợp đồng bán TSBV');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="01simple.xlsx"');
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

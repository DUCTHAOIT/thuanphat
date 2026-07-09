<?php
function hdbannhanvien(){
	global $db,$lang,$lable;	
	$username=getParam("id");		
	
	
	$sql="SELECT sys_userorder.*, DATE_FORMAT(sys_userorder.date_create, '".format_date()."') as date_create, TO_DAYS(sys_userorder.date_create) as today, user.gioithieu";
	$sql.=" FROM user, sys_userorder";
	$sql.=" WHERE (user.gioithieu = '$username') AND (user.id = sys_userorder.userid) AND (sys_userorder.ctrl=1)";
	$sql.=" ORDER BY sys_userorder.id DESC";
	$rs=$db->Execute($sql);	
	
	if($rs->RecordCount()){	?>	
 <div class="topic">Các hợp đồng đã tất toán</div> 
<div class="col-xs-12 col-sm-12 col-md-12">
<table width="100%" border="1" cellspacing="0" cellpadding="0" class="table">
  <tr class="tr" style="background-color:#CCCCCC">
    <td class="td">Hợp đồng muốn rút vốn</td>
    <td class="td">Ngày mua trong HĐ/<br /> Ngày đặt lệnh</td>
    <td class="td">Số lượng ĐVĐT</td>
    <td class="td">Giá mua 1 ĐVĐT bình quân</td>
    <td class="td">Tổng giá trị</td>
    <td class="td">Số lượng ĐVĐT bán</td>
    <td class="td">Giá bán 1 ĐVĐT</td>
    <td class="td">Tổng giá trị bán</td>
    <td class="td">Lãi/Lỗ</td>
    <td class="td">Phí hợp tác đầu tư</td>
    <td class="td">Chi phí rút trước hạn</td>
    <td class="td">Hoa hồng CK</td>
    <td class="td">Thuế thu nhập cá nhân</td>
    <td class="td">Thực nhận</td>
   
    <td class="td" align="center">Trạng thái</td>
    <td></td>
  </tr>  
<?php
	$j=0;
	while(!$rs->EOF){
	
	$sql="SELECT sys_userorder.*, sys_userorder.id as mahd, DATE_FORMAT(sys_userorder.date_create, '".format_date()."') as date_create, TO_DAYS(sys_userorder.date_create) as today";
	$sql.=" FROM user, sys_userorder";
	$sql.=" WHERE (user.id = sys_userorder.userid) AND (sys_userorder.ctrl&1=1) AND (sys_userorder.id=".$rs->fields("hdban").")";
	$rshdban=$db->Execute($sql);
	
	if($rs->fields("price")){$giadvdtchot=$rs->fields("price");}else{$giadvdtchot=0;};
	//echo $rshdban->fields("price")."<br>";
	
	$tongban=$giadvdtchot*$rs->fields("model");
	//$lailo=($giadvdtchot-$rshdban->fields("price"))*$rs->fields("model");
	//$lailo=$tongban-$rshdban->fields("price_old");
	
	$lailo=$tongban-($rs->fields("model")*$rshdban->fields("price"));
	
	//$phamtram=($lailo/$tongban)*100;
	
	$phamtramlailo=($giadvdtchot-$rshdban->fields("price"))/$rshdban->fields("price");
	
	$songay=$rs->fields("today")-$rshdban->fields("today");
	
	if($songay<90){$phiruttruochan=$tongban*0.02;}
	if(90<=$songay && $songay<180){$phiruttruochan=$tongban*0.01;}
	if($songay>=180){$phiruttruochan=$tongban*0;}
	
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
	
if($rs->fields("trangthai")<>2){
?>


  <tr <?php if($j%2){?> bgcolor="#F4F4F4"<?php }?>>
    <td class="td"><?php echo $rshdban->fields("name") ?></td>
    <td class="td"><?php echo $rshdban->fields("date_create") ?><br /><?php echo $rs->fields("date_create") ?></td>
    <td  class="td" align="right"><?php echo number_format($rshdban->fields("delivery"), 0, '.', ',') ?></td>
    <td class="td" align="right"><?php echo number_format($rshdban->fields("price"), 0, '.', ',') ?></td>
    <td class="td" align="right"><?php echo number_format($rshdban->fields("price_old"), 0, '.', ',') ?></td>
   
    <td class="td" align="right"><?php echo number_format($rs->fields("model"), 0, '.', ',') ?></td>
    <td class="td" align="right"><?php if($giadvdtchot){ echo number_format($giadvdtchot, 0, '.', ',')."";}else{?> <font color="#FF0000" style="font-size:16px">*</font><?php }?></td>
    <td class="td" align="right"><?php if($giadvdtchot>0){ echo number_format($tongban, 0, '.', ',')."";}else{ echo "#";} ?></td>
    <td class="td" align="right"><?php if($giadvdtchot>0){ echo number_format($lailo, 0, '.', ',')."";}else{ echo "#";} ?></td>
    <td class="td" align="right"><?php if($giadvdtchot>0){ echo number_format($phihoptac, 0, '.', ',')."";}else{ echo "#";} ?></td>
   
    <td class="td" align="right"><?php if($giadvdtchot>0){ echo number_format($phiruttruochan, 0, '.', ',')."";}else{ echo "#";}?></td>
    <td class="td" align="right"><?php if($giadvdtchot>0){ echo number_format($hoahongck, 0, '.', ',')."";}else{ echo "#";} ?></td>
    <td class="td" align="right"><?php if($giadvdtchot>0){ echo number_format($tncn, 0, '.', ',')."";}else{ echo "#";} ?></td>
     <td class="td" align="right"><?php if($giadvdtchot>0){ echo number_format($thucnhan, 0, '.', ',')."";}else{ echo "#";} ?></td>
  	<?php if($rs->fields("price")){?>
    
		
        <td align="center" class="td"><?php if($rs->fields("trangthai")==1){?><img src="images/daban<?php echo $rs->fields("trangthai");?>.gif" style="cursor:pointer" alt="Đã chuyển khoản" /><?php }else{?><img src="images/daban<?php echo $rs->fields("trangthai");?>.gif" style="cursor:pointer" alt="click để xác nhận chuyển khoản" /><?php }?></td>
	<?php }else{?>
    
     <td align="center" class="td"><?php if($rs->fields("trangthai")==2){?><img src="images/huy<?php echo $rs->fields("trangthai");?>.gif" style="cursor:pointer" alt="click để hủy giao dịch" /><?php }else{?>Đang đặt bán<?php }?></td>
    <?php }?>
  
  </tr>	



<?php 
	}
	$j++;
	$rs->MoveNext();
 }
 
?>

</table>
</div>
<?php 
	}
}	
?>
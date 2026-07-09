<?php
include_once("header.php");
	global $db,$lang,$lable;	
	$sql="SELECT *, DATE_FORMAT(date_create, '".format_date()."') as date_creategiadvdtchot,TO_DAYS(xuat_su.date_create) as today, TO_DAYS(CURDATE()) as homnay FROM xuat_su WHERE type=1 ORDER BY id DESC LIMIT 0,1";
	$rsgiadvdt=$db->Execute($sql);	
	$giadvdtchot=$rsgiadvdt->fields("giadvdt");
	
	
	$sql="SELECT sys_userorder.*, DATE_FORMAT(sys_userorder.date_create, '".format_date()."') as date_create, TO_DAYS(sys_userorder.date_create) as today, user.name as tenkh, user.gioithieu";
	$sql.=" FROM user, sys_userorder";
	$sql.=" WHERE (user.id = sys_userorder.userid) AND (sys_userorder.ctrl=0) AND (sys_userorder.tinh_trang=1) AND (sys_userorder.loai=1)";
	$sql.=" ORDER BY sys_userorder.id DESC";
	$rs=$db->Execute($sql);	
	if($rs->RecordCount()){	?>	
 <div class="topic">Quản lý hợp đồng bán TSTT <button><a href="http://thachsanhinvestment.com.vn/admin80/?m=tstt&f=01simple-download-xlsx" target="_blank">Download dữ liệu</a></button></div> 
<div class="col-xs-12 col-sm-12 col-md-12">
<table width="100%" border="1" cellspacing="0" cellpadding="0" class="table">
  <tr class="tr" style="background-color:#CCCCCC">
    <td class="td">ID</td>
    <td class="td">Hợp đồng muốn rút vốn</td>
    <td class="td">Tên KH</td>
    <td class="td">Ngày mua trong HĐ/<br /> Ngày đặt lệnh</td>
    
    <td class="td">Số lượng ĐVĐT</td>
    <td class="td">Giá mua 1 ĐVĐT bình quân</td>
    <td class="td">Tổng giá trị</td>
    <td class="td">Số lượng ĐVĐT bán</td>
    <td class="td">Giá bán 1 ĐVĐT</td>
    <td class="td">Tổng giá trị bán</td>
    
    <td class="td">Phí ứng trước tiền bán</td>
    <td class="td">Tổng giá trị bán thực tế</td>
    
    <td class="td">Lãi/Lỗ</td>
    <td class="td">Phí hợp tác đầu tư</td>
    <td class="td">Chi phí rút trước hạn</td>
    <td class="td">Hoa hồng CK</td>
    <td class="td">Thuế thu nhập cá nhân</td>
    <td class="td">Thực nhận</td>
    
    <td class="td">Người giới thiệu</td>
  	<td class="td">Hoa hồng giới thiệu</td>
    <td class="td">Thuế hoa hồng giới thiệu</td>
    <td class="td">Người GT Thực nhận</td>
    
    <td class="td" align="center">Người dùng</td>
    <td class="td" align="center">TSI</td>
  </tr>  
<?php
	$j=0;
	while(!$rs->EOF){
	
	$sql="SELECT sys_userorder.*, sys_userorder.id as mahd, DATE_FORMAT(sys_userorder.date_create, '".format_date()."') as date_create, TO_DAYS(sys_userorder.date_create) as today";
	$sql.=" FROM user, sys_userorder";
	$sql.=" WHERE (user.id = sys_userorder.userid) AND (sys_userorder.ctrl&1=1) AND (sys_userorder.id=".$rs->fields("hdban").")";
	$rshdban=$db->Execute($sql);
	
	if($rs->fields("price")){$giadvdtchot=$rs->fields("price");};
	//echo $rshdban->fields("price")."<br>";
	
	//$tongban=$giadvdtchot*$rs->fields("model");
	//$lailo=($giadvdtchot-$rshdban->fields("price"))*$rs->fields("model");
	//$lailo=$tongban-$rshdban->fields("price_old");
	$tongbanhopdong=$giadvdtchot*$rs->fields("model");
	$phirut=$tongbanhopdong*0.003;
	
	$tongban=$tongbanhopdong*0.997;
	
	
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
	
	
?>


  <tr <?php if($j%2){?> bgcolor="#F4F4F4"<?php }?>>
  	<td class="td"><?php echo $rs->fields("id") ?></td>
    <td class="td"><?php echo $rshdban->fields("name") ?></td>
     <td   nowrap="nowrap" style="text-transform:uppercase"><strong><?php echo $rs->fields("tenkh"); ?></strong></td>
    <td class="td"><?php echo $rshdban->fields("date_create") ?><br /><?php echo $rs->fields("date_create") ?></td>
   
    <td  class="td" align="right"><?php echo number_format($rshdban->fields("delivery"), 0, '.', ',') ?></td>
    <td class="td" align="right"><?php echo number_format($rshdban->fields("price"), 0, '.', ',') ?></td>
    <td class="td" align="right"><?php echo number_format($rshdban->fields("price_old"), 0, '.', ',') ?></td>
   
    <td class="td" align="right"><?php echo number_format($rs->fields("model"), 0, '.', ',') ?></td>
    <td class="td" align="right"><?php if($giadvdtchot){ echo number_format($giadvdtchot, 0, '.', ',')."";}else{?> <font color="#FF0000" style="font-size:16px">*</font><?php }?></td>
    <td class="td" align="right"><?php if($giadvdtchot>0){ echo number_format($tongbanhopdong, 0, '.', ',')."";}else{ echo "#";} ?></td>
    
     <td align="right" style="text-align: center; vertical-align: middle;"><?php if($giadvdtchot>0){ echo number_format($phirut, 0, '.', ',')."";}else{ echo "#";}?></td>
    <td align="right" style="text-align: center; vertical-align: middle;"><?php if($giadvdtchot>0){ echo number_format($tongban, 0, '.', ',')."";}else{ echo "#";} ?></td>
    
    
    <td class="td" align="right" <?php if($lailo<0){ echo "style=\"color:#FF0000\"";} ?> ><?php if($giadvdtchot>0){ echo number_format($lailo, 0, '.', ',')."";}else{ echo "#";} ?></td>
    <td class="td" align="right"><?php if($giadvdtchot>0){ echo number_format($phihoptac, 0, '.', ',')."";}else{ echo "#";} ?></td>
   
    <td class="td" align="right"><?php if($giadvdtchot>0){ echo number_format($phiruttruochan, 0, '.', ',')."";}else{ echo "#";}?></td>
    <td class="td" align="right"><?php if($giadvdtchot>0){ echo number_format($hoahongck, 0, '.', ',')."";}else{ echo "#";} ?></td>
    <td class="td" align="right"><?php if($giadvdtchot>0){ echo number_format($tncn, 0, '.', ',')."";}else{ echo "#";} ?></td>
     <td class="td" align="right"><?php if($giadvdtchot>0){ echo number_format($thucnhan, 0, '.', ',')."";}else{ echo "#";} ?></td>
     
     <td   nowrap="nowrap"><strong><?php echo $rs->fields("gioithieu"); ?></strong></td>
     <td class="td" align="right"><?php if($giadvdtchot>0){ echo number_format($hoahongck, 0, '.', ',')."";}else{ echo "#";} ?></td>
     <td class="td" align="right"><?php if($giadvdtchot>0){ echo number_format($hoahongck*0.1, 0, '.', ',')."";}else{ echo "#";} ?></td>
     <td class="td" align="right"><?php if($giadvdtchot>0){ echo number_format($hoahongck*0.9, 0, '.', ',')."";}else{ echo "#";} ?></td>
      
  	<?php if($rs->fields("price")){?>
    
		<td nowrap="nowrap" align="center" style="color:#0000FF">Đã xác thực</td>
        <td align="center" class="td"><?php if($rs->fields("trangthai")==1){?><img src="images/daban<?php echo $rs->fields("trangthai");?>.gif" style="cursor:pointer" alt="Đã chuyển khoản" /><?php }else{?><a href="<?php echo _DOMAIN_ROOT_URL;?>/admin80/?m=tstt&op=daban&id=<?php echo $rs->fields("id");?>&hdban=<?php echo $rs->fields("hdban");?>&soluongban=<?php echo $rs->fields("model");?>" onclick = "if (! confirm('Bạn muốn xác nhận giao dịch đã hoàn thành chuyển khoản cho NĐT?')) { return false; }" title="click để xác nhận chuyển khoản" class="title" style="font-size:12px; color:#FFFFFF"><img src="images/daban<?php echo $rs->fields("trangthai");?>.gif" style="cursor:pointer" alt="click để xác nhận chuyển khoản" /></a><?php }?></td>
	<?php }else{?>
    <td class="td"  align="center" >
        
        <div style="padding-top:10px; width:120px">
        <?php if($giadvdtchot){?>
         
         <?php }else{?> 
          Chờ người dùng xác thực
        <?php }?>
        </div> 
    </td>
     <td align="center" class="td"><?php if($rs->fields("trangthai")==2){?><img src="images/huy<?php echo $rs->fields("trangthai");?>.gif" style="cursor:pointer" alt="click để hủy giao dịch" /><?php }else{?><a href="<?php echo _DOMAIN_ROOT_URL;?>/admin80/?m=tstt&op=huy&id=<?php echo $rs->fields("id");?>&soluongban=<?php echo $rs->fields("model");?>" onclick = "if (! confirm('Bạn muốn hủy giao dịch?')) { return false; }" title="click để hủy giao dịch" class="title" style="font-size:12px; color:#FFFFFF"><img src="images/huy<?php echo $rs->fields("trangthai");?>.gif" style="cursor:pointer" alt="click để hủy giao dịch" /></a><?php }?></td>
    <?php }?>
    
    
   <!-- 
    <td align="center" class="td"><a href="<?php echo _DOMAIN_ROOT_URL;?>/admin80/?m=tstt&op=deleteban&id=<?php echo $rs->fields("id");?>" onclick = "if (! confirm('Bạn muốn hủy giao dịch?')) { return false; }" class="title" style="font-size:12px; color:#FFFFFF"><img src="images/delete.gif" style="cursor:pointer" /></a></td>
    -->
  </tr>	



<?php 
	$j++;
	$rs->MoveNext();
 }
 
?>

</table>
</div>
<?php 
	}
include_once("footer.php");
?>
<script language="Javascript1.2">
		 Calendar.setup(
			{
			  inputField  : "date",         // ID of the input field
			  ifFormat    : "%Y-%m-%d",    // the date format
			  button      : "btndate",       // ID of the button
			  showsTime	  :	true
			}			
		  );  		  
</script>
<script language="javascript" type="text/javascript">
function myFunction(f) {
		var obj;
			obj=document.frmbookingRoom;
			//alert(obj.soluong.value);
			
			url="../../?m=booking&f=tongtienvoucher&price="+ obj.price.value +"&soluong="+ obj.soluong.value +"/";
		
		AjaxRequest.get(
				{
				'url':url				
				,'onSuccess':function(req){document.getElementById('lblCheckMailvoucher').innerHTML=req.responseText;}
				,'onError':function(req){}
				}
			)
		return true;	
	
}
function goDelete(f) {
		var obj;
		obj=document.frmbookingRoom;
		if (confirm('Bạn muốn hủy giao dịch')!=0){
			obj.submit();					
	  	}
}

function checkSendMail(f){
	var obj;
	obj=document.frmbookingRoom;
	if(obj.name.value==""){
		alert("Bạn cần nhập Tên");
		obj.name.focus();
		return;
	}else if(!isValidEmail(obj.emailbook.value)){
		alert("Bạn cần nhập địa chỉ Email đúng quy các!");
		obj.emailbook.focus();
		return;	
	}else if(obj.phone.value==""){
		alert("Bạn cần nhập số phone");
		obj.phone.focus();
		return;	
	}else if(obj.soluong.value==""){
		alert("Bạn cần nhập số lượng");
		obj.soluong.focus();
		return;
	}else if(obj.amount.value==""){
		//alert("Chúng tôi đang thực hiện tính tổng tiền");
		obj.soluong.focus();
		return;		
		
	}else{	
		
		obj.submit();					
	  }
}
//
function isValidEmail(str) {
	if((str.indexOf(".") > 2) && (str.indexOf("@") > 0)){
		return true;
	}	
	else{
		return false;
	} 
}
</script>
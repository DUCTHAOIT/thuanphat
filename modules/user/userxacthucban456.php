<?php
function userxacthucban456(){
	global $db,$lang,$lable;	
	$username=getSession("username");
	if(!$username) return;
	
	$sql="SELECT *, DATE_FORMAT(date_create, '".format_date()."') as date_creategiadvdtchot,TO_DAYS(xuat_su.date_create) as today, TO_DAYS(CURDATE()) as homnay FROM xuat_su WHERE type=1 ORDER BY id DESC LIMIT 0,1";
	$rsgiadvdt=$db->Execute($sql);	
	$giadvdtchot=$rsgiadvdt->fields("giadvdt");
	$date_creategiadvdtchot=$rsgiadvdt->fields("date_creategiadvdtchot");
	$creategiadvdtchot=$rsgiadvdt->fields("date_create");
	
	$today=$rsgiadvdt->fields("today");
	$homnay=$rsgiadvdt->fields("homnay");
	//echo "ccccccccccc".$homnay;
	//if(($homnay-$today)>1){$giadvdtchot1=0;}else{$giadvdtchot1=$rsgiadvdt->fields("giadvdt");}
	$giadvdtchot1=$rsgiadvdt->fields("giadvdt");
	
	
	$sql="SELECT sys_userorder.*, DATE_FORMAT(sys_userorder.dategiadvdt, '".format_date()."') as date_creategiadvdtchot, DATE_FORMAT(sys_userorder.date_create, '".format_date()."') as date_create, TO_DAYS(sys_userorder.date_create) as today, user.gioithieu";
	$sql.=" FROM user, sys_userorder";
	$sql.=" WHERE (user.username = '$username') AND (user.id = sys_userorder.userid) AND (sys_userorder.ctrl=0) AND (sys_userorder.tinh_trang=1) AND (sys_userorder.loai=1)";
	$sql.=" ORDER BY sys_userorder.id DESC";
	$rs=$db->Execute($sql);	
	if($rs->RecordCount()){	?>	

<?php
	$j=0;
	while(!$rs->EOF){
	
	$sql="SELECT sys_userorder.*, sys_userorder.id as mahd, DATE_FORMAT(sys_userorder.date_create, '".format_date()."') as date_create, TO_DAYS(sys_userorder.date_create) as today";
	$sql.=" FROM user, sys_userorder";
	$sql.=" WHERE (user.username = '$username') AND (user.id = sys_userorder.userid) AND (sys_userorder.ctrl&1=1) AND (sys_userorder.id=".$rs->fields("hdban").")";
	$rshdban=$db->Execute($sql);
	if($rs->fields("price")){$giadvdtchot=$rs->fields("price"); $date_creategiadvdtchot=$rs->fields("date_creategiadvdtchot"); $creategiadvdtchot=$rs->fields("dategiadvdt");}else{$giadvdtchot=$giadvdtchot1;};
	
	//if($rs->fields("price")){$giadvdtchot=$rs->fields("price"); $date_creategiadvdtchot=$rs->fields("dategiadvdt");}else{$giadvdtchot=$giadvdtchot1;};
	//echo $rshdban->fields("price")."<br>";
	
	$tongbanhopdong=$giadvdtchot*$rs->fields("model");
	$phirut=$tongbanhopdong*0.003;
	
	$tongban=$tongbanhopdong*0.997;
	
	//$lailo=$tongban-$rshdban->fields("price_old");
	//$lailo=($giadvdtchot-$rshdban->fields("price"))*$rs->fields("model");
	//$lailo=$tongban-($rs->fields("model")*$rshdban->fields("price"));
	$lailo=($giadvdtchot-$rshdban->fields("price"))*$rs->fields("model")-$phirut;
	
	$phamtramlailo=($giadvdtchot-$rshdban->fields("price"))/$rshdban->fields("price");
	
	if($phamtramlailo<0.1){
		$hoahongck=0;
		$phantramhoahongck=0;
	}
	if(0.1<= $phamtramlailo && $phamtramlailo <0.5){
		$hoahongck=$lailo*0.025;
		$phantramhoahongck=2.5;
		
	}
	if(0.5<=$phamtramlailo && $phamtramlailo<1){
		$hoahongck=$lailo*0.03;
		$phantramhoahongck=3;
	}
	if(1<=$phamtramlailo){
		$hoahongck=$lailo*0.04;
		$phantramhoahongck=4;
	}
	//
	//
	if(!$rs->fields("gioithieu")){
		$hoahongck=0;
	}
	//
	$tysuatloinhuan=$giadvdtchot/$rshdban->fields("price");
	//echo $tysuatloinhuan;
	
	if($tysuatloinhuan<1.1){$phihoptac=0; $phantramphihoptac=0;}
	if(1.1<=$tysuatloinhuan && $tysuatloinhuan<1.5){$phihoptac=$lailo*0.15; $phantramphihoptac=15;}
	if(1.5<=$tysuatloinhuan && $tysuatloinhuan<2){$phihoptac=$lailo*0.2; $phantramphihoptac=20;}
	if(2<$tysuatloinhuan){$phihoptac=$lailo*0.25; $phantramphihoptac=25;}
	
	
	$songay=$rs->fields("today")-$rshdban->fields("today");
	if($songay<90){$phiruttruochan=$tongban*0.01; $phantramphiruttruochan=1;}
	if(90<=$songay && $songay<180){$phiruttruochan=$tongban*0.005; $phantramphiruttruochan=0.5;}
	
	//if($songay<90){$phiruttruochan=$tongban*0.02; $phantramphiruttruochan=2;}
	//if(90<=$songay && $songay<180){$phiruttruochan=$tongban*0.01; $phantramphiruttruochan=1;}
	if($songay>=180){$phiruttruochan=$tongban*0; $phantramphiruttruochan=0;}
	
	if($tongban>1000000000&&738489<$rs->fields("today")){$phiruttruochan=$phiruttruochan*0.5; $phantramphiruttruochan=$phantramphiruttruochan*0.5;}
	
	$phirut=$tongban*0.003;
	
	$ctthue=$lailo-$phihoptac-$phiruttruochan;
	if($ctthue>0){
		$tncn=($lailo-$phihoptac-$phiruttruochan+$hoahongck)*0.05;
		$phantramtncn=5;
	}else{
		$tncn=0;
		$phantramtncn=0;
	}
	//if($lailo>0){
		//$phihoptac=$lailo*0.1;	
	//	$tncn=($lailo-$phihoptac-$phiruttruochan)*0.05;
	//}else{
		//$phihoptac=0;
	//	$tncn=0;
	//}
	
	$thucnhan=$tongban-$phihoptac-$phiruttruochan-$tncn+$hoahongck;
	
	$ngayban=$rs->fields("today");
	//echo $ngayban."ccccccccccc".$homnay;
	date_default_timezone_set('Asia/Ho_Chi_Minh');
	$timelenh = date('Hi');
	if(($homnay-$ngayban)>0){
		$lenhxacnhan=0;
		if(($homnay-$ngayban)==1){
			if($timelenh<1000){$lenhxacnhan=1;}else{$lenhxacnhan=0;}
			//echo "vvv";
		}
	}else{
		$lenhxacnhan=1;
	}
?>
<?php 
$date = date("Y-m-d");
$days = to_days($date);
if($rs->fields("trangthai")==2 && $days > $rs->fields("today")){
}else{
?>
<?php if($rs->fields("trangthai")==1){?>
<div class="col-xs-12 col-sm-12 col-md-12" style="margin-bottom:10px; margin-top:10px;">

<div class="col-xs-12 col-sm-12 col-md-12" style="background-color:#F4F4F4">
	<div style="float:left"><strong>Hợp đồng đã bán - <?php echo $rshdban->fields("name") ?></strong></div>
    
	<div  class="content" style="cursor:pointer; float:right; color:#FF0000" onClick="JavaScript:dropCategory(<?php echo $rs->fields("id");?>)">Chi tiết</span></div>
</div>
<div id="<?php echo $rs->fields("id");?>" style="display:none;">

<table width="100%" border="1" cellspacing="0" cellpadding="0" class="table">
    
   <tr <?php if($j%2){?> bgcolor="#F4F4F4"<?php }?>>
    <td ><strong>Hợp đồng muốn rút vốn</strong></td>
    <td style="text-align: right; vertical-align: middle;" ><strong><?php echo $rshdban->fields("name") ?></strong></td>
   </tr>
    <tr <?php if($j%2){?> bgcolor="#F4F4F4"<?php }?>> 
    <td>Ngày mua theo HĐ (1):</td>
    <td style="text-align: right; vertical-align: middle;"><?php echo $rshdban->fields("date_create") ?></td>
   </tr>
   
    <tr <?php if($j%2){?> bgcolor="#F4F4F4"<?php }?>> 
    <td>Số lượng ĐVĐT (2):</td>
    <td align="right" style="text-align: right; vertical-align: middle;"><?php echo number_format($rs->fields("model"), 0, '.', ',') ?></td>
    </tr>
    <tr <?php if($j%2){?> bgcolor="#F4F4F4"<?php }?>>
    <td>Giá mua ĐVĐT (3):</td>
     <td align="right" style="text-align: right; vertical-align: middle;"><?php echo number_format($rshdban->fields("price"), 0, '.', ',') ?></td>
    </tr>
    <tr <?php if($j%2){?> bgcolor="#F4F4F4"<?php }?>>
    <td>Tổng giá trị (4):</td>
    <td align="right" style="text-align: right; vertical-align: middle;"><?php echo number_format($rshdban->fields("price_old"), 0, '.', ',') ?></td>
    </tr>
     <tr <?php if($j%2){?> bgcolor="#F4F4F4"<?php }?>>
    <td colspan="2"><strong>Thông tin rút vốn</strong></td>
    <tr <?php if($j%2){?> bgcolor="#F4F4F4"<?php }?>> 
    <td>Ngày định giá (5)</td>
    <td style="text-align: right; vertical-align: middle;"><?php echo $date_creategiadvdtchot; ?></td>
   </tr>
   
    <tr <?php if($j%2){?> bgcolor="#F4F4F4"<?php }?>>
    <td>Số lượng ĐVĐT đặt bán (6)</td>
    <td align="right" style="text-align: right; vertical-align: middle;"><?php echo number_format($rs->fields("model"), 0, '.', ',') ?></td>
    </tr>
    <tr <?php if($j%2){?> bgcolor="#F4F4F4"<?php }?>>
    <td>Giá bán 1 ĐVĐT (7)</td>
    <td align="right" style="text-align: right; vertical-align: middle;"><?php if($giadvdtchot){ echo number_format($giadvdtchot, 0, '.', ',')."";}else{?> <font color="#FF0000">*</font><?php }?></td>
    </tr>
    <tr <?php if($j%2){?> bgcolor="#F4F4F4"<?php }?>>
    <td>Tổng giá trị bán</td>
     <td align="right" style="text-align: right; vertical-align: middle;"><?php if($giadvdtchot>0){ echo number_format($tongbanhopdong, 0, '.', ',')."";}else{ echo "#";} ?></td>
    </tr>
     <tr <?php if($j%2){?> bgcolor="#F4F4F4"<?php }?>>
    <td>Phí rút (để lại TK đầu tư)</td>
     <td align="right" style="text-align: right; vertical-align: middle;"><?php if($giadvdtchot>0){ echo number_format($phirut, 0, '.', ',')."";}else{ echo "#";}?></td>
    </tr>
      <tr <?php if($j%2){?> bgcolor="#F4F4F4"<?php }?>>
    <td>Tổng giá trị bán thực tế (8)</td>
     <td align="right" style="text-align: right; vertical-align: middle;"><?php if($giadvdtchot>0){ echo number_format($tongban, 0, '.', ',')."";}else{ echo "#";} ?></td>
    </tr>
    <tr <?php if($j%2){?> bgcolor="#F4F4F4"<?php }?>>
    <td>Lãi/Lỗ (9)=(8)-(6)*(3)</td>
    <td align="right" style="text-align: right; vertical-align: middle;"><?php if($giadvdtchot>0){ echo number_format($lailo, 0, '.', ',')."";}else{ echo "#";} ?></td>
    </tr>
    <tr <?php if($j%2){?> bgcolor="#F4F4F4"<?php }?>>
    <td>Phí hợp tác đầu tư theo hợp đồng (10)=<?php echo $phantramphihoptac;?>%*(9)</td>
     <td align="right" style="text-align: right; vertical-align: middle;"><?php if($giadvdtchot>0){ echo number_format($phihoptac, 0, '.', ',')."";}else{ echo "#";} ?></td>
    </tr>
    <tr <?php if($j%2){?> bgcolor="#F4F4F4"<?php }?>>
    <td>Hoa hồng chiết khấu (11)=<?php echo $phantramhoahongck;?>%*(9)</td>
    <td align="right" style="text-align: right; vertical-align: middle;"><?php if($giadvdtchot>0){ echo number_format($hoahongck, 0, '.', ',')."";}else{ echo "#";} ?></td>
    </tr>
    <tr <?php if($j%2){?> bgcolor="#F4F4F4"<?php }?>>
    <td>Hoa hồng giới thiệu (12)=<?php echo $phantramhoahongck;?>%*(9)</td>
    <td align="right" style="text-align: right; vertical-align: middle;"><?php if($giadvdtchot>0){ echo number_format($hoahongck, 0, '.', ',')."";}else{ echo "#";} ?></td>
    </tr>
     <tr <?php if($j%2){?> bgcolor="#F4F4F4"<?php }?>>
    <td>Phí hợp tác đầu tư TSI thực nhận (13)=(10)-(11)-(12)</td>
     <td align="right" style="text-align: right; vertical-align: middle;"><?php if($giadvdtchot>0){ echo number_format($phihoptac-$hoahongck-$hoahongck, 0, '.', ',')."";}else{ echo "#";}?></td>
    </tr>
   
    <tr <?php if($j%2){?> bgcolor="#F4F4F4"<?php }?>>
    <td>Phí rút trước hạn (14)=<?php echo $phantramphiruttruochan;?>%*(8)</td>
     <td align="right" style="text-align: right; vertical-align: middle;"><?php if($giadvdtchot>0){ echo number_format($phiruttruochan, 0, '.', ',')."";}else{ echo "#";}?></td>
    </tr>
    
    <tr <?php if($j%2){?> bgcolor="#F4F4F4"<?php }?>>
    <td>Lãi lỗ trước thuế (15)=(9)-(10)+(11)-(14)</td>
    <td align="right" style="text-align: right; vertical-align: middle;"><?php if($giadvdtchot>0){ echo number_format($lailo-$phihoptac+$hoahongck-$phiruttruochan-$phirut, 0, '.', ',')."";}else{ echo "#";} ?></td>
    </tr>
    
    <tr <?php if($j%2){?> bgcolor="#F4F4F4"<?php }?>>
    <td>Thuế thu nhập cá nhân (16)=<?php echo $phantramtncn;?>%*(15)</td>
    <td align="right" style="text-align: right; vertical-align: middle;"><?php if($giadvdtchot>0){ echo number_format($tncn, 0, '.', ',')."";}else{ echo "#";} ?></td>
    </tr>
    <tr <?php if($j%2){?> bgcolor="#F4F4F4"<?php }?>>
    <td>Thực nhận (=6*3+15-16)</td>
     <td align="right" style="text-align: right; vertical-align: middle;"><?php if($giadvdtchot>0){ echo number_format($thucnhan, 0, '.', ',')."";}else{ echo "#";} ?></td>
    </tr>
    
    <tr <?php if($j%2){?> bgcolor="#F4F4F4"<?php }?>>
    <?php if($rs->fields("trangthai")==1){ echo "<td colspan=\"2\" nowrap=\"nowrap\" align=\"center\" class=\"title\"  style=\"color:#0000FF; text-align: center; vertical-align: middle;  padding:5px\">Đã bán</td>";}?>
     <?php if($rs->fields("trangthai")==2){ echo "<td colspan=\"2\" nowrap=\"nowrap\" align=\"center\" class=\"title\" style=\"color:#FF0000; text-align: center; vertical-align: middle; padding:5px\">Bị hủy bỏ</td>";}?>
     <?php if($rs->fields("trangthai")==0){ ?>
	<?php if($rs->fields("price")){echo "<td colspan=\"2\" nowrap=\"nowrap\" align=\"center\"  style=\"text-align: center; vertical-align: middle; padding:5px\">Đã xác nhận</td>";}else{?>
    <td colspan="2" nowrap="nowrap" align="center" style="text-align: center; vertical-align: middle; padding:5px"  >
     
        <div align="center"><button class="button1" style="font-size:12px; color:#FFFFFF; background-color:#FF0000; border:2px solid #CCCCCC; width:120px">
       
        <a href="<?php echo _DOMAIN_ROOT_URL;?>/?m=user&op=huy&id=<?php echo $rs->fields("id");?>" onclick = "if (! confirm('Bạn muốn hủy giao dịch?')) { return false; }" class="title" style="font-size:12px; color:#FFFFFF">Hủy giao dịch</a></button>
        </div>
        <div style="padding-top:10px;" align="center">
        <?php if($lenhxacnhan==1){?>
          <button class="button1" style="width:120px; background-color:#0033FF"><a href="<?php echo _DOMAIN_ROOT_URL;?>/?m=user&f=submituserxacthucban&id=<?php echo $rs->fields("id");?>&soluongban=<?php echo $rs->fields("model");?>&giadvdtchot=<?php echo $giadvdtchot;?>&idrut=<?php echo $rshdban->fields("mahd");?>&tongbanhopdong=<?php echo $tongbanhopdong?>&tongban=<?php echo $tongban?>&lailo=<?php echo $lailo;?>&phihoptac=<?php echo $phihoptac;?>&phantramphihoptac=<?php echo $phantramphihoptac;?>&tncn=<?php echo $tncn;?>&phantramtncn=<?php echo $phantramtncn;?>&thucnhan=<?php echo $thucnhan;?>&phiruttruochan=<?php echo $phiruttruochan?>&phirut=<?php echo $phirut?>&phantramphiruttruochan=<?php echo $phantramphiruttruochan;?>&hoahongck=<?php echo $hoahongck;?>&phantramhoahongck=<?php echo $phantramhoahongck;?>&hoahonggioithieu=<?php echo $hoahongck;?>&date_creategiadvdtchot=<?php echo $date_creategiadvdtchot;?>" onclick = "if (! confirm('Bạn muốn thực hiện giao dịch?')) { return false; }" class="title" style="font-size:12px; color:#FFFFFF">Xác nhận</a></button>
         <?php }else{?> 
          <button class="button1"  style="font-size:12px; color:#FFFFFF; background-color:#CCCCCC; border:2px solid #CCCCCC; width:120px" title="chưa thể xác nhận"><a href="#"  class="title" style="font-size:12px; color:#006633"  onClick="alert('Quý khách vui lòng xác nhận vào khoảng thời gian từ lúc đặt bán đến 10h sáng ngày tiếp theo')">Xác nhận</a></button>
        <?php }?>
        </div> 
      <?php }?>  
    </td>
    </tr>
    <?php }?>

</table> 
</div>
</div>
<?php }else{?>
<div class="col-xs-12 col-sm-12 col-md-12">


<table width="100%" border="1" cellspacing="0" cellpadding="0" class="table">
    
   <tr <?php if($j%2){?> bgcolor="#F4F4F4"<?php }?>>
    <td ><strong>Hợp đồng muốn rút vốn</strong></td>
    <td style="text-align: right; vertical-align: middle;" ><strong><?php echo $rshdban->fields("name") ?></strong></td>
   </tr>
    <tr <?php if($j%2){?> bgcolor="#F4F4F4"<?php }?>> 
    <td>Ngày mua theo HĐ (1):</td>
    <td style="text-align: right; vertical-align: middle;"><?php echo $rshdban->fields("date_create") ?></td>
   </tr>
   
    <tr <?php if($j%2){?> bgcolor="#F4F4F4"<?php }?>> 
    <td>Số lượng ĐVĐT (2):</td>
    <td align="right" style="text-align: right; vertical-align: middle;"><?php echo number_format($rshdban->fields("model")+$rshdban->fields("product_in"), 0, '.', ',') ?></td>
    </tr>
    <tr <?php if($j%2){?> bgcolor="#F4F4F4"<?php }?>>
    <td>Giá mua ĐVĐT (3):</td>
     <td align="right" style="text-align: right; vertical-align: middle;"><?php echo number_format($rshdban->fields("price"), 0, '.', ',') ?></td>
    </tr>
    
    
    <?php if(($rshdban->fields("delivery")-$rshdban->fields("model")-$rshdban->fields("product_in"))>0){?>
     <tr <?php if($j%2){?> bgcolor="#F4F4F4"<?php }?>>
    <td>Tổng giá trị (4):</td>
    <td align="right" style="text-align: right; vertical-align: middle;"><?php echo number_format(($rshdban->fields("model")+$rshdban->fields("product_in"))*$rshdban->fields("price"), 0, '.', ',') ?></td>
    </tr>
    
    <?php }else{?>
      <tr <?php if($j%2){?> bgcolor="#F4F4F4"<?php }?>>
    <td>Tổng giá trị (4):</td>
    <td align="right" style="text-align: right; vertical-align: middle;"><?php echo number_format($rshdban->fields("promotion"), 0, '.', ',') ?></td>
    </tr>
    <?php }?>
    
     <tr <?php if($j%2){?> bgcolor="#F4F4F4"<?php }?>>
    <td colspan="2"><strong>Thông tin rút vốn</strong></td>
    <tr <?php if($j%2){?> bgcolor="#F4F4F4"<?php }?>> 
    <td>Ngày định giá (5)</td>
    <td style="text-align: right; vertical-align: middle;"><?php echo $date_creategiadvdtchot; ?></td>
   </tr>
   
    <tr <?php if($j%2){?> bgcolor="#F4F4F4"<?php }?>>
    <td>Số lượng ĐVĐT đặt bán (6)</td>
    <td align="right" style="text-align: right; vertical-align: middle;"><?php echo number_format($rs->fields("model"), 0, '.', ',') ?></td>
    </tr>
    <tr <?php if($j%2){?> bgcolor="#F4F4F4"<?php }?>>
    <td>Giá bán 1 ĐVĐT (7)</td>
    <td align="right" style="text-align: right; vertical-align: middle;"><?php if($giadvdtchot){ echo number_format($giadvdtchot, 0, '.', ',')."";}else{?> <font color="#FF0000">*</font><?php }?></td>
    </tr>
    <tr <?php if($j%2){?> bgcolor="#F4F4F4"<?php }?>>
    <td>Tổng giá trị bán</td>
     <td align="right" style="text-align: right; vertical-align: middle;"><?php if($giadvdtchot>0){ echo number_format($tongbanhopdong, 0, '.', ',')."";}else{ echo "#";} ?></td>
    </tr>
     <tr <?php if($j%2){?> bgcolor="#F4F4F4"<?php }?>>
    <td>Phí rút (để lại TK đầu tư)</td>
     <td align="right" style="text-align: right; vertical-align: middle;"><?php if($giadvdtchot>0){ echo number_format($phirut, 0, '.', ',')."";}else{ echo "#";}?></td>
    </tr>
      <tr <?php if($j%2){?> bgcolor="#F4F4F4"<?php }?>>
    <td>Tổng giá trị bán thực tế (8)</td>
     <td align="right" style="text-align: right; vertical-align: middle;"><?php if($giadvdtchot>0){ echo number_format($tongban, 0, '.', ',')."";}else{ echo "#";} ?></td>
    </tr>
    <tr <?php if($j%2){?> bgcolor="#F4F4F4"<?php }?>>
    <td>Lãi/Lỗ (9)=(8)-(6)*(3)</td>
    <td align="right" style="text-align: right; vertical-align: middle;"><?php if($giadvdtchot>0){ echo number_format($lailo, 0, '.', ',')."";}else{ echo "#";} ?></td>
    </tr>
    <tr <?php if($j%2){?> bgcolor="#F4F4F4"<?php }?>>
    <td>Phí hợp tác đầu tư theo hợp đồng (10)=<?php echo $phantramphihoptac;?>%*(9)</td>
     <td align="right" style="text-align: right; vertical-align: middle;"><?php if($giadvdtchot>0){ echo number_format($phihoptac, 0, '.', ',')."";}else{ echo "#";} ?></td>
    </tr>
    <tr <?php if($j%2){?> bgcolor="#F4F4F4"<?php }?>>
    <td>Hoa hồng chiết khấu (11)=<?php echo $phantramhoahongck;?>%*(9)</td>
    <td align="right" style="text-align: right; vertical-align: middle;"><?php if($giadvdtchot>0){ echo number_format($hoahongck, 0, '.', ',')."";}else{ echo "#";} ?></td>
    </tr>
    <tr <?php if($j%2){?> bgcolor="#F4F4F4"<?php }?>>
    <td>Hoa hồng giới thiệu (12)=<?php echo $phantramhoahongck;?>%*(9)</td>
    <td align="right" style="text-align: right; vertical-align: middle;"><?php if($giadvdtchot>0){ echo number_format($hoahongck, 0, '.', ',')."";}else{ echo "#";} ?></td>
    </tr>
     <tr <?php if($j%2){?> bgcolor="#F4F4F4"<?php }?>>
    <td>Phí hợp tác đầu tư TSI thực nhận (13)=(10)-(11)-(12)</td>
     <td align="right" style="text-align: right; vertical-align: middle;"><?php if($giadvdtchot>0){ echo number_format($phihoptac-$hoahongck-$hoahongck, 0, '.', ',')."";}else{ echo "#";}?></td>
    </tr>
    
    <tr <?php if($j%2){?> bgcolor="#F4F4F4"<?php }?>>
    <td>Phí rút trước hạn (14)=<?php echo $phantramphiruttruochan;?>%*(8)</td>
     <td align="right" style="text-align: right; vertical-align: middle;"><?php if($giadvdtchot>0){ echo number_format($phiruttruochan, 0, '.', ',')."";}else{ echo "#";}?></td>
    </tr>
    <tr <?php if($j%2){?> bgcolor="#F4F4F4"<?php }?>>
    <td>Lãi lỗ trước thuế (15)=(9)-(10)+(11)-(14)</td>
    <td align="right" style="text-align: right; vertical-align: middle;"><?php if($giadvdtchot>0){ echo number_format($lailo-$phihoptac+$hoahongck-$phiruttruochan, 0, '.', ',')."";}else{ echo "#";} ?></td>
    </tr>
    
    <tr <?php if($j%2){?> bgcolor="#F4F4F4"<?php }?>>
    <td>Thuế thu nhập cá nhân (16)=<?php echo $phantramtncn;?>%*(15)</td>
    <td align="right" style="text-align: right; vertical-align: middle;"><?php if($giadvdtchot>0){ echo number_format($tncn, 0, '.', ',')."";}else{ echo "#";} ?></td>
    </tr>
    <tr <?php if($j%2){?> bgcolor="#F4F4F4"<?php }?>>
    <td>Thực nhận (=6*3+15-16)</td>
     <td align="right" style="text-align: right; vertical-align: middle;"><?php if($giadvdtchot>0){ echo number_format($thucnhan, 0, '.', ',')."";}else{ echo "#";} ?></td>
    </tr>
    
    <tr <?php if($j%2){?> bgcolor="#F4F4F4"<?php }?>>
    <?php if($rs->fields("trangthai")==1){ echo "<td colspan=\"2\" nowrap=\"nowrap\" align=\"center\" class=\"title\"  style=\"color:#0000FF; text-align: center; vertical-align: middle;  padding:5px\">Đã bán</td>";}?>
     <?php if($rs->fields("trangthai")==2){ echo "<td colspan=\"2\" nowrap=\"nowrap\" align=\"center\" class=\"title\" style=\"color:#FF0000; text-align: center; vertical-align: middle; padding:5px\">Bị hủy bỏ</td>";}?>
     <?php if($rs->fields("trangthai")==0){ ?>
	<?php if($rs->fields("price")){echo "<td colspan=\"2\" nowrap=\"nowrap\" align=\"center\"  style=\"text-align: center; vertical-align: middle; padding:5px\">Đã xác nhận</td>";}else{?>
    <td colspan="2" nowrap="nowrap" align="center" style="text-align: center; vertical-align: middle; padding:5px"  >
     
        <div align="center"><button class="button1" style="font-size:12px; color:#FFFFFF; background-color:#FF0000; border:2px solid #CCCCCC; width:120px">
       
        <a href="<?php echo _DOMAIN_ROOT_URL;?>/?m=user&op=huy&id=<?php echo $rs->fields("id");?>" onclick = "if (! confirm('Bạn muốn hủy giao dịch?')) { return false; }" class="title" style="font-size:12px; color:#FFFFFF">Hủy giao dịch</a></button>
        </div>
        <div style="padding-top:10px;" align="center">
        <?php if($lenhxacnhan==1){?>
          <button class="button1" style="width:120px; background-color:#0033FF"><a href="<?php echo _DOMAIN_ROOT_URL;?>/?m=user&f=submituserxacthucban&id=<?php echo $rs->fields("id");?>&soluongban=<?php echo $rs->fields("model");?>&giadvdtchot=<?php echo $giadvdtchot;?>&idrut=<?php echo $rshdban->fields("mahd");?>&tongbanhopdong=<?php echo $tongbanhopdong?>&tongban=<?php echo $tongban?>&lailo=<?php echo $lailo;?>&phihoptac=<?php echo $phihoptac;?>&phantramphihoptac=<?php echo $phantramphihoptac;?>&tncn=<?php echo $tncn;?>&phantramtncn=<?php echo $phantramtncn;?>&thucnhan=<?php echo $thucnhan;?>&phiruttruochan=<?php echo $phiruttruochan?>&phirut=<?php echo $phirut?>&phantramphiruttruochan=<?php echo $phantramphiruttruochan;?>&hoahongck=<?php echo $hoahongck;?>&phantramhoahongck=<?php echo $phantramhoahongck;?>&hoahonggioithieu=<?php echo $hoahongck;?>&date_creategiadvdtchot=<?php echo $date_creategiadvdtchot;?>" onclick = "if (! confirm('Bạn muốn thực hiện giao dịch?')) { return false; }" class="title" style="font-size:12px; color:#FFFFFF">Xác nhận</a></button>
         <?php }else{?> 
          <button class="button1"  style="font-size:12px; color:#FFFFFF; background-color:#CCCCCC; border:2px solid #CCCCCC; width:120px" title="chưa thể xác nhận"><a href="#"  class="title" style="font-size:12px; color:#006633"  onClick="alert('Quý khách vui lòng xác nhận vào khoảng thời gian từ lúc đặt bán đến 10h sáng ngày tiếp theo')">Xác nhận</a></button>
        <?php }?>
        </div> 
      <?php }?>  
    </td>
    </tr>
    <?php }?>

</table> 
</div>
<?php 
}
}
?>   
<?php 
	$j++;
	$rs->MoveNext();
 }
 
?>



<?php 
	}
}
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
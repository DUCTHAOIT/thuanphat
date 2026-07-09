<?php
function lichsugiaodich(){
	global $db,$lang,$lable;	
	$monthlichsu=getParam("monthlichsu");
	$monthtoday=date("m");
	$monthtoday2=date("m")-1;
	$yearlichsu=getParam("yearlichsu");
	$yeartoday=date("Y");	
	
	
	$sql="SELECT sys_userorder.*, DATE_FORMAT(sys_userorder.date_create, '".format_date()."') as date_create, TO_DAYS(sys_userorder.date_create) as today, MONTH(sys_userorder.date_create) as monthlichsu, YEAR(sys_userorder.date_create) as yearlichsu";
	$sql.=" FROM user, sys_userorder";
	$sql.=" WHERE (user.id = sys_userorder.userid) AND (sys_userorder.ctrl=0) AND (sys_userorder.tinh_trang=1) AND (sys_userorder.trangthai=1) AND (sys_userorder.loai=0)";
	if($monthlichsu){
		$sql.=" AND (MONTH(sys_userorder.date_create) = '$monthlichsu')";	
	}else{
		//$sql.=" AND ((MONTH(sys_userorder.date_create) = '$monthtoday') OR MONTH(sys_userorder.date_create) = '$monthtoday2')";
		$sql.=" AND (MONTH(sys_userorder.date_create) = '$monthtoday')";	
		$monthlichsu=date("m");
	}
	if($yearlichsu){
		$sql.=" AND (YEAR(sys_userorder.date_create) = '$yearlichsu')";	
	}else{
		$sql.=" AND (YEAR(sys_userorder.date_create) = '$yeartoday')";
		$yearlichsu=date("Y");
	}
	$sql.=" ORDER BY sys_userorder.id DESC";
	//echo $sql;
	$rs=$db->Execute($sql);	
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="100%" align="right"> Lựa chọn: </td>
    <td nowrap="nowrap" class="title" >Năm: &nbsp;</td>
    <td align="right" nowrap="nowrap">			
    <select name="year" onchange="location = '<?php echo _DOMAIN_ROOT_URL."/user_buy_sell/"; ?><?php if($monthlichsu){ echo "&monthlichsu=".$monthlichsu;} ?>&yearlichsu='+ this.options[this.selectedIndex].value;" style="font-size:12px" >
    	<option value="2020" <?php if($yearlichsu=="2020"){ echo 'selected="selected"';} ?>>2020</option>
    	<option value="2021" <?php if($yearlichsu=="2021"){ echo 'selected="selected"';} ?>>2021</option>                   
        <option value="2022" <?php if($yearlichsu=="2022"){ echo 'selected="selected"';} ?>>2022</option>
        <option value="2023" <?php if($yearlichsu=="2023"){ echo 'selected="selected"';} ?>>2023</option>
        
        <option value="2024" <?php if($yearlichsu=="2024"){ echo 'selected="selected"';} ?>>2024</option>                   
        <option value="2025" <?php if($yearlichsu=="2025"){ echo 'selected="selected"';} ?>>2025</option>
        <option value="2026" <?php if($yearlichsu=="2026"){ echo 'selected="selected"';} ?>>2026</option>
        
        <option value="2027" <?php if($yearlichsu=="2027"){ echo 'selected="selected"';} ?>>2027</option>                   
        <option value="2028" <?php if($yearlichsu=="2028"){ echo 'selected="selected"';} ?>>2028</option>
        <option value="2029" <?php if($yearlichsu=="2029"){ echo 'selected="selected"';} ?>>2029</option>
        
        <option value="2030" <?php if($yearlichsu=="2030"){ echo 'selected="selected"';} ?>>2030</option>  
            
    </select>
    </td>
    <td nowrap="nowrap" class="title">Tháng: &nbsp;</td>
    <td align="right" nowrap="nowrap">			
    <select name="month" onchange="location = '<?php echo _DOMAIN_ROOT_URL."/user_buy_sell/"; ?><?php if($yearlichsu){ echo "&yearlichsu=".$yearlichsu;} ?>&monthlichsu='+ this.options[this.selectedIndex].value;" style="font-size:12px" >
        <option value="1" <?php if($monthlichsu=="1"){ echo 'selected="selected"';} ?>>1</option>                   
        <option value="2" <?php if($monthlichsu=="2"){ echo 'selected="selected"';} ?>>2</option>
        <option value="3" <?php if($monthlichsu=="3"){ echo 'selected="selected"';} ?>>3</option>
        
        <option value="4" <?php if($monthlichsu=="4"){ echo 'selected="selected"';} ?>>4</option>                   
        <option value="5" <?php if($monthlichsu=="5"){ echo 'selected="selected"';} ?>>5</option>
        <option value="6" <?php if($monthlichsu=="6"){ echo 'selected="selected"';} ?>>6</option>
        
        <option value="7" <?php if($monthlichsu=="7"){ echo 'selected="selected"';} ?>>7</option>                   
        <option value="8" <?php if($monthlichsu=="8"){ echo 'selected="selected"';} ?>>8</option>
        <option value="9" <?php if($monthlichsu=="9"){ echo 'selected="selected"';} ?>>9</option>
        
        <option value="10" <?php if($monthlichsu=="10"){ echo 'selected="selected"';} ?>>10</option>                   
        <option value="11" <?php if($monthlichsu=="11"){ echo 'selected="selected"';} ?>>11</option>
        <option value="12" <?php if($monthlichsu=="12"){ echo 'selected="selected"';} ?>>12</option>
       
            
    </select>
    </td>
  </tr>
</table>
<?php	
	if($rs->RecordCount()){	?>
<div class="">

<table width="100%" border="1" cellspacing="0" cellpadding="0" class="table">
  <tr class="tr" style="background-color:#CCCCCC">
  	<td class="title" align="center">Ngày mua/<br /> Ngày bán</td>
    <td class="title" align="center">Số hợp đồng</td>
    
    <td class="title" align="center">Số lượng ĐVĐT bán</td>
    <td class="title" align="center">Giá mua 1 ĐVĐT</td>
   
    <td class="title" align="center">Giá bán 1 ĐVĐT</td>
    <td class="title" align="center">Tổng giá trị bán</td>
    <td class="title" align="center">Lãi/Lỗ</td>
    <td class="title" align="center">% Lãi/Lỗ</td>
    
    
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
	//
	
	
	$tysuatloinhuan=$giadvdtchot/$rshdban->fields("price");
	if($tysuatloinhuan<1.1){$phihoptac=0;}
	if(1.1<=$tysuatloinhuan && $tysuatloinhuan<1.5){$phihoptac=$lailo*0.15;}
	if(1.5<=$tysuatloinhuan && $tysuatloinhuan<2){$phihoptac=$lailo*0.2;}
	if(2<$tysuatloinhuan){$phihoptac=$lailo*0.25;}
	//
	if($lailo>0){
		//$phihoptac=$lailo*0.15;	
		$tncn=($lailo-$phihoptac-$phiruttruochan+$hoahongck)*0.05;
	}else{
		$phihoptac=0;
		$tncn=0;
	}
	
	
	
	$thucnhan=$tongban-$phihoptac-$phiruttruochan-$tncn+$hoahongck;
	
	
?>


  <tr <?php if($j%2){?> bgcolor="#F4F4F4"<?php }?>>
    
    <td class="title"><?php echo $rshdban->fields("date_create") ?><br /><?php echo $rs->fields("date_create") ?></td>
    <td class="title"><?php echo $rshdban->fields("name") ?></td>
    <td class="title" align="right"><?php echo number_format($rs->fields("model"), 0, '.', ',') ?></td>
    <td class="title" align="right"><?php echo number_format($rshdban->fields("price"), 0, '.', ',') ?></td>
   
    
    <td class="title" align="right"><?php if($giadvdtchot){ echo number_format($giadvdtchot, 0, '.', ',')."";}else{?> <font color="#FF0000" style="font-size:16px">*</font><?php }?></td>
    <td class="title" align="right"><?php if($giadvdtchot>0){ echo number_format($tongban, 0, '.', ',')."";}else{ echo "#";} ?></td>
    <td class="title" align="right" <?php if($lailo>0){ echo 'style="color:#0000FF"';}else{ echo 'style="color:#FF0000"';}?> ><?php if($giadvdtchot>0){ echo number_format($lailo, 0, '.', ',')."";}else{ echo "#";} ?></td>
    <td class="title" align="right" <?php if($lailo>0){ echo 'style="color:#0000FF"';}else{ echo 'style="color:#FF0000"';}?> ><?php if($giadvdtchot>0){ echo number_format($phamtramlailo*100, 2, '.', ',')."%";}else{ echo "#";} ?></td>
    
  
   
  </tr>	



<?php 
	$j++;
	$rs->MoveNext();
 }
 
?>

</table>
</div>
<?php 
	}else{ echo "Không có dữ liệu";}
}	
?>
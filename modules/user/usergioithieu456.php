<?php
function usergioithieu456(){
	global $db,$lang,$lable;	
	$username=getSession("username");
	if(!$username) return;
	
	$sql="SELECT * FROM xuat_su WHERE type=1 ORDER BY id DESC LIMIT 0,1";
	$rsgiadvdt=$db->Execute($sql);	
	$giadvdthientai=$rsgiadvdt->fields("giadvdt");
	
	
	$sql="SELECT * FROM user WHERE gioithieu='$username' AND ctrl=1 ORDER BY id DESC";
	$rs=$db->Execute($sql);

	if($rs->RecordCount()){	?>	
  

<?php
	$j=0;
	
	while(!$rs->EOF){
	$tongsoluongdvdtgioithieu=0;
	$giatrimua=0;
	$tonglailo=0;
	$tonggiatrimua=0;
	
	
	$sql="SELECT sys_userorder.*, DATE_FORMAT(sys_userorder.date_create, '".format_date()."') as date_create";
	$sql.=" FROM user, sys_userorder";
	$sql.=" WHERE (user.email = '".$rs->fields("username")."') AND (user.id = sys_userorder.userid) AND (sys_userorder.ctrl&1=1) AND (sys_userorder.loai=1)";
	$sql.=" ORDER BY sys_userorder.date_create ASC";
	$arr=$db->GetAssoc($sql);
	
?>
<div class="col-xs-12 col-sm-12 col-md-12">
<table width="100%" border="1" cellspacing="0" cellpadding="0" class="table">
  <tr>
    <td colspan="8" class="tr" style="text-transform:uppercase; background-color:#CCCCCC">Thông tin Tài khoản người được giới thiệu - <?php echo $rs->fields("name"); ?></td>
  </tr>
  <tr>
    <td style="vertical-align: middle; text-align:center" class="title">Ngày mua</td>
    <td style="vertical-align: middle; text-align:center" class="title">Số hợp đồng</td>
    <td style="vertical-align: middle; text-align:center" class="title">Số lượng ĐVĐT</td>
    <td style="vertical-align: middle; text-align:center" class="title">Giá mua 1 ĐVĐT</td>
    <td style="vertical-align: middle; text-align:center" class="title">Tổng giá trị mua</td>
    <td style="vertical-align: middle; text-align:center" class="title">Lãi/ lỗ</td>
    <td style="vertical-align: middle; text-align:center" class="title">%</td>
    <td style="vertical-align: middle; text-align:center" class="title">Tình trạng</td>
  </tr>
  <?php foreach($arr as $k=>$v){
  	
  
	if($v["model"]=='0'){
		$khoiluong=$v["delivery"];
		//
	}else{
		$khoiluong=$v["model"];
	}
  	if($v["model"]=$v["delivery"]){$tonggiatri=$v["price_old"]; }else{$tonggiatri=$v["price"]*$khoiluong;}
	if($v["trangthai"]=='1'){
		$sqlgiaban="SELECT sys_userorder.*, DATE_FORMAT(sys_userorder.date_create, '".format_date()."') as date_create";
		$sqlgiaban.=" FROM user, sys_userorder";
		$sqlgiaban.=" WHERE (user.email = '".$rs->fields("username")."') AND (user.id = sys_userorder.userid) AND (sys_userorder.trangthai=1) AND (sys_userorder.loai=0) AND (sys_userorder.hdban=".$k.")";
		$sqlgiaban.=" ORDER BY sys_userorder.date_create ASC";
		$rsgiaban=$db->Execute($sqlgiaban);	
		$giadvdt=$rsgiaban->fields("price");
		$tonggiatri=$v["price_old"];		
	}else{
		$giadvdt=$giadvdthientai;
	}
	//echo $tonggiatri;
	
	$tongsoluongdvdtgioithieu=$tongsoluongdvdtgioithieu+$khoiluong;
	
	$tonggiatrimua=$tonggiatrimua+$tonggiatri;
	$tonglailogioithieu=$tonglailogioithieu+($giadvdt-$v["price"])*$khoiluong;
	
	//echo $giadvdt;
  ?>
    
      <tr bgcolor="">
        <td class="title"  style="vertical-align: middle;"><?php echo $v["date_create"];?></td>
        <td class="title"  style="vertical-align: middle;"><?php echo $v["name"]; ?></td>
        <td class="title" align="right"  style="vertical-align: middle;"><?php echo number_format($khoiluong, 0, '.', ',');?></td>
        <td class="title" align="right"  style="vertical-align: middle;"><?php echo number_format($v["price"], 0, '.', ',');?> </td>
        <td class="title" align="right"  style="vertical-align: middle;"><?php echo number_format($tonggiatri, 0, '.', ',');?> </td>
        <td class="title" align="right"  <?php if(($giadvdt-$v["price"])>0){?> style="color:#0000CC; vertical-align: middle;" <?php }else{?> style="color:#FF0000; vertical-align: middle;"<?php }?>><?php echo number_format(($giadvdt-$v["price"])*$khoiluong, 0, '.', ',');?> </td>
        <td class="title" align="right" <?php if(($giadvdt-$v["price"])>0){?> style="color:#0000CC; vertical-align: middle;" <?php }else{?> style="color:#FF0000; vertical-align: middle;"<?php }?>><?php echo number_format(($giadvdt-$v["price"])/$v["price"]*100, 2, '.', ',');?>%</td>
        <td align="center"  style="vertical-align: middle;"><?php if($v["trangthai"]=='1'){ echo "Đã tất toán"; }else{ echo "Chưa tất toán";}?></td>
      </tr>
  <?php }?>
  <tr height="50px">
    <td style="vertical-align: middle;" colspan="2"><strong>Tổng cộng:</strong></td>
    <td style="vertical-align: middle;" class="title" align="right"><strong><?php echo number_format($tongsoluongdvdtgioithieu, 0, '.', ',');?></strong></td>
    <td style="vertical-align: middle;" class="title" align="right"><strong><?php echo number_format(($tonggiatrimua/$tongsoluongdvdtgioithieu), 0, '.', ',');?></strong></td>
    <td style="vertical-align: middle;" class="title" align="right"><strong><?php echo number_format($tonggiatrimua, 0, '.', ',');?></strong></td>
    <td <?php if($tonglailogioithieu>0){?> style="color:#0000CC; vertical-align: middle;" <?php }else{?> style="color:#FF0000; vertical-align: middle;"<?php }?> class="title" align="right"><strong><?php echo number_format($tonglailogioithieu, 0, '.', ',');?></strong></td>
    <td <?php if($tonglailogioithieu>0){?> style="color:#0000CC; vertical-align: middle;" <?php }else{?> style="color:#FF0000; vertical-align: middle;"<?php }?> class="title" align="right"><strong><?php echo number_format($tonglailogioithieu/$tonggiatrimua*100, 2, '.', ',');?>%</strong></td>
    <td style="vertical-align: middle;" class="title"></td>
  </tr>
</table>
</div>
<?php 
	$j++;
	$rs->MoveNext();

	}
	}
}
?>
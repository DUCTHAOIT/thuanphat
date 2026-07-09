<?php
	global $db,$lang,$lable;
	$id = getParam("id");
	if(!$id) return;	
	$username=getSession("username");
	$sql="SELECT sys_userorder.*, DATE_FORMAT(sys_userorder.date_create, '%d/%m/%Y') as date_create, sys_product.name as nameproduct, sys_product.id as proid";
	$sql.=" FROM user, sys_userorder, sys_product";
	$sql.=" WHERE (user.username = '$username') AND (user.id = sys_userorder.userid) AND (sys_userorder.ctrl&1=1) AND (sys_userorder.id='$id') AND (sys_product.id = sys_userorder.catID)";
	$rs=$db->Execute($sql);
	
	$datcoc=$rs->fields("cklan1")+$rs->fields("cklan2");
	$conlai=$datcoc*(100-$rs->fields("phihoancoc"))/100;
?>


<form name="frmbookingRoom" action="#" method="post" enctype="multipart/form-data">
<input type="hidden" name="f" value="user_sell_add" />
<input type="hidden" name="m" value="user" />
<input type="hidden" name="phihoancoc" value="<?php echo $rs->fields("phihoancoc"); ?>" />
<input type="hidden" name="conlai" value="<?php echo $conlai; ?>" />
<input type="hidden" name="id" value="<?php echo $rs->fields("id"); ?>" />

<div>		
	<div class="title" align="center"><h1 style="text-transform:uppercase; font-size:20px; font-weight:700">Xác nhận hoàn cọc</h1></div>
    <?php 
		
	?> 
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
		<td align="right" style="padding-right:10px;" nowrap="nowrap">Mã HĐ: </td>
		<td>MC-<?php echo $rs->fields("id"); ?></td>
	  </tr>
      <tr>
		<td align="right" style="padding-right:10px;" nowrap="nowrap">Ngày HĐ: </td>
		<td><?php echo $rs->fields("date_create"); ?></td>
	  </tr>
      
       <tr>
		<td align="right" style="padding-right:10px;" nowrap="nowrap">Dự án: </td>
		<td><?php echo $rs->fields("nameproduct"); ?></td>
	  </tr>
       <tr>
		<td align="right" style="padding-right:10px;" nowrap="nowrap">Giai đoạn: </td>
		<td><?php echo $rs->fields("giaidoan"); ?></td>
	  </tr>
      <tr>
		<td align="right" style="padding-right:10px;" nowrap="nowrap">Số suất đầu tư: </td>
		<td><?php echo $rs->fields("soxuatdautu"); ?></td>
	  </tr>
       <tr>
		<td align="right" style="padding-right:10px;" nowrap="nowrap">Số tiền / một suất: </td>
		<td><?php  echo number_format($rs->fields("sotienmotxuat"), 0, '.', ','); ?></td>
	  </tr>
      <tr>
		<td align="right" style="padding-right:10px;" nowrap="nowrap">Chiết khấu: </td>
		<td><?php  echo number_format($rs->fields("chietkhau"), 0, '.', ','); ?></td>
	  </tr>
      <tr>
		<td align="right" style="padding-right:10px;" nowrap="nowrap">Tổng thanh toán: </td>
		<td><?php echo number_format($rs->fields("tongtien"), 0, '.', ','); ?></td>
	  </tr>
      <tr>
		<td align="right" style="padding-right:10px;" nowrap="nowrap">Đã đặt cọc: </td>
		<td><?php echo number_format($datcoc, 0, '.', ','); ?></td>
	  </tr>
      <tr>
		<td align="right" style="padding-right:10px;" nowrap="nowrap">Phí hoàn cọc: </td>
		<td><?php echo number_format($rs->fields("phihoancoc"), 0, '.', ','); ?>%</td>
	  </tr>
      <tr>
		<td align="right" style="padding-right:10px;" nowrap="nowrap" class="title">Số tiền thực nhận: </td>
		<td  class="title"><?php echo number_format($conlai, 0, '.', ','); ?></td>
	  </tr>
    </table>

    
    <div style="padding-top:20px; padding-bottom:20px;" class="row" align="center"><input type="button" onclick="submit()" value="Xác nhận" class="btn btn-primary"  /></div>
</div>
</form>
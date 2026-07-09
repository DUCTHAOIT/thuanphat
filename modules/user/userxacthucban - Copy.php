<?php
function userxacthucban(){
	global $db,$lang,$lable;	
	$username=getSession("username");
	if(!$username) return;
	
	$sql="SELECT sys_userorder.*, DATE_FORMAT(sys_userorder.date_create, '".format_date()."') as date_create";
	$sql.=" FROM user, sys_userorder";
	$sql.=" WHERE (user.username = '$username') AND (user.id = sys_userorder.userid) AND (sys_userorder.ctrl=0) AND (sys_userorder.tinh_trang=1) AND (sys_userorder.loai=0)";
	$sql.=" ORDER BY sys_userorder.id DESC";
	$rs=$db->Execute($sql);	
	if($rs->RecordCount()){	?>	
  
<div class="col-xs-12 col-sm-12 col-md-12">  
<?php
	$j=0;
	while(!$rs->EOF){
	
	$sql="SELECT sys_userorder.*, DATE_FORMAT(sys_userorder.date_create, '".format_date()."') as date_create";
	$sql.=" FROM user, sys_userorder";
	$sql.=" WHERE (user.username = '$username') AND (user.id = sys_userorder.userid) AND (sys_userorder.ctrl&1=1) AND (sys_userorder.id=".$rs->fields("hdban").")";
	$rshdban=$db->Execute($sql);
	
	
	
?>
<form name="frmuserxacthucban" action="#" method="post" enctype="multipart/form-data">
<input type="hidden" name="id" value="<?php echo $rs->fields("id");?>" />
<input type="hidden" name="m" value="user" /> 
<input type="hidden" name="op" value="godetele" />          
<table width="100%" border="1" cellspacing="0" cellpadding="0" class="table">
  <tr>
    <td colspan="2" class="tr" style="text-transform:uppercase; background-color:#CCCCCC">THÔNG TIN ĐẶT BÁN Ngày <?php echo $rs->fields("date_create") ?></td>
  </tr>
         <tr>
            <td colspan="2"><strong>Thông tin hợp đồng</strong></td>
          </tr>	
          <tr>
            <td>Hợp đồng muốn rút vốn:</td>
            <td><?php echo $rshdban->fields("name") ?></td>
          </tr>
           <tr>
            <td>Ngày mua trong HĐ:</td>
            <td><?php echo $rshdban->fields("date_create") ?></td>
          </tr>
           <tr>
            <td>Số lượng ĐVĐT:</td>
            <td><?php echo $rshdban->fields("model") ?></td>
          </tr>
           <tr>
            <td>Giá mua 1 ĐVĐT bình quân:</td>
            <td><?php echo number_format($rshdban->fields("price"), 0, '.', ',') ?>đ</td>
          </tr>
           <tr>
            <td>Tổng giá trị:</td>
            <td><?php echo number_format($rshdban->fields("price_old"), 0, '.', ',') ?>đ</td>
          </tr>
          
          <tr>
            <td colspan="2"><strong>Thông tin giao dịch</strong></td>
          </tr>
          <tr>
            <td>Ngày đặt lệnh:</td>
            <td><?php echo $rs->fields("date_create") ?></td>
          </tr>
           <tr>
            <td>Số lượng ĐVĐT bán:</td>
            <td><?php echo $rs->fields("model") ?></td>
          </tr>
          
           <tr>
            <td>Giá bán 1 ĐVĐT:</td>
            <td><?php if($giadvdtchot){ echo $giadvdtchot;}else{?>Giá ĐVĐT rút vốn là giá trị đóng cửa (sau 15h30) ngày thứ 5 hàng tuần<?php }?></td>
          </tr>
           <tr>
            <td>Tổng giá trị bán:</td>
            <td>#</td>
          </tr>
          <tr>
            <td>Lãi/Lỗ:</td>
            <td>#</td>
          </tr>
          <tr>
            <td>Phí hợp tác đầu tư:</td>
            <td>#</td>
          </tr>
          <tr>
            <td>Chi phí rút trước hạn:</td>
            <td>#</td>
          </tr>
          <tr>
            <td>Thuế thu nhập cá nhân:</td>
            <td>#</td>
          </tr>
          <tr>
            <td>Thực nhận:</td>
            <td>#</td>
          </tr>
        
          <tr>
            <td colspan="2">
            	<button class="button1" style="font-size:14px; color:#FFFFFF; background-color:#FF0000; border:2px solid #CCCCCC"><a  onclick="goDelete();" class="title" style="font-size:14px; color:#FFFFFF">Hủy giao dịch</a></button>
                <?php if($giadvdtchot){?>
                  <button class="button1"><a href="#" rel="modal:open" class="title" style="font-size:14px; color:#006633">Xác thực</a></button>
                 <?php }else{?> 
                  <button class="button1"  style="font-size:14px; color:#FFFFFF; background-color:#CCCCCC; border:2px solid #CCCCCC" title="chưa thể xác thực">Xác thực</button>
                <?php }?>
                 
            </td>
          </tr>	
</table>
</form>

<?php 
	$j++;
	$rs->MoveNext();
 }
 
?>
</div>
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
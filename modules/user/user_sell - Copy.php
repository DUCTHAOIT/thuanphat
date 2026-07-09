<?php

	
	global $db,$lang,$lable;
	$id = getParam("id");
	if(!$id) return;	
	$username=getSession("username");
	$sql="SELECT sys_userorder.*, DATE_FORMAT(sys_userorder.date_create, '".format_date()."') as date_create";
	$sql.=" FROM user, sys_userorder";
	$sql.=" WHERE (user.username = '$username') AND (user.id = sys_userorder.userid) AND (sys_userorder.ctrl&1=1) AND (sys_userorder.id='$id')";
	$rs=$db->Execute($sql);
	
	
?>
<style type="text/css">@import url(../js/jscalendar/calendar-win2k-1.css);</style>
<script type="text/javascript" src="<?php echo _DOMAIN_ROOT_URL?>/js/jscalendar/calendar.js"></script>
<script type="text/javascript" src="<?php echo _DOMAIN_ROOT_URL?>/js/jscalendar/lang/calendar-en.js"></script>
<script type="text/javascript" src="<?php echo _DOMAIN_ROOT_URL?>/js/jscalendar/calendar-setup.js"></script>
<form name="frmbookingRoom" action="#" method="post" enctype="multipart/form-data">

<input type="hidden" name="f" value="user_buy" />
<input type="hidden" name="op" value="add" />
<input type="hidden" name="m" value="booking" />
<input type="hidden" name="price" value="<?php echo $rs->fields("tel") ?>" />
<input type="hidden" name="proid" value="<?php echo $id;?>" />
<input type="hidden" name="tour" value="<?php echo $rs->fields("name") ?>" />
<input type="hidden" name="mavoucher" value="<?php echo $rs->fields("address") ?>" />


            
<div style="border-bottom:1px dotted #666666;">           
	<div class="topicContent">Quy trình rút vốn tại TSI</div>
    <div class="title">
    	<li>Chỉ được rút vốn (TSI chuyển lại cho NĐT tiền ) vào thứ 6 hàng tuần</li>
        <li>Giá ĐVĐT</li>
    </div>
</div>
<div  style="padding-top:10px">		
	<div class="topicContent"><h1>Thông tin giao dịch</h1></div> 
    <div class="row" style="border-bottom:1px dotted #666666;">
    	<div class="col-xs-12 col-sm-12 col-md-4 content" style="" >Mã HĐ:</div>
		<div class="col-xs-12 col-sm-12 col-md-8" style="padding:5px" ><?php echo $rs->fields("name") ?></div>
        <div class="col-xs-12 col-sm-12 col-md-4 content" style="" >Ngày mua trong HĐ:</div>
		<div class="col-xs-12 col-sm-12 col-md-8" style="padding:5px" ><?php echo $rs->fields("date_create") ?></div>
        <div class="col-xs-12 col-sm-12 col-md-4 content" style="" >Ngày bán:</div>
		<div class="col-xs-12 col-sm-12 col-md-8"  style="padding:5px"><input type="text" name="date" id="date" style="width:30%" class="text" value="" />&nbsp;
				<button id="btndate" style="height:20;">...</button>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-4 content" style="color:#FF0000" >Số lượng ĐVĐT bán:<font color="red">*</font></div>
        <div class="col-xs-12 col-sm-12 col-md-8"  style="padding:5px"><input id="price" type="text" style="width:50%" name="price" onchange="myFunction(document.frmbookingRoom)"/></div>
        <div class="col-xs-12 col-sm-12 col-md-12" id="lblCheckMailvoucher" ></div>
        
        <div class="col-xs-12 col-sm-12 col-md-4 content" style="" >Giá mua ĐVĐT trong HĐ:</div>
		<div class="col-xs-12 col-sm-12 col-md-8" style="padding:5px" ><?php echo number_format($rs->fields("price"), 0, '.', ',') ?>đ</div>
        
        <div class="col-xs-12 col-sm-12 col-md-4 content" style="" >Giá bán:</div>
		<div class="col-xs-12 col-sm-12 col-md-8" style="padding:5px" ><?php echo number_format($rs->fields("price"), 0, '.', ',') ?>đ</div>
        
        <div class="col-xs-12 col-sm-12 col-md-4 content" style="" >Tổng giá trị bán:</div>
		<div class="col-xs-12 col-sm-12 col-md-8" style="padding:5px" ><?php echo number_format($rs->fields("price"), 0, '.', ',') ?>đ</div>
        
        <div class="col-xs-12 col-sm-12 col-md-4 content" style="" >Lãi lỗ:</div>
		<div class="col-xs-12 col-sm-12 col-md-8" style="padding:5px" ><?php echo number_format($rs->fields("price"), 0, '.', ',') ?>đ</div>
        
        <div class="col-xs-12 col-sm-12 col-md-4 content" style="" >%:</div>
		<div class="col-xs-12 col-sm-12 col-md-8" style="padding:5px" ><?php echo number_format($rs->fields("price"), 0, '.', ',') ?>đ</div>
        
        <div class="col-xs-12 col-sm-12 col-md-4 content" style="" >Phí hợp tác đầu tư:</div>
		<div class="col-xs-12 col-sm-12 col-md-8" style="padding:5px" ><?php echo number_format($rs->fields("price"), 0, '.', ',') ?>đ</div>
        
        <div class="col-xs-12 col-sm-12 col-md-4 content" style="" >Chi phí rút trước hạn:</div>
		<div class="col-xs-12 col-sm-12 col-md-8" style="padding:5px" ><?php echo number_format($rs->fields("price"), 0, '.', ',') ?>đ</div>
        
        <div class="col-xs-12 col-sm-12 col-md-4 content" style="" >Thuế thu nhập cá nhân:</div>
		<div class="col-xs-12 col-sm-12 col-md-8" style="padding:5px" ><?php echo number_format($rs->fields("price"), 0, '.', ',') ?>đ</div>
        
        <div class="col-xs-12 col-sm-12 col-md-4 content" style="" >Thực nhận:</div>
		<div class="col-xs-12 col-sm-12 col-md-8" style="padding:5px; font-size:16px" ><?php echo number_format($rs->fields("price"), 0, '.', ',') ?>đ</div>
        
    </div>
    <div style="padding-top:20px; padding-bottom:20px;" class="row">
        
        <div class="col-xs-12 col-sm-12 col-md-4 content" style="" ></div> 
		<div class="col-xs-12 col-sm-12 col-md-8"  style="padding:5px"><input type="button" onclick="checkSendMail(document.frmbookingRoom);" value="Đặt mua" class="button" /></div>
        

        
        
        
    
    </div>
    
</div>
</form>
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
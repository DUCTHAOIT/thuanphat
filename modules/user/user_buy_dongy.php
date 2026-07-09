<?php
	global $db;
	$id = getParam("id");
	if(!$id) return;
	$sql="SELECT * FROM xuat_su WHERE id='$id'";
	$rs=$db->Execute($sql);
	
?>
<form name="frmbookingRoom" id="frmbookingRoom" action="#" method="post" enctype="multipart/form-data">
<input type="hidden" name="f" value="user_buy_add" />
<input type="hidden" name="m" value="user" />
<input type="hidden" name="giadvdt" value="<?php echo $rs->fields("giadvdt"); ?>" />
<input type="hidden" name="loai" value="<?php echo $rs->fields("type"); ?>" />

<div  style="padding-top:10px">		
	<div class="topicContent"><h1>Thông tin giao dịch</h1></div> 
    <div class="row" style="border-bottom:1px dotted #666666;">
    	
        <div class="col-xs-12 col-sm-12 col-md-4 title">Giá trị đăng ký mua:<font color="red">*</font></div>
        <div class="col-xs-12 col-sm-12 col-md-8"  style="padding:5px"><input id="giatri" type="text"  name="giatri" onkeyup="myFunction(document.frmbookingRoom)"/></div>
        <div class="col-xs-12 col-sm-12 col-md-4" style="" >Gía ĐVDT:</div> 
        <div class="col-xs-12 col-sm-12 col-md-8" ><?php echo $rs->fields("giadvdt"); ?></div>
        
        <div class="col-xs-12 col-sm-12 col-md-4 content" style="" >Số lượng ĐVĐT:</div> 
        <div class="col-xs-12 col-sm-12 col-md-8" id="lblCheckMailvoucher" ></div>
        
        
    </div>
    <div style="padding-top:20px; padding-bottom:20px; width:100%" class="row col-md-10">
        <div class="form-input col-md-12"><input type="checkbox" name="option" id="checkbox1" value="false"> Bạn đồng ý với các <a href="../lib/hdkhung-tsi.pdf" target="_blank">Điều khoản dịch vụ và hợp đồng hợp tác đầu tư</a> của TSI</div>
        <div class="col-xs-12 col-sm-12 col-md-4 content" style="" ></div> 
		<div class="col-xs-12 col-sm-12 col-md-8"  style="padding:5px"><input type="button" onclick="checkSendMail(document.frmbookingRoom);" value="Đặt mua" class="button" /></div>
    
    </div>
    
</div>
</form>

<script language="javascript" type="text/javascript">
$("#giatri").on('keyup', function(){
    var n = parseInt($(this).val().replace(/\D/g,''),10);
    $(this).val(n.toLocaleString());
});
function myFunction(f) {
		var obj;
			obj=document.frmbookingRoom;
			giatri=obj.giatri.value.replace(/([.])+/g, '');
			//alert(obj.soluong.value);
			
			url="../../?m=user&f=user_buy_calculator&giatri="+ giatri +"&giadvdt="+ obj.giadvdt.value +"/";
		
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
		
	
	giatri=obj.giatri.value.replace(/([.])+/g, '');
	
	
	if(giatri==""){
		alert("Bạn cần nhập số tiền muốn mua");
		obj.giatri.focus();
		return;
	}else if(giatri<10000000){
		alert("Giá trị mua tối thiểu phải là 10 triệu!");
		obj.giatri.focus();
		return;		
	}else if(obj.option.value=='false'){
		alert("Bạn cần đồng ý với các Điều khoản dịch vụ và hợp đồng hợp tác đầu tư của TSI!");
		obj.option.focus();
		return;	
	}else{
		obj.submit();					
	}
}
$('#checkbox-value').text($('#checkbox1').val());

$("#checkbox1").on('change', function() {
  if ($(this).is(':checked')) {
    $(this).attr('value', 'true');
  } else {
    $(this).attr('value', 'false');
  }
  
  $('#checkbox-value').text($('#checkbox1').val());
});

</script>

<script type="text/javascript">
$("form").bind("keypress", function (e) {
    if (e.keyCode == 13) {
        $("#button").attr('value');
        //add more buttons here
        return false;
    }
});
</script>
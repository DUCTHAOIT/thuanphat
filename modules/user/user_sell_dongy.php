<?php
	global $db,$lang,$lable;
	$id = getParam("id");
	$loai=getParam("loai");
	if(!$id) return;	
	$username=getSession("username");
	$sql="SELECT sys_userorder.*, DATE_FORMAT(sys_userorder.date_create, '".format_date()."') as date_create";
	$sql.=" FROM user, sys_userorder";
	$sql.=" WHERE (user.username = '$username') AND (user.id = sys_userorder.userid) AND (sys_userorder.ctrl&1=1) AND (sys_userorder.id='$id')";
	$rs=$db->Execute($sql);
	

?>
<div style="border-bottom:1px dotted #666666;">           
	<div class="topicContent">Quy trình rút vốn tại TSI</div>
    <div class="title">
    	<?php
			if($loai=='0'){ 
		?>
    	<li>Chỉ được rút vốn (TSI chuyển lại cho NĐT tiền ) vào thứ 6 hàng tuần</li>
        <li>Giá ĐVĐT rút vốn là giá trị đóng cửa (sau 15h30) ngày thứ 5 hàng tuần</li>
        <li>Nhà đầu tư phải thông báo đặt lệnh muộn nhất 1 ngày trước ngày rút vốn (nghĩa là muộn nhất trước ngày thứ 5 phải đặt lệnh)</li>
        <?php }else{ ?>
        <li>Giá ĐVĐT rút vốn là giá tại thời điểm NĐT đặt bán</li>
        <li>Sau khi lệnh bán được xác nhận, TSI sẽ chuyển tiền vào tài khoản NĐT đã đăng ký vào làm việc kế tiếp sau ngày NĐT đặt bán</li>
        <?php }?>
    </div>
</div>

<form name="frmbookingRoom" action="#" method="post" enctype="multipart/form-data">
<input type="hidden" name="f" value="user_sell_add" />
<input type="hidden" name="m" value="user" />
<input type="hidden" name="soluong" value="<?php echo $rs->fields("model"); ?>" />
<input type="hidden" name="id" value="<?php echo $rs->fields("id"); ?>" />
<input type="hidden" name="loai" value="<?php echo $rs->fields("loai"); ?>" />

<div  style="padding-top:10px">		
	<div class="topicContent"><h1>Thông tin giao dịch</h1></div> 
    <div class="row" style="border-bottom:1px dotted #666666;">
    	
        <div class="col-xs-12 col-sm-12 col-md-4 title">Hợp đồng:</div>
        <div class="col-xs-12 col-sm-12 col-md-8"  style="padding:5px" class="title"><?php echo $rs->fields("name"); ?></div>
        
        <div class="col-xs-12 col-sm-12 col-md-12" style="color:#FF0000" >Số lượng đơn vị bán không được phép vượt quá: <?php echo $rs->fields("model"); ?></div>
        <div class="col-xs-12 col-sm-12 col-md-4 title">Số lượng bán:<font color="red">*</font></div>
        <div class="col-xs-12 col-sm-12 col-md-8"  style="padding:5px"><input id="soluongban" type="text"  name="soluongban" value=""/> <input type="checkbox"  data-max="<?php echo $rs->fields("model"); ?>" id="checkbox_id"><label for="checkbox_id">(bán hết)</label></div>
        
        
    </div>
    <div style="padding-top:20px; padding-bottom:20px;" class="row">
        <div class="form-input"><input type="checkbox" name="option" id="checkbox1" value="false"> Bạn đồng ý với các <a href="../lib/hdkhung-tsi.pdf" target="_blank">Điều khoản dịch vụ và hợp đồng hợp tác đầu tư</a> của TSI</div>
        <div class="col-xs-12 col-sm-12 col-md-4 content" style="" ></div> 
		<div class="col-xs-12 col-sm-12 col-md-8"  style="padding:5px"><input type="button" onclick="checkSendMail(document.frmbookingRoom);" value="Đặt bán" class="button" /></div>
    
    </div>
    
</div>

<script>
    $("input[type='checkbox']").change(function () {
        //var min = $('input:checkbox:checked').map(function () { return $(this).data('min') }).get().sort(function (a, b) { return a - b });
        var max = $('input:checkbox:checked').map(function () { return $(this).data('max') }).get().sort(function (a, b) { return b - a });

        if (max.length) {
            //$("#price-min").val(min[0]);
            $("#soluongban").val(max[0]);
        } else {
            //$("#price-min").val(1);
            $("#soluongban").val(null);
        }
    });
</script>
</form>

<script language="javascript" type="text/javascript">
$("#soluongban").on('keyup', function(){
    var n = parseInt($(this).val().replace(/\D/g,''),10);
    $(this).val(n.toLocaleString());
});
function myFunction(f) {
		var obj;
			obj=document.frmbookingRoom;
			//alert(obj.soluong.value);
			soluongban=obj.soluongban.value.replace(/([.])+/g, '');
			url="../../?m=user&f=user_sell_calculator&soluongban="+ soluongban +"&soluong="+ obj.soluong.value +"/";
		
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
	//alert(obj.soluongban.value);
	soluongban=obj.soluongban.value.replace(/([.])+/g, '');
	
	if(soluongban==""){
		alert("Bạn cần nhập số lượng ĐVĐT muốn bán");
		obj.soluongban.focus();
		return;
	}else if( Number(soluongban) > Number(obj.soluong.value)){
		alert("Số lượng ĐVĐT muốn bán phải nhỏ hơn số lượng ĐVĐT của hợp đồng!");
		obj.soluongban.focus();
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
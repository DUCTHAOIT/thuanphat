<style>
	.modal {
		position: fixed;
		top: 5%;
		left: 0;
		z-index: 1050;
		display: none;
		width: 100%;
		height: 100%;
		overflow: hidden;
		outline: 0;
	}
</style>
<?php
	if(isset($_COOKIE['affiliate_id'])) {
	   $affiliate_id = $_COOKIE['affiliate_id'];
	}
	$sqluser="SELECT * FROM user WHERE (email='$affiliate_id')";	
	$rsuser=$db->Execute($sqluser);	
	$loaiuser=$rsuser->fields("loai");
	
	
	
	$id = $_POST['id'];
	global $db,$lang;
	$sql="SELECT * FROM sys_product WHERE (id='$id')";	
	$rs=$db->Execute($sql);	
	?>
<form name="frmDangky" id="frmDangky" action="#" method="post" enctype="multipart/form-data">   
<div class="container" style="padding:0px; padding-top:30px; padding-bottom:30px">
<div class="title col-xs-12 col-sm-12 col-md-12" style="padding-bottom:10px;"><?php echo $rs->fields("name");?></div>
	
        <div class="col-xs-12 col-sm-6 col-md-6">
                <input type="hidden" name="m" value="dangky" />
                <input type="hidden" name="op" value="dangky" />
                <input type="hidden" name="loaidt" value="1" />
                <input type="hidden" name="tenkhoahoc" value="<?php echo $rs->fields("name");?>" />
                <input type="hidden" name="datekhaigiang" value="<?php echo $rs->fields("delivery");?>" />
                <input type="hidden" name="diadiemhoc" value="<?php echo $rs->fields("product_in");?>" />
                
                <input type="hidden" name="price" value="<?php echo $rs->fields("price");?>" />
                <input type="hidden" name="price1" value="<?php echo $rs->fields("price1");?>" />
                <input type="hidden" name="price2" value="<?php echo $rs->fields("price2");?>" />
                
                <input type="hidden" name="idpro" value="<?php echo $rs->fields("id");?>" />
                <input type="hidden" name="nguoigioithieu" value="<?php echo $affiliate_id;?>" />
                
                <div><input  name="name" class="text"   id="inputName" style="width:100%" placeholder="Họ tên" /></div>
                <div><input  name="mobile" id="inputmobile" class="text" style="width:100%" placeholder="Điện thoại" /></div>
                <div><input placeholder="Email của bạn"  name="email" id="inputEmail" style="width:100%" class="text"></div>
           
                <div>
                    <select name="cosohoc" id="cosohoc" class="text" aria-label="Chọn cơ sở học">
                    <option selected="">Chọn cơ sở học</option>
                    <option value="Hà Nội">Hà Nội</option>
                    <option value="TP. Hồ Chí Minh">TP. Hồ Chí Minh</option>
                    <option value="Khu vực khác">Khu vực khác</option>
                    </select>
                </div>
                <div>
                    <textarea name="content" class="text" style="width:100%; height:90px" placeholder="Lời nhắn"></textarea>
                </div>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-6">
        <table width="100%" border="0" cellspacing="0" cellpadding="10">
          <tr>
            <td style="border-bottom: 0.5px solid #2fd7b3; padding-top:10px; padding-bottom:10px" nowrap="nowrap">Giá niêm yết:</td>
            <td style="border-bottom: 0.5px solid #2fd7b3; padding-top:10px; padding-bottom:10px" align="right"  class="title"><?php echo number_format($rs->fields("price"), 0, '.', ',');?>đ</td>
          </tr>
          <?php if($loaiuser>0){?>
          <tr>
            <td style="border-bottom: 0.5px solid #2fd7b3; padding-top:10px; padding-bottom:10px">Người giới thiệu:</td>
            <td style="border-bottom: 0.5px solid #2fd7b3; padding-top:10px; padding-bottom:10px" align="right" class="title"><?php echo $rsuser->fields("name");?></td>
          </tr>
          <tr>
            <td style="border-bottom: 0.5px solid #2fd7b3; padding-top:10px; padding-bottom:10px">Giá khuyến mại:</td>
            <td style="border-bottom: 0.5px solid #2fd7b3; padding-top:10px; padding-bottom:10px"  align="right"  class="title"><?php echo number_format($rs->fields("price".$loaiuser.""), 0, '.', ',');?>đ</td>
          </tr>
          <tr>
            <td style="padding-top:10px; padding-bottom:10px" class="title">Tổng:</td>
            <td  style="padding-top:10px; padding-bottom:10px; color:#FF6600; font-size:1.2rem" class="title" align="right"><?php echo number_format($rs->fields("price".$loaiuser.""), 0, '.', ',');?>đ</td>
          </tr>
          <input type="hidden" name="tong" value="<?php echo $rs->fields("price".$loaiuser."");?>" />
          <?php }else{?>
           <tr>
            <td style="border-bottom: 0.5px solid #2fd7b3; padding-top:10px; padding-bottom:10px">Mã Voucher</td>
            <td style="border-bottom: 0.5px solid #2fd7b3; padding-top:10px; padding-bottom:10px"  align="right"><input  name="voucher"  style="width:100%; text-align:right;" id="voucher" placeholder="Nhập Voucher" class="text" /></td>
          </tr>
           <tr>
            <td style="border-bottom: 0.5px solid #2fd7b3; padding-top:10px; padding-bottom:10px">Khuyến mại</td>
            <td style="border-bottom: 0.5px solid #2fd7b3; padding-top:10px; padding-bottom:10px" align="right"  id="kq_voucher"></td>
          </tr>
         
          <tr>
            <td style="padding-top:10px; padding-bottom:10px" class="title">Tổng</td>
            <td  style="padding-top:10px; padding-bottom:10px; color:#FF6600; font-size:1.2rem" class="title" align="right" id="addVoucher"><?php echo number_format($rs->fields("price"), 0, '.', ',');?>đ</td>
          </tr>
          <?php }?>
        </table>
        
         <div class="text-center" ><input type="button" class="btn btn-primary-dangky" value="Đăng ký ngay"  onclick="submitContactForm()" /></div>
        
    </div>
  
</div>
</form>	
<script>

function submitContactForm(){
    var reg = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
    var name = $('#inputName').val();
    var email = $('#inputEmail').val();
    var mobile = $('#inputmobile').val();
    if(name.trim() == '' ){
        alert('Bạn cần nhập họ tên!');
        $('#inputName').focus();
        return false;
	}else if(mobile.trim() == '' ){
        alert('Bạn cần nhập số điện thoại!');
        $('#inputmobile').focus();
        return false;	
    }else if(email.trim() == '' ){
        alert('Bạn cần nhập Email!');
        $('#inputEmail').focus();
        return false;
    }else if(email.trim() != '' && !reg.test(email)){
        alert('Địa chỉ Email không hợp lệ!');
        $('#inputEmail').focus();
        return false;
    
    }else{
        $('#frmDangky').submit();	
    }
}
</script>

<script language="javascript" type="text/javascript">

$('#voucher').change(function(){ 
	//alert('voucher');
  	//$("#kq_voucher").val($(this).val());
    var voucher=$(this).val();
	
	url="../../?m=dangky&f=kq_voucher&voucher="+ voucher +"";
	AjaxRequest.get(
		{
		'url':url
		,'onSuccess':function(req){document.getElementById('kq_voucher').innerHTML=req.responseText;}
		,'onError':function(req){}
		}					
	)
	
  	url="../../?m=dangky&f=voucher&voucher="+ voucher +"&price="+ <?php echo $rs->fields("price");?> +"";
	AjaxRequest.get(
		{
		'url':url
		,'onSuccess':function(req){document.getElementById('addVoucher').innerHTML=req.responseText;}
		,'onError':function(req){}
		}					
	)
});
</script>
    <?php
	//echo $response;
	//exit;
?>

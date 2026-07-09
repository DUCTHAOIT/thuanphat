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
	$id = $_POST['id'];
	global $db,$lang;
	$sql="SELECT * FROM sys_gopvon WHERE (id='$id')";	
	$rs=$db->Execute($sql);	
	?>
<form name="frmDangky" id="frmDangky" action="#" method="post" enctype="multipart/form-data">   
<div class="container" style="padding:0px; padding-top:10px; padding-bottom:30px">
<div class="title"><?php echo $rs->fields("name");?></div>
	
        <div class="col-xs-12 col-sm-6 col-md-6">
                <input type="hidden" name="m" value="dangky" />
                <input type="hidden" name="op" value="combo" />
                <input type="hidden" name="tenkhoahoc" value="<?php echo $rs->fields("name");?>" />
                <input type="hidden" name="datekhaigiang" value="<?php echo $rs->fields("delivery");?>" />
                <input type="hidden" name="diadiemhoc" value="<?php echo $rs->fields("product_in");?>" />
                
                <input type="hidden" name="price" value="<?php echo $rs->fields("price");?>" />
                <input type="hidden" name="khuyenmai" value="<?php echo $khuyenmai;?>" />
                <input type="hidden" name="voucher" value="<?php echo $voucher;?>" />
                <input type="hidden" name="idpro" value="<?php echo $rs->fields("id");?>" />
                <input type="hidden" name="nguoigioithieu" value="<?php echo $nguoigioithieu;?>" />
                
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
            <td style="border-bottom: 0.5px solid #2fd7b3; padding-top:10px; padding-bottom:10px" nowrap="nowrap">Giá niêm yết</td>
            <td style="border-bottom: 0.5px solid #2fd7b3; padding-top:10px; padding-bottom:10px" align="right"><?php echo number_format($rs->fields("price"), 0, '.', ',');?>đ</td>
          </tr>
          <tr>
            <td style="border-bottom: 0.5px solid #2fd7b3; padding-top:10px; padding-bottom:10px">Khuyến mại</td>
            <td style="border-bottom: 0.5px solid #2fd7b3; padding-top:10px; padding-bottom:10px" align="right"><?php echo number_format($rs->fields("khuyenmai"), 0, '.', ',');?>đ</td>
          </tr>
          <tr>
            <td style="border-bottom: 0.5px solid #2fd7b3; padding-top:10px; padding-bottom:10px">Mã Voucher</td>
            <td style="border-bottom: 0.5px solid #2fd7b3; padding-top:10px; padding-bottom:10px"  align="right"><?php echo $voucher;?></td>
          </tr>
          <tr>
            <td style="padding-top:10px; padding-bottom:10px" class="title">Tổng</td>
            <td  style="padding-top:10px; padding-bottom:10px; color:#FF6600; font-size:1.2rem" class="title" align="right"><?php echo number_format($rs->fields("price")-$khuyenmai, 0, '.', ',');?>đ</td>
          </tr>
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
    <?php
	//echo $response;
	//exit;
?>

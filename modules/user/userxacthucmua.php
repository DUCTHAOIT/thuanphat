<?php
function userxacthucmua(){
	global $db,$lang,$lable;	
	$username=getSession("username");
	if(!$username) return;
	$MemberName=getMemberNameID($username,"name");
	$MemberName=convert_name($MemberName);


	$sql="SELECT sys_userorder.*, DATE_FORMAT(sys_userorder.date_create, '".format_date()."') as date_create";
	$sql.=" FROM user, sys_userorder";
	$sql.=" WHERE (user.username = '$username') AND (user.id = sys_userorder.userid) AND (sys_userorder.tinh_trang=0) AND (sys_userorder.loai=0) AND (sys_userorder.ctrl=0)";
	$sql.=" ORDER BY sys_userorder.id DESC";
	//echo $sql;
	$rs=$db->Execute($sql);	
	if($rs->RecordCount()){	?>	
  
<div class="col-xs-12 col-sm-12 col-md-12">

<table width="100%" border="1" cellspacing="0" cellpadding="0" class="table" >
   
<?php
	$j=0;
	while(!$rs->EOF){	
?>
  <tr class="tr" style="background-color:#CCCCCC">
    <td align="center" style="width:16%">Hợp đồng</td>
    <td align="center" style="width:16%">Ngày đặt mua</td>
    <td align="center" style="width:16%">Giá trị đặt mua</td>
    <td align="center" style="width:16%">Giá mua 1 ĐVĐT</td>
    <td align="center" style="width:16%">Số lượng ĐVĐT đặt mua</td>
    <td align="center" >Trạng thái</td>
  </tr>
  <tr <?php if($j%2){?> bgcolor="#F4F4F4"<?php }?>>
    <td align="center" class="td" style="text-align: center; vertical-align: middle; font-size:13px"><?php echo $rs->fields("name") ?></td>
    <td align="center" class="td" style="text-align: center; vertical-align: middle; font-size:13px"><?php echo $rs->fields("date_create") ?></td>
    <td align="right" class="td" style="text-align: center; vertical-align: middle; font-size:13px"><?php echo number_format($rs->fields("price_old"), 0, '.', ',') ?></td>
    <td align="right" class="td" style="text-align: center; vertical-align: middle; font-size:13px"><?php echo number_format($rs->fields("price"), 0, '.', ',') ?></td>
    <td align="right" class="td" style="text-align: center; vertical-align: middle; font-size:13px"><?php echo number_format($rs->fields("model"), 0, '.', ',') ?></td>
    <td align="center" class="td" style="text-align: center; vertical-align: middle; font-size:13px"><?php if($rs->fields("ctrl")==0){ echo "<font  class=\"title\" style=\"color:#FF0000\">Đang thực hiện</font>";}else{ echo "<font  class=\"title\" style=\"color:#0000FF\">Đã hoàn thành</font>";} ?></td>
  </tr>
	 <tr>
        <td  colspan="6"><p><strong>Quý khách chuyển khoản cho TSI theo thông tin dưới để hoàn tất việc đặt mua</strong> </p></td>
      </tr>
      <tr>
        <td width="30%" colspan="2"><p>Tổng giá trị đầu tư (VNĐ):</p></td>
        <td width="70%" colspan="4"><p><?php echo number_format($rs->fields("price_old"), 0, '.', ',') ?></p></td>
      </tr>
      <tr>
        <td  colspan="2"><p>Tên chủ tài khoản:</p></td>
        <td  colspan="4"><p>Công ty cổ phần chứng khoán Tân Việt</p></td>
      </tr>
      <tr>
        <td colspan="2" rowspan="3"><p>Tại Ngân hàng:</p></td>
        <td colspan="2"><p id="p1" style="display:none">0011001954698</p><p><a onclick="copyToClipboard('p1')" title="Click để copy" style="cursor:pointer;">0011001954698 <i class="fa fa-files-o" aria-hidden="true" style="font-size:13px" ></i></a></p></td>
        <td  colspan="2" valign="top"><p>VCB - Hội sở chính</p></td>
      </tr>
      <tr>
        <td colspan="2"><p id="p2" style="display:none">12610000161365</p><p><a  onclick="copyToClipboard('p2')" title="Click để copy" style="cursor:pointer;">12610000161365 <i class="fa fa-files-o" aria-hidden="true" style="font-size:13px" ></i></a></p></td>
        <td colspan="2" valign="top"><p>BIDV - Chi nhánh Ba Đình</p></td>
      </tr>
      <tr>
        <td colspan="2"><p id="p3" style="display:none">0571102713009</p><p><a  onclick="copyToClipboard('p3')" title="Click để copy" style="cursor:pointer;">0571102713009 <i class="fa fa-files-o" aria-hidden="true" style="font-size:13px" ></i></a></p></td>
        <td  colspan="2" valign="top"><p>MBB - Chi nhánh Hoàn Kiếm</p></td>
      </tr>
      <tr>
        <td colspan="2"><p>Nội dung:</p></td>
        <td colspan="4"><p id="p4" style="display:none"><?php echo $MemberName;?> <?php echo $rs->fields("name") ?> nop tien vao tai khoan 8883686 cua CTCP Dau tu phat trien Thach Sanh</p><p><a onclick="copyToClipboard('p4')" title="Click để copy" style="cursor:pointer;"><?php echo $MemberName;?> <?php echo $rs->fields("name") ?> nop tien vao tai khoan 8883686 cua CTCP Dau tu phat trien Thach Sanh <i class="fa fa-files-o" aria-hidden="true" style="font-size:13px" ></i></a></p></td>
      </tr>
	<tr>
        <td  colspan="6" bgcolor="#FFFFFF">&nbsp;</td>
    </tr>

<?php 
	$j++;
	$rs->MoveNext();
 }
 
?>
</table>
<table border="1" cellspacing="0" cellpadding="0" width="100%">
  <tr>
    <td valign="top"><p>     Quý khách chuyển khoản (hoặc cung cấp sao kê đã chuyển khoản thành    công) trước 15h30’.<br>
        Sau thời điểm    này, các hợp đồng mà TSI chưa nhận được tiền (hoặc nhận được sao kê đã chuyển    khoản thành công) sẽ thực hiện theo giá ĐVĐT ngày hiện tại – theo đó, số    lượng ĐVĐT sẽ được điều chỉnh tương ứng.</p></td>
  </tr>
</table>

</div>
<?php 
	}
}
function convert_name($str) {
		$str = preg_replace("/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/", 'a', $str);
		$str = preg_replace("/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/", 'e', $str);
		$str = preg_replace("/(ì|í|ị|ỉ|ĩ)/", 'i', $str);
		$str = preg_replace("/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/", 'o', $str);
		$str = preg_replace("/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/", 'u', $str);
		$str = preg_replace("/(ỳ|ý|ỵ|ỷ|ỹ)/", 'y', $str);
		$str = preg_replace("/(đ)/", 'd', $str);
		$str = preg_replace("/(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)/", 'A', $str);
		$str = preg_replace("/(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)/", 'E', $str);
		$str = preg_replace("/(Ì|Í|Ị|Ỉ|Ĩ)/", 'I', $str);
		$str = preg_replace("/(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)/", 'O', $str);
		$str = preg_replace("/(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)/", 'U', $str);
		$str = preg_replace("/(Ỳ|Ý|Ỵ|Ỷ|Ỹ)/", 'Y', $str);
		$str = preg_replace("/(Đ)/", 'D', $str);
		$str = preg_replace("/(\“|\”|\‘|\’|\,|\!|\&|\;|\@|\#|\%|\~|\`|\=|\_|\'|\]|\[|\}|\{|\)|\(|\+|\^)/", '-', $str);
		//$str = preg_replace("/( )/", '-', $str);
		return $str;
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
function copyToClipboard(elementId) {

  // Create a "hidden" input
  var aux = document.createElement("input");

  // Assign it the value of the specified element
  aux.setAttribute("value", document.getElementById(elementId).innerHTML);

  // Append it to the body
  document.body.appendChild(aux);

  // Highlight its content
  aux.select();

  // Copy the highlighted text
  document.execCommand("copy");

  // Remove it from the body
  document.body.removeChild(aux);

}
</script>
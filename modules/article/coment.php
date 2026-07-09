<?php 
		$id  = getParam("id");
		
?>  
    <form name="frmFaqarticle" action="<?php echo _DOMAIN_ROOT_URL;?>/" method="post" enctype="multipart/form-data">
     <input type="hidden" name="m" value="article" />
    <input type="hidden" name="op" value="insertFaqarticle" />
    <input type="hidden" name="proid" value="<?php echo $id;?>" />
    <table width="100%" border="0" cellspacing="0" cellpadding="0">   
      <tr>       
        <td style="padding-right:10px"><input type="text" class="text" name="name" style="width:100%"  placeholder="Họ và tên"/></td>
        <td  style="padding-right:10px"><input type="text" class="text" name="address" style="width:100%" placeholder="Số điện thoại" /></td>      
        <td><input type="text" class="text" name="email" style="width:100%"  placeholder="Email"/></td>
      </tr>
   </table>
   <div style="height:5px"></div>
    <table width="100%" border="0" cellspacing="10" cellpadding="0" style="background-color:#f1f1f1">
      <tr>
        <td valign="top"><img src="<?php echo _DOMAIN_ROOT_URL;?>/theme_images/noavatar.png" width="60" /></td>
        <td width="100%"><textarea name="question" class="textarea" style="height:80px; width:100%; border:1px solid #CCCCCC"></textarea></td>
      </tr>
      <tr>        
        <td align="right" style="padding-top:5px">&nbsp;</td>
        <td align="right" style="padding-top:5px"> <input type="image"  onClick="checkSendMail(document.frmFaqarticle);" src="<?php echo _DOMAIN_ROOT_URL;?>/theme_images/binhluan.png"/></td>
      </tr>
    </table>
    </form>	
<script language="javascript" type="text/javascript">
function checkSendMail(f){
	var obj;
	obj=document.frmFaqarticle;
	if(obj.name.value==""){
		alert("Bạn cần nhập Tên");
		obj.name.focus();
		return;
	}else if(!isValidEmail(obj.email.value)){
		alert("Bạn cần nhập địa chỉ Email đúng quy cách!");
		obj.email.focus();
		return;	
	}else if(obj.question.value==""){
		alert("Bạn cần nhập ý kiến đánh giá");
		obj.question.focus();
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
    
<script language="javascript" type="text/javascript">
function test(value){
	alert("This rating's value is "+value);
}
$(function() {
	$("#rating_simple1").webwidget_rating_simple({
		rating_star_length: '5',
		rating_initial_value: '',
		rating_function_name: '',//this is function name for click
		directory: '<?php echo _DOMAIN_ROOT_URL;?>/js/Jquery-simple-rating-system-with-small-stars_files/'
	});
$("#rating_simple2").webwidget_rating_simple({
		rating_star_length: '5',
		rating_initial_value: '',
		rating_function_name: '',//this is function name for click
		directory: '<?php echo _DOMAIN_ROOT_URL;?>/js/Jquery-simple-rating-system-with-small-stars_files/'
	});
$("#rating_simple21").webwidget_rating_simple({
		rating_star_length: '5',
		rating_initial_value: '',
		rating_function_name: '',//this is function name for click
		directory: '<?php echo _DOMAIN_ROOT_URL;?>/js/Jquery-simple-rating-system-with-small-stars_files/'
	});
$("#rating_simple22").webwidget_rating_simple({
		rating_star_length: '5',
		rating_initial_value: '',
		rating_function_name: '',//this is function name for click
		directory: '<?php echo _DOMAIN_ROOT_URL;?>/js/Jquery-simple-rating-system-with-small-stars_files/'
	});												
$("#rating_simple3").webwidget_rating_simple({
		rating_star_length: '10',
		rating_initial_value: '4',
		rating_function_name: 'test',//this is function name for click
		directory: '<?php echo _DOMAIN_ROOT_URL;?>/js/Jquery-simple-rating-system-with-small-stars_files/'
	});
});
</script>

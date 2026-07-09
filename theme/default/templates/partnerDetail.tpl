{literal}
<style>
@media (max-width: 768px) {
  .hlvdetail {
    margin-top:-60px;	
  }
}  	
</style>
<script>
	$('#myModal').on('shown.bs.modal', function () {
	  $('#myInput').trigger('focus')
	})
</script>
  <script>
        $(document).ready(function() {
            $('li a').click(function() {
                $('a.active').removeClass("active");
                $(this).addClass("active");
            });
        });
    </script>
{/literal}

<section class="hlvbg">
<div class="container">
    <div class="row">
    	<div class="col-xs-12 col-sm-6 col-md-6" style="top:-80px;">
        	<img src="{$smarty.const._DOMAIN_ROOT_URL}/image.php?width=800&image={$smarty.const._DOMAIN_ROOT_URL}/images/partner/{$arr.img}" class="img-fluid"  alt="{$arr.name}" title="{$title}" border="0" vspace="0"  hspace="0" width="100%" />
        </div>
    	<div class="col-xs-12 col-sm-6 col-md-6 hlvdetail" style="padding-bottom:30px">
            	<h1 class="topic" style="margin-bottom:10px;">{$arr.name}</h1>
    			<div class="content" >{$arr.summary}</div>
                <div class="combo-line-left"></div>
            	<div>{$arr.content}</div>
        </div>
    </div>
</div>
</section>

<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Đăng ký: {$arr.name}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="padding-bottom:30px">
        <form name="frmContact" action="#" method="post" enctype="multipart/form-data">
        <input type="hidden" name="m" value="contact" />
        <input type="hidden" name="op" value="sendMail" />
        <input type="hidden" name="proid" value="1" />
        <input type="hidden" name="subject" value="Đăng ký khóa học BĐS: {$arr.name}" />
          <div class="row">  
            <div class="col-xs-12 col-sm-12 col-md-12" >
            	<div><input  name="name" class="text" style="width:100%" placeholder="Họ tên" /></div>
                <div><input  name="mobile" class="text" style="width:100%" placeholder="Điện thoại" /></div>
                <div><input placeholder="Email của bạn"  name="email" style="width:100%" class="text"></div>
            </div>
            
            <div class="col-xs-12 col-sm-12 col-md-12 text-center" ><input type="button" class="btn btn-primary" value="Đăng ký" onclick="checkSendMail(document.frmContact);"  /></div>
          </div>  
        </form>	
      </div>
    </div>
  </div>
</div>
{literal}
<script language="javascript" type="text/javascript">
function checkSendMail(f){
	var obj;
	obj=document.frmContact;
	if(obj.name.value==""){
		alert("Xin nhập họ và tên");
		obj.name.focus();
		return;	
	}else if(obj.mobile.value==""){
		alert("Xin nhập điện thoại");
		obj.mobile.focus();
		return;		
	}else if(isNaN(obj.mobile.value)){
		alert("Điện thoại chỉ được nhập số");
		obj.mobile.focus();
		return;	
	}else if(!isValidEmail(obj.email.value)){
		alert("Xin nhập địa chỉ Email");
		obj.email.focus();
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

{/literal}
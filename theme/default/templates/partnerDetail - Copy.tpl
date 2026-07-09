{literal}
<style>
	
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

<section class="text-center">
<div class="container" align="center">
	<div class="namefun text-center">{$nameFun}</div>
    <div class="des">
    	<h1 class="topiccontent">{$arr.name}</h1>
    	<div class="content" align="center" >{$arr.summary}</div>
    </div>
    <div class="row daotaobds notemb">
      
    	<ul class="tab nav">
        <li><a href="#content" class="active">Giới thiệu</a></li>
        <li><a  href="#loiich" >Lợi ích</a></li>
        <li><a  href="#ainenhoc" >Ai nên học</a></li>
        <li><a  href="#giangvien">Giảng viên</a></li>
        <li><a  href="#noidung">Nội dung khóa học</a></li>
        <li><a  href="#" data-toggle="modal" data-target="#exampleModalCenter">Đăng ký</a></li>
        </ul>
    </div>
    <div class="row">
    	<div class="col-xs-12 col-sm-9 col-md-9">
            <div>
            	<div class="titledaotao" id="content">Giới thiệu khóa học</div>
            	<div class="contentdaotao">{$arr.content}</div>
            </div>
            <div>
            	<div class="titledaotao" id="loiich">Lợi ích</div>
            	<div class="contentdaotao">{$arr.loiich}</div>
            </div>
            <div>
            	
                <div class="titledaotao" id="ainenhoc">Ai nên học</div>
            	<div class="contentdaotao">{$arr.ainenhoc}</div>
            </div>
            <div>
            	<div class="titledaotao" id="giangvien">Giảng viên</div>
            	<div class="contentdaotao">{$arr.giangvien}</div>
            </div>
             <div>
            	<div class="titledaotao" id="noidung">Nội dung khóa học</div>
            	<div class="contentdaotao">{$arr.noidung}</div>
            </div>
           
        </div>
        <div class="col-xs-12 col-sm-3 col-md-3" style="padding-bottom:30px">
        	<div class="room-sidebar">
                <div class="card">
                	<div class="titledaotao">Thông tin</div>
                	<div style="padding-top:20px">{$arr.thongtin}</div>
                </div>   
                
                <div class="card2">
                	{if $arr.uudai} 
                	<div class="titledaotao">Ưu đãi</div>
                	<div style="padding-top:20px">
                	{$arr.uudai}
                   {/if}
                   <div align="center"><button type="button" class="btn_viewmore1" data-toggle="modal" data-target="#exampleModalCenter">
  Đăng ký ngay
</button></div>
                    </div>
                </div>
                
                {if $arr.pdf}
                <div class="card3">
                	<div><a href="{$smarty.const._DOMAIN_ROOT_URL}/lib/{$arr.pdf}" target="_blank"><i class="fa fa-download" aria-hidden="true"></i> Tải tài liệu liên quan</a></div>
                </div>
                {/if}
    		</div>
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
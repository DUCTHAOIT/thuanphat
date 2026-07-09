<div class="container-fluid" style="padding:0px;">
    {advertise_footer}   
</div>
<div class="container-fluid" style="padding-top:30px;">
    <div class="row">{advertise_button}</div>     
</div>
</main>
<footer>
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-3 text-center" style="padding-bottom:20px;">
                  <div class="text-center"><center><a href=""><img src="{$smarty.const._DOMAIN_ROOT_URL}/theme_images/footer/logo.png" style="width:80%" alt=""></a></center></div>
                  <div style="padding-top:20px; text-align:center" >CTY CỔ PHẦN TM QUỐC TẾ THUẬN PHÁT</div>
                  <div class="text-center" style="padding-top:10px"><center>{weblink}</center></div>
            </div>
          <div class="col-xs-12 col-sm-12 col-md-3" style="padding-top:20px">
            <h4><strong>LIÊN HỆ</strong></h4>
            <div class="info">
                <p>{$address}</p>
            </div>
        </div>
            <div class="col-xs-12 col-sm-12 col-md-3" style="padding-top:20px; padding-bottom:20px; ">
           		{menu_button_default}
            </div>
            <div class="col-xs-12 col-sm-12 col-md-3"  style="padding-top:20px">
                            <h4><strong>Đăng kí nhận email</strong></h4>
                            <form name="dangkyemail" method="post" action="#" class="pr">
                            	<input type="hidden" name="m" value="newsletter" />
                                <input type="hidden" name="f" value="add" />
                                <input type="text"  name="email" placeholder="Nhập email của bạn..." style="color:#333333; outline: none; width:100%; border:0px; height:40px;  border-radius: 0.25rem;">
                                <input type="submit"  value="Đăng ký" style="width:100%; margin-top:5px; border:0px" class="btn_viewmore2" />	
                            </form>
            </div>
            
        </div>
        
    </div>
    <div class="row" style="border-top:1px solid #2fd7b3; margin-top:20px; padding:10px">
        <div class="container flex-lc" style="padding:10px">
            <div class="info" style="font-size:13px">Copyright © {$smarty.const._DOMAIN_ROOT_URL}</div>
            <button type="button" class="info flex-lc ml-auto"><a href="#" style="color:#FFFFFF; font-size:13px">Về đầu trang</a> <i class="icon icon-back"></i></button>
        </div>
    </div>
</footer>

<!-- Modal dang nhap-->
<div class="modal fade" id="exampleModalIn" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
    	
      <div class="modal-header" style="position:relative">
      	<div style="width:100%" align="center"><img src="{$smarty.const._DOMAIN_ROOT_URL}/theme_images/header/logo.png"  height="40px" alt=""></div>
        
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="position:absolute; top:10px; right:10px">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div align="center" style="padding-top:20px;">
      	<h1 class="titleBlock" style="text-transform:uppercase">Đăng nhập</h1>
        <p align="center">Đăng nhập để có trải nghiệm tốt nhất</p>
      </div>
      <div class="modal-body">
        <form name="loginForm" action="{$smarty.const._DOMAIN_ROOT_URL}/?m=user" method="post">
			<input type="hidden" name="op" value="login" />
            <input type="hidden" name="ret_page" value="{$ret_page}" />
            <input type="hidden" name="mName" value="{$moduleName}" />
            <input  type="submit" name="update" value=" Apply " 
    style="position: absolute; height: 0px; width: 0px; border: none; padding: 0px;"
    hidefocus="true" tabindex="-1"/>
            	
                <div ><input placeholder="Email hoặc số điện thoại của bạn" type="text" name="email" style="width:100%" class="text"></div>
                <div ><input placeholder="Mật khẩu" type="password" name="password" style="width:100%" class="text"></div>
                
                <div ><input type="button" value="Đăng nhập" class="btn btn-primary" onclick="checkInputloginForm();"/>	</div>
                <div style="padding:5px"><a href="#" class="content" data-toggle="modal" data-target="#exampleModalPass" data-dismiss="modal" >Quên mật khẩu</a> &nbsp;|&nbsp; <a href="#" class="content" data-toggle="modal" data-target="#exampleModalOut" data-dismiss="modal"> Đăng ký</a></div>
            </form>
      </div>
      <div class="modal-footer">
      </div>
    </div>
  </div>
</div>
{literal}
    <style>
        .waiting-overlay {
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: rgba(255,255,255,0.6);
            z-index: 9999;
            display: none;
            justify-content: center;
            align-items: center;
        }
    </style>
<script>
// When the user scrolls down 50px from the top of the document, resize the header's font size
window.onscroll = function() {scrollFunction()};
var header = document.getElementById("myHeader");
function scrollFunction() {
  if (document.body.scrollTop > 1 || document.documentElement.scrollTop > 1) {
    //document.getElementById("header").style.background = "#ffffff";
	//
	header.classList.add("scrollHeader");
	//alert("1111");
  } else {
	header.classList.remove("scrollHeader");
	//alert("222");
  }
}
</script>
<script language=javascript>
function checkInputloginForm(){
	var obj;
	obj=document.loginForm;
	if(!obj.email.value){
		alert("Bạn cần nhập Email hoặc số điện thoại!");
		obj.email.focus();
		return;
	}
	if(!obj.password.value){
		alert("Bạn cần nhập mật khẩu!");
		obj.password.focus();
		return;
	}else{		
		obj.submit();
	}
}
</script>

{/literal}


<!-- Modal dang ky-->
<div class="waiting-overlay" id="waitingOverlay">
    <i class="fas fa-spinner fa-spin fa-3x"></i>
</div>
<div class="modal fade" id="exampleModalOut" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header" style="position:relative">
                <div style="width:100%" align="center"><img src="{$smarty.const._DOMAIN_ROOT_URL}/theme_images/header/logo.png"  height="60px" alt=""></div>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="position:absolute; top:10px; right:10px">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div align="center" style="padding-top:20px;">
                <h1 class="titleBlock" style="text-transform:uppercase">Đăng Ký Thành Viên</h1>
            </div>
            <div class="modal-body">
                <form name="frmRegisterUser" action="{$smarty.const._DOMAIN_ROOT_URL}/?m=user" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="op" value="register" />
                    <input type="hidden" name="ret_page" value="{$ret_page}" />
                    <input type="hidden" name="mName" value="{$moduleName}" />
                    {*<input type="hidden" name="gioithieu" value="{$affiliate_id}" />*}

                    <div ><input placeholder="Họ và tên theo CMND có dấu" type="text" name="name" class="text" /></div>
                    <div ><input placeholder="Email của bạn" type="text" name="txtEmail" class="text" onchange="isValidEmail(document.frmRegisterUser.txtEmail.value)" /></div>

                    <div><input placeholder="Điện thoại" type="text" name="mobile" id="mobile" class="text"  onchange="isValidmobile(document.frmRegisterUser.mobile.value)" /></div>
                    <div ><input placeholder="Mật khẩu" type="password" name="txtPassword" class="text" /></div>
                    <div ><input placeholder="Nhập lại mật khẩu" type="password" name="txtEnterPassword" class="text" /></div>
                    {if $affiliate_id}
                        <input type="hidden" name="gioithieu" value="{$affiliate_id}" />
                        <div><input placeholder="Mã giới thiệu" readonly value="Người giới thiệu: {$tennguoigiothieu}" type="text" name="nguoigioithieu" class="text" /></div>
                    {else}
                        <div>
                            <input placeholder="Mã giới thiệu (số điện thoại của tài khoản giới thiệu)" type="text" name="gioithieu" class="text"
                                   onchange="checkReferralCodePopup(this.value)" />
                            <label id="lblReferral" style="font-size:11px;"></label>
                        </div>
                    {/if}
                    {*<div ><input placeholder="Mã giới thiệu (số điện thoại của tài khoản giới thiệu)" value="{$affiliate_id}" type="text" name="gioithieu" class="text" /></div>*}
                    <div ><input type="checkbox" id="myCheck" name="option" onclick="myFunction()" value="false">
                        <label for="myCheck" style="cursor:pointer" >Đồng ý với <a href="{$smarty.const._DOMAIN_ROOT_URL}/lib/dieukhoan-hopdong.pdf" target="_blank">Điều khoản và điều kiện hợp đồng đại lý</a></label></div>

                    <div ><input type="button" value="Đăng ký" id="submitBtn" class="btn btn-primary" onclick="checkRegisterUser()" />	</div>
                    <div><a href="#" class="content" data-toggle="modal" data-target="#exampleModalPass" data-dismiss="modal" >Quên mật khẩu</a> &nbsp;|&nbsp; <a href="#" class="content" data-toggle="modal" data-target="#exampleModalIn" data-dismiss="modal"> Đăng nhập</a></div>
                    <label id="lblCheckMail" style="font-size:11px; color:#FF0000"><input type="hidden" name="checkMail" id="checkMail" value="0" /></label><br />
                    <label id="lblCheckmobile" style="font-size:11px; color:#FF0000"><input type="hidden" name="checkmobile" id="checkmobile" value="0" /></label>
                </form>
            </div>
        </div>
    </div>
</div>
{literal}
    <script language="javascript" type="text/javascript">
        var isReferralValidPopup = true; // Mặc định cho phép submit nếu không nhập mã

        function checkReferralCodePopup(code) {
            var submitBtnPopup = document.getElementById('submitBtn');
            if (code.trim() === '') {
                document.getElementById('lblReferral').innerHTML = '';
                isReferralValidPopup = true; // Không nhập mã thì coi như hợp lệ
                submitBtnPopup.disabled = false;
                return;
            }

            var url = "../../?m=user&f=checkreferral&code=" + encodeURIComponent(code);

            AjaxRequest.get({
                'url': url,
                'onSuccess': function (req) {
                    var res = JSON.parse(req.responseText);
                    if (res.status === 'ok') {
                        document.getElementById('lblReferral').innerHTML = '<span style="color:green">Người giới thiệu: ' + res.name + '</span>';
                        isReferralValidPopup = true;
                        submitBtnPopup.disabled = false;
                    } else {
                        document.getElementById('lblReferral').innerHTML = '<span style="color:red">Mã giới thiệu không tồn tại!</span>';
                        isReferralValidPopup = false;
                        submitBtnPopup.disabled = true;
                    }
                },
                'onError': function () {
                    document.getElementById('lblReferral').innerHTML = '<span style="color:red">Lỗi kết nối!</span>';
                    isReferralValidPopup = false;
                    submitBtnPopup.disabled = true;
                }
            });
        }

        function getval(sel)
        {
            //alert(sel.value);
            if(sel.value == 1){
                $('#doanhnghiep').hide();
            }else{
                $('#doanhnghiep').show();
            }
        }
        function isValidEmail(str) {
            if(str.indexOf("@") > 0){
                //document.getElementById('lbl_email').innerHTML = "<img src=\"images/check.gif\" />";
                //
                var url;
                url="/?m=user&f=checkMail&mail="+str;
                //alert(url);
                AjaxRequest.get(
                    {
                        'url':url
                        ,'onSuccess':function(req){document.getElementById('lblCheckMail').innerHTML=req.responseText;}
                        ,'onError':function(req){}
                    }
                )
                return true;
            }
            else{
                //document.getElementById('lbl_email').innerHTML = "<img src=\"images/not_check.gif\" />";
                return false;
            }
        }
        ///
        function isValidmobile(str) {
            var url;
            url="../../?m=user&f=checkmobile&mobile="+str;
            //alert(url);
            AjaxRequest.get(
                {
                    'url':url
                    ,'onSuccess':function(req){document.getElementById('lblCheckmobile').innerHTML=req.responseText;}
                    ,'onError':function(req){}
                }
            )
            return true;
        }
        ///
        function checkRegisterUser(){
            var obj;
            obj=document.frmRegisterUser;
            //var response = grecaptcha.getResponse();
            //alert(obj.option.value);
            if(!obj.name.value){
                alert("Bạn cần nhập họ tên!");
                obj.name.focus();
                return;
            }else if(!isValidEmail(obj.txtEmail.value)){
                alert("Bạn cần nhập Email!");
                obj.txtEmail.focus();
                return;
            }else if(obj.checkMail.value==1){
                alert("Địa chỉ Email này đã được đăng ký!");
                obj.txtEmail.focus();
                return;
            }else if(!obj.mobile.value){
                alert("Bạn cần nhập số điện thoại!");
                obj.mobile.focus();
                return;
            }else if(!isValidmobile(obj.mobile.value)){
                alert("Bạn cần nhập số điện thoại đúng quy cách!");
                obj.mobile.focus();
                return;
            }else if(obj.checkmobile.value==1){
                alert("Số điện thoại này đã được đăng ký!");
                obj.mobile.focus();
                return;
            }else if(obj.txtPassword.value != obj.txtEnterPassword.value || obj.txtPassword.value.length < 6 ) {
                //alert(obj.txtPassword.value.length);
                alert("Mật khẩu phải từ 6 ký tự trở lên");
                obj.txtPassword.focus();
                return;
            // ✅ Kiểm tra mã giới thiệu
            }else if (!isReferralValidPopup) {
                alert("Mã giới thiệu không hợp lệ!");
                obj.gioithieu.focus();
                return;
            }else if(obj.option.value=='false'){
                alert("Bạn cần Đồng ý với Chính sách & Bảo mật!");
                obj.option.focus();
                return;
                //}else if(response.length == 0){
                //	alert("Bạn cần check captcha");
                //	return;
            }else{
                document.getElementById('waitingOverlay').style.display = 'flex';
                const btn = document.getElementById('submitBtn');
                btn.disabled = true;
                btn.value = 'Đang xử lý...';

                obj.submit();
            }
        }
    </script>
    <script>
        function validatePhone2(field, alerttext) {
            if (field.match(/^\d{10}/)) {
                return true;
            }
            alert(alerttext);
            return false;
        }
        function validatePhone(field) {

            if(field.value.length > 10) {
                //alert(alerttext);
                return false;
            }
            for(i = 0; i < field.value.length; i++) {
                if(parseInt(field.value[i]) == NaN) {
                    //alert(alerttxt);
                    return false;
                }
            }
            return true;
        }

        function myFunction() {
            // Get the checkbox
            var checkBox = document.getElementById("myCheck");
            // Get the output text
            // If the checkbox is checked, display the output text
            if (checkBox.checked == true){
                $("#myCheck").attr('value', 'true');
            } else {
                $("#myCheck").attr('value', 'false');
            }
        }
</script>
{/literal}
<!-- Modal quen pass-->
<div class="modal fade" id="exampleModalPass" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
    	<div class="modal-header" style="position:relative">
      	<div style="width:100%" align="center"><img src="{$smarty.const._DOMAIN_ROOT_URL}/theme_images/header/logo.png"  height="40px" alt=""></div>
        
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="position:absolute; top:10px; right:10px">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div align="center" style="padding-top:20px;">
      	<h1 class="titleBlock" style="text-transform:uppercase">Lấy lại mật khẩu</h1>
      </div>
    
      <div class="modal-body">
        <form name="frmForgetUser" action="#" method="post" enctype="multipart/form-data">
			<input type="hidden" name="m" value="user" />
            <input type="hidden" name="op" value="randPasword" />
                <div><input placeholder="Email của bạn" type="text" name="txtEmail" class="text" /></div>
                <div><input type="button" value="Xác nhận" class="btn btn-primary" id="quenpass" onclick="checkForgetUser()" />	</div>
            </form>
      </div>
      <div class="modal-footer">
      </div>
    </div>
  </div>
</div>
{literal}
<script language="javascript" type="text/javascript">
function checkForgetUser(){
	var obj;
	obj=document.frmForgetUser;
	if(!isValidEmail(obj.txtEmail.value)){
		alert("Email!");
		obj.txtEmail.focus();
		return;	
	}else{
        document.getElementById('waitingOverlay').style.display = 'flex';
        const btn = document.getElementById('quenpass');
        btn.disabled = true;
        btn.value = 'Đang xử lý...';

		obj.submit();
	}
}
</script>
{/literal}


<!-- Modal -->
<div class="modal fade" id="myModalDangkyKhoahocShow" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" style="position:absolute; top:0px; right:8px; z-index:9999">&times;</button>
           
            <div class="modal-body-dangky">
               
            </div>
           
        </div>
      
    </div>
</div>
{literal}
<script type='text/javascript' src='https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js?ver=5.3.11'></script>

<script>
// Lấy ID affiliate từ cookie và thêm vào các liên kết
var affiliate_id = getCookie('affiliate_id');
if(!affiliate_id){
	//alert('xxx');
}else{	
	const links = document.querySelectorAll(".aff");
	//var links = document.getElementsByTagName('a');
	for (var i = 0; i < links.length; i++) {
		var href = links[i].getAttribute('href');
		links[i].setAttribute('href', href + '&aff=' + affiliate_id);
	}	
}
// Hàm lấy giá trị cookie
function getCookie(name) {
	var value = "; " + document.cookie;
	var parts = value.split("; " + name + "=");
	if (parts.length == 2) return parts.pop().split(";").shift();
}	

/*
const nodeList = document.querySelectorAll("a[class]");
for (let i = 0; i < nodeList.length; i++) {
	var href = nodeList[i].getAttribute('href');
    nodeList[i].setAttribute('href', href + '&value=100');
}
*/
</script>
{/literal}
</body>
</html>
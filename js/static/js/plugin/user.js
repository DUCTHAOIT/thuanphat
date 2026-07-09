/**
 * Created with JetBrains PhpStorm.
 * User: truonghm
 * Date: 3/28/13
 * Time: 4:33 PM
 * To change this template use File | Settings | File Templates.
 */

var user = {
    register:{
        validate:function(){
            email = $('#email');
            password = $('#password');
            confirmpassword = $('#confirmpassword');
            fullname = $('#fullname');
            mobile = $('#mobile');
            captcha = $('#captcha');

            this.message('');
            if(!core.notEmpty(email)){
                this.message("Vui lòng nhập email!");
                return;
            }else if(!core.emailValidator(email)){
                this.message("Email không đúng định dạng!");
                return
            }else if(!core.notEmpty(password)){
                this.message("Vui lòng nhập mật khẩu đăng nhập!");
                return;
            }else if(!core.notEmpty(password)){
                this.message("Vui lòng nhập mật khẩu đăng nhập!");
                return;
            }else if(password.val().length < 6){
                this.message("Mật khẩu tối thiểu 6 ký tự!");
                password.focus();
                return;
            }else if(!core.notEmpty(confirmpassword)){
                this.message("Vui lòng xác nhận lại mật khẩu!");
                return;
            }else if(password.val() != confirmpassword.val()){
                this.message("Mật khẩu xác nhận không đúng!");
                confirmpassword.focus();
                return;
            }else if(!core.notEmpty(fullname)){
                this.message("Vui lòng nhập họ tên đầy đủ của bạn!");
                return;
            }else if(!this.mobile(mobile)){
                this.message("Vui lòng cung cấp đúng số điện thoại!");
                mobile.focus();
                return;
            }else if(!core.notEmpty(captcha)){
                this.message("Vui lòng nhập mã xác nhận!");
                return;
            }else  if(!$('#chk').is(':checked')){
                this.message("Vui lòng chấp nhận các điều khoản & quy định của thegiamgia.vn");
            }else{
                this.message('Vui lòng chờ trong giây lát...!');
                this.submit();
            }
        },
        submit:function(){
            $('#btnRegister').attr("disabled", "disabled");
            var data = new Object();
            $(".rigister-main :input").each(function(){
                data[$(this).attr('name')] = $(this).val();
            });

            $.ajax({
                type: "POST",
                url: "/dang-ky/",
                data: data,
                dataType: 'json'
            }).done(function(msg) {
                $('#register-message').html('');
                if(msg.success){
                    window.location.href = window.location;
                }else{
                    alert(msg.msg);
                    $('#btnRegister').removeAttr("disabled");
                }
            });
        },
        message:function(msg){
            $('#register-message').html(msg);
        },
        mobile:function(mobileObj){
            if(mobileObj.val().length < 8) return false;
            if(!isNumeric(mobileObj)) return false;
            return true;
        },
        regChk:function(){
            if($('#chk').is(':checked'))
                $('#chk').attr('checked', false);
            else
                $('#chk').attr('checked', true);
        }

    },
    confirmation: {
        validate: function(){
            objDisplayName = $('#displayName');
            objProvince = $('#province');
            objDistrict = $('#district');
            objAddressDetail = $('#addressDetail');

            if(!core.notEmpty(objDisplayName)){
                this.message("Vui lòng nhập tên hiển thị!",false)
                return null;
            }else if(!core.notEmpty(objAddressDetail)){
                this.message("Vui lòng nhập địa chỉ nơi bạn đang ở!",false)
                return null;
            }else{
                this.message('Vui lòng chờ trong giây lát...!',true);
                this.submit();
            }
        },
        message:function(msg,status){
            if(status==false)
                $('#update-message').css({"color":"red"})
            else
                $('#update-message').css({"color":"blue"})

            $('#update-message').html(msg);
        },
        submit:function(){
            $('#confirmation').attr("disabled", "disabled");
            var data = new Object();
            $("#userInfo :input").each(function(){
                data[$(this).attr('name')] = $(this).val();
            });

            $.ajax({
                type: "POST",
                url: "/cap-nhat-thong-tin-thanh-vien/",
                data: data,
                dataType: 'json'
            }).done(function(msg) {
                //$('#register-message').html('');
                    user.confirmation.message('',true);
                if(msg.success){
                    //window.location.href = window.location;
                    alert('aa');
                }else{
                    alert(msg.msg);
                    $('#confirmation').removeAttr("disabled");
                }
            });
        }
    }

}
<?php 
	function usermenu2(){
	global $db,$lang,$lable;		
	$username=getSession("username");
	$MemberName=getMemberNameID($username,"name");
	$MemberEmail=getMemberNameID($username,"username");
	$Membermobile=getMemberNameID($username,"mobile");
	$Memberloai=getMemberNameID($username,"loai");
	$MemberHlv=getMemberNameID($username,"permit");
    $MemberAvatar=getMemberNameID($username,"avata");

	
?>

<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

<style type="text/css">

    * {

        margin: 0;

        box-sizing: border-box;

    }



    .avatar .camera {

        display: none;

    }



    .avatar:hover .camera {

        display: block;

    }

</style>
<div style="padding-top: 40px">
    <div style="text-align: center; position:relative">


        <form role="form" id="avatarForm" method="post" enctype="multipart/form-data">

            <input type="hidden" name="code" value="DSAFDSGFDGGFHFJ45245345^GFDGGSDFGDSDSFFHHQACFBHJGPOIUJ">

            <label class="avatar" for="uploadAvatar" style="display: inline-block; position: relative; overflow: hidden; width: 120px; height: 120px; border-radius: 50%; background-color: #f6f6f6; cursor: pointer">



            <span class="embed-avatar" style="display: block; width: 100%; height: 100%; display: block; position: absolute; top: 0; left: 0;">

                <?php if($MemberAvatar){?>

                    <span class="img-avatar img-avatar-lg bg" style="display: block; width: 100%; height: 100%; background: url('<?php echo _DOMAIN_ROOT_URL;?>/modules/avatar/images/<?php echo $MemberAvatar;?>') no-repeat center; background-size: 100% 100%;"></span>

                <?php }else{?>

                    <span class="img-avatar img-avatar-lg bg" style="display: block; width: 100%; height: 100%; background: url('<?php echo _DOMAIN_ROOT_URL;?>/modules/avatar/images/default-avatar.png') no-repeat center; background-size: 100% 100%;"></span>

                <?php }?>

            </span>

                <span class="camera" style="width: 100%;height: 100%;z-index: 9999;text-align: center;position: absolute;top: 0;left: 0;background: #F0F0F0;opacity: 0.5;padding: 0;padding-top: 43%;">

                <i class="fa fa-camera" style="color: blueviolet"></i>

            </span>

                <input type="file" name="uploadAvatar" id="uploadAvatar" class="upload-avatar" accept="image/*" style="display: none;">

            </label>

        </form>

    </div>
</div>


    <script>

        $(function () {

            $("input[name='uploadAvatar']").change(function () {

                if (this.files.length > 0) {

                    if (!window.FormData) {

                        alert("Your browse does not support FormData object.");

                        return false;

                    }

                    //console.log(this.form); return;



                    $.ajax({

                        url: "../?m=avatar&f=upload",

                        method: 'POST',

                        dataType: 'json',

                        data: new FormData(this.form),

                        contentType: false,

                        processData: false,

                        beforeSend: function () {

                            //

                        },

                        success: function (data) {

                            if (data['status'] === 'ok') {

                                var uploaded_url = data['uploaded_url'];

                                $(".avatar .embed-avatar .img-avatar").css({"background-image": "url('" + uploaded_url + "')"});

                            }

                        },

                        complete: function () {

                            //

                        },

                        error: function () {

                            //

                        }

                    });

                }

            });

        });

    </script>
<div style="padding-top:10px; text-align: center">
        <font class="title" style="text-transform: uppercase"><?php echo $MemberName; ?></font>
        <p><?php echo $NameMemberloai; ?></p>
        <p><a href="<?php echo _DOMAIN_ROOT_URL;?>/vn/chuong-trinh-afiiliate/" style="color:#990000; font-size:12px">Tìm hiểu quyền lợi Affiliate (tiếp thị liên kết).</a></p>

</div>
<div class="notemb">
<div class="card3">
	<div id="menuuser">
       <ul>
           <li><a href="<?php echo _DOMAIN_ROOT_URL;?>/user_dashboard/"><i class="fa fa-users" aria-hidden="true"></i> Thống kê</a></li>
           <li><a href="<?php echo _DOMAIN_ROOT_URL;?>/user_iMember/" ><i class="fa fa-user-circle" aria-hidden="true"></i> Quản lý tài khoản</a></li>
           <li><a href="<?php echo _DOMAIN_ROOT_URL;?>/change_password/" ><i class="fa fa-unlock-alt" aria-hidden="true"></i> Đổi mật khẩu</a></li>
           <li><a href="<?php echo _DOMAIN_ROOT_URL;?>/?m=user&op=logout"><i class="fa fa-sign-out" aria-hidden="true"></i> Đăng xuất</a></li>
       </ul>
    </div>
</div>
</div>

<div class="card2" style="margin-top:20px;">
                
    <p id="p1" style="display:none"><?php echo _DOMAIN_ROOT_URL;?>/user/<?php echo $Membermobile;?></p>
    <p style="cursor:pointer; font-size:12px;"><button id="btn_view_more"><a href="#" onclick="copyToClipboard('p1')" title="Click để copy" style="cursor:pointer; font-size:12px;">Click vào đây để copy link giới thiệu <i class="fa fa-clone" aria-hidden="true"></i></a></button></p><font style="font-size:12px;"><?php echo _DOMAIN_ROOT_URL;?>/user/<?php echo $Membermobile;?></font>
     <p style="font-size:12px;">Quyền lợi người giới thiệu: <button> <a href="<?php echo _DOMAIN_ROOT_URL;?>/vn/chuong-trinh-afiiliate/" target="_blank"  style="color:#FF0000">Xem </a></button></p>
     
</div>
<script>
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
<script>
jQuery(document).ready(function($) {

	  //toggle move less on product.
	  $(document).on('click', '#btn_view_more', function (e) {
		  e.preventDefault();
		  if ($('.data-des').hasClass('on')) {
			  $('.data-des').removeClass('on');
			  $(this).text('copy link giới thiệu');
		  } else {
			  $('.data-des').addClass('on');
			  $(this).text('Đã copy link giới thiệu');
		  }
		});

	});
</script>   
<?php 
	}
?>  
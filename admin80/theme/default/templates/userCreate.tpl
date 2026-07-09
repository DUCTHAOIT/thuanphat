{literal}
    <script language="javascript" type="text/javascript">
        function checkInput(){
            var obj;

            obj=document.frmCreateMember;

            if(!obj.txtPassword.value){
                alert("Mật khẩu !");
                obj.txtEmail.focus();
                return;
            }
            if(!obj.txtEnterPassword.value){
                alert("Nhập lại mật khẩu!");
                obj.firstname.focus();
                return;
            }
            if(obj.txtPassword.value != obj.txtEnterPassword.value || obj.txtPassword.value.length < 6 ){
                //alert(obj.txtPassword.value.length);
                alert("Mật khẩu nhập lại không khớp");
                obj.txtPassword.focus();
                return;
            }
            else{
                obj.submit();
            }
        }
    </script>
{/literal}
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td bgcolor="#FFFFFF">
            <form name="frmCreateMember" action="?m=user" method="post" enctype="multipart/form-data">
                <input type="hidden" name="op" value="changepass" />
                <input type="hidden" name="id" value="{$arr.id}" />
                <TABLE WIDTH=582 BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0>
                    <TR>
                        <TD style="background-image:url({$smarty.const._DOMAIN_ROOT_URL}/theme_images/block_register_02.gif); background-repeat:repeat-x; padding-top:20px; color:#993300"><strong>Đổi mật khẩu tài khoản {$arr.name}</strong></TD>
                    </TR>
                    <TR>
                        <TD width="100%" style="padding-top:20px; padding-bottom:20px"><table width="100%" border="0" cellspacing="0" cellpadding="0">

                                <tr>
                                    <td style="padding-right:10px; padding-left:10px; padding-bottom:10px;" nowrap="nowrap">Nhập mật khẩu <label style="color:#FF0000">*</label></td>
                                    <td><input type="password" name="txtPassword" class="text" /></td>
                                </tr>
                                <tr>
                                    <td style="padding-right:10px; padding-left:10px; padding-bottom:10px;" nowrap="nowrap">Nhập lại mật khẩu <label style="color:#FF0000">*</label></td>
                                    <td><input type="password" name="txtEnterPassword" class="text" /></td>
                                </tr>

                                <tr>
                                    <td style="padding-right:10px; padding-left:10px" nowrap="nowrap">&nbsp;</td>
                                    <td><input type="button" value="Xác nhận" class="button" onclick="checkInput()" /></td>
                                </tr>
                            </table></TD>
                    </TR>

                </TABLE>
            </form></td>
    </tr>
</table>
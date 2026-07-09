/**
 * Created with JetBrains PhpStorm.
 * User: Truonghm
 * Date: 3/29/13
 * Time: 9:59 AM
 * To change this template use File | Settings | File Templates.
 */
var message = {
    conf:{
        x:0
    },
    validate:function(un){
        content=$('#message').val();
        if(!content) return;
        $("#show_message").css({"color":"blue"});
        $("#show_message").html('Đang thực hiện...');
        $.ajax({
            type: "POST",
            url: "/gui-tin-nhan/",
            data: {"msg":content,"un":un},
            dataType: "json",
            success: function(result) {
                if(result.success){

                    var obj = jQuery.parseJSON(result.data);

                    dMain=document.createElement('div');
                    $(dMain).css({"clear": "both","padding-top":"10px"})

                    dAvatar=document.createElement('div');
                    $(dAvatar).css({"float": "left", "margin-right": "5px"})
                             .html('<img width="30px;" height="30px" src="'+obj.avatar+'">');

                    dInfo=document.createElement('div');
                    $(dInfo).css({"color": "#0453C8"})
                        .html('<b>'+obj.display_name+'</b> &nbsp;<span style="color:#ccc; font-size:11px">['+ obj.time+']</span>');

                    dContent=document.createElement('div');
                    $(dContent).html(obj.content);

                    if(message.conf.x ==0){
                        $(dMain).append(dAvatar,dInfo,dContent);
                        message.conf.x = 1;
                    }
                    else{
                        $(dContent).css({"margin-left": "35px"})
                        $(dMain).append(dContent);
                    }

                    $('#message_item').append(dMain);

                    $("#show_message").css({"color":"#ccc"});
                    $("#show_message").html('Nhấn enter để gửi tiếp');
                    $('#message_container').nanoScroller({scroll: 'bottom'});
                    $('#message').val('');

                }else{
                    $("#show_message").html(result.message);
                }
            }
        });
    }
}
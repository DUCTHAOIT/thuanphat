/**
 * Created with JetBrains PhpStorm.
 * User: Truonghm
 * Date: 3/29/13
 * Time: 9:59 AM
 * To change this template use File | Settings | File Templates.
 */

$(document).ready(function() {
    core.checkOnlineSkype();
    core.getOnlineNumber();
    if ( ($(window).height() + 100) < $(document).height() ) {
        $('#top-link-block').removeClass('hidden').affix({
            // how far to scroll down before link "slides" into view
            offset: {top:100}
        });
    }
})

var core = {
    captchaRefresh:function(imgId){
        document.getElementById(imgId).src="/common/captcha/?rnd=" + Math.random();
    },
    notEmpty: function(elem){
        if(elem.val() == 0 || elem.val()==null){
            elem.focus();
            return false;
        }
        return true;
    },
    isNumeric: function(elem){
        var numericExpression = /^[0-9]+$/;
        if(elem.val().match(numericExpression)){
            return true;
        }else{
            elem.focus();
            return false;
        }
    },
    emailValidator:function(elem){
        var emailExp = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/;
        if(elem.val().match(emailExp)){
            return true;
        }else{
            elem.focus();
            return false;
        }
    },
    checkOnlineSkype:function(){
        $.ajax({
            type: "POST",
            url: "/support-online/"
        })
        .done(function( msg ) {
//                alert(msg.skype);
            $("#skype").html(msg.skype);
            $("#yahoo").html(msg.yahoo);
        });
    },
    getOnlineNumber:function(){
        $.ajax({
            type: "get",
            url: "/online-number/",
            dataType:'json'
        }).done(function( msg ) {
                accessTotal =msg.access_total.toString();
                x="";
                if(accessTotal.length<6)
                    for(i=0; i<(6-accessTotal.length); i++)
                        x = x+"0";

                accessTotal =x+accessTotal
                j=1;
                for(i=0; i<accessTotal.length; i++){
                    tmp=accessTotal.substring(i,j);
                    $(".access-total-number").append('<span class="online-number-'+tmp+'"></span>');
                    j++;
                }

                x="";
                currentOnline = (msg.current_online*2).toString();
                if(currentOnline.length<3)
                    for(i=0; i<(3-currentOnline.length); i++)
                        x = x+"0";
//                alert(x);
                currentOnline = x+currentOnline;
//                alert(currentOnline.length);
                j=1;
                for(i=0; i<currentOnline.length; i++){
                    tmp=currentOnline.substring(i,j);
                    $(".current-online-number").append('<span class="online-number-'+tmp+'"></span>');
                    j++;
                }

            //$("#skype").html(msg.skype);
//                alert(msg.current_online);
        });
    }
}
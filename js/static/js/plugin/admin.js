var adminCore = {
    uploadForm:function(){
        window.open('/admin/upload/frm/','Upload','top=350,left=250,width=500px,height=110px,scrollbars=yes').focus();
    },
    empty:function(elem){
        if(elem.val() == 0 || elem.val()==null){
            elem.focus();
            return false;
        }
        return true;
    },
    isNumeric:function(elem){
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
    }

}


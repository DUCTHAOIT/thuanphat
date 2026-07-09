/**
 * Created by JetBrains PhpStorm.
 * User: truonghm
 * Date: 6/30/12
 * Time: 3:07 PM
 * To change this template use File | Settings | File Templates.
 */
// put all error code here, user Alt+F7 to find usage


	//minhnq
    //format money
    Number.prototype.formatMoney = function(c, d, t){ var n = this, c = isNaN(c = Math.abs(c)) ? 2 : c, d = d == undefined ? "," : d, t = t == undefined ? "." : t, s = n < 0 ? "-" : "", i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "", j = (j = i.length) > 3 ? j % 3 : 0; return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : ""); };

	/*--check form-------*/
	
	function notEmpty(elem){
		if(elem.val() == 0 || elem.val()==null){
			elem.focus();
			return false;
		}
		return true;
	}
	
	function isNumeric(elem){
		var numericExpression = /^[0-9]+$/;
		if(elem.val().match(numericExpression)){
			return true;
		}else{
			elem.focus();
			return false;
		}
	}
	
	function emailValidator(elem){
		var emailExp = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/;
		if(elem.val().match(emailExp)){
			return true;
		}else{
			elem.focus();
			return false;
		}
	}

    function logout(){
        $.post('/logout/',{
        },function(result){
            window.location='/';
            if (result.success){
            }
            else{
            }
        },'json');
    }

    function addToCartFromProduct(proId,quantity){
        $.ajax({
            url:("/add-to-cart/")
            ,type:"POST"
            ,dataType:"json"
            ,data:{pid:proId,qty:quantity}
            ,success:function(result){
                showShopping(result.data);
            }
        });
    }

    function showShopping(data){
        $("#header-shopping-cart").html(data);
        $( "#shopping-cart-menu" ).toggle( "blind" );
        setTimeout(function(){
            $( "#shopping-cart-menu" ).hide();
        },4000);
    }

$( document ).ready(function() {
    $("#header-shopping-cart" ).click(function() {
        $( "#shopping-cart-menu" ).toggle("blind");
        setTimeout(function(){
            $( "#shopping-cart-menu" ).hide();
        },4000);
    });

});


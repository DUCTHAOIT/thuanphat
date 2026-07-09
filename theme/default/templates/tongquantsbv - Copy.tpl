{literal}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" />

<link rel="stylesheet"  href="../../js/tabview2/tab/css/webwidget_tab.css" type="text/css" />
<script type='text/javascript' src='http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js'></script>
<script type='text/javascript' src='../../js/tabview2/tab/js/webwidget_tab.js'></script>
<script type="text/javascript">// <![CDATA[
	$(function() {
		$(".webwidget_tab").webwidget_tab({
			window_padding: '10',
			head_text_color: '#666',
			head_current_text_color: '#f1592a'
		});
	});
// ]]></script>
<script language="javascript">
function dropCategory(obj){
	if(document.getElementById(obj).style.display == ""){		
		document.getElementById(obj).style.display = "none";
		document.frmTemp.objdrop.value = "none";	
	}
	else{
		document.getElementById(obj).style.display = "";
		document.frmTemp.objdrop.value = obj.id;
	}
}

</script>
{/literal}
<div class="contentFun">{$nameFun}</div>
<div class="topicContent"><h1>{$name}</h1></div>             
 <div  style="padding-top:10px;" class="row">
    <div class="col-xs-12 col-sm-12 col-md-5">
        <div class="titleBlock" style="padding-top:10px;" align="center">Tổng quan</div>
        <div style="padding-top:10px">{$tongquan}</div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-7">
        <div class="titleBlock" style="padding-top:10px;" align="center">Hiệu quả đầu tư</div>
        <div style="padding-top:10px">{hieuquabv}</div>
    </div>
    
</div>
<div style="padding:5px; font-size:14px; cursor:pointer"  onClick="JavaScript:dropCategory(8)" class="title" >Giới thiệu <i class="fa fa-angle-down" aria-hidden="true"></i></div>
<div id="8" style="display:none; padding:5px">{$gioithieu}</div>
<div style="padding:5px; font-size:14px; cursor:pointer"  onClick="JavaScript:dropCategory(7)" class="title" >Thành tựu <i class="fa fa-angle-down" aria-hidden="true"></i></div>
<div id="7" style="display:none; padding:5px">{$thanhtuu}</div>
<div style="padding:5px; font-size:14px; cursor:pointer"  onClick="JavaScript:dropCategory(6)" class="title" >Điều khoản dịch vụ <i class="fa fa-angle-down" aria-hidden="true"></i></div>
<div id="6" style="display:none; padding:5px">{$dieukhoan}</div>
<div style="padding:5px; font-size:14px; cursor:pointer"  onClick="JavaScript:dropCategory(1)" class="title" >Chiến lược đầu tư <i class="fa fa-angle-down" aria-hidden="true"></i></div>
<div id="1" style="display:none; padding:5px">{$chienluoc}</div>
<div style="padding:5px;  font-size:14px; cursor:pointer"  onClick="JavaScript:dropCategory(2)" class="title" >Phương pháp đầu tư <i class="fa fa-angle-down" aria-hidden="true"></i></div>
<div id="2" style="display:none; padding:5px">{$phuongphap}</div>
<div style="padding:5px;  font-size:14px; cursor:pointer"  onClick="JavaScript:dropCategory(3)" class="title" >Danh mục đầu tư <i class="fa fa-angle-down" aria-hidden="true"></i></div>
<div id="3" style="display:none; padding:5px">{$danhmuc}</div>
<div style="padding:5px;  font-size:14px; cursor:pointer"  onClick="JavaScript:dropCategory(4)" class="title" >Rủi ro <i class="fa fa-angle-down" aria-hidden="true"></i></div>
<div id="4" style="display:none; padding:5px">{$ruiro}</div>
<div style="padding:5px;  font-size:14px; cursor:pointer"  onClick="JavaScript:dropCategory(5)" class="title" >Ưu điểm <i class="fa fa-angle-down" aria-hidden="true"></i></div>
<div id="5" style="display:none; padding:5px">{$uudiem}</div>
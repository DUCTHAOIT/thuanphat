{literal}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
{/literal}
{if $username}
{if !$cmt}
{literal}
<style>
	#popup_this {
    top: 50%;
    left: 50%;
    text-align:center;
    margin-top: -50px;
   
    position: fixed;
    background: #fff;
      padding: 20px;
	padding-top:30px;
	width:380px;
}
.b-close {
    position: absolute;
    right: 0;
    top: 0;
    cursor: pointer;
    color: #fff;
    background: #ff0000;
    padding: 5px 10px;
}
</style>
<script src="../../js/bpopup-master/jquery.bpopup.min.js"></script>
<script>
$( document ).ready(function() {
    $('#popup_this').bPopup();
});
</script>
{/literal}
<div id="popup_this">
    <span class="button b-close">
        <span>X</span>
    </span>
    <h2>Để có thể giao dịch ngay</h2>
    <p>Quý khách vui lòng <a href="{$smarty.const._DOMAIN_ROOT_URL}/user_iMember/" class="title">Click vào đây</a> cập nhật thêm thông tin tài khoản</p>
</div>
{/if}
{/if}
<section class="text-center">
<div class="container" align="center">
	<div class="namefun text-center">{$nameFun}</div>
    <div class="des">
    	<h1 class="topiccontent">{$arr.name}</h1>
    	<div class="content" align="center" >{$arr.summary}</div>
    </div>
    <div>
        <div class="tabduan">
            <ul class="tab nav">
                <li><a href="#report1" data-toggle="tab" class="active">Thông tin dự án</a></li>
                <li><a href="#report2" data-toggle="tab">Tiến độ dự án</a></li>
                <li><a href="#report3" data-toggle="tab">Quy trình & pháp lý</a></li>
                <li><a href="#report4" data-toggle="tab">Kết quả hoạt động</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade show active" id="report1">
                    <div class="titledaotao" style="color:#3ca994">Thông tin dự án</div>
            		<div class="contentdaotao">{$arr.content}</div>
                </div>
                <div class="tab-pane fade" id="report2">
                	<div class="titledaotao" style="color:#3ca994">Tiến độ dự án</div>
            		<div class="contentdaotao">{$arr.vitri}</div>
                </div>
                <div class="tab-pane fade" id="report3">
                	<div class="titledaotao" style="color:#3ca994">Quy trình & pháp lý</div>
            		<div class="contentdaotao">{$arr.tienich}</div>
                </div>
                <div class="tab-pane fade" id="report4">
                	<div class="titledaotao" style="color:#3ca994">Kết quả hoạt động</div>
            		<div class="contentdaotao">{$arr.chinhsach}</div>
                </div>
            </div>
        </div>
    </div>
</div>
{$sotienmotxuat1=$arr.sotienmotxuat1}
{if $Memberloai=='1'}
	{$sotienmotxuat1=$arr.sotienmotxuat1}
{/if}
{if $Memberloai=='0'}
	{$sotienmotxuat1=$arr.sotienmotxuat1-$arr.chietkhau1}
{/if}
{if $Memberloai=='2'}
	{$sotienmotxuat1=$arr.sotienmotxuat1-$arr.chietkhau12}
{/if}
<div class="giothieuduan" id="giothieuduan">
 <div class="container"  style="text-align:left">
    <div class="topiccontent">Thông tin đầu tư</div>
  
    <div id="gioithieu1" style="padding-top: 1.5rem !important;">
        <div>{$arr.gioithieu1}</div>
        <div class="row" style="padding-bottom: 2.5rem !important;">
           <div class="col-xs-12 col-sm-6 col-md-6 ">
            	<div class="row linetop">
                	<div class="col-xs-6 col-sm-6 col-md-6"><strong>Diện tích và quy mô:</strong></div>
                    <div class="col-xs-6 col-sm-6 col-md-6">{$arr.tengiaidoan1}</div>
                </div>
                <div  class="row linetop">
                	<div class="col-xs-6 col-sm-6 col-md-6"><strong>Hình thức đầu tư:</strong></div>
                    <div class="col-xs-6 col-sm-6 col-md-6">{$arr.hinhthuc1}</div>
                </div>
            	<div class="row linetop">
                	<div class="col-xs-6 col-sm-6 col-md-6"><strong>Vốn pháp định:</strong></div>
                    <div class="col-xs-6 col-sm-6 col-md-6">{format_number number=$arr.tongvondautu1}</div>
                </div>
                <div  class="row linetop">
                	<div class="col-xs-6 col-sm-6 col-md-6"><strong>Tổng số cổ phần:</strong></div>
                    <div class="col-xs-6 col-sm-6 col-md-6">{format_number2 number=$arr.soxuatdautu1}</div>
                </div>
                <div  class="row linetop">
                	<div class="col-xs-6 col-sm-6 col-md-6"><strong>Giá trị / 1 cổ phần:</strong></div>
                    <div class="col-xs-6 col-sm-6 col-md-6">{format_number number=$sotienmotxuat1} {if $sotienmotxuat1<>$arr.sotienmotxuat1}{if $Memberloai=='0' || $Memberloai=='2'}<font style="font-size:12px; color:#FF0000">(Đã trừ chiết khấu cho thành viên)</font>{/if}{/if}</div>
                </div>
                <div  class="row linetop notemb"></div>
                
          </div>
          <div class="col-xs-12 col-sm-6 col-md-6 "> 
            	
            	<div  class="row linetop">
                	<div class="col-xs-6 col-sm-6 col-md-6"><strong>Số tiền đầu tư tối thiểu:</strong></div>
                    <div class="col-xs-6 col-sm-6 col-md-6">{format_number number=$arr.sotientoithieu}</div>
                </div>
                <div  class="row linetop">
                	<div class="col-xs-6 col-sm-6 col-md-6"><strong>Số tiền đầu tư tối đa:</strong></div>
                    <div class="col-xs-6 col-sm-6 col-md-6">{format_number number=$arr.sotientoida}</div>
                </div>
                <div  class="row linetop">
                	<div class="col-xs-6 col-sm-6 col-md-6"><strong>Số cổ đông tối đa:</strong></div>
                    <div class="col-xs-6 col-sm-6 col-md-6">{$arr.codongtoida}</div>
                </div>
           
            	<div  class="row linetop">
                	<div class="col-xs-6 col-sm-6 col-md-6"><strong>Số cổ phần đang gọi:</strong></div>
                    <div class="col-xs-6 col-sm-6 col-md-6">{format_number2 number=$arr.soxuatdautu1 - $arr.soxuatdakeugoi1}</div>
                </div>
                <div  class="row linetop">
                	<div class="col-xs-6 col-sm-6 col-md-6"><strong>Tình trạng dự án:</strong></div>
                    <div class="col-xs-6 col-sm-6 col-md-6">{$arr.tinhtrangduan1}</div>
                </div>
                <div  class="row linetop"></div>
           </div>     
        </div>
        <div class="text-center">
        	{if $username}
            {if $cmt}
        	<button class="btn_viewmore1"><a href="#" data-toggle="modal" data-target="#exampleModalBuy1" >Góp vốn</a></button>
            {else}
            <button class="btn_viewmore1"><a href="{$smarty.const._DOMAIN_ROOT_URL}/user_iMember/" >Góp vốn</a></button>
            {/if}
            {else}
            <button class="btn_viewmore1"><a href="#" data-toggle="modal" data-target="#exampleModalIn">Góp vốn</a></button>
            {/if}
            <button class="btn_viewmore2"><a href="{$arr.product_in}">Tư vấn ngay</a></button>
            <button class="btn_viewmore3"><a href="tel:{$arr.model}">Gọi: {$arr.model}</a></button>
        </div>
    </div>
    
   </div> 
</div>
</section>
<div class="modal fade" id="exampleModalBuy1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="titleBlock">Thông tin giao dịch</h1>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form name="frmbookingRoom1" id="frmbookingRoom1" action="#" method="post" enctype="multipart/form-data">
        <input type="hidden" name="f" value="user_buy_add_gopvon" />
        <input type="hidden" name="m" value="user" />
        <input type="hidden" name="sotienmotcophanchietkhau" value="{$sotienmotxuat1}" />
        <input type="hidden" name="sotienmotcophan" value="{$arr.sotienmotxuat1}" />
        <input type="hidden" name="loaitv" value="{$Memberloai}" />
        <input type="hidden" name="catID" value="{$arr.id}" />
        <input type="hidden" name="sotientoithieu" value="{$arr.sotientoithieu}" />
        <input type="hidden" name="sotientoida" value="{$arr.sotientoida}" />
        <input type="hidden" name="soxuatconlai" value="{$arr.soxuatdautu1-$arr.soxuatdakeugoi1}" />
            <div class="row content" >
                <div class="col-xs-6 col-sm-6 col-md-5">Số tiền góp vốn:<font color="red">*</font></div>
                <div class="col-xs-6 col-sm-6 col-md-7"><input id="giatri" type="text"  name="giatri" onkeyup="myFunctionBuy1(document.frmbookingRoom1)" style="width:100%"/></div>
            </div>
            <div class="row content" >   
                <div class="col-xs-6 col-sm-6 col-md-5" >Số tiền / 1 cổ phần:</div> 
                <div class="col-xs-6 col-sm-6 col-md-7" >{format_number number=$arr.sotienmotxuat1}</div>
             </div>
             <div class="row content" >       
                <div class="col-xs-6 col-sm-6 col-md-5">Tổng số cổ phần:</div> 
                <div class="col-xs-6 col-sm-6 col-md-7" id="lblCheckMailvoucher1" ></div>
            </div>
            <div class="row content" >
                <div class="col-xs-12 col-sm-12 col-md-12"><input type="button" onclick="checkbookingRoom1(document.frmbookingRoom1);" value="Góp vốn" class="btn btn-primary" /></div>
            </div>
        </form>
      </div>
      <div class="modal-footer">
      </div>
    </div>
  </div>
</div>
{literal}
<script language="javascript" type="text/javascript">

function myFunctionBuy1(f) {
		var obj;
			obj=document.frmbookingRoom1;
			giatri=obj.giatri.value.replace(/([.])+/g, '');
			//alert(obj.soluong.value);
			
			url="../../?m=user&f=user_buy_calculator_gopvon&giatri="+ giatri +"&sotienmotcophan="+ obj.sotienmotcophan.value +"&sotientoida="+ obj.sotientoida.value +"&sotientoithieu="+ obj.sotientoithieu.value +"/";
		
		AjaxRequest.get(
				{
				'url':url				
				,'onSuccess':function(req){document.getElementById('lblCheckMailvoucher1').innerHTML=req.responseText;}
				,'onError':function(req){}
				}
			)
		return true;	
	
}

function checkbookingRoom1(f){
	var obj;
	obj=document.frmbookingRoom1;
		
	
	var giatri=obj.giatri.value.replace(/([.])+/g, '');	
	var sotientoida=obj.sotientoida.value.replace(/([.])+/g, '');
	var sotientoithieu=obj.sotientoithieu.value.replace(/([.])+/g, '');
	
	if(giatri==""){
		alert("Bạn cần nhập số tiền góp vốn");
		obj.giatri.focus();
		return;
	}else if(Number(giatri) < Number(sotientoithieu)){
		alert("Bạn cần góp vốn lớn hơn giá trị tối thiểu!");
		obj.giatri.focus();
		return;
	}else if(Number(sotientoida) < Number(giatri)){
		alert("Bạn cần góp vốn nhỏ hơn giá trị tối đa!");
		obj.giatri.focus();
		return;	
	//}else if(obj.option.value=='false'){
	//	alert("Bạn cần đồng ý với các Điều khoản dịch vụ và hợp đồng hợp tác đầu tư của TSI!");
	//	obj.option.focus();
	//	return;	
	}else{
		obj.submit();					
	}
}
</script>
{/literal}
{literal}
<script type="text/javascript">
$("#giatri").on('keyup', function(){
    var n = parseInt($(this).val().replace(/\D/g,''),10);
    $(this).val(n.toLocaleString());
});

$("form").bind("keypress", function (e) {
    if (e.keyCode == 13) {
        $("#button").attr('value');
        //add more buttons here
        return false;
    }
});
</script>
{/literal}
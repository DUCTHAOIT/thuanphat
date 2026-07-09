{literal}
<style type="text/css">
.item-khoahoc-khaigiang tr {
	height:60px;
}

.item-khoahoc-khaigiang table {
  border-collapse: separate;
  border-spacing: 0;
}

.item-khoahoc-khaigiang td {
  border: solid 5px #FFFFFF;
  border-radius: 4px;
  background-color:#e6fbf6;
  padding: 10px 12px;
}

.item-khoahoc-khaigiang tr:first-child td:first-child { border-top-left-radius: 10px; }
.item-khoahoc-khaigiang tr:first-child td:last-child { border-top-right-radius: 10px; }

.item-khoahoc-khaigiang tr:last-child td:first-child { border-bottom-left-radius: 10px; }
.item-khoahoc-khaigiang tr:last-child td:last-child { border-bottom-right-radius: 10px; }

.item-khoahoc-khaigiang tr:first-child td { border-top-style: solid; }
.item-khoahoc-khaigiang tr td:first-child { border-left-style: solid; }

.item-khoahoc-khaigiang td:hover {
	background-color: #cef6ed;
}

.buttondangky {
	background-color: #0b7a62; 
	color: #FFFFFF; 
	border-radius: 4px;
	text-align:center;
	height:auto;
	width:100%;
	line-height: 60px;
}
.buttondangky a{
	color: #FFFFFF;
}
.buttondangky:hover {
	background-color: #2fd7b3;
}
.buttondangky:hover a{
	color: #fff;
	text-decoration:none;
}
.khoahoctitle {
	font-weight:600;
	font-size:0.9rem;
}
.item-khoahoc-khaigiang-mb {
	display:none;
}
@media (max-width: 768px) {
	.khoahoc {
	 	margin-top:70px;
	}
	
	.khoahoctitle {
		font-weight:500;
		font-size:0.8rem;
	}
	.item-khoahoc-khaigiang-mb tr {
		padding-top:10px;
		padding-bottom:10px;
		border-bottom:1px solid #94d0c4;
	}
	.item-khoahoc-khaigiang-mb {
	  border-radius: 4px;
	  background-color:#d1f6ee;
	  padding: 10px 12px;
	  display:block;
	}
	
	.buttondangky-mb {
		background-color: #0b7a62; 
		color: #FFFFFF; 
		border-radius: 4px;
		text-align:center;
		height:auto;
		width:100%;
		line-height: 40px;
		padding:5px;
		font-weight:700;
		font-size:0.8rem;
	}
	.buttondangky-mb a{
		color: #FFFFFF;
	}
	.buttondangky-mb:hover {
		background-color: #2fd7b3;
	}
	.buttondangky-mb:hover a{
		color: #FF6600;
	}
}
</style> 
<style>
	.yellow {
		background-color: #cef6ed !important;
	}
</style>
<script>


	$(function() {
		$('tr.unselected').hover(function() {
			$(this).addClass('yellow');
		}, function() {
			$(this).removeClass('yellow');
		});
	});
</script>

{/literal}
<section class="text-center">
<div class="row">
<div class="container" style="padding-bottom:20px; padding-left:0px; padding-right:0px;" >
    <div class="khoahoc" >
        <h2 class="topic">Khóa học tại Viewgolf</h2>
    </div>
    <div class="tab-content-lichkhaigiang hide-m">
     {assign var="k" value="0"}
        {foreach key=key item=item from=$arr}
            <div class="item-khoahoc-khaigiang">
            <table width="100%" cellspacing="0" cellpadding="0" border="0">
            <tr class="unselected">
            <td width="55%" align="left">
            <a href="{$smarty.const._DOMAIN_ROOT_URL}/{$item.url}{$item.alias}" class="khoahoctitle aff">{$item.name}</a>
            </td>
            <td width="15%" class="hide-m">{$item.promotion}</td>
            <td width="15%" class="hide-m">{if $item.price_old}<div class="combo-price"><del>{format_number number=$item.price_old}</del>{/if}</div><div class="combo-price"><strong>{format_number number=$item.price}</strong></div></td>
            <td width="15%">
            <a href="#" data-toggle="modal" data-id="{$item.id}" class="btn-block"><button class="buttondangky" tabindex="-1">Đăng ký ngay</button></a>
            
          
             
            </td>
            </tr>
            </table>
            </div>
          {assign var="i" value="$i+1"}
         {/foreach}
     </div>
     
     
     <div class="item-khoahoc-khaigiang-mb">
     {assign var="k" value="0"}
        {foreach key=key item=item from=$arr}
            <div class="">
            <table width="100%" cellspacing="0" cellpadding="0" border="0">
            <tr class="unselected">
            <td width="100%" align="left" style="text-align:justify; padding-top:10px; padding-bottom:10px; padding-right:10px;">
            <a href="{$smarty.const._DOMAIN_ROOT_URL}/{$item.url}{$item.alias}" class="khoahoctitle aff">{$item.name}</a>
            <div class="nonepc"><div class="combo-price"><del>{format_number number=$item.price_old}</del><strong style="color:#FF9900">{format_number number=$item.price}</strong></div></div>
            </td>
            <td nowrap="nowrap">
             <a href="#" data-toggle="modal" data-id="{$item.id}" class="btn-block" ><button class="buttondangky-mb">Đăng ký</button></a>
             </td>
            </tr>
            </table>
            </div>

          {assign var="i" value="$i+1"}
         {/foreach}
     </div>
</div> 
</div>    
</section>

{literal}  

<script>
  $('.btn-block').click(function(){
	var id=$(this).data('id');
	//undefined
	//alert(id);
	//shows loading text
	//it dosent work
    //$('.data-modal').html('loading');
    $.ajax({
		
		url: '../?m=dangky&f=dangkykhoahoc',
		type: 'post',
		data: {id: id},
		success: function(response){ 
			// Add response in Modal body
			$('.modal-body-dangky').html(response); 

			// Display Modal
			$('#myModalDangkyKhoahocShow').modal('show'); 
		},
        error:function(err){
            alert("error"+JSON.stringify(err));
        }
		
     });
});
</script>	

{/literal}
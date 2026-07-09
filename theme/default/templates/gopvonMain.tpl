<div class="container" style="padding:10px; padding-left:0px; padding-right:0px">
	<div class="namefun text-center">{$nameFun}</div>
	<div class="text-center">
        <h1 class="topiccontent">{$name}</h1>
    </div>
    {if $des}<div class="content" align="center"  style="padding:10px; padding-bottom:30px" >{$des}</div>{/if}
    <div>{gopvon_list}</div>
</div>


{literal}
	<script language="javascript" type="text/javascript">
		//
		function addToShoppingCart(id)
		{
			url="/add_basket/"+ id +"/";
			AjaxRequest.get(
				{
				'url':url
				,'onSuccess':function(req){document.getElementById('addToShoppingCart_'+id).innerHTML=req.responseText;}
				,'onError':function(req){}
				}
			)
			//
			url="/view_basket_count/";
			AjaxRequest.get(
				{
				'url':url
				,'onSuccess':function(req){document.getElementById('div_view_summary_basket').innerHTML=req.responseText;}
				,'onError':function(req){}
				}
			)
		}
	</script>
{/literal}
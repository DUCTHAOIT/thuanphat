{literal}
<script language="javascript" type="text/javascript">
function callLock(id){
	AjaxRequest.get(
		{
		'url':window.location.search + '&op=lockBasket&id='+id
		,'onSuccess':function(req){document.getElementById('lock_'+id).innerHTML=req.responseText;}
		,'onError':function(req){}
		}
	)	
}
//
function goEdit(id){
	document.frmList.id.value=id;
	document.frmList.op.value='frm';
	document.frmList.submit();	
}
//
function goDelete(id,f){
	if (confirm('are you sure to delete?')!=0){
		document.frmList.id.value=id;
		document.frmList.op.value='pDelete';		
		var status = AjaxRequest.submit(
			f
			,{
			  'url':window.location.search
			  ,'onSuccess':function(req){ document.getElementById('BasketDelete').innerHTML=req.responseText;}
			  ,'onError':function(req){}
			}
		  );				  
		  return status;	
	}
}
</script>
{/literal}
{literal}
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
<form name="frmList" action="" method="post" enctype="multipart/form-data">
<input type="hidden" name="id" value="" />
<input type="hidden" name="op" value="" />

<table width="100%" border="1" cellpadding="0" cellspacing="0" class="table">
  <tr height="25">
    <td class="tr" nowrap="nowrap">ID Đơn hàng</td>
    <td class="tr" style="padding-left:10px;" >Ngày</td>
    <td class="tr">Khách hàng</td>
    <td class="tr">Trạng thái</td>
  
  </tr>
  {foreach key=key item=item from=$arr}
  <tr>
    <td class="td" nowrap="nowrap">{$key}</td>
    <td class="td" nowrap="nowrap"><strong>{$item.sdate}</strong></td>
    <td class="td" width="100%"><strong>{$item.name}</strong> Email: <a href="mailto:{$item.username}" class="title">{$item.username}</a></td>    
	 <td class="td" nowrap="nowrap"><label id="lock_{$key}" onclick="callLock({$key})" style="cursor:pointer; padding-right:5px"><img src="images/{$item.ctrl}.gif" alt="Trạng thái" /></label>{if $item.ctrl=='1'}Đã xử lý{else}Chưa xử lý{/if} <label style="padding-right:5px"><a href="?m=basket&op=pDelete&id={$key}"><img src="images/delete.gif" style="cursor:pointer" title="Delete" border="0" /></a>	</label></td>
	
  </tr>
  <tr>
  
  	<td colspan="5" style="color:#FF0000; padding:5px; cursor:pointer"  onClick="JavaScript:dropCategory({$key})" class="content" ><i>Chi tiết đơn hàng</i></td>
  </tr>
   <tr id="{$key}" style="display:none;">  
	<td class="content" style="padding:10px" colspan="5">
		{$item.des}
	</td>
  </tr>
  {/foreach}
</table>
</form>
<div style="text-align:right">{$sPage}</div>
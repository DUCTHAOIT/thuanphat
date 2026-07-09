{literal}
<script language="javascript" type="text/javascript">
	function goEdit(id){
		document.frmList.id.value=id;
		document.frmList.op.value='frm';
		document.frmList.submit();	
	}
	//
	function goPhoto(id){
		document.frmList.id.value=id;
		document.frmList.op.value='photo';
		document.frmList.submit();	
	}
	//
	//
	function goFile(id){
		document.frmList.id.value=id;
		document.frmList.op.value='file';
		document.frmList.submit();	
	}
	//
	function goDelete(id,f){
		if (confirm('are you sure to delete?')!=0){
			document.frmList.id.value=id;
			document.frmList.op.value='delete';
			var status = AjaxRequest.submit(
				f
				,{
				  'url':'?m=hdgopvon'
				  ,'onSuccess':function(req){ document.getElementById('hdgopvonList').innerHTML=req.responseText;}
				  ,'onError':function(req){}
				}
			  );		  
			  return status;	
		}
	}
	//
	function callSearch(f){
		var status = AjaxRequest.submit(
			f
			,{
			  'url':'?m=hdgopvon'
			  ,'onSuccess':function(req){ document.getElementById('hdgopvonList').innerHTML=req.responseText;}
			  ,'onError':function(req){}
			}
		  );
		  progress('hdgopvonList');
		  return status;		
	}
	//
	function btnGo_Click(evt){
		var e=(window.event)?event:evt;
		if(e.keyCode==13){
			document.getElementById('btnSearch').click(); 
			return false;
		}
	}
	function callLock(id){
		AjaxRequest.get(
			{
			'url':'?m=hdgopvon&op=lockhdgopvon&id='+id
			,'onSuccess':function(req){document.getElementById('lock_'+id).innerHTML=req.responseText;}
			,'onError':function(req){}
			}
		)	
	}
	function callHC(id){
		AjaxRequest.get(
			{
			'url':'?m=hdgopvon&op=hoancochdgopvon&id='+id
			,'onSuccess':function(req){document.getElementById('hc_'+id).innerHTML=req.responseText;}
			,'onError':function(req){}
			}
		)	
	}
</script>
{/literal}
<div class="topic">Quản lý hợp đồng góp vốn</div>
<!-- <div align="right"><a href="?m=hdgopvon&op=frm" class="title">{$Create}</a></div> -->
<form name="frmSearch" action="#" method="post" enctype="multipart/form-data">
<input type="hidden" name="op" value="list" />
<input type="hidden" name="loaihd" value="{$loaihd}" />
<table border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td style="border:1px solid #E3E6EB; padding-bottom:2px; padding-left:2px; padding-right:2px; padding-top:2px"><table border="0" cellspacing="0" cellpadding="0">
  <tr bgcolor="#E3E6EB" height="30">
    <td style="padding-left:10px">
	<select name="proid" style="border:1px solid #cccccc;">
	<option value="" selected="selected">--Tất cả dự án--</option>
	{foreach key=key item=item from=$arrgopvon}
    {if $key==$proid}
      <option value="{$item.id}" style="padding-left:10px; padding-right:10px" selected="selected" >&nbsp; &nbsp;{$item.name}</option>
    {else}
	<option value="{$item.id}" style="padding-left:10px; padding-right:10px" >&nbsp; &nbsp;{$item.name}</option>
    {/if}
	{/foreach}
	</select>
	</td>
    <td style="padding-left:10px">
	<select name="userid" style="border:1px solid #cccccc;">
    <option value="">--Tất cả thành viên--</option>
    {foreach key=key item=item from=$arr_user}
    {if $key==$userid}
      <option value="{$item.id}" style="padding-left:10px; padding-right:10px" selected="selected" >&nbsp; &nbsp;{$item.name}</option>
    {else}
        <option value="{$item.id}" style="padding-left:10px; padding-right:10px" >&nbsp; &nbsp;{$item.name}</option>
    {/if}
    {/foreach}
    </select>
	</td>  
    <td style="padding-left:10px" nowrap="nowrap"><strong>Từ khóa:</strong></td>
    <td style="padding-left:10px"><input type="text" class="text" name="keyword" style="width:150" onkeypress="return btnGo_Click(event);" /></td>
    <td style="padding-left:10px; padding-right:10px"><input type="button" id="btnSearch" value="Search" class="button" onclick="callSearch(document.frmSearch)" /></td>
  </tr>
</table></td>
  </tr>
</table>
</form>
{if $loaihd=='1'}
<h1 class="topic">Hợp Đồng Đăng Ký Góp Vốn</h1>
{/if}
{if $loaihd=='2'}
<h1 class="topic">Hợp Đồng Chưa Thanh Toán Hết</h1>
{/if}
{if $loaihd=='3'}
<h1 class="topic">Hợp Đồng Đã Thanh Toán Hết</h1>
{/if}
{if $loaihd=='4'}
<h1 class="topic">Hợp Đồng Hoàn Cọc</h1>
{/if}
{if !$loaihd}
<h1 class="topic">Tất cả các hợp đồng</h1>
{/if}
<div id="hdgopvonList">{hdgopvonList}</div>

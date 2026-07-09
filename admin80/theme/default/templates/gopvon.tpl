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
				  'url':'?m=gopvon'
				  ,'onSuccess':function(req){ document.getElementById('gopvonList').innerHTML=req.responseText;}
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
			  'url':'?m=gopvon'
			  ,'onSuccess':function(req){ document.getElementById('gopvonList').innerHTML=req.responseText;}
			  ,'onError':function(req){}
			}
		  );
		  progress('gopvonList');
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
			'url':'?m=gopvon&op=lockgopvon&id='+id
			,'onSuccess':function(req){document.getElementById('lock_'+id).innerHTML=req.responseText;}
			,'onError':function(req){}
			}
		)	
	}
</script>
{/literal}

<div>
<form name="frmSearch" action="#" method="post" enctype="multipart/form-data">
<input type="hidden" name="op" value="list" />
<table border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td style="border:1px solid #E3E6EB; padding-bottom:2px; padding-left:2px; padding-right:2px; padding-top:2px"><table border="0" cellspacing="0" cellpadding="0">
  <tr bgcolor="#E3E6EB" height="30">
    <td style="padding-left:10px" nowrap="nowrap"><strong>{$gopvon_group}:</strong></td>
    <td style="padding-left:10px">
	<select name="catID" style="border:1px solid #cccccc;">
	<option value="" selected="selected"></option>
	{foreach key=key item=item from=$arrTopicgopvon}
	<option value="{$item.id}" style="padding-left:{$item.level*15}px; padding-right:10px" >&nbsp; &nbsp;{$item.name}</option>
	{/foreach}
	</select>
	</td>	  
    <td style="padding-left:10px" nowrap="nowrap"><strong>Tên hoặc mã sản phẩm:</strong></td>
    <td style="padding-left:10px"><input type="text" class="text" name="keyword" style="width:150" onkeypress="return btnGo_Click(event);" /></td>
    <td style="padding-left:10px; padding-right:10px"><input type="button" id="btnSearch" value="Search" class="button" onclick="callSearch(document.frmSearch)" /></td>
  </tr>
</table></td>
  </tr>
</table>
</form>
</div>
<div align="right"><a href="?m=gopvon&op=frm" class="title">{$Create}</a></div>
<div id="gopvonList">{gopvonList}</div>

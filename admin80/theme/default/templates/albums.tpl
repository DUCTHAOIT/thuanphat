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
	function goDelete(id,f){
		if (confirm('are you sure to delete?')!=0){
			document.frmList.id.value=id;
			document.frmList.op.value='delete';
			var status = AjaxRequest.submit(
				f
				,{
				  'url':'?m=albums'
				  ,'onSuccess':function(req){ document.getElementById('albumsList').innerHTML=req.responseText;}
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
			  'url':'?m=albums'
			  ,'onSuccess':function(req){ document.getElementById('albumsList').innerHTML=req.responseText;}
			  ,'onError':function(req){}
			}
		  );
		  progress('albumsList');
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
			'url':'?m=albums&op=lockalbums&id='+id
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
<table border="0" cellspacing="0" cellpadding="0" width="90%">
  <tr>
    <td style="border:1px solid #E3E6EB; padding-bottom:2px; padding-left:2px; padding-right:2px; padding-top:2px"><table border="0" cellspacing="0" cellpadding="0">
  <tr bgcolor="#E3E6EB" height="30">
    <td style="padding-left:10px" nowrap="nowrap"><strong>{$albums_group}:</strong></td>
    <td style="padding-left:10px">
	<select name="catID" style="border:1px solid #cccccc;">	
	{foreach key=key item=item from=$arrTopicalbums}
	<option value="{$item.id}" style="padding-left:{$item.level*15}px; padding-right:10px" >&nbsp; &nbsp;{$item.name}</option>
	{/foreach}
	</select>
	</td>  
	<td width="100%">&nbsp;</td>
    <td style="padding-left:10px" nowrap="nowrap"><strong>{$albums_name}:</strong></td>
    <td style="padding-left:10px"><input type="text" class="text" name="keyword" style="width:150" onkeypress="return btnGo_Click(event);" /></td>
    <td style="padding-left:10px; padding-right:10px"><input type="button" id="btnSearch" value="Search" class="button" onclick="callSearch(document.frmSearch)" /></td>
  </tr>
</table></td>
  </tr>
</table>
</form>
</div>
<div align="right"><a href="?m=albums&op=frm" class="title">{$Create}</a></div>
<div id="albumsList">{albumsList}</div>

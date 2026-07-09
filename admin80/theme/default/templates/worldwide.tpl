{literal}
<script language="javascript" type="text/javascript">
	function callSearch(f)
		{			
			var status = AjaxRequest.submit(
			f
			,{
			  'url':'?m=worldwide'
			  ,'onSuccess':function(req){ document.getElementById('worldwideList').innerHTML=req.responseText;}
			  ,'onError':function(req){}
			}
		  );
		  progress('listArticle');
		  return status;		
		}	
function callLock(id){
	AjaxRequest.get(
		{
		'url':window.location.search + '&op=lockworldwide&id='+id
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
			  ,'onSuccess':function(req){ document.getElementById('worldwideList').innerHTML=req.responseText;}
			  ,'onError':function(req){}
			}
		  );	
		  progress('worldwideList');		  
		  return status;	
	}
}
</script>
{/literal}
<form name="frmSearch" action="#" method="post" enctype="multipart/form-data">
<input type="hidden" name="op" value="list" />
<table border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td style="border:1px solid #E3E6EB; padding-bottom:2px; padding-left:2px; padding-right:2px; padding-top:2px"><table border="0" cellspacing="0" cellpadding="0">
  <tr bgcolor="#E3E6EB" height="30">
    <td style="padding-left:10px"><strong>Nhóm:</strong></td>
    <td style="padding-left:10px">
	<select name="catID" style="border:1px solid #cccccc;">
	<option value="" selected="selected"></option>
	{foreach key=key item=item from=$arrTopicArticle}
	<option value="{$item.id}" style="padding-left:{$item.level*15}px; padding-right:10px" >&nbsp; &nbsp;{$item.name}</option>
	{/foreach}
	</select>
	</td>
    <td style="padding-left:10px"><strong>Từ khóa:</strong></td>
    <td style="padding-left:10px"><input type="text" id="txtSearch" name="keyword" class="text" value="{$keyword}" style="width:200" onkeypress="return btnGo_Click(event);" /></td>
    <td style="padding-left:10px; padding-right:10px"><input type="button" id="btnSearch" value="Search" class="button" onclick="callSearch(document.frmSearch)" /></td>
  </tr>
</table></td>
  </tr>
</table>
</form>
<div style="text-align:right; padding-bottom:5px"><a href="?m=worldwide&op=frm" class="title">Thêm mới</a></div>
<div id="worldwideList">{worldwideList}</div>

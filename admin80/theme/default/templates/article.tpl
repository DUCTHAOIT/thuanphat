{literal}
	<script language="javascript" type="text/javascript">
		function callSearch(f)
		{			
			var status = AjaxRequest.submit(
			f
			,{
			  'url':'?m=article'
			  ,'onSuccess':function(req){ document.getElementById('listArticle').innerHTML=req.responseText;}
			  ,'onError':function(req){}
			}
		  );
		  progress('listArticle');
		  return status;		
		}	
		function goEdit(id){
			document.frmListArticle.id.value=id;
			document.frmListArticle.op.value='frm';
			document.frmListArticle.submit();	
		}
		//
		function goDelete(id,f){
		if (confirm('Bạn có chắc chắn xóa?')!=0){
			document.frmListArticle.id.value=id;
			document.frmListArticle.op.value='delete';
			var status = AjaxRequest.submit(
				f
				,{
				  'url':'?m=article'
				  ,'onSuccess':function(req){ document.getElementById('listArticle').innerHTML=req.responseText;}
				  ,'onError':function(req){}
				}
			  );
			  progress('listArticle');
			  return status;	
		}
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
			'url': window.location.search + '&op=lock&id='+id
			,'onSuccess':function(req){document.getElementById('lock_'+id).innerHTML=req.responseText;}
			,'onError':function(req){}
			}
		)	
	}
	function callDuyet(id){
		AjaxRequest.get(
			{
			'url': window.location.search + '&op=duyet&id='+id
			,'onSuccess':function(req){document.getElementById('duyet_'+id).innerHTML=req.responseText;}
			,'onError':function(req){}
			}
		)	
	}
	</script>
{/literal}
<form name="frmSearch" action="#" method="post" enctype="multipart/form-data">
<input type="hidden" name="op" value="list" />
<table border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td style="border:1px solid #E3E6EB; padding-bottom:2px; padding-left:2px; padding-right:2px; padding-top:2px"><table border="0" cellspacing="0" cellpadding="0">
  <tr bgcolor="#E3E6EB" height="30">
    <td style="padding-left:10px"><strong>{$Group_name}:</strong></td>
    <td style="padding-left:10px">
	<select name="catID" style="border:1px solid #cccccc;">
	<option value="" selected="selected"></option>
	{foreach key=key item=item from=$arrTopicArticle}
	<option value="{$item.id}" style="padding-left:{$item.level*15}px; padding-right:10px" >&nbsp; &nbsp;{$item.name}</option>
	{/foreach}
	</select>
	</td>
    <td style="padding-left:10px"><strong>{$Keyword}:</strong></td>
    <td style="padding-left:10px"><input type="text" id="txtSearch" name="keyword" class="text" value="{$keyword}" style="width:200" onkeypress="return btnGo_Click(event);" /></td>
    <td style="padding-left:10px; padding-right:10px"><input type="button" id="btnSearch" value="Search" class="button" onclick="callSearch(document.frmSearch)" /></td>
  </tr>
</table></td>
  </tr>
</table>
</form>
<div style="text-align:right"><a href="?m=article&op=frm" class="title">{$Article_create}</a></div>
<div id="listArticle">{listArticle}</div>
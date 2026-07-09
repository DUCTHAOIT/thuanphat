{literal}
	<script language="javascript" type="text/javascript">
		function callSearch(f)
		{			
			var status = AjaxRequest.submit(
			f
			,{
			  'url':'?m=partner'
			  ,'onSuccess':function(req){ document.getElementById('listpartner').innerHTML=req.responseText;}
			  ,'onError':function(req){}
			}
		  );
		  progress('listpartner');
		  return status;		
		}	
		function goEdit(id){
			document.frmListpartner.id.value=id;
			document.frmListpartner.op.value='frm';
			document.frmListpartner.submit();	
		}
		//
		function goDelete(id,f){
		if (confirm('Bạn có chắc chắn xóa?')!=0){
			document.frmListpartner.id.value=id;
			document.frmListpartner.op.value='delete';
			var status = AjaxRequest.submit(
				f
				,{
				  'url':'?m=partner'
				  ,'onSuccess':function(req){ document.getElementById('listpartner').innerHTML=req.responseText;}
				  ,'onError':function(req){}
				}
			  );
			  progress('listpartner');
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
	</script>
{/literal}
<h2>Danh sách huấn luyện viên</h2>
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
	{foreach key=key item=item from=$arrTopicpartner}
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
<div style="text-align:right"><a href="?m=partner&op=frm" class="title">Thêm mới</a></div>
<div id="listpartner">{listpartner}</div>
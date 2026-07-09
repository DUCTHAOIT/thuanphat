{literal}
	<script language="javascript">
		function callSearch()
		{
			AjaxRequest.get(
				{
				'url':'?m=htmlpage&op=list&txtSearch='+document.getElementById('txtSearch').value
				,'onSuccess':function(req){document.getElementById('listHtmlpage').innerHTML=req.responseText;}
				,'onError':function(req){}
				}
			)		
		}	
		function goEdit(id){
			document.listHtmlpage.id.value=id;
			document.listHtmlpage.op.value='frm';
			document.listHtmlpage.submit();	
		}
		//
		function goDelete(f){
		if (confirm('Bạn có chắc chắn xóa?')!=0){			
			document.listHtmlpage.op.value='delete';
			var status = AjaxRequest.submit(
				f
				,{
				  'url':'?m=htmlpage'
				  ,'onSuccess':function(req){ document.getElementById('listHtmlpage').innerHTML=req.responseText;}
				  ,'onError':function(req){}
				}
			  );
			  progress('listHtmlpage');
			  return status;	
		}
	}
	</script>
{/literal}
<form action="?m=htmlpage" method="post" enctype="multipart/form-data">
<table border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td style="border:1px solid #E3E6EB; padding-bottom:2px; padding-left:2px; padding-right:2px; padding-top:2px"><table border="0" cellspacing="0" cellpadding="0">
  <tr bgcolor="#E3E6EB" height="30">
    <td style="padding-left:10px"><strong>{$title}:</strong></td>
    <td style="padding-left:10px"><input type="text" id="txtSearch" name="txtSearch" class="text" style="width:200" value="{$Keyword}"  /></td>
    <td style="padding-left:10px; padding-right:10px"><input type="submit" name="btnSearch" class="button" value="Search" /></td>
  </tr>
</table></td>
  </tr>
</table>
</form>
<div style="text-align:right"><a href="?m=htmlpage&amp;op=frm">{$Create}</a></div>
<div id="listHtmlpage">{listHtmlpage}</div>
{literal}
<script language="javascript" type="text/javascript">
function callLock(id){
	AjaxRequest.get(
		{
		'url':window.location.search + '&op=lock&id='+id
		,'onSuccess':function(req){document.getElementById('lock_'+id).innerHTML=req.responseText;}
		,'onError':function(req){}
		}
	)	
}
//
function goEdit(id,parent){
	document.frmList.id.value=id;
	document.frmList.op.value='frmcreate';
	document.frmList.parent.value=parent;
	document.frmList.submit();	
}
//
function goDelete(id,f){
	if (confirm('are you sure to delete?')!=0){
		document.frmList.id.value=id;
		document.frmList.op.value='delete';
		;	
		var status = AjaxRequest.submit(
			f
			,{
			  'url':window.location.search
			  ,'onSuccess':function(req){ document.getElementById('photoList').innerHTML=req.responseText;}
			  ,'onError':function(req){}
			}
		  );	
		  progress('photoList')	  
		  return status;	
	}
}
</script>
{/literal}
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="right"><a href="?m=photo&op=frmcreate&parent={$parent}" class="title">{$Create}</a></td>
  </tr>
  <tr>
    <td class="title">{$Photo_library} :: {$name}</td>
  </tr>
  <tr>
    <td id="photoList">{photoListOfGroup}</td>
  </tr>
</table>

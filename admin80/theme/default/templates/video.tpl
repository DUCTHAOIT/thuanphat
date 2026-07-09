{literal}
<script language="javascript" type="text/javascript">
function callLock(id){
	AjaxRequest.get(
		{
		'url':window.location.search + '&op=lockvideo&id='+id
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
			  ,'onSuccess':function(req){ document.getElementById('videoList').innerHTML=req.responseText;}
			  ,'onError':function(req){}
			}
		  );	
		  progress('videoList');		  
		  return status;	
	}
}
</script>
{/literal}
<div style="text-align:right; padding-bottom:5px"><a href="?m=video&op=frm" class="title">{$Create_video}</a></div>
<div id="videoList">{videoList}</div>

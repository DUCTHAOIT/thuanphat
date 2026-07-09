{literal}
<script language="javascript" type="text/javascript">
function callLock(id){
	AjaxRequest.get(
		{
		'url':'?m=member&op=lockMember&id='+id
		,'onSuccess':function(req){document.getElementById('lock_'+id).innerHTML=req.responseText;}
		,'onError':function(req){}
		}
	)	
}
//
function goEdit(id){
	document.frmList.id.value=id;
	document.frmList.op.value='frmCreate';
	document.frmList.submit();	
}
//
function goDelete(id,f){
	if (confirm('are you sure to delete?')!=0){
		document.frmList.id.value=id;
		document.frmList.op.value='mDelelte';
		var status = AjaxRequest.submit(
			f
			,{
			  'url':'?m=member'
			  ,'onSuccess':function(req){ document.getElementById('memberList').innerHTML=req.responseText;}
			  ,'onError':function(req){}
			}
		  );		  
		  return status;	
	}
}
</script>
{/literal}
<div style="text-align:right; padding-bottom:10px"><a href="?m=member&op=frmCreate" class="title">{$Member_create}</a></div>
<div id="memberList">{memberList}</div>

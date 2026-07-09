{literal}
<script language="javascript" type="text/javascript">
function callLock(id){
	AjaxRequest.get(
		{
		'url':'?m=doitac&op=lockdoitac&id='+id
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
			  'url':'?m=doitac'
			  ,'onSuccess':function(req){ document.getElementById('doitacList').innerHTML=req.responseText;}
			  ,'onError':function(req){}
			}
		  );		  
		  return status;	
	}
}
</script>
{/literal}

<div id="doitacList">{doitacList}</div>

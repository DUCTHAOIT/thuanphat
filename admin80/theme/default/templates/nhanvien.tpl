{literal}
<script language="javascript" type="text/javascript">
function callLock(id){
	AjaxRequest.get(
		{
		'url':'?m=nhanvien&op=locknhanvien&id='+id
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
			  'url':'?m=nhanvien'
			  ,'onSuccess':function(req){ document.getElementById('nhanvienList').innerHTML=req.responseText;}
			  ,'onError':function(req){}
			}
		  );		  
		  return status;	
	}
}
</script>
{/literal}

<div id="nhanvienList">{nhanvienList}</div>

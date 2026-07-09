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
function goEdit(id,f){
	document.frmList.id.value=id;
	document.frmList.op.value='frm';
	progress('frm');
	var status = AjaxRequest.submit(
		f
		,{
		  'url':window.location.search
		  ,'onSuccess':function(req){ document.getElementById('frm').innerHTML=req.responseText;}
		  ,'onError':function(req){}
		}
	  );		  
	  return status;	
}
//
function goDelete(id,f){
	if (confirm('are you sure to delete?')!=0){
		document.frmList.id.value=id;
		document.frmList.op.value='delelte';
		progress('listWeblink');	
		var status = AjaxRequest.submit(
			f
			,{
			  'url':window.location.search
			  ,'onSuccess':function(req){ document.getElementById('listWeblink').innerHTML=req.responseText;}
			  ,'onError':function(req){}
			}
		  );		  
		  return status;	
	}
}
//
function callSubmit(f){
	progress('listWeblink');	
	var status = AjaxRequest.submit(
		f
		,{
		  'url':window.location.search
		  ,'onSuccess':function(req){ document.getElementById('listWeblink').innerHTML=req.responseText;}
		  ,'onError':function(req){}
		}
	  );		  
	  return status;
}
</script>
{/literal}
<div style="padding-bottom:10px" class="topic">{$Website_associate}</div>
<div id="frm">{frmWeblink}</div>
<div id="listWeblink">{listWeblink}</div>

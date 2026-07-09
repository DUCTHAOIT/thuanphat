{literal}
<script language="javascript" type="text/javascript">
//
function callSearch(f){
	var status = AjaxRequest.submit(
		f
		,{
		  'url':'?m=user'
		  ,'onSuccess':function(req){ document.getElementById('userList').innerHTML=req.responseText;}
		  ,'onError':function(req){}
		}
	  );
	  progress('userList');
	  return status;		
}
//
function callLock(id){
	AjaxRequest.get(
		{
		'url':'?m=user&op=lockUser&id='+id
		,'onSuccess':function(req){document.getElementById('lock_'+id).innerHTML=req.responseText;}
		,'onError':function(req){}
		}
	)	
}
function callLoai(loai,id){
	if (confirm('Bạn muốn chuyển vai trò của thành viên?')) {
		AjaxRequest.get(
			{
			'url':'?m=user&op=loaiUser&loai='+loai+'&id='+id
			,'onSuccess':function(req){document.getElementById('loai_'+id).innerHTML=req.responseText;}
			,'onError':function(req){}
			}
		)	
		
	} 

}
//
function callHLV(id){
	AjaxRequest.get(
		{
		'url':'?m=user&op=lockHLV&id='+id
		,'onSuccess':function(req){document.getElementById('hlv_'+id).innerHTML=req.responseText;}
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
			  'url':'?m=user'
			  ,'onSuccess':function(req){ document.getElementById('userList').innerHTML=req.responseText;}
			  ,'onError':function(req){}
			}
		  );		  
		  return status;	
	}
}
function txtEnterKey(evt) 
{
   var e=(window.event)?event:evt;
	if(e.keyCode==13){
		document.getElementById('btnSearch').onclick();
		return false;
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
    <td style="padding-left:10px" nowrap="nowrap"><strong>Tên, điện thoại hoặc email:</strong></td>
    <td style="padding-left:10px"><input type="text" class="text" name="keyword" style="width:250" onkeypress="return btnGo_Click(event);" /></td>
    <td style="padding-left:10px; padding-right:10px"><input type="button" id="btnSearch" value="Search" class="button" onclick="callSearch(document.frmSearch)" /></td>
  </tr>
</table></td>
  </tr>
</table>
</form>
<div id="userList">{userList}</div>

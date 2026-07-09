{literal}
<script language="javascript" type="text/javascript">
	function goEdit(id){
		document.frmList.id.value=id;
		document.frmList.op.value='frm';
		document.frmList.submit();	
	}
	//
	function goPhoto(id){
		document.frmList.id.value=id;
		document.frmList.op.value='photo';
		document.frmList.submit();	
	}
	//
	//
	function goFile(id){
		document.frmList.id.value=id;
		document.frmList.op.value='file';
		document.frmList.submit();	
	}
	//
	function goDelete(id,f){
		if (confirm('are you sure to delete?')!=0){
			document.frmList.id.value=id;
			document.frmList.op.value='delete';
			var status = AjaxRequest.submit(
				f
				,{
				  'url':'?m=hdgopvon&op=ban'
				  ,'onSuccess':function(req){ document.getElementById('hdgopvonListban').innerHTML=req.responseText;}
				  ,'onError':function(req){}
				}
			  );		  
			  return status;	
		}
	}
	//
	function callSearch(f){
		var status = AjaxRequest.submit(
			f
			,{
			  'url':'?m=hdgopvon'
			  ,'onSuccess':function(req){ document.getElementById('hdgopvonList').innerHTML=req.responseText;}
			  ,'onError':function(req){}
			}
		  );
		  progress('hdgopvonListban');
		  return status;		
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
			'url':'?m=hdgopvon&op=lockhdgopvon&id='+id
			,'onSuccess':function(req){document.getElementById('lock_'+id).innerHTML=req.responseText;}
			,'onError':function(req){}
			}
		)	
	}
</script>
{/literal}
<div class="topic">Quản lý hợp đồng bán TSBV</div>
<div align="right"><a href="?m=hdgopvon&op=frm" class="title">{$Create}</a></div>
<div id="hdgopvonList">{hdgopvonListban}</div>

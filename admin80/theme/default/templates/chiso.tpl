{literal}
	<script language="javascript" type="text/javascript">
		function callSearch(f)
		{			
			var status = AjaxRequest.submit(
			f
			,{
			  'url':'?m=chiso'
			  ,'onSuccess':function(req){ document.getElementById('listchiso').innerHTML=req.responseText;}
			  ,'onError':function(req){}
			}
		  );
		  progress('listchiso');
		  return status;		
		}	
		function goEdit(id){
			document.frmListchiso.id.value=id;
			document.frmListchiso.op.value='frm';
			document.frmListchiso.submit();	
		}
		//
		function goDelete(id,f){
		if (confirm('Bạn có chắc chắn xóa?')!=0){
			document.frmListchiso.id.value=id;
			document.frmListchiso.op.value='delete';
			var status = AjaxRequest.submit(
				f
				,{
				  'url':'?m=chiso'
				  ,'onSuccess':function(req){ document.getElementById('listchiso').innerHTML=req.responseText;}
				  ,'onError':function(req){}
				}
			  );
			  progress('listchiso');
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
<div class="topic">Chart TSTT</div>
<div style="text-align:right"><a href="?m=chiso&op=frm" class="title">Thêm mới</a></div>
<div id="listchiso">{listchiso}</div>
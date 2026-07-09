{literal}
<script language="javascript" type="text/javascript">
function listBlockOnPage(pid,pos,f){
	document.frmListBlockOnPage.pid.value=pid;
	document.frmListBlockOnPage.pos.value=pos;
	
	AjaxRequest.get(
				{
				'url':'?m=block&op=getPath&pid='+pid+'&pos='+pos
				,'onSuccess':function(req){document.getElementById('path').innerHTML=req.responseText;}
				,'onError':function(req){}
				}
			)	
	
	var status = AjaxRequest.submit(
		f
		,{
		  'url':'?m=block'
		  ,'onSuccess':function(req){ document.getElementById('listBlockOnPage').innerHTML=req.responseText;}
		  ,'onError':function(req){}
		}
	  );
	  progress('listBlockOnPage');
	  return status;
	}
	//
	function calladdBlockOnPage(f){
			var status = AjaxRequest.submit(
		f
		,{
		  'url':'?m=block'
		  ,'onSuccess':function(req){ document.getElementById('listBlockOnPage').innerHTML=req.responseText;}
		  ,'onError':function(req){}
		}
	  );
	  progress('listBlockOnPage');
	  return status;
	}
	function goDelete(id,f){
		if (confirm('Do you delete?')!=0){
			document.frmBlockOnPage.id.value=id;
			document.frmBlockOnPage.op.value='deleteBlockOnPage';			
			var status = AjaxRequest.submit(
				f
				,{
				  'url':'?m=block'
				  ,'onSuccess':function(req){ document.getElementById('listBlockOnPage').innerHTML=req.responseText;}
				  ,'onError':function(req){}
				}
			  );
			  progress('listBlockOnPage');
			  return status;	
		}
	}
	//
	function orderBlock(id,type,f){
		document.frmBlockOnPage.id.value=id;
		document.frmBlockOnPage.op.value='orderBlock';
		var status = AjaxRequest.submit(
			f
			,{
			  'url':'?m=block&type='+type
			  ,'onSuccess':function(req){ document.getElementById('listBlockOnPage').innerHTML=req.responseText;}
			  ,'onError':function(req){}
			}
		  );
		  progress('listBlockOnPage');
		  return status;
	}
	//
	function callLock(id){
		AjaxRequest.get(
			{
			'url':'?m=block&op=lockBlockOnPage&id='+id
			,'onSuccess':function(req){document.getElementById('lock_'+id).innerHTML=req.responseText;}
			,'onError':function(req){}
			}
		)	
	}
</script>
{/literal}

<table width="100%%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="right">
	<table width="100%%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td class="topic" style="padding-left:0px">Block</td>
        <td align="right"><a href="?m=block&op=frmBlock" class="title">{$Create}</a> &nbsp; &nbsp; <a href="?m=block&op=blockList" class="title">{$Block_list}</a></td>
      </tr>
    </table>	</td>
  </tr>
  <tr>
    <td>{pageList}</td>
  </tr>
  <tr>
    <td id="path" class="title"></td>
  </tr>
  <tr>
    <td id="listBlockOnPage"></td>
  </tr>
</table>

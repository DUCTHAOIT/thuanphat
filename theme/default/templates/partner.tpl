{literal}
<script language="javascript" type="text/javascript">
function callSearch(f){
	var keyword,obj;
	obj=document.frmSearch;
	keyword=obj.txtSearch.value;	
	if(keyword){		
		//obj.submit();
		searchDocument(f)
	}else obj.txtSearch.focus();	
	
}

function txtEnterKey(evt) 
{
   var e=(window.event)?event:evt;
	if(e.keyCode==13){
		document.getElementById('btnSearch').onclick();
		return false;
	}
}
//
function searchDocument(f){
	var status = AjaxRequest.submit(
		f
		,{
		  'url':'?m=partner&op=search'
		  ,'onSuccess':function(req){ document.getElementById('partnerList').innerHTML=req.responseText;}
		  ,'onError':function(req){}
		}
	  );
	  progress('partnerList');
	  return status;
}
</script>
{/literal}
<section class="text-center hlvbg">
<div class="container" align="center">
	<div class="namefun text-center">{$nameFun}</div>
	<div class="text-center">
        <h1 class="topiccontent">{$name}</h1>
    </div>
    <div class="des">
    	{if $des}<div class="content" align="center" >{$des}</div>{/if}
    </div>
    <div class="row" >{partnerList}</div>
</div>
</section>
{literal}
<script>	
	function goDeletenhanxet(id,iduserorder,sogiohoc){
		if (confirm('Bạn muốn xóa nhận xét?')) {
			AjaxRequest.get(
				{
				'url':'../../?m=user&f=deletenhanxet&id='+id+'&iduserorder='+iduserorder+'&sogiohoc='+sogiohoc
				,'onSuccess':function(req){ document.getElementById('diemdanh_'+iduserorder).innerHTML=req.responseText;}
			 	 ,'onError':function(req){}				
				}
			)	
		} 
	}
	//
</script>
{/literal}
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="table"  style="border:1px solid #CCCCCC">
  <tr>
    <td colspan="4"><p><strong>Điểm danh</strong> </p></td>
  </tr>
  <tr style="background-color:#0b7a62">
    <td  style="vertical-align: middle; text-align:center; color:#FFFFFF; font-size:0.8rem;" nowrap="nowrap">Ngày Học</td>
    <td  style="vertical-align: middle; text-align:center; color:#FFFFFF; font-size:0.8rem;" nowrap="nowrap">Số Giờ</td>
    <td  style="vertical-align: middle; text-align:center; color:#FFFFFF; font-size:0.8rem;" width="100%">Nhận Xét của giáo viên</td>
    {if $MemberHlv=='1'}<td></td>{/if}
  </tr>
  {assign var="i" value=1}
  {foreach key=key item=item from=$arr}
  <tr>
    <td nowrap="nowrap">{$item.date_create}</td>
    <td nowrap="nowrap" align="center">{$item.sogiohoc}</td>
    <td>{$item.comments}</td>
    {if $MemberHlv=='1'}
    <td onclick="goDeletenhanxet('{$key}','{$item.iduserorder}','{$item.sogiohoc}')" style="cursor:pointer; width:13px"><i class="fa fa-trash" aria-hidden="true"></i></td>
    {/if}
  </tr>
  {assign var="i" value=$i+1}
{/foreach}
</table>
{literal}{/literal}
<table width="100%%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td style="padding:20px"><table width="100%%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="title">{$arr.subject}</td>
  </tr>
  <tr>
    <td style="padding-bottom:5px; padding-top:5px">
	<div style="color:#666666;"><em>{if $arr.name}{$Name}: <strong>{$arr.name}</strong> &nbsp; {/if}{$Date}: <strong>{$arr.date_create}</strong></em></div>
	<em>{$arr.question}</em></td>
  </tr>
  <tr>
    <td style="padding-top:5px; padding-bottom:10px;">	
	{$arr.answer}	</td>
  </tr>
  <tr>
    <td></td>
  </tr>
</table></td>
  </tr>
</table>
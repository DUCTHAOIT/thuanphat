{assign var="i" value=1}
<div align="center"><strong>Lớp:</strong> {$name}</div>
<div align="center"><strong>HLV:</strong></div>

{foreach key=key item=item from=$arruser}
<div align="center">{$item.name}</div>
{assign var="i" value=$i+1}
{/foreach}
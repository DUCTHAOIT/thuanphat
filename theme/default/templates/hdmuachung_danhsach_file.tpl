{assign var="i" value=1}
{foreach key=key item=item from = $arrdanhsachListfile}
  <li><a href="{$smarty.const._DOMAIN_ROOT_URL}/lib/{$item.logo}" class="content">{$item.name}</a></li>
{assign var="i" value=$i+1}
{/foreach}
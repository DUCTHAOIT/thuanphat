<div class="tieude_tintuc">{$arr.name}</div>
 <div class="news-day">{$arr.date_create}</div>
  {if $arr.source}<div style="font-size:11px; color:#999999">({if $arr.title_img}<a href="{$arr.title_img}" target="_blank"  style="font-size:11px; color:#999999">{$arr.source}</a>{else}{$arr.source}{/if})</div>{/if}
  {if $arr.summary}<div style="font-size:16px; color:#999999; padding-bottom:10px">{$arr.summary}</div>{/if}  
  <div class="showText">
    <div class="kietxuat_lead">{$arr.content}</div>   
 </div>
<div class="clr"></div>
 <div class="article"><h1 class="widget-title">{if $lang=='vn'}Tin liên quan{else}Related news{/if}</h1></div>
<div>
<ul>
{section name=i loop=$arrre start=$pageID max=$limit}
{if $arrre[i].id<>$arr.id}  
                <li style="border-bottom: 1px solid #ececec; padding-bottom: 10px;   padding-bottom: 1rem;   margin-bottom: 10px;    margin-bottom: 1rem; height:88px">
                        <div class="thumbnail">
                            <a href="{$smarty.const._DOMAIN_ROOT_URL}/{$arrre[i].htaccess}{$arrre[i].alias}"><img src="{$smarty.const._DOMAIN_ROOT_URL}/image.php?width=95&image={$smarty.const._DOMAIN_ROOT_URL}/images/inveslist/{$arrre[i].img}" alt="{$title}" title="{$title}" border="0" vspace="0"  hspace="0" width="95px" height="75px"/></a>	
                        </div>
                        <div class="thumbnail_fix">
                            <div class="news-day">{$arrre[i].date_create}</div>
                            <a href="{$smarty.const._DOMAIN_ROOT_URL}/{$arrre[i].htaccess}{$arrre[i].alias}" class="title"  title="{$title}" >{$arrre[i].name}</a>
                        </div>
				</li>
{/if}	    
{/section}
</ul>
</div>
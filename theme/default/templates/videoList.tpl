<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td  class="contentFun"><div>{$nameFun}</div>	</td>
  </tr> 
</table>
<div class="title" style="padding:10px; font-size:16px">{$name}</div>
{if $arr.youtube}
    <iframe width="100%" height="450" src="http://www.youtube.com/embed/{$arr.youtube}?modestbranding=1&autoplay=1" frameborder="0" allowfullscreen></iframe>
{else}
  <script type="text/javascript" src="{$smarty.const._DOMAIN_ROOT_URL}/js/swfobject.js"></script>
   <div id="preview"><a href="http://www.macromedia.com/go/getflashplayer">Trình duyệt của bạn chưa cài flash</a> để xem video này.</div>
   <script type="text/javascript">
        var so = new SWFObject('{$smarty.const._DOMAIN_ROOT_URL}/flash/player.swf','mpl','680px','543px','0');
        so.addParam('allowscriptaccess','always');
        so.addParam('allowfullscreen','true');
        so.addParam('flashvars','&file={$smarty.const._DOMAIN_ROOT_URL}/img/video/{$arr.img1}&image={$smarty.const._DOMAIN_ROOT_URL}/img/video/{$arr.img}&backcolor=C2C2C2&frontcolor=000000&lightcolor=000000&screencolor=000000');
        so.write('preview');
    </script>
{/if}	
<div class="content" style="text-align:justify; padding:10px">
    {$des}
</div>  

<div class="col-xs-12 col-sm-12 col-md-12 title" style="background-color:#e7e7e7; font-size:16px; color:#2f2f2f; padding:10px; text-transform:uppercase">Video liên quan</div>
{assign var="k" value="0"}
{assign var="j" value="0"}
{foreach item=item key=key from=$arrre}
{if $key<>$id}
 <div class="col-xs-6 col-sm-6 col-md-4 z-depth-0"  style="padding-bottom:10px; padding-top:10px;">	
   <a href="{$smarty.const._DOMAIN_ROOT_URL}/{$url}&id={$key}"><img src="http://img.youtube.com/vi/{$item.youtube}/0.jpg" border="0"   width="100%"  vspace="0" hspace="0"  style="border:1px solid #eeeef0"/></a>
    <p class="title" style="padding:5px; height:30px"><a href="{$smarty.const._DOMAIN_ROOT_URL}/{$url}&id={$key}" class="title">{$item.name}</a></p>
 </div>						 			  
{assign var="j" value="$j+1"}	
{/if}			 
{/foreach}
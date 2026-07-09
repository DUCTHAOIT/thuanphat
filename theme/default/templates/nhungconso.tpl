{literal}
<script type="text/javascript" src="../../js/static/js/jquery-1.8.3.min.js"></script>
<script src="../../js/static/js/jquery.cycle2.js"></script>
{/literal}
<div>
<table bolder="0" width="100%" cellpadding="0" cellspacing="0">
    <tr>
        <td style="padding-bottom:2px"><a href=# id="prev"><img src="{$smarty.const._DOMAIN_ROOT_URL}/theme_images/number-left.png" alt="" border="0"></a></td>
        <td class="blog-number-header" style="padding-bottom:2px; padding-top: 15px; color:#000000; width:100%; font-size:14px">NHỮNG CON SỐ</td>
        <td style="padding-bottom:2px"><a href=# id="next"><img src="{$smarty.const._DOMAIN_ROOT_URL}/theme_images/number-right.png" alt="" border="0"></a></td>
    </tr>

</table>
   <div colspan="3" class="cycle-slideshow"
        data-cycle-fx="scrollHorz"
        data-cycle-timeout="4000"
        data-cycle-prev="#prev"
        data-cycle-next="#next"
        data-cycle-slides="> a"
            >
        {foreach item=item key=key from=$arr}			
         <a href="{$item.website}"><img   src="{$smarty.const._DOMAIN_ROOT_URL}/img/advertise/{$item.img}" width="285px"  border="0" /></a>
        {/foreach}
    </div>
</div>    

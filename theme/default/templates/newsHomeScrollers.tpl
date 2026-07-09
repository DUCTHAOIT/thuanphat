<div>
    <table>
        <tr>
            <td style="color:#27b28b" class="title" >
                News:&nbsp;
            </td>
            <td style="padding-top:8px">
                <marquee onmouseover="this.stop()" onmouseout="this.start()" scrollamount="5">
                {foreach key=key item=item from=$arr}  
                    <span style="color:#FFFFFF"><a href="{$smarty.const._DOMAIN_ROOT_URL}/{$item.htaccess}{$item.alias}" class="content" style="color:#FFFFFF">{$item.name}</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;</span>
                {/foreach}	
            </marquee>
            </td>
        </tr>
    </table>
</div>
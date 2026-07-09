{assign var="i" value="0"}
{foreach item=item key=key from=$arr}
<div class="banner banner--qc pr">
        <div class="item">
            <div class="banner__img"><img src="{$smarty.const._DOMAIN_ROOT_URL}/img/advertise/{$item.img}" alt=""></div>
            <div class="banner__content_qc">
                <div class="container">
                   <div class="item_content_qc" align="left" style="padding-left:20px;">
                        <h2 style="font-weight:500">{$item.name}</h2>
                        <p  style="font-weight:500">{$item.address}</p>
                        <a href="{$smarty.const._DOMAIN_ROOT_URL}/user/" class="btn_viewmore flex-center">Đăng ký ngay</a>
                    </div>
                </div>
            </div>
        </div>
 </div>
{assign var="i" value="$i+1"}	 
{/foreach}
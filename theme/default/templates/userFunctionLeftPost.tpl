<div style="padding:0px; height:300px" class="img-thumbnail">
    <div align="center" class="cover" style="padding-top:20px">
    	<p align="center" class="topic">{$arr.name}</p>
    	{if $arr.img}<img src="{$smarty.const._DOMAIN_ROOT_URL}/images/user/{$arr.img}" border="0" hspace="0" vspace="0" style=" border: 1px #d4d4d4 solid;
    border-radius:50%;
    -moz-border-radius:50%;
    -webkit-border-radius:50%; width:50%"/>{else}<img src="{$smarty.const._DOMAIN_ROOT_URL}/theme_images/avatar.jpg" border="0" hspace="0" vspace="0" class="img-fluid"  style=" border: 1px #d4d4d4 solid;
    border-radius:50%;
    -moz-border-radius:50%;
    -webkit-border-radius:50%;" />{/if}
    </div>
    <div style="padding-left:10px; padding-top:90px;"><i class="fa fa-list-alt" aria-hidden="true"></i> <a href="{$smarty.const._DOMAIN_ROOT_URL}/user_post_{$arr.id}/" class="content">Các bài đã viết</a></div>
    <div style="padding-left:10px; padding-top:10px"><i class="fa fa-envelope-o" aria-hidden="true"></i> <a href="mailto:{$arr.email}" class="content">Liên hệ</a></div>
    
</div>
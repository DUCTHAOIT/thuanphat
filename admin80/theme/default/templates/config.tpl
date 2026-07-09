<form name="frmmain" action="index.php" method="post" enctype="multipart/form-data">
<input type="hidden" name="m" value="config" />
<input type="hidden" name="op" value="update" />
<div id="view">
<table width="100%" cellpadding="5" style="border:1px solid #F2F2F2; padding-left:5" id="main">
  <tr >
    <td colspan="2" style="padding-left:10;"><h2>Cấu hình hệ thống</h2></td>
  </tr> 
  
  <tr>
    <td style="border-bottom:1ps solid #f2f2f2">{$Web_title}</td>
    <td style="border-bottom:1ps solid #f2f2f2">
    <input type="text" class="form-control" name="web_title" style="width:100%;" value="{$arr.web_title}" /></td>
  </tr>
  
  <tr>
    <td style="border-bottom:1ps solid #f2f2f2">{$Email}</td>
    <td style="border-bottom:1ps solid #f2f2f2"><input type="text" class="form-control" name="email" style="width:100%;" value="{$arr.email}" /></td>
  </tr>
  <tr>
    <td style="border-bottom:1ps solid #f2f2f2">{$Yahoo_online}</td>
    <td style="border-bottom:1ps solid #f2f2f2"><input type="form-control" class="form-control" name="ymsupport" style="width:100%;" value="{$arr.ymsupport}" /></td>
  </tr>
  <tr>
    <td style="border-bottom:1ps solid #f2f2f2">Nick skype</td>
    <td style="border-bottom:1ps solid #f2f2f2"><input type="form-control" class="form-control" name="skype" style="width:100%;" value="{$arr.skype}" /></td>
  </tr>
  <tr>
    <td style="border-bottom:1ps solid #f2f2f2">Facebook</td>
    <td style="border-bottom:1ps solid #f2f2f2"><input type="form-control" class="form-control" name="hotline" style="width:100%;" value="{$arr.hotline}" /></td>
  </tr>
  <tr>
    <td style="border-bottom:1ps solid #f2f2f2">Sales Online</td>
    <td style="border-bottom:1ps solid #f2f2f2"><input type="form-control" class="form-control" name="tel" style="width:100%;" value="{$arr.tel}" /></td>
  </tr>
  <tr>
    <td style="border-bottom:1ps solid #f2f2f2">%F1</td>
    <td style="border-bottom:1ps solid #f2f2f2"><input type="form-control" class="form-control" name="f1" style="width:100%;" value="{$arr.f1}" /></td>
  </tr>
  <tr>
    <td style="border-bottom:1ps solid #f2f2f2">%F2</td>
    <td style="border-bottom:1ps solid #f2f2f2"><input type="form-control" class="form-control" name="f2" style="width:100%;" value="{$arr.f2}" /></td>
  </tr>
  <tr>
    <td style="border-bottom:1ps solid #f2f2f2">%F3</td>
    <td style="border-bottom:1ps solid #f2f2f2"><input type="form-control" class="form-control" name="f3" style="width:100%;" value="{$arr.f3}" /></td>
  </tr>
  <tr>
    <td style="border-bottom:1ps solid #f2f2f2">Meta description</td>
    <td width="100%" style="border-bottom:1ps solid #f2f2f2"><textarea name="site_name" class="form-control" style="width:100%; height:80;">{$arr.site_name}</textarea></td>
  </tr>
  <tr>
    <td style="border-bottom:1ps solid #f2f2f2">{$Meta_key}</td>
    <td style="border-bottom:1ps solid #f2f2f2"><textarea name="meta_keys" class="form-control" style="width:100%; height:80;">{$arr.meta_keys}</textarea></td>
  </tr>
  <tr>
    <td style="border-bottom:1ps solid #f2f2f2">{$Address}</td>
    <td style="border-bottom:1ps solid #f2f2f2"><textarea name="address" class="form-control" style="width:100%; height:80;">{$arr.address}</textarea></td>
  </tr>
  
  <tr>
    <td style="border-bottom:1ps solid #f2f2f2" nowrap="nowrap">{$Contact}</td>
    <td style="border-bottom:1ps solid #f2f2f2"><textarea name="des" class="form-control" style="width:100%; height:80;">{$arr.des}</textarea></td>
  </tr>
    <tr>
    <td style="border-bottom:1ps solid #f2f2f2" nowrap="nowrap">Google Maps</td>
    <td style="border-bottom:1ps solid #f2f2f2"><textarea name="support" class="form-control" style="width:100%; height:80;">{$arr.support}</textarea></td>
  </tr>
  <tr>
    <td style="border-bottom:1ps solid #f2f2f2">{$Theme}</td>
    <td style="border-bottom:1ps solid #f2f2f2"><select name="theme" class="form-select"><option value="default">default</option></select></td>
  </tr>
  <tr>
    <td style="border-bottom:1ps solid #f2f2f2">{$Language}</td>
    <td style="border-bottom:1ps solid #f2f2f2">{getCboLanguage lang=$lang}</td>
  </tr>
  <tr>
    <td style="border-bottom:1ps solid #f2f2f2">Rewrite URL?</td>
    <td style="border-bottom:1ps solid #f2f2f2"><input type="checkbox"  name="rewrite_url" {if $arr.rewrite_url=='htaccess'} checked="checked" {/if} /></td>
  </tr>
  <tr>
    <td style="border-bottom:1ps solid #f2f2f2">&nbsp;</td>
    <td style="border-bottom:1ps solid #f2f2f2"><input type="submit" value="{$Update}"  class="btn btn-primary"/></td>
  </tr>  
</table>
</div>
</form>
<?php
/* Smarty version 3.1.36, created on 2026-07-11 16:10:13
  from 'C:\xampp\htdocs\thuanphatitc.vn\admin80\theme\default\templates\config.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.36',
  'unifunc' => 'content_6a524ec5644a61_82777192',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '4ece770c1b0c6ada5a9fe9adab0e9d68d7cfa181' => 
    array (
      0 => 'C:\\xampp\\htdocs\\thuanphatitc.vn\\admin80\\theme\\default\\templates\\config.tpl',
      1 => 1783779010,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6a524ec5644a61_82777192 (Smarty_Internal_Template $_smarty_tpl) {
?><form name="frmmain" action="index.php" method="post" enctype="multipart/form-data">

  <input type="hidden" name="m" value="config" />

  <input type="hidden" name="op" value="update" />

  <div id="view">

    <table width="100%" cellpadding="5" style="border:1px solid #F2F2F2; padding-left:5" id="main">

      <tr>

        <td colspan="2" style="padding-left:10;">
          <h2>Cấu hình hệ thống</h2>
        </td>

      </tr>



      <tr>

        <td style="border-bottom:1ps solid #f2f2f2"><?php echo $_smarty_tpl->tpl_vars['Web_title']->value;?>
</td>

        <td style="border-bottom:1ps solid #f2f2f2">

          <input type="text" class="form-control" name="web_title" style="width:100%;" value="<?php echo $_smarty_tpl->tpl_vars['arr']->value['web_title'];?>
" />
        </td>

      </tr>



      <tr>

        <td style="border-bottom:1ps solid #f2f2f2"><?php echo $_smarty_tpl->tpl_vars['Email']->value;?>
</td>

        <td style="border-bottom:1ps solid #f2f2f2"><input type="text" class="form-control" name="email"
            style="width:100%;" value="<?php echo $_smarty_tpl->tpl_vars['arr']->value['email'];?>
" /></td>

      </tr>

      <tr>

        <td style="border-bottom:1ps solid #f2f2f2"><?php echo $_smarty_tpl->tpl_vars['Yahoo_online']->value;?>
</td>

        <td style="border-bottom:1ps solid #f2f2f2"><input type="form-control" class="form-control" name="ymsupport"
            style="width:100%;" value="<?php echo $_smarty_tpl->tpl_vars['arr']->value['ymsupport'];?>
" /></td>

      </tr>

      <tr>

        <td style="border-bottom:1ps solid #f2f2f2">Nick skype</td>

        <td style="border-bottom:1ps solid #f2f2f2"><input type="form-control" class="form-control" name="skype"
            style="width:100%;" value="<?php echo $_smarty_tpl->tpl_vars['arr']->value['skype'];?>
" /></td>

      </tr>

      <tr>

        <td style="border-bottom:1ps solid #f2f2f2">Facebook</td>

        <td style="border-bottom:1ps solid #f2f2f2"><input type="form-control" class="form-control" name="hotline"
            style="width:100%;" value="<?php echo $_smarty_tpl->tpl_vars['arr']->value['hotline'];?>
" /></td>

      </tr>

      <tr>

        <td style="border-bottom:1ps solid #f2f2f2">Sales Online</td>

        <td style="border-bottom:1ps solid #f2f2f2"><input type="form-control" class="form-control" name="tel"
            style="width:100%;" value="<?php echo $_smarty_tpl->tpl_vars['arr']->value['tel'];?>
" /></td>

      </tr>

      <tr>

        <td style="border-bottom:1ps solid #f2f2f2">Meta description</td>

        <td width="100%" style="border-bottom:1ps solid #f2f2f2"><textarea name="site_name" class="form-control"
            style="width:100%; height:80;"><?php echo $_smarty_tpl->tpl_vars['arr']->value['site_name'];?>
</textarea></td>

      </tr>

      <tr>

        <td style="border-bottom:1ps solid #f2f2f2"><?php echo $_smarty_tpl->tpl_vars['Meta_key']->value;?>
</td>

        <td style="border-bottom:1ps solid #f2f2f2"><textarea name="meta_keys" class="form-control"
            style="width:100%; height:80;"><?php echo $_smarty_tpl->tpl_vars['arr']->value['meta_keys'];?>
</textarea></td>

      </tr>

      <tr>

        <td style="border-bottom:1ps solid #f2f2f2"><?php echo $_smarty_tpl->tpl_vars['Address']->value;?>
</td>

        <td style="border-bottom:1ps solid #f2f2f2"><textarea name="address" class="form-control"
            style="width:100%; height:80;"><?php echo $_smarty_tpl->tpl_vars['arr']->value['address'];?>
</textarea></td>

      </tr>



      <tr>

        <td style="border-bottom:1ps solid #f2f2f2" nowrap="nowrap"><?php echo $_smarty_tpl->tpl_vars['Contact']->value;?>
</td>

        <td style="border-bottom:1ps solid #f2f2f2"><textarea name="des" class="form-control"
            style="width:100%; height:80;"><?php echo $_smarty_tpl->tpl_vars['arr']->value['des'];?>
</textarea></td>

      </tr>

      <tr>

        <td style="border-bottom:1ps solid #f2f2f2" nowrap="nowrap">Google Maps</td>

        <td style="border-bottom:1ps solid #f2f2f2"><textarea name="support" class="form-control"
            style="width:100%; height:80;"><?php echo $_smarty_tpl->tpl_vars['arr']->value['support'];?>
</textarea></td>

      </tr>

      <tr>

        <td style="border-bottom:1ps solid #f2f2f2"><?php echo $_smarty_tpl->tpl_vars['Theme']->value;?>
</td>

        <td style="border-bottom:1ps solid #f2f2f2"><select name="theme" class="form-select">
            <option value="default">default</option>
          </select></td>

      </tr>

      <tr>

        <td style="border-bottom:1ps solid #f2f2f2"><?php echo $_smarty_tpl->tpl_vars['Language']->value;?>
</td>

        <td style="border-bottom:1ps solid #f2f2f2"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['getCboLanguage'][0], array( array('lang'=>$_smarty_tpl->tpl_vars['lang']->value),$_smarty_tpl ) );?>
</td>

      </tr>

      <tr>

        <td style="border-bottom:1ps solid #f2f2f2">Rewrite URL?</td>

        <td style="border-bottom:1ps solid #f2f2f2"><input type="checkbox" name="rewrite_url" <?php if ($_smarty_tpl->tpl_vars['arr']->value['rewrite_url'] == 'htaccess') {?> checked="checked" <?php }?> /></td>

      </tr>

      <tr>
        <td style="border-bottom:1ps solid #f2f2f2">% tối đa thanh toán bằng điểm thẻ tiêu dùng</td>
        <td style="border-bottom:1ps solid #f2f2f2">
          <input type="text" class="form-control" name="card_payment_percent" style="width:100px;"
            value="<?php if ($_smarty_tpl->tpl_vars['arr']->value['card_payment_percent'] == '') {?>100<?php } else {
echo $_smarty_tpl->tpl_vars['arr']->value['card_payment_percent'];
}?>" />
          <!-- <em>(0-100, mục 3 BUSINESS_RULES.md - đơn hàng chỉ được thanh toán tối đa % này bằng điểm thẻ tiêu dùng)</em> -->
        </td>
      </tr>
      <tr>

        <td style="border-bottom:1ps solid #f2f2f2">&nbsp;</td>

        <td style="border-bottom:1ps solid #f2f2f2"><input type="submit" value="<?php echo $_smarty_tpl->tpl_vars['Update']->value;?>
" class="btn btn-primary" />
        </td>

      </tr>

    </table>

  </div>

</form><?php }
}

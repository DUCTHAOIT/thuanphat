<?php
/* Smarty version 3.1.36, created on 2026-07-16 17:25:15
  from 'C:\xampp\htdocs\thuanphatitc.vn\admin80\theme\default\templates\config.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.36',
  'unifunc' => 'content_6a58f7dbc515b4_40410545',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '4ece770c1b0c6ada5a9fe9adab0e9d68d7cfa181' => 
    array (
      0 => 'C:\\xampp\\htdocs\\thuanphatitc.vn\\admin80\\theme\\default\\templates\\config.tpl',
      1 => 1784215421,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6a58f7dbc515b4_40410545 (Smarty_Internal_Template $_smarty_tpl) {
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
        <td style="border-bottom:1ps solid #f2f2f2; width:320px !important; min-width:320px !important; max-width:320px !important;">% tối đa thanh toán bằng điểm thẻ tiêu dùng</td>
        <td style="border-bottom:1ps solid #f2f2f2">
          <input type="text" class="form-control" name="card_payment_percent" style="width:100px;"
            value="<?php if ($_smarty_tpl->tpl_vars['arr']->value['card_payment_percent'] == '') {?>100<?php } else {
echo $_smarty_tpl->tpl_vars['arr']->value['card_payment_percent'];
}?>" />
          <!-- <em>(0-100, mục 3 BUSINESS_RULES.md - đơn hàng chỉ được thanh toán tối đa % này bằng điểm thẻ tiêu dùng)</em> -->
        </td>
      </tr>
      <tr>
        <td style="border-bottom:1ps solid #f2f2f2; width:320px !important; min-width:320px !important; max-width:320px !important;">% quỹ chia hoa hồng trích vào quỹ vận hành</td>
        <td style="border-bottom:1ps solid #f2f2f2">
          <input type="text" class="form-control" name="operating_fund_percent" style="width:100px;"
            value="<?php if ($_smarty_tpl->tpl_vars['arr']->value['operating_fund_percent'] == '') {?>10<?php } else {
echo $_smarty_tpl->tpl_vars['arr']->value['operating_fund_percent'];
}?>" />
        </td>
      </tr>
      <tr>
        <td style="border-bottom:1ps solid #f2f2f2; width:320px !important; min-width:320px !important; max-width:320px !important;">% quỹ chia hoa hồng trích vào Tích lũy tiêu dùng</td>
        <td style="border-bottom:1ps solid #f2f2f2">
          <input type="text" class="form-control" name="accumulated_consumption_percent" style="width:100px;"
            value="<?php if ($_smarty_tpl->tpl_vars['arr']->value['accumulated_consumption_percent'] == '') {?>10<?php } else {
echo $_smarty_tpl->tpl_vars['arr']->value['accumulated_consumption_percent'];
}?>" />
        </td>
      </tr>
      <tr>
        <td style="border-bottom:1ps solid #f2f2f2; width:320px !important; min-width:320px !important; max-width:320px !important;">% quỹ chia hoa hồng trích vào thưởng tiêu dùng tuần hoàn</td>
        <td style="border-bottom:1ps solid #f2f2f2">
          <input type="text" class="form-control" name="card_recurring_percent" style="width:100px;"
            value="<?php if ($_smarty_tpl->tpl_vars['arr']->value['card_recurring_percent'] == '') {?>16<?php } else {
echo $_smarty_tpl->tpl_vars['arr']->value['card_recurring_percent'];
}?>" />
        </td>
      </tr>
      <tr>
        <td style="border-bottom:1ps solid #f2f2f2; width:320px !important; min-width:320px !important; max-width:320px !important;">% thưởng tiêu dùng tuần hoàn chia cho tuyến trên<br /><small style="color:#6b7280; font-weight:normal;">(còn lại vào Quỹ tiêu dùng tuần hoàn công ty)</small></td>
        <td style="border-bottom:1ps solid #f2f2f2">
          <input type="text" class="form-control" name="recurring_consumption_ancestor_percent" style="width:100px;"
            value="<?php if ($_smarty_tpl->tpl_vars['arr']->value['recurring_consumption_ancestor_percent'] == '') {?>70<?php } else {
echo $_smarty_tpl->tpl_vars['arr']->value['recurring_consumption_ancestor_percent'];
}?>" />
        </td>
      </tr>
      <tr>
        <td style="border-bottom:1ps solid #f2f2f2; vertical-align:top;">Tỉ lệ % hoa hồng theo tầng F1-F8<br />(mục 4 &amp; 6 BUSINESS_RULES.md)</td>
        <td style="border-bottom:1ps solid #f2f2f2">
          <table class="table table-bordered" style="width:auto;">
            <tr>
              <th>Tầng</th>
              <th>Hoa hồng sơ đồ trực tiếp (%)</th>
              <th>Hoa hồng cây điều tầng (%)</th>
            </tr>
            <tr>
              <td>F1</td>
              <td><input type="text" class="form-control" name="f1" style="width:90px;" value="<?php if ($_smarty_tpl->tpl_vars['arr']->value['f1'] == '') {?>16<?php } else {
echo $_smarty_tpl->tpl_vars['arr']->value['f1']*100;
}?>" /></td>
              <td><input type="text" class="form-control" name="spillover_f1" style="width:90px;" value="<?php if ($_smarty_tpl->tpl_vars['arr']->value['spillover_f1'] == '') {?>3<?php } else {
echo $_smarty_tpl->tpl_vars['arr']->value['spillover_f1']*100;
}?>" /></td>
            </tr>
            <tr>
              <td>F2</td>
              <td><input type="text" class="form-control" name="f2" style="width:90px;" value="<?php if ($_smarty_tpl->tpl_vars['arr']->value['f2'] == '') {?>2<?php } else {
echo $_smarty_tpl->tpl_vars['arr']->value['f2']*100;
}?>" /></td>
              <td><input type="text" class="form-control" name="spillover_f2" style="width:90px;" value="<?php if ($_smarty_tpl->tpl_vars['arr']->value['spillover_f2'] == '') {?>3<?php } else {
echo $_smarty_tpl->tpl_vars['arr']->value['spillover_f2']*100;
}?>" /></td>
            </tr>
            <tr>
              <td>F3</td>
              <td><input type="text" class="form-control" name="f3" style="width:90px;" value="<?php if ($_smarty_tpl->tpl_vars['arr']->value['f3'] == '') {?>2<?php } else {
echo $_smarty_tpl->tpl_vars['arr']->value['f3']*100;
}?>" /></td>
              <td><input type="text" class="form-control" name="spillover_f3" style="width:90px;" value="<?php if ($_smarty_tpl->tpl_vars['arr']->value['spillover_f3'] == '') {?>3<?php } else {
echo $_smarty_tpl->tpl_vars['arr']->value['spillover_f3']*100;
}?>" /></td>
            </tr>
            <tr>
              <td>F4</td>
              <td><input type="text" class="form-control" name="f4" style="width:90px;" value="<?php if ($_smarty_tpl->tpl_vars['arr']->value['f4'] == '') {?>2<?php } else {
echo $_smarty_tpl->tpl_vars['arr']->value['f4']*100;
}?>" /></td>
              <td><input type="text" class="form-control" name="spillover_f4" style="width:90px;" value="<?php if ($_smarty_tpl->tpl_vars['arr']->value['spillover_f4'] == '') {?>3<?php } else {
echo $_smarty_tpl->tpl_vars['arr']->value['spillover_f4']*100;
}?>" /></td>
            </tr>
            <tr>
              <td>F5</td>
              <td><input type="text" class="form-control" name="f5" style="width:90px;" value="<?php if ($_smarty_tpl->tpl_vars['arr']->value['f5'] == '') {?>2<?php } else {
echo $_smarty_tpl->tpl_vars['arr']->value['f5']*100;
}?>" /></td>
              <td><input type="text" class="form-control" name="spillover_f5" style="width:90px;" value="<?php if ($_smarty_tpl->tpl_vars['arr']->value['spillover_f5'] == '') {?>3<?php } else {
echo $_smarty_tpl->tpl_vars['arr']->value['spillover_f5']*100;
}?>" /></td>
            </tr>
            <tr>
              <td>F6</td>
              <td><input type="text" class="form-control" name="f6" style="width:90px;" value="<?php if ($_smarty_tpl->tpl_vars['arr']->value['f6'] == '') {?>2<?php } else {
echo $_smarty_tpl->tpl_vars['arr']->value['f6']*100;
}?>" /></td>
              <td><input type="text" class="form-control" name="spillover_f6" style="width:90px;" value="<?php if ($_smarty_tpl->tpl_vars['arr']->value['spillover_f6'] == '') {?>3<?php } else {
echo $_smarty_tpl->tpl_vars['arr']->value['spillover_f6']*100;
}?>" /></td>
            </tr>
            <tr>
              <td>F7</td>
              <td><input type="text" class="form-control" name="f7" style="width:90px;" value="<?php if ($_smarty_tpl->tpl_vars['arr']->value['f7'] == '') {?>2<?php } else {
echo $_smarty_tpl->tpl_vars['arr']->value['f7']*100;
}?>" /></td>
              <td><input type="text" class="form-control" name="spillover_f7" style="width:90px;" value="<?php if ($_smarty_tpl->tpl_vars['arr']->value['spillover_f7'] == '') {?>3<?php } else {
echo $_smarty_tpl->tpl_vars['arr']->value['spillover_f7']*100;
}?>" /></td>
            </tr>
            <tr>
              <td>F8</td>
              <td><input type="text" class="form-control" name="f8" style="width:90px;" value="<?php if ($_smarty_tpl->tpl_vars['arr']->value['f8'] == '') {?>2<?php } else {
echo $_smarty_tpl->tpl_vars['arr']->value['f8']*100;
}?>" /></td>
              <td><input type="text" class="form-control" name="spillover_f8" style="width:90px;" value="<?php if ($_smarty_tpl->tpl_vars['arr']->value['spillover_f8'] == '') {?>3<?php } else {
echo $_smarty_tpl->tpl_vars['arr']->value['spillover_f8']*100;
}?>" /></td>
            </tr>
          </table>
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

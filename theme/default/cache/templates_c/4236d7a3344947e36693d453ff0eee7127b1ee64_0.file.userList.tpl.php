<?php
/* Smarty version 3.1.36, created on 2025-09-21 10:51:44
  from '/www/wwwroot/thuanphatitc.vn/admin80/theme/default/templates/userList.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.36',
  'unifunc' => 'content_68cf7650137f32_17568603',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '4236d7a3344947e36693d453ff0eee7127b1ee64' => 
    array (
      0 => '/www/wwwroot/thuanphatitc.vn/admin80/theme/default/templates/userList.tpl',
      1 => 1758426681,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_68cf7650137f32_17568603 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/www/wwwroot/thuanphatitc.vn/smarty-master/libs/plugins/function.cycle.php','function'=>'smarty_function_cycle',),));
?>

<style>
.switch {
  position: relative;
  display: inline-block;
  width: 50px;
  height: 24px;
}

.switch input { 
  opacity: 0;
  width: 0;
  height: 0;
}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 16px;
  width: 16px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #2196F3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 24px;
}

.slider.round:before {
  border-radius: 50%;
}

/* The container must be positioned relative: */
.custom-select {
  position: relative;
  font-family: Arial;
}

.custom-select select {
  display: none; /*hide original SELECT element: */
}

.select-selected {
  background-color: DodgerBlue;
}

/* Style the arrow inside the select element: */
.select-selected:after {
  position: absolute;
  content: "";
  top: 14px;
  right: 10px;
  width: 0;
  height: 0;
  border: 6px solid transparent;
  border-color: #fff transparent transparent transparent;
}

/* Point the arrow upwards when the select box is open (active): */
.select-selected.select-arrow-active:after {
  border-color: transparent transparent #fff transparent;
  top: 7px;
}

/* style the items (options), including the selected item: */
.select-items div,.select-selected {
  color: #ffffff;
  padding: 8px 16px;
  border: 1px solid transparent;
  border-color: transparent transparent rgba(0, 0, 0, 0.1) transparent;
  cursor: pointer;
}

/* Style items (options): */
.select-items {
  position: absolute;
  background-color: DodgerBlue;
  top: 100%;
  left: 0;
  right: 0;
  z-index: 99;
}

/* Hide the items when the select box is closed: */
.select-hide {
  display: none;
}

.select-items div:hover, .same-as-selected {
  background-color: rgba(0, 0, 0, 0.1);
}
</style>

<!-- <a href="../admin80/?m=user&f=user-download-file" target="_blank">Download dữ liệu file excel</a> -->
<form name="frmList" action="" method="post" enctype="multipart/form-data">
<input type="hidden" name="id" value="" />
<input type="hidden" name="op" value="" />
<table border="1" width="100%" cellspacing="0" cellpadding="0" class="table table-striped table-bordered dataTable">
  <tr class="tr">

    <td class="td"></td>
    <td class="td">ID</td>
    <td class="td"><?php echo $_smarty_tpl->tpl_vars['Date']->value;?>
</td>
    <td class="td">Họ tên</td>
    <td class="td">Điện thoại</td>
    <td class="td">Email</td>
    <td class="td">Người giới thiệu</td>
        <td class="td">&nbsp;</td>
  </tr>
  <?php if ($_smarty_tpl->tpl_vars['arr']->value) {?>
  <?php $_smarty_tpl->_assignInScope('i', 1);?>
  <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['arr']->value, 'item', false, 'key');
$_smarty_tpl->tpl_vars['item']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['key']->value => $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->do_else = false;
?>  
    <tr bgcolor="<?php echo smarty_function_cycle(array('values'=>"#FFFFFF,#F7F7F7"),$_smarty_tpl);?>
">
      <td class="td">
        <a href="#" class="btn-view-user" data-id="<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
" data-bs-toggle="modal" data-bs-target="#viewUserModal">Xem thông tin</a>
      </td>
    <td class="td"><?php echo $_smarty_tpl->tpl_vars['key']->value;?>
</td>
    <td class="td"><?php echo $_smarty_tpl->tpl_vars['item']->value['date_create'];?>
</td>
	
    <td class="td" nowrap="nowrap">
	<a href="?m=user&f=dashboard&user_id=<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
&name=<?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
"  ><strong><?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
</strong><br>(xem thống kê)</a></td>
    <td class="td"><?php echo $_smarty_tpl->tpl_vars['item']->value['mobile'];?>
</td>
    <td class="td"><?php echo $_smarty_tpl->tpl_vars['item']->value['email'];?>
</td>
    <td class="td"><?php echo $_smarty_tpl->tpl_vars['item']->value['gioithieu'];?>
</td>
         
        <td class="td" nowrap="nowrap">
	<label style="padding-right:5px"><img src="images/delete.gif" onclick="goDelete('<?php echo $_smarty_tpl->tpl_vars['item']->value['username'];?>
',document.frmList)" style="cursor:pointer" title="Delete" />	</label>

	<label id="lock_<?php echo $_smarty_tpl->tpl_vars['item']->value['username'];?>
" onclick="callLock('<?php echo $_smarty_tpl->tpl_vars['item']->value['username'];?>
')" style="cursor:pointer; padding-right:5px"><img src="images/<?php echo $_smarty_tpl->tpl_vars['item']->value['ctrl'];?>
.gif" /></label>
      <label style="padding-right:5px" title="Đổi pass"><img src="images/edit.gif" onclick="goEdit('<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
')" style="cursor:pointer" /> </label>
    </td>
    </tr>
  <?php $_smarty_tpl->_assignInScope('i', $_smarty_tpl->tpl_vars['i']->value+1);?>
  <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
  <?php } else { ?>
  <tr>
    <td colspan="5" class="td" style="color:#FF0000">Not find data!</td>
  </tr>
  <?php }?>
</table>
</form>
<div style="text-align:right; color:#0000CC"> <?php echo $_smarty_tpl->tpl_vars['sPage']->value;?>
</div>
<!-- Nếu chưa có Bootstrap JS -->
<?php echo '<script'; ?>
 src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"><?php echo '</script'; ?>
>

<!-- Modal danh sách rút tiền -->
<div class="modal fade" id="viewUserModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Thông tin thành viên</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div id="viewuser-table-body">
          <!-- Dữ liệu sẽ được load bằng JS -->
        </div>
      </div>
    </div>
  </div>
</div>

  <?php echo '<script'; ?>
>
    let currentUserId = 0;

    // Gán sự kiện click cho nút "Xem"
    $(document).on('click', '.btn-view-user', function () {
      currentUserId = $(this).data('id');
    });

    function loadviewUser(userId) {
      $.ajax({
        url: '?m=user&f=viewuser',
        method: 'GET',
        data: { user_id: userId },
        dataType: 'html', // Hoặc 'json' nếu bạn trả JSON
        success: function(res) {
          $('#viewuser-table-body').html(res);
        },
        error: function() {
          $('#viewuser-table-body').html('<div class="text-danger">Lỗi tải dữ liệu</div>');
        }
      });
    }

    // Khi modal mở ra, gọi hàm với userId đã lưu
    $('#viewUserModal').on('shown.bs.modal', function () {
      if (currentUserId) {
        loadviewUser(currentUserId);
      }
    });
  <?php echo '</script'; ?>
>
<?php }
}

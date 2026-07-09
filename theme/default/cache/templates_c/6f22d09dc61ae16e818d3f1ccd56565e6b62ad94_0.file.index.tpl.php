<?php
/* Smarty version 3.1.36, created on 2025-09-10 22:35:10
  from '/www/wwwroot/thuanphatitc.vn/admin80/theme/default/templates/index.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.36',
  'unifunc' => 'content_68c19aaee28cd7_09483376',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '6f22d09dc61ae16e818d3f1ccd56565e6b62ad94' => 
    array (
      0 => '/www/wwwroot/thuanphatitc.vn/admin80/theme/default/templates/index.tpl',
      1 => 1757518508,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_68c19aaee28cd7_09483376 (Smarty_Internal_Template $_smarty_tpl) {
?><div class="row">
  <!-- Column -->
  <div class="col-md-6 col-lg-6 col-xlg-6">
    <div class="card card-hover">
      <div class="box bg-warning text-center">
        <a href="#" class="no-underline" style="color: #ffffff">
        <h6 class="text-white">Tổng doanh thu</h6>
        <h1 class="font-light text-white">
          <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['format_number'][0], array( array('number'=>$_smarty_tpl->tpl_vars['tongdoanhthu']->value),$_smarty_tpl ) );?>

        </h1>
        </a>
      </div>
    </div>
  </div>
<!-- Column -->
<div class="col-md-6 col-lg-3 col-xlg-3">
  <div class="card card-hover">
    <div class="box bg-cyan text-center">
      <a href="?m=user&f=list_user" class=" no-underline" style="color: #ffffff;">
      <h1 class="font-light text-white">
        <?php echo $_smarty_tpl->tpl_vars['tongsoluonguser']->value;?>
&nbsp;<i class="mdi mdi-account fs-3 mb-1 font-16"></i>
      </h1>
      <h6 class="text-white">Khách hàng</h6>
      </a>
    </div>
  </div>
</div>
<!-- Column -->
<div class="col-md-6 col-lg-3 col-xlg-3">
  <div class="card card-hover">
    <div class="box bg-success text-center">
      <h1 class="font-light text-white">
        <?php echo $_smarty_tpl->tpl_vars['tongsoluongusernew']->value;?>
&nbsp;<i class="mdi mdi-plus fs-3 font-16"></i>
      </h1>
      <h6 class="text-white">Khách hàng đăng ký mới</h6>
    </div>
  </div>
</div>
</div>
<div class="row">
<!-- Column -->
<div class="col-md-3 col-lg-3 col-xlg-3">
  <div class="card card-hover">
    <div class="box bg-danger text-center">
      <a href="?m=user&f=list_user" class=" no-underline" style="color: #ffffff; text-decoration ; : none; ">
      <h6 class="text-white">Tổng hoa hồng</h6>
      <h1 class="font-light text-white">
        <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['format_number'][0], array( array('number'=>$_smarty_tpl->tpl_vars['tonghoahong']->value),$_smarty_tpl ) );?>

      </h1>
      </a>
    </div>
  </div>
</div>
    <!-- Column -->
    <div class="col-md-3 col-lg-3 col-xlg-3">
        <div class="card card-hover">
            <div class="box bg-danger text-center">
                <a href="?m=user&f=list_user" class=" no-underline" style="color: #ffffff; text-decoration ; : none; ">
                    <h6 class="text-white">Tổng hoa hồng sau thuế</h6>
                    <h1 class="font-light text-white">
                        <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['format_number'][0], array( array('number'=>$_smarty_tpl->tpl_vars['tonghoahong']->value-$_smarty_tpl->tpl_vars['tonghoahong']->value*0.105),$_smarty_tpl ) );?>

                    </h1>
                </a>
            </div>
        </div>
    </div>
<!-- Column -->
<div class="col-md-3 col-lg-3 col-xlg-3">
  <div class="card card-hover">
    <div class="box bg-danger text-center">
      <a href="?m=user&f=list_user" class=" no-underline" style="color: #ffffff; text-decoration ; : none; ">
        <h6 class="text-white">Thuế tncn (10.5%HH)</h6>
        <h1 class="font-light text-white">
          <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['format_number'][0], array( array('number'=>$_smarty_tpl->tpl_vars['tonghoahong']->value*0.105),$_smarty_tpl ) );?>

        </h1>
      </a>
    </div>
  </div>
</div>


<!-- Column -->
<div class="col-md-6 col-lg-3 col-xlg-3">
  <div class="card card-hover">
    <div class="box bg-danger text-center">
      <h6 class="text-white">Thuế VAT (8%DT)</h6>
      <h1 class="font-light text-white">
        <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['format_number'][0], array( array('number'=>$_smarty_tpl->tpl_vars['thuevat']->value),$_smarty_tpl ) );?>

      </h1>
    </div>
  </div>
</div>

<!-- Column -->
<div class="col-md-6 col-lg-6 col-xlg-6">
  <div class="card card-hover">
    <div class="box bg-info text-center">
      <h6 class="text-white">Còn lại</h6>
      <h1 class="font-light text-white">
        <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['format_number'][0], array( array('number'=>$_smarty_tpl->tpl_vars['conlai']->value),$_smarty_tpl ) );?>
 đ
      </h1>
    </div>
  </div>
</div>
</div>
<!-- viewuser.tpl -->
<?php echo '<script'; ?>
 src="https://cdn.jsdelivr.net/npm/chart.js"><?php echo '</script'; ?>
>
<div><h2>Biểu đồ doanh thu</h2></div>
<table>
  <tr>
    <td>
      <div style="margin-top: 10px;">
      <label for="reportType">Chọn kỳ báo cáo:</label>
      <select id="reportType">
        <option value="year" selected>Năm</option>
        <option value="day">Theo thời gian</option>
              </select>
      </div>
    </td>
    <td>
      <div id="filter_day" style="display: none; margin-top: 10px;">
        Từ ngày: <input type="date" id="fromDate">
        Đến ngày: <input type="date" id="toDate">
      </div>
    </td>
    <td>
      <div id="filter_year" style="margin-top: 10px;">
        Năm: <select id="yearSelect">
          <?php
$_smarty_tpl->tpl_vars['__smarty_section_i'] = new Smarty_Variable(array());
if (true) {
for ($__section_i_0_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] = 2023; $__section_i_0_iteration <= 3; $__section_i_0_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']++){
?>
            <option value="<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null);?>
" <?php if ((isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null) == 2025) {?>selected<?php }?>>
              <?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null);?>

            </option>
          <?php
}
}
?>
        </select>
      </div>
    </td>
    <td>
      <button id="btnLoad" style="margin-top: 10px;">Tải dữ liệu</button>
    </td>
  </tr>
</table>
<div style="margin-bottom: 20px;">
  </div>
<canvas id="revenueChart" height="200"></canvas>

  <style>
    .no-underline { font-weight: bold; }
    .no-underline:hover { text-decoration: none; }
  </style>
  <?php echo '<script'; ?>
>
    let revenueChart = null;

    // Ẩn/hiện bộ lọc theo loại kỳ
    document.getElementById('reportType').addEventListener('change', function () {
      const type = this.value;
      document.getElementById('filter_day').style.display = type === 'day' ? 'block' : 'none';
      document.getElementById('filter_month').style.display = type === 'month' ? 'block' : 'none';
      document.getElementById('filter_year').style.display = type === 'year' ? 'block' : 'none';
    });

    document.getElementById('btnLoad').addEventListener('click', function () {
      const type = document.getElementById('reportType').value;
      let params = new URLSearchParams({ type });

      if (type === 'day') {
        params.append('from', document.getElementById('fromDate').value);
        params.append('to', document.getElementById('toDate').value);
      } else if (type === 'month') {
        params.append('month', document.getElementById('monthYear').value);
      } else if (type === 'year') {
        params.append('year', document.getElementById('yearSelect').value);
      }

      fetch('?m=home&f=ajax_revenue&' + params.toString())
              .then(res => res.json())
              .then(response => {
                const labels = response.labels;
                const data = response.data;

                if (revenueChart) revenueChart.destroy();

                const ctx = document.getElementById('revenueChart').getContext('2d');
                revenueChart = new Chart(ctx, {
                  type: 'bar',
                  data: {
                    labels: labels,
                    datasets: [{
                      label: 'Doanh thu (VNĐ)',
                      data: data,
                      backgroundColor: 'rgba(75, 192, 192, 0.6)',
                      borderColor: 'rgba(75, 192, 192, 1)',
                      borderWidth: 1
                    }]
                  },
                  options: {
                    responsive: true,
                    scales: {
                      y: {
                        beginAtZero: true,
                        ticks: {
                          callback: value => new Intl.NumberFormat().format(value)
                        }
                      }
                    },
                    plugins: {
                      tooltip: {
                        callbacks: {
                          label: context =>
                                  context.dataset.label + ': ' + new Intl.NumberFormat().format(context.raw) + ' VNĐ'
                        }
                      }
                    }
                  }
                });
              });
    });

    // Tải mặc định theo năm hiện tại
    document.getElementById('btnLoad').click();
  <?php echo '</script'; ?>
>
<?php }
}

<div class="row">
  <!-- Column -->
  <div class="col-md-6 col-lg-6 col-xlg-6">
    <div class="card card-hover">
      <div class="box bg-warning text-center">
        <a href="#" class="no-underline" style="color: #ffffff">
        <h6 class="text-white">Tổng doanh thu</h6>
        <h1 class="font-light text-white">
          {format_number number=$tongdoanhthu}
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
        {$tongsoluonguser}&nbsp;<i class="mdi mdi-account fs-3 mb-1 font-16"></i>
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
        {$tongsoluongusernew}&nbsp;<i class="mdi mdi-plus fs-3 font-16"></i>
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
        {format_number number=$tonghoahong}
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
                        {format_number number=$tonghoahong-$tonghoahong*0.105}
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
          {format_number number=$tonghoahong*0.105}
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
        {format_number number=$thuevat}
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
        {format_number number=$conlai} đ
      </h1>
    </div>
  </div>
</div>
{*
<!-- Column -->
<div class="col-md-6 col-lg-3 col-xlg-3">
  <div class="card card-hover">
    <div class="box bg-danger text-center">
      <h6 class="text-white">Thưởng khác (5%)</h6>
      <h1 class="font-light text-white">
        {format_number number=$thuongkhac}
      </h1>
    </div>
  </div>
</div>
  <div>
    <h2>Còn lại: {format_number number=$conlai} vnđ</h2>
  </div>
</div>*}
</div>
<!-- viewuser.tpl -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<div><h2>Biểu đồ doanh thu</h2></div>
<table>
  <tr>
    <td>
      <div style="margin-top: 10px;">
      <label for="reportType">Chọn kỳ báo cáo:</label>
      <select id="reportType">
        <option value="year" selected>Năm</option>
        <option value="day">Theo thời gian</option>
        {*<option value="month">Tháng</option>*}
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
          {section name=i start=2023 loop=2026}
            <option value="{$smarty.section.i.index}" {if $smarty.section.i.index == 2025}selected{/if}>
              {$smarty.section.i.index}
            </option>
          {/section}
        </select>
      </div>
    </td>
    <td>
      <button id="btnLoad" style="margin-top: 10px;">Tải dữ liệu</button>
    </td>
  </tr>
</table>
<div style="margin-bottom: 20px;">
  {*<div id="filter_month" style="display: none; margin-top: 10px;">
    Năm: <select id="monthYear">
      {section name=i start=1 loop=12}
        <option value="{$smarty.section.i.index}" {if $smarty.section.i.index == 8}selected{/if}>
          {$smarty.section.i.index}
        </option>
      {/section}
    </select>
  </div>*}
</div>
<canvas id="revenueChart" height="200"></canvas>
{literal}
  <style>
    .no-underline { font-weight: bold; }
    .no-underline:hover { text-decoration: none; }
  </style>
  <script>
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
  </script>
{/literal}
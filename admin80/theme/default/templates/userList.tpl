{literal}
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
{/literal}
<!-- <a href="../admin80/?m=user&f=user-download-file" target="_blank">Download dữ liệu file excel</a> -->
<form name="frmList" action="" method="post" enctype="multipart/form-data">
<input type="hidden" name="id" value="" />
<input type="hidden" name="op" value="" />
<table border="1" width="100%" cellspacing="0" cellpadding="0" class="table table-striped table-bordered dataTable">
  <tr class="tr">

    <td class="td"></td>
    <td class="td">ID</td>
    <td class="td">{$Date}</td>
    <td class="td">Họ tên</td>
    <td class="td">Điện thoại</td>
    <td class="td">Email</td>
    <td class="td">Người giới thiệu</td>
    {*<td class="td">Thành viên</td>
    <td class="td">HLV</td>*}
    <td class="td">&nbsp;</td>
  </tr>
  {if $arr}
  {assign var="i" value=1}
  {foreach item=item key=key from=$arr}  
    <tr bgcolor="{cycle values="#FFFFFF,#F7F7F7"}">
      <td class="td">
        <a href="#" class="btn-view-user" data-id="{$key}" data-bs-toggle="modal" data-bs-target="#viewUserModal">Xem thông tin</a>
      </td>
    <td class="td">{$key}</td>
    <td class="td">{$item.date_create}</td>
	
    <td class="td" nowrap="nowrap">
	<a href="?m=user&f=dashboard&user_id={$key}&name={$item.name}"  ><strong>{$item.name}</strong><br>(xem thống kê)</a></td>
    <td class="td">{$item.mobile}</td>
    <td class="td">{$item.email}</td>
    <td class="td">{$item.gioithieu}</td>
     {*<td class="td" nowrap="nowrap" align="center">
     <div class="btn btn-success text-white show" style="width:120px;">
     <select  onChange="callLoai(this.options[this.selectedIndex].value,'{$item.username}')"  style="background-color:#28b779; color:#FFFFFF; border:0px">
        <option value="0" {if $item.loai=='0'} selected="selected"{/if}>TV Thường</option>
        <option value="1" {if $item.loai=='1'}  selected="selected" {/if}>TV Vip1</option>
        <option value="2" {if $item.loai=='2'}  selected="selected" {/if}>TV Vip2</option>
     </select>
     </div>
    
    
    </td>*}
    
    {*<td>
    	<label class="switch">
          <input type="checkbox" {if $item.permit=='1'} checked {/if} onclick="callHLV('{$item.username}')">
          <span class="slider round" id="hlv_{$item.username}"></span>
        </label>
    </td>*}
    <td class="td" nowrap="nowrap">
	<label style="padding-right:5px"><img src="images/delete.gif" onclick="goDelete('{$item.username}',document.frmList)" style="cursor:pointer" title="Delete" />	</label>

	<label id="lock_{$item.username}" onclick="callLock('{$item.username}')" style="cursor:pointer; padding-right:5px"><img src="images/{$item.ctrl}.gif" /></label>
      <label style="padding-right:5px" title="Đổi pass"><img src="images/edit.gif" onclick="goEdit('{$key}')" style="cursor:pointer" /> </label>
    </td>
    </tr>
  {assign var="i" value=$i+1}
  {/foreach}
  {else}
  <tr>
    <td colspan="5" class="td" style="color:#FF0000">Not find data!</td>
  </tr>
  {/if}
</table>
</form>
<div style="text-align:right; color:#0000CC"> {$sPage}</div>
<!-- Nếu chưa có Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

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
{literal}
  <script>
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
  </script>
{/literal}
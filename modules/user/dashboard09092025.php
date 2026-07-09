<?php
session_start(); // Bắt buộc nếu bạn dùng $_SESSION
$username=getSession("username");
if (!isset($username) || empty($username)) {
    header("Location: /"); // Chuyển hướng về trang chủ
    exit();
}
include_once("header.php");
// Lấy user_id

$user_id = getMemberNameID($username, "id");
$mobile = getMemberNameID($username, "mobile");
$Membertknh=getMemberNameID($username,"tknh");
$Membernganhangtknh=getMemberNameID($username,"nganhangtknh");
$Membertknh=getMemberNameID($username,"tknh");

$start_date = $_POST['start_date'] ?? null;
$end_date = $_POST['end_date'] ?? null;

$where_date = "";
if ($start_date && $end_date) {
    $where_date = "AND c.created_at BETWEEN '$start_date 00:00:00' AND '$end_date 23:59:59'";
    $thongbao = "Thống kê từ $start_date đến $end_date";
} else {
    $thongbao = "Thống kê";
}

/*// Lấy ngày lọc
/*$start_date = $_GET['start_date'] ?? null;
$end_date = $_GET['end_date'] ?? null;*/


/*

// Hàm lấy tổng theo level
function get_total($mysqli, $user_id, $level, $where_date) {
    $result = $mysqli->query("
        SELECT SUM(c.amount) AS total
        FROM commissions c, orders o
        WHERE o.status = 'approved' AND c.order_id = o.id AND c.user_id = $user_id  AND c.level = $level
        $where_date
    ");
    return $result->fetch_assoc()['total'] ?? 0;
}
// Tính tổng tiền bán trực tiếp của user
function get_total_sales($mysqli, $user_id, $where_date) {
    $result = $mysqli->query("
        SELECT SUM(amount) AS total_sales
        FROM orders c
        WHERE status = 'approved' AND user_id = $user_id $where_date
    ");
    return $result->fetch_assoc()['total_sales'] ?? 0;
}

$total_sales = get_total_sales($mysqli, $user_id, $where_date);

// Lấy tổng
$direct = get_total($mysqli, $user_id, 0, $where_date);
$level1 = get_total($mysqli, $user_id, 1, $where_date);
$level2 = get_total($mysqli, $user_id, 2, $where_date);
$total = $direct + $level1 + $level2;
/// tổng số dư hiện tại
// Lấy tổng tiền đã rút từ bảng transactions
$stmt2 = $mysqli->prepare("SELECT IFNULL(SUM(amount), 0) AS total_withdrawn FROM transactions WHERE user_id = ? AND type = 'withdraw' AND status = 'approved'");
$stmt2->bind_param("i", $user_id);
$stmt2->execute();
$result2 = $stmt2->get_result();
$row2 = $result2->fetch_assoc();
$total_withdrawn = $row2['total_withdrawn'] ?? 0;

// Tính số dư hiện tại
$current_balance = $total - $total_withdrawn;


//// thống kê f1,f2
// Đếm số lượng F1 (tuyển trực tiếp)
$result_f1 = $mysqli->query("SELECT COUNT(*) AS total_f1 FROM user WHERE ref_by = $user_id");
$total_f1 = $result_f1->fetch_assoc()['total_f1'] ?? 0;

// Đếm số lượng F2 (tuyển gián tiếp qua F1)
$result_f2 = $mysqli->query("SELECT COUNT(*) AS total_f2
    FROM user
    WHERE ref_by IN (
        SELECT id FROM user WHERE ref_by = $user_id
    )");
$total_f2 = $result_f2->fetch_assoc()['total_f2'] ?? 0;*/

///*/
///
// Hàm lấy tổng hoa hồng theo level
function get_total($mysqli, $user_id, $level, $where_date) {
    $result = $mysqli->query("
        SELECT SUM(c.amount) AS total 
        FROM commissions c
        JOIN orders o ON c.order_id = o.id
        WHERE o.status = 'approved' 
        AND c.user_id = $user_id  
        AND c.level = $level
        $where_date
    ");
    return $result->fetch_assoc()['total'] ?? 0;
}

// Hàm lấy tổng doanh số trực tiếp
function get_total_sales($mysqli, $user_id, $where_date) {
    $result = $mysqli->query("
        SELECT SUM(amount) AS total_sales 
        FROM orders c 
        WHERE status = 'approved' 
        AND user_id = $user_id 
        $where_date
    ");
    return $result->fetch_assoc()['total_sales'] ?? 0;
}

// Tổng doanh số trực tiếp
$total_sales = get_total_sales($mysqli, $user_id, $where_date);

// Lấy tổng hoa hồng theo từng cấp
$direct = get_total($mysqli, $user_id, 0, $where_date); // tự bán
$level1 = get_total($mysqli, $user_id, 1, $where_date); // F1
$level2 = get_total($mysqli, $user_id, 2, $where_date); // F2
$level3 = get_total($mysqli, $user_id, 3, $where_date); // F3

// Tổng hoa hồng
$total = $direct + $level1 + $level2 + $level3;

// Lấy tổng tiền đã rút
$stmt2 = $mysqli->prepare("
    SELECT IFNULL(SUM(amount), 0) AS total_withdrawn 
    FROM transactions c
    WHERE user_id = ? 
    AND type = 'withdraw' 
    AND status = 'approved'
    $where_date
");
$stmt2->bind_param("i", $user_id);
$stmt2->execute();
$result2 = $stmt2->get_result();
$row2 = $result2->fetch_assoc();
$total_withdrawn = $row2['total_withdrawn'] ?? 0;

// Số dư hiện tại
$current_balance = $total - $total_withdrawn;

// Đếm số lượng F1
$result_f1 = $mysqli->query("SELECT COUNT(*) AS total_f1 FROM user WHERE ref_by = $user_id");
$total_f1 = $result_f1->fetch_assoc()['total_f1'] ?? 0;

// Đếm số lượng F2
$result_f2 = $mysqli->query("
    SELECT COUNT(*) AS total_f2 
    FROM user 
    WHERE ref_by IN (
        SELECT id FROM user WHERE ref_by = $user_id
    )
");
$total_f2 = $result_f2->fetch_assoc()['total_f2'] ?? 0;

// Đếm số lượng F3
$result_f3 = $mysqli->query("
    SELECT COUNT(*) AS total_f3 
    FROM user 
    WHERE ref_by IN (
        SELECT id 
        FROM user 
        WHERE ref_by IN (
            SELECT id FROM user WHERE ref_by = $user_id
        )
    )
");
$total_f3 = $result_f3->fetch_assoc()['total_f3'] ?? 0;

?>
<div class="row"  style="padding: 10px">
<div class="container">
    <div class="text-center">
        <h1 class="topiccontent"><?= $thongbao ?></h1>
    </div>
    <div class="g-4 mb-4" style="padding-bottom: 10px">
        <div class="card text-white bg-danger h-100">
            <div class="card-body">
                <h5 class="card-title">Giá trị đơn hàng đã mua: <?= number_format($total_sales, 0) ?> VND</h5>
                <?php if($total_sales<3300000){?>
                <h5 class="card-title">Để có thể phát triển hệ thống (<a href="<?php echo _DOMAIN_ROOT_URL;?>/vn/chuong-trinh-afiiliate/" target="_blank"  style="color:aqua">quyền lợi hấp dẫn của nhà phân phối</a>). Vui lòng mua 1 combo 3.300.000 đ <a href="<?php echo _DOMAIN_ROOT_URL;?>/vn/san-pham/combo-san-pham" style="color: aqua; text-transform: uppercase">tại đây</a> </h5>
                <?php }else{ ?>
                <p id="p1" style="display:none"><?php echo _DOMAIN_ROOT_URL;?>/user/<?php echo $mobile;?></p>
                    <h5 class="card-title">Bạn đã đủ điều kiện làm nhà phân phối cho Thuận Phát, hãy giới thiệu người dùng để hưởng <a href="<?php echo _DOMAIN_ROOT_URL;?>/vn/chuong-trinh-afiiliate/" target="_blank"  style="color:aqua">quyền lợi hấp dẫn của nhà phân phối.</a> Link giới thiệu người dùng đăng ký tài khoản: <?php echo _DOMAIN_ROOT_URL;?>/user/<?php echo $mobile; ?> <button id="btn_view_more"><a href="#" onclick="copyToClipboard('p1')" title="Click vào đây để copy link giới thiệu " style="cursor:pointer; color: aqua"> (copy link giới thiệu <i class="fa fa-clone" aria-hidden="true"></i>)</a></button></h5>

                <?php } ?>
                <!--<h5 class="card-title">Hoa hồng trực tiếp F0</h5>
                <p class="card-text fs-5"><?/*= number_format($direct, 0) */?> VND</p>-->
            </div>
        </div>
    </div>
    <div class="row g-4 mb-4">

        <div class="col-md-4" style="padding-bottom: 10px">
            <div class="card text-white bg-success h-100">
                <div class="card-body">
                    <h5 class="card-title">Số lượng F1</h5>
                    <p class="card-text fs-5"><?= number_format($total_f1) ?> thành viên</p><br>
                    <h5 class="card-title">Hoa hồng hưởng từ F1</h5>
                    <p class="card-text fs-5"><?= number_format($level1, 0) ?> VND</p>
                </div>
            </div>
        </div>
        <div class="col-md-4" style="padding-bottom: 10px">
            <div class="card text-white bg-warning h-100">
                <div class="card-body">
                    <h5 class="card-title">Số lượng F2</h5>
                    <p class="card-text fs-5"><?= number_format($total_f2) ?> thành viên</p><br>
                    <h5 class="card-title">Hoa hồng hưởng từ F2</h5>
                    <p class="card-text fs-5"><?= number_format($level2, 0) ?> VND</p>
                </div>
            </div>
        </div>
        <div class="col-md-4" style="padding-bottom: 10px">
            <div class="card text-white bg-primary h-100">
                <div class="card-body">
                    <h5 class="card-title">Số lượng F3</h5>
                    <p class="card-text fs-5"><?= number_format($total_f3) ?> thành viên</p><br>
                    <h5 class="card-title">Hoa hồng hưởng từ F3</h5>
                    <p class="card-text fs-5"><?= number_format($level3, 0) ?> VND</p>
                </div>
            </div>
        </div>

    </div>
    <div class="g-4 mb-4" style="padding-bottom: 10px">
        <div class="card text-white bg-dark h-100">
            <div class="card-body">
                <div class="col-md-4" style="padding-bottom: 10px">
                    <h5 class="card-title">Tổng cộng hoa hồng</h5>
                    <p class="card-text fs-5"><?= number_format($total, 0) ?> VND</p>
                </div>
                <div class="col-md-4" style="padding-bottom: 10px">
                    <h5 class="card-title">Số tiền đã rút</h5>

                    <p class="card-text fs-5"><a href="#" data-toggle="modal" data-target="#withdrawListModal" style="color: #ffffff;"><?= number_format($total_withdrawn, 0) ?> VND (xem chi tiết)</a></p>
                </div>
                <div class="col-md-4" style="padding-bottom: 10px">
                    <h5 class="card-title">Số tiền còn lại</h5>
                    <p class="card-text fs-5"><?= number_format($current_balance, 0) ?> VND</p>
                </div>
                <?php if($total_sales<3300000){?>
                    <button class="btn btn-warning mt-3" onclick="showAlert()">
                        Rút tiền
                    </button>
                <?php }else{ ?>
                    <button class="btn btn-warning mt-3" data-toggle="modal" data-target="#withdrawModal">
                        Rút tiền
                    </button>
                <?php } ?>

            </div>
        </div>
    </div>

    <!-- Form tìm kiếm -->
    <form method="post" action="/user_dashboard/" class="row g-3 mb-4">
       <!-- <input type="hidden" name="m" value="user">
        <input type="hidden" name="f" value="dashboard">-->
        <div class="col-md-3">
            <label for="start_date" class="form-label">Từ ngày</label>
            <input type="date" name="start_date" id="start_date" value="<?= $start_date ?>" class="form-control">
        </div>
        <div class="col-md-3">
            <label for="end_date" class="form-label">Đến ngày</label>
            <input type="date" name="end_date" id="end_date" value="<?= $end_date ?>" class="form-control">
        </div>
        <div class="col-md-3 align-self-end">
            <button type="submit" class="btn btn-outline-primary" style="border: 1px solid #3abcff;">Lọc theo ngày</button>
        </div>
    </form>

    <!-- Chi tiết hoa hồng -->
    <h4>Chi tiết hoa hồng theo đơn hàng</h4>
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
            <tr>
                <th>Đơn hàng</th>
                <th>Sản phẩm</th>
                <th>Người mua</th>
                <th>Tổng tiền</th>
                <th>Hoa hồng</th>
                <th>Ngày</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $limit = 30;
            $page = max(1, intval($_GET['page'] ?? 1));
            $offset = ($page - 1) * $limit;

            // Tổng bản ghi
            $res_count = $mysqli->query("
                    SELECT COUNT(DISTINCT c.order_id) AS total
                    FROM commissions c
                    WHERE c.user_id = $user_id $where_date
                ");
            $total_records = $res_count->fetch_assoc()['total'] ?? 0;
            $total_pages = ceil($total_records / $limit);

            // Truy vấn dữ liệu chi tiết
            $result = $mysqli->query("
                    SELECT 
                        c.order_id,
                        o.user_id AS seller_id,
                        o.products AS products,
                        o.amount AS amount,           
                        u.name AS seller_name,
                        c.level as level,   
                        MAX(c.created_at) AS created_at,
                        SUM(c.amount) AS commission_total
                    FROM commissions c
                    JOIN orders o ON c.order_id = o.id
                    JOIN user u ON o.user_id = u.id
                    WHERE o.status = 'approved' AND c.user_id = $user_id $where_date
                    GROUP BY c.order_id
                    ORDER BY created_at DESC
                    LIMIT $limit OFFSET $offset
                ");

            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>#{$row['order_id']}</td>";
                echo "<td>" . nl2br(htmlspecialchars($row['products'])) . "</td>";
                echo "<td>F{$row['level']} - {$row['seller_name']} (#{$row['seller_id']})</td>";
                echo "<td>" . number_format($row['amount'], 0) . " VND</td>";
                echo "<td>" . number_format($row['commission_total'], 0) . " VND</td>";
                echo "<td>{$row['created_at']}</td>";
                echo "</tr>";
            }
            ?>
            </tbody>
        </table>
    </div>

    <!-- Phân trang -->
    <div style="text-align: center; padding: 20px; margin-bottom: 60px" align="center">
        <?php if ($total_pages > 1): ?>
            <ul class="pagination justify-content-center" style="background-color: #ffffff">
                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <?php
                    $active = ($i == $page) ? 'active' : '';
                    ?>
                    <li class="page-item <?= $active ?>">
                        <a class="page-link" href="/user_dashboard/<?= $i ?>"><?= $i ?></a>
                    </li>
                <?php endfor; ?>
            </ul>
        <?php endif; ?>
    </div>

</div>
</div>

<!-- Modal Rút tiền -->
<!-- Modal -->
<div class="modal fade" id="withdrawModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form id="withdrawForm" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Yêu cầu rút tiền</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="position:absolute; top:10px; right:10px">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="withdraw-alert" class="alert d-none" role="alert"></div>

                <div class="mb-2">
                    <label for="amount" class="form-label">Số tiền</label>
                    <input type="number" class="form-control" name="amount" id="amount" required>
                </div>
                <div class="mb-2">
                    <label for="bank_name" class="form-label">Tên ngân hàng</label>
                    <input type="text" class="form-control" value="<?=$Membernganhangtknh?>" name="bank_name" required>
                </div>
                <div class="mb-2">
                    <label for="bank_account_number" class="form-label">Số tài khoản</label>
                    <input type="text" class="form-control" value="<?=$Membertknh?>" name="bank_account_number" required>
                </div>
                <div class="mb-2">
                    <label for="bank_account_holder" class="form-label">Tên chủ tài khoản</label>
                    <input type="text" class="form-control" value="<?=$MemberName?>" readonly name="bank_account_holder" required>
                </div>
                <div class="mb-2">
                    <label for="note" class="form-label">Ghi chú</label>
                    <textarea class="form-control" name="note"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Gửi yêu cầu</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
            </div>
        </form>
    </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const totalHoaHong = <?= $current_balance ?>;
        const form = document.getElementById('withdrawForm');
        const alertBox = document.getElementById('withdraw-alert');

        //const modalEl = document.getElementById('withdrawModal');
        $(document).ready(function () {
            const form = $('#withdrawForm');
            const alertBox = $('#withdraw-alert');

            $('#withdrawModal').on('show.bs.modal', function () {
                fetch('/?m=user&f=check_withdraw_pending')
                    .then(res => res.json())
                    .then(data => {
                        if (data.pending) {
                            // Tạo thông báo chi tiết
                            let html = `
                        <strong>Bạn đã có 1 yêu cầu rút tiền đang chờ duyệt.</strong><br>
                        <b>Mã lệnh:</b> #${data.id}<br>
                        <b>Số tiền:</b> ${data.amount}<br>
                        <b>Ngày tạo:</b> ${data.created_at}<br>
                        <b>Trạng thái:</b> ${data.status}<br>
                        <strong>Vui lòng chờ xử lý trước khi tạo yêu cầu mới.</strong>
                    `;

                            alertBox.removeClass('d-none alert-success alert-danger')
                                .addClass('alert-warning')
                                .html(html);

                            // Ẩn toàn bộ form (chỉ để lại alertBox)
                            form.find('.modal-body > div').not('#withdraw-alert').hide();
                            form.find('.modal-footer').hide();
                        } else {
                            // Reset lại form
                            alertBox.addClass('d-none').text('');
                            form.find('.modal-body > div').show();
                            form.find('.modal-footer').show();
                        }
                    })
                    .catch(err => console.error(err));
            });
        });


        form.addEventListener('submit', function (e) {
            e.preventDefault();
            const amount = parseFloat(form.amount.value);

            // Kiểm tra số tiền vượt quá
            if (amount > totalHoaHong) {
                alertBox.className = 'alert alert-danger';
                alertBox.innerText = 'Số tiền vượt quá hoa hồng hiện có.';
                alertBox.classList.remove('d-none');
                return;
            }

            const formData = new FormData(form);
            fetch('/?m=user&f=xu_ly_rut_tien', {
                method: 'POST',
                body: formData
            })
                .then(res => res.text())
                .then(data => {
                    if (data.trim() === 'success') {
                        alertBox.className = 'alert alert-success';
                        alertBox.innerText = 'Yêu cầu rút tiền đã được gửi.';
                        alertBox.classList.remove('d-none');
                        form.reset();
                        Array.from(form.elements).forEach(el => {
                            if (el.tagName !== "BUTTON") {
                                el.parentElement.style.display = 'none';
                            }
                        });
                        const footer = form.querySelector('.modal-footer');
                        if (footer) footer.style.display = 'none';
                        setTimeout(() => {
                            modal.hide();
                        }, 3000);
                    } else {
                        alertBox.className = 'alert alert-danger';
                        alertBox.innerText = data;
                        alertBox.classList.remove('d-none');
                    }
                })
                .catch(err => {
                    alertBox.className = 'alert alert-danger';
                    alertBox.innerText = 'Đã xảy ra lỗi. Vui lòng thử lại.';
                    alertBox.classList.remove('d-none');
                });
        });
    });

</script>


<!-- Modal danh sách rút tiền -->
<div class="modal fade" id="withdrawListModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Danh sách giao dịch rút tiền</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="position:absolute; top:10px; right:10px">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Ngày tạo</th>
                        <th>Số tiền</th>
                        <th>Ngân hàng</th>
                        <th>STK</th>
                        <th>Chủ TK</th>
                        <th>Trạng thái</th>
                        <th>Ngày duyệt</th>
                    </tr>
                    </thead>
                    <tbody id="withdraw-table-body">
                    <!-- Dữ liệu sẽ được load bằng JS -->
                    </tbody>
                </table>
                <div id="withdraw-pagination"></div>
            </div>
        </div>
    </div>
</div>
<script>
    function loadWithdrawList(page = 1) {
        const userId = <?= $user_id ?>; // hoặc lấy qua JS nếu không có PHP
        $.ajax({
            url: '/?m=user&f=get_withdraw_list',
            method: 'GET',
            data: { user_id: userId, page: page },
            dataType: 'json',
            success: function(res) {
                $('#withdraw-table-body').html(res.html);
                $('#withdraw-pagination').html(res.pagination);
            },
            error: function() {
                $('#withdraw-table-body').html('<tr><td colspan="8">Lỗi tải dữ liệu</td></tr>');
            }
        });
    }

    // Khi mở modal thì tải trang đầu
    $('#withdrawListModal').on('shown.bs.modal', function () {
        loadWithdrawList(1);
    });

    // Bắt sự kiện click phân trang
    $(document).on('click', '#withdraw-pagination .page-link', function (e) {
        e.preventDefault();
        const page = $(this).data('page');
        loadWithdrawList(page);
    });
</script>
<script>
    function copyToClipboard(elementId) {

        // Create a "hidden" input
        var aux = document.createElement("input");

        // Assign it the value of the specified element
        aux.setAttribute("value", document.getElementById(elementId).innerHTML);

        // Append it to the body
        document.body.appendChild(aux);

        // Highlight its content
        aux.select();

        // Copy the highlighted text
        document.execCommand("copy");

        // Remove it from the body
        document.body.removeChild(aux);

    }
    jQuery(document).ready(function($) {

        //toggle move less on product.
        $(document).on('click', '#btn_view_more', function (e) {
            e.preventDefault();
            if ($('.data-des').hasClass('on')) {
                $('.data-des').removeClass('on');
                $(this).text('copy link giới thiệu');
            } else {
                $('.data-des').addClass('on');
                $(this).text('Đã copy link giới thiệu');
            }
        });

    });
</script>
<script>
    function showAlert() {
        alert("Bạn không đủ điều kiện để thực hiện chức năng này! Vui lòng mua 1 combo sản phẩm");
    }
</script>
<?php include_once("footer.php"); ?>

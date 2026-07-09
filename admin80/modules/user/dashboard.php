<?php
require_once 'classes/SimpleXLSXGen.php';
// Nếu bấm Export Excel
if (isset($_POST['export']) && $_POST['export'] == 1) {
    $user_id = $_GET['user_id'];
    $name = $_GET['name'];
// Lấy ngày lọc
    /*$start_date = $_GET['start_date'] ?? null;
    $end_date = $_GET['end_date'] ?? null;*/
    $start_date = $_POST['start_date'] ?? null;
    $end_date = $_POST['end_date'] ?? null;

    $where_date = "";
    if ($start_date && $end_date) {
        $where_date = "AND c.created_at BETWEEN '$start_date 00:00:00' AND '$end_date 23:59:59'";
    }
    $data = [];
    $data[] = ['Đơn hàng', 'Sản phẩm', 'Người mua', 'Tổng tiền', 'Hoa hồng', 'Ngày'];

    $res_export = $mysqli->query("
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
    ");

    while ($row = $res_export->fetch_assoc()) {
        $data[] = [
            '#' . $row['order_id'],
            $row['products'],
            'F' . $row['level'] . ' - ' . $row['seller_name'] . ' (#' . $row['seller_id'] . ')',
            (float)$row['amount'],
            (float)$row['commission_total'],
            $row['created_at'],
        ];
    }

    $xlsx = Shuchkin\SimpleXLSXGen::fromArray($data);
    $xlsx->downloadAs('"'.$name.'".xlsx');
    //$xlsx->downloadAs('commission_detail.xlsx');
    exit;
}
?>
<?php
include_once("header.php");
// Lấy user_id
$user_id = $_GET['user_id'];
$name = $_GET['name'];
// Lấy ngày lọc
/*$start_date = $_GET['start_date'] ?? null;
$end_date = $_GET['end_date'] ?? null;*/
$start_date = $_POST['start_date'] ?? null;
$end_date = $_POST['end_date'] ?? null;

$where_date = "";
if ($start_date && $end_date) {
    $where_date = "AND c.created_at BETWEEN '$start_date 00:00:00' AND '$end_date 23:59:59'";
    $thongbao = "Thống kê từ $start_date đến $end_date khách hàng: $name";
} else {
    $thongbao = "Thống kê khách hàng: $name";
}
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
$tncn = $total*0.105;
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
$current_balance = $total - $tncn - $total_withdrawn;

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
            <div class="card text-white bg-danger">
                <div class="card-body">
                    <h5 class="card-title">Giá trị đơn hàng đã mua: <?= number_format($total_sales, 0) ?> VND</h5>
                </div>
            </div>
        </div>
        <div class="g-4 mb-4" style="padding-bottom: 10px">
            <div class="card text-white bg-dark">
                <div class="card-body">
                 <?php
                    // --- Chạy ---
                    $tree = getUserTree($mysqli, $user_id);

                    $total_sales_fn = sumSales($tree);
                    $total_users_fn = countUsers($tree);

                    echo "<h3><strong>Tổng doanh số toàn hệ thống: "
                        . number_format($total_sales_fn,0,",",".") . "đ</strong></h3>";
                    echo "<p><strong>Tổng số lượng thành viên trong cây: $total_users_fn</strong></p>";
                    echo "<h3>Cây hệ thống của User #$name</h3>";


                    ?>
                    <div style="margin-bottom:10px;">
                        <button id="expandAll" type="button">Xem tất cả</button>
                        <button id="collapseAll" type="button">Thu gọn</button>
                        <a href="?m=user&f=export_tree&user_id=<?php echo $user_id; ?>" class="btn btn-success">Export Excel</a>
                    </div>

                    <div class="tree">
                        <?php renderTree($tree); ?>
                    </div>

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
            <div class="card text-white bg-dark">
                <div class="card-body">
                    <div class="col-md-4" style="padding-bottom: 10px">
                        <h5 class="card-title">Tổng cộng hoa hồng</h5>
                        <p class="card-text fs-5"><?= number_format($total, 0) ?> VND</p>
                    </div>
                    <div class="col-md-4" style="padding-bottom: 10px">
                        <h5 class="card-title">Thuế TNCN 10.5%</h5>
                        <p class="card-text fs-5" style="color: crimson"><?= number_format($tncn, 0) ?> VND</p>
                    </div>
                    <div class="col-md-4" style="padding-bottom: 10px">
                        <h5 class="card-title">Số tiền đã rút</h5>

                        <p class="card-text fs-5">
                            <a href="#" data-bs-toggle="modal" data-bs-target="#withdrawListModal" style="color: #ffffff;">
                                <?= number_format($total_withdrawn, 0) ?> VND (xem chi tiết)
                            </a>
                        </p>
                    </div>
                    <div class="col-md-4" style="padding-bottom: 10px">
                        <h5 class="card-title">Số tiền còn lại</h5>
                        <p class="card-text fs-5"><?= number_format($current_balance, 0) ?> VND</p>
                    </div>
                </div>
            </div>
        </div>



        <!-- Form tìm kiếm -->
        <form method="post" action="?m=user&f=dashboard&user_id=<?= $user_id ?>&page=<?= $i ?>&name=<?= $name ?>" class="row g-3 mb-4">
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
                <button type="submit" name="export" value="1" class="btn btn-success">Export Excel</button>
            </div>
        </form>


        <!-- Chi tiết hoa hồng -->
        <h4>Chi tiết hoa hồng theo đơn hàng</h4>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                <tr>
                    <th style="color: #ffffff">Đơn hàng</th>
                    <th style="color: #ffffff">Sản phẩm</th>
                    <th style="color: #ffffff">Người mua</th>
                    <th style="color: #ffffff">Tổng tiền</th>
                    <th style="color: #ffffff">Hoa hồng</th>
                    <th style="color: #ffffff">Ngày</th>
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
                        <a class="page-link" href="?m=user&f=dashboard&user_id=<?= $user_id ?>&page=<?= $i ?>&name=<?= $name ?>"><?= $i ?></a>
                    </li>
                <?php endfor; ?>
            </ul>
        <?php endif; ?>
    </div>

</div>
</div>
<!-- Nếu chưa có Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- Modal danh sách rút tiền -->
<div class="modal fade" id="withdrawListModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Danh sách giao dịch rút tiền</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
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
            url: '?m=user&f=get_withdraw_list',
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

<?php
// Lấy toàn bộ hệ thống tuyến dưới của user_id
function getUserTree($mysqli, $user_id, $level = 1) {
    $users = [];

    // Lấy các F trực tiếp
    $stmt = $mysqli->prepare("SELECT id, name, email FROM user WHERE ref_by = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $res = $stmt->get_result();

    while ($row = $res->fetch_assoc()) {
        // Tính tổng doanh số của user này
        $stmt2 = $mysqli->prepare("
            SELECT IFNULL(SUM(o.amount),0) as total_sales
            FROM orders o
            WHERE o.user_id = ? AND o.status = 'approved'
        ");
        $stmt2->bind_param("i", $row['id']);
        $stmt2->execute();
        $sales = $stmt2->get_result()->fetch_assoc()['total_sales'] ?? 0;

        // Đệ quy lấy tuyến dưới
        $row['sales'] = $sales;
        $row['level'] = $level; // thêm level (F mấy)
        $row['children'] = getUserTree($mysqli, $row['id'], $level+1);

        $users[] = $row;
    }
    return $users;
}

// Tính tổng doanh số toàn bộ cây
function sumSales($tree) {
    $sum = 0;
    foreach ($tree as $node) {
        $sum += $node['sales'];
        if (!empty($node['children'])) {
            $sum += sumSales($node['children']);
        }
    }
    return $sum;
}

// Đếm số lượng user trong cây
function countUsers($tree) {
    $count = 0;
    foreach ($tree as $node) {
        $count += 1; // chính nó
        if (!empty($node['children'])) {
            $count += countUsers($node['children']);
        }
    }
    return $count;
}

// Hàm hiển thị dạng cây
function renderTree($tree) {
    echo "<ul class='children'>"; // mặc định tất cả ẩn
    foreach ($tree as $node) {
        echo "<li>";
        echo "<span>F{$node['level']} | {$node['name']} ({$node['email']}) "
            . "- Doanh số: " . number_format($node['sales'],0,",",".") . "đ</span>";
        if (!empty($node['children'])) {
            renderTree($node['children']);
        }
        echo "</li>";
    }
    echo "</ul>";
}

?>
<style>
    .tree ul {
        list-style-type: none;
        margin-left: 20px;
        padding-left: 15px;
        border-left: 1px dashed #ccc;
        display: none; /* Ẩn toàn bộ mặc định, kể cả cấp gốc */
    }

    /* Khi container .tree ở trạng thái mở, hiển thị cấp gốc */
    .tree.open > ul {
        display: block;
    }

    /* Khi một node mở, hiển thị danh sách con trực tiếp của nó */
    .tree li.open > ul {
        display: block;
    }

    .tree li {
        margin: 5px 0;
        cursor: pointer;
        position: relative;
    }

    .tree li span {
        padding: 4px 8px;
        background: #f5f5f5;
        border-radius: 6px;
        display: inline-block;
        transition: all 0.2s;
        color: black;
    }

    .tree li span:hover {
        background: #e2e2e2;
    }

    .tree li::before {
        content: "▶";
        position: absolute;
        left: -15px;
        font-size: 12px;
        transition: transform 0.2s;
    }

    .tree li.open::before {
        transform: rotate(90deg);
    }
</style>
<script>
    (function () {
        function wireUp() {
            // Toggle từng node khi click vào <span>
            document.querySelectorAll(".tree li > span").forEach(function (span) {
                span.addEventListener("click", function (e) {
                    e.stopPropagation();
                    // Bật .open cho container để cấp gốc hiển thị nếu đang ẩn
                    document.querySelector(".tree")?.classList.add("open");
                    this.parentElement.classList.toggle("open");
                });
            });

            // Mở rộng tất cả
            document.getElementById("expandAll")?.addEventListener("click", function () {
                const tree = document.querySelector(".tree");
                if (!tree) return;
                tree.classList.add("open"); // hiển thị cấp gốc
                tree.querySelectorAll("li").forEach(function (li) {
                    li.classList.add("open");
                });
            });

            // Thu gọn tất cả
            document.getElementById("collapseAll")?.addEventListener("click", function () {
                const tree = document.querySelector(".tree");
                if (!tree) return;
                tree.classList.remove("open"); // ẩn cấp gốc
                tree.querySelectorAll("li").forEach(function (li) {
                    li.classList.remove("open");
                });
            });
        }

        // Đảm bảo chạy cả khi DOM đã sẵn sàng từ trước
        if (document.readyState === "loading") {
            document.addEventListener("DOMContentLoaded", wireUp);
        } else {
            wireUp();
        }
    })();
</script>
<?php include_once("footer.php"); ?>

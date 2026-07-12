<?php
// Thanh menu điều hướng dùng chung cho khu vực thành viên (dashboard.php, so_do_truc_tiep.php,
// cay_dieu_tang.php, lich_su_vi.php, lich_su_rut_tien.php). File gọi include phải set $active_nav trước khi include.
// Dùng đường dẫn tuyệt đối (_DOMAIN_ROOT_URL/?m=...) chứ không dùng href tương đối "?m=...":
// trang dashboard được vào qua URL đẹp "/user_dashboard/" (rewrite trong htaccess.txt), nếu href
// tương đối thì trình duyệt sẽ nối thành "/user_dashboard/?m=user&f=xxx" và bị rewrite rule
// "^user_dashboard/(.*) ?m=user&f=dashboard&page=$1" ghi đè lại thành f=dashboard, sai trang đích.
$tpud_nav_items = [
    'dashboard' => ['label' => 'Tổng Quan', 'href' => _DOMAIN_ROOT_URL . '/?m=user&f=dashboard'],
    'so_do_truc_tiep' => ['label' => 'Sơ Đồ Trực Tiếp', 'href' => _DOMAIN_ROOT_URL . '/?m=user&f=so_do_truc_tiep'],
    'cay_dieu_tang' => ['label' => 'Cây Điều Tầng', 'href' => _DOMAIN_ROOT_URL . '/?m=user&f=cay_dieu_tang'],
    'lich_su_vi' => ['label' => 'Lịch Sử Thu Nhập', 'href' => _DOMAIN_ROOT_URL . '/?m=user&f=lich_su_vi'],
    'lich_su_rut_tien' => ['label' => 'Lịch Sử Rút Tiền', 'href' => _DOMAIN_ROOT_URL . '/?m=user&f=lich_su_rut_tien'],
];
?>
<div class="tpud-nav">
    <?php foreach ($tpud_nav_items as $key => $item): ?>
        <a href="<?= $item['href'] ?>" class="<?= (isset($active_nav) && $active_nav === $key) ? 'active' : '' ?>"><?= $item['label'] ?></a>
    <?php endforeach; ?>
</div>
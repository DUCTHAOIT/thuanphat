<?php
// Thanh menu điều hướng dùng chung cho khu vực thành viên (dashboard.php, so_do_truc_tiep.php,
// cay_dieu_tang.php, lich_su_vi.php). File gọi include phải set $active_nav trước khi include.
// Dùng đường dẫn tuyệt đối (_DOMAIN_ROOT_URL/?m=...) chứ không dùng href tương đối "?m=...":
// trang dashboard được vào qua URL đẹp "/user_dashboard/" (rewrite trong htaccess.txt), nếu href
// tương đối thì trình duyệt sẽ nối thành "/user_dashboard/?m=user&f=xxx" và bị rewrite rule
// "^user_dashboard/(.*) ?m=user&f=dashboard&page=$1" ghi đè lại thành f=dashboard, sai trang đích.
$tpud_nav_items = [
    'dashboard' => ['label' => 'Tổng quan', 'href' => _DOMAIN_ROOT_URL . '/?m=user&f=dashboard'],
    'so_do_truc_tiep' => ['label' => 'Sơ đồ trực tiếp', 'href' => _DOMAIN_ROOT_URL . '/?m=user&f=so_do_truc_tiep'],
    'cay_dieu_tang' => ['label' => 'Cây điều tầng', 'href' => _DOMAIN_ROOT_URL . '/?m=user&f=cay_dieu_tang'],
    'lich_su_vi' => ['label' => 'Lịch sử giao dịch', 'href' => _DOMAIN_ROOT_URL . '/?m=user&f=lich_su_vi'],
];
?>
<div class="tpud-nav">
    <?php foreach ($tpud_nav_items as $key => $item): ?>
        <a href="<?= $item['href'] ?>" class="<?= (isset($active_nav) && $active_nav === $key) ? 'active' : '' ?>"><?= $item['label'] ?></a>
    <?php endforeach; ?>
</div>

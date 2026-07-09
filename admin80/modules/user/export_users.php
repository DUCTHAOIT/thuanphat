<?php
require_once __DIR__ . '/SimpleXLSXGen.php';

$data = [];
$data[] = [
    'ID',
    'Họ tên',
    'Email',
    'Mobile',
    'Ngày tạo',
    'Doanh số bán trực tiếp',
    'Số F1',
    'Hoa hồng hưởng từ F1',
    'Số F2',
    'Hoa hồng hưởng từ F2',
    'Số F3',
    'Hoa hồng hưởng từ F3',
    'Số F4',
    'Hoa hồng hưởng từ F4',
    'Số F5',
    'Hoa hồng hưởng từ F5',
    'Số F6',
    'Hoa hồng hưởng từ F6',
    'Số F7',
    'Hoa hồng hưởng từ F7',
    'Số F8',
    'Hoa hồng hưởng từ F8',
    'Số F9',
    'Hoa hồng hưởng từ F9',
    'Tổng Hoa Hồng'
];

$sql = "
    SELECT 
        u.id, u.name, u.email, u.mobile, u.date_create,
        IFNULL(SUM(o.amount), 0) AS direct_sales,

        -- Hoa hồng trực tiếp (level 0)
        (SELECT IFNULL(SUM(amount), 0) FROM commissions WHERE user_id = u.id AND level = 0) AS hoa_hong_truc_tiep,

        -- Số lượng F1
        (SELECT COUNT(*) FROM user f1 WHERE f1.ref_by = u.id) AS so_luong_f1,
        -- Hoa hồng từ F1 (level 1)
        (SELECT IFNULL(SUM(amount), 0) FROM commissions WHERE user_id = u.id AND level = 1) AS hoa_hong_f1,

        -- Số lượng F2
        (SELECT COUNT(*) FROM user f2 WHERE f2.ref_by IN (
            SELECT id FROM user WHERE ref_by = u.id
        )) AS so_luong_f2,
        -- Hoa hồng từ F2 (level 2)
        (SELECT IFNULL(SUM(amount), 0) FROM commissions WHERE user_id = u.id AND level = 2) AS hoa_hong_f2,

        -- Số lượng F3
        (SELECT COUNT(*) FROM user f3 WHERE f3.ref_by IN (
            SELECT id FROM user f2 WHERE f2.ref_by IN (
                SELECT id FROM user f1 WHERE f1.ref_by = u.id
            )
        )) AS so_luong_f3,
        -- Hoa hồng từ F3 (level 3)
        (SELECT IFNULL(SUM(amount), 0) FROM commissions WHERE user_id = u.id AND level = 3) AS hoa_hong_f3,

        -- Số lượng F4
        (SELECT COUNT(*) FROM user f4 WHERE f4.ref_by IN (
            SELECT id FROM user f3 WHERE f3.ref_by IN (
                SELECT id FROM user f2 WHERE f2.ref_by IN (
                    SELECT id FROM user f1 WHERE f1.ref_by = u.id
                )
            )
        )) AS so_luong_f4,
        -- Hoa hồng từ F4 (level 4)
        (SELECT IFNULL(SUM(amount), 0) FROM commissions WHERE user_id = u.id AND level = 4) AS hoa_hong_f4,

        -- Số lượng F5
        (SELECT COUNT(*) FROM user f5 WHERE f5.ref_by IN (
            SELECT id FROM user f4 WHERE f4.ref_by IN (
                SELECT id FROM user f3 WHERE f3.ref_by IN (
                    SELECT id FROM user f2 WHERE f2.ref_by IN (
                        SELECT id FROM user f1 WHERE f1.ref_by = u.id
                    )
                )
            )
        )) AS so_luong_f5,
        -- Hoa hồng từ F5 (level 5)
        (SELECT IFNULL(SUM(amount), 0) FROM commissions WHERE user_id = u.id AND level = 5) AS hoa_hong_f5,

        -- Số lượng F6
        (SELECT COUNT(*) FROM user f6 WHERE f6.ref_by IN (
            SELECT id FROM user f5 WHERE f5.ref_by IN (
                SELECT id FROM user f4 WHERE f4.ref_by IN (
                    SELECT id FROM user f3 WHERE f3.ref_by IN (
                        SELECT id FROM user f2 WHERE f2.ref_by IN (
                            SELECT id FROM user f1 WHERE f1.ref_by = u.id
                        )
                    )
                )
            )
        )) AS so_luong_f6,
        -- Hoa hồng từ F6 (level 6)
        (SELECT IFNULL(SUM(amount), 0) FROM commissions WHERE user_id = u.id AND level = 6) AS hoa_hong_f6,

        -- Số lượng F7
        (SELECT COUNT(*) FROM user f7 WHERE f7.ref_by IN (
            SELECT id FROM user f6 WHERE f6.ref_by IN (
                SELECT id FROM user f5 WHERE f5.ref_by IN (
                    SELECT id FROM user f4 WHERE f4.ref_by IN (
                        SELECT id FROM user f3 WHERE f3.ref_by IN (
                            SELECT id FROM user f2 WHERE f2.ref_by IN (
                                SELECT id FROM user f1 WHERE f1.ref_by = u.id
                            )
                        )
                    )
                )
            )
        )) AS so_luong_f7,
        -- Hoa hồng từ F7 (level 7)
        (SELECT IFNULL(SUM(amount), 0) FROM commissions WHERE user_id = u.id AND level = 7) AS hoa_hong_f7,

        -- Số lượng F8
        (SELECT COUNT(*) FROM user f8 WHERE f8.ref_by IN (
            SELECT id FROM user f7 WHERE f7.ref_by IN (
                SELECT id FROM user f6 WHERE f6.ref_by IN (
                    SELECT id FROM user f5 WHERE f5.ref_by IN (
                        SELECT id FROM user f4 WHERE f4.ref_by IN (
                            SELECT id FROM user f3 WHERE f3.ref_by IN (
                                SELECT id FROM user f2 WHERE f2.ref_by IN (
                                    SELECT id FROM user f1 WHERE f1.ref_by = u.id
                                )
                            )
                        )
                    )
                )
            )
        )) AS so_luong_f8,
        -- Hoa hồng từ F8 (level 8)
        (SELECT IFNULL(SUM(amount), 0) FROM commissions WHERE user_id = u.id AND level = 8) AS hoa_hong_f8,

        -- Số lượng F9
        (SELECT COUNT(*) FROM user f9 WHERE f9.ref_by IN (
            SELECT id FROM user f8 WHERE f8.ref_by IN (
                SELECT id FROM user f7 WHERE f7.ref_by IN (
                    SELECT id FROM user f6 WHERE f6.ref_by IN (
                        SELECT id FROM user f5 WHERE f5.ref_by IN (
                            SELECT id FROM user f4 WHERE f4.ref_by IN (
                                SELECT id FROM user f3 WHERE f3.ref_by IN (
                                    SELECT id FROM user f2 WHERE f2.ref_by IN (
                                        SELECT id FROM user f1 WHERE f1.ref_by = u.id
                                    )
                                )
                            )
                        )
                    )
                )
            )
        )) AS so_luong_f9,
        -- Hoa hồng từ F9 (level 9)
        (SELECT IFNULL(SUM(amount), 0) FROM commissions WHERE user_id = u.id AND level = 9) AS hoa_hong_f9,

        -- Tổng cộng hoa hồng
        (SELECT IFNULL(SUM(commissions.amount), 0) FROM commissions, orders WHERE commissions.user_id = u.id AND orders.id = commissions.order_id AND orders.status = 'approved') AS tong_hoa_hong

    FROM user u
    LEFT JOIN orders o ON u.id = o.user_id AND o.status = 'approved'
    GROUP BY u.id
";

$result = $mysqli->query($sql);
while ($row = $result->fetch_assoc()) {
    $data[] = [
        $row['id'],
        $row['name'],
        $row['email'],
        $row['mobile'],
        $row['date_create'],
        (float)$row['direct_sales'],
        (int)$row['so_luong_f1'],
        (float)$row['hoa_hong_f1'],
        (int)$row['so_luong_f2'],
        (float)$row['hoa_hong_f2'],
        (int)$row['so_luong_f3'],
        (float)$row['hoa_hong_f3'],
        (int)$row['so_luong_f4'],
        (float)$row['hoa_hong_f4'],
        (int)$row['so_luong_f5'],
        (float)$row['hoa_hong_f5'],
        (int)$row['so_luong_f6'],
        (float)$row['hoa_hong_f6'],
        (int)$row['so_luong_f7'],
        (float)$row['hoa_hong_f7'],
        (int)$row['so_luong_f8'],
        (float)$row['hoa_hong_f8'],
        (int)$row['so_luong_f9'],
        (float)$row['hoa_hong_f9'],
        (float)$row['tong_hoa_hong'],
    ];
}

$xlsx = Shuchkin\SimpleXLSXGen::fromArray($data);
$xlsx->downloadAs('user_report.xlsx');
exit;

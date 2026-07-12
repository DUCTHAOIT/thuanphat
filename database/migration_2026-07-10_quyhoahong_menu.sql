-- Migration: Thêm menu admin cho trang theo dõi Quỹ hoa hồng / Quỹ công ty / Quỹ vận hành
-- Date: 2026-07-10
-- Ref: admin80/modules/quyhoahong/index.php (?m=quyhoahong)
--
-- `sys_menu_admin.id` không phải AUTO_INCREMENT (được gán thủ công ở dữ liệu seed có sẵn trong
-- database/thuanphat.sql), nên lấy id kế tiếp bằng MAX(id)+1 thay vì hard-code, theo đúng cách các
-- dòng menu ?m=order / ?m=withdraw đã có.

START TRANSACTION;

INSERT INTO `sys_menu_admin` (`id`, `parent`, `namevn`, `nameen`, `namecn`, `url`, `desvn`, `desen`, `descn`, `order`, `ctrl`, `icon`)
SELECT (SELECT MAX(id) + 1 FROM `sys_menu_admin` t2), 0,
       'Quỹ hoa hồng', 'Quỹ hoa hồng', 'Quỹ hoa hồng',
       '?m=quyhoahong',
       'Theo dõi quỹ công ty, quỹ chia hoa hồng, hoa hồng/thưởng đã trả - pending, quỹ vận hành và ví',
       NULL, NULL,
       9997, 1, 'mdi mdi-cash-multiple'
FROM `sys_menu_admin` t1
WHERE NOT EXISTS (SELECT 1 FROM `sys_menu_admin` WHERE `url` = '?m=quyhoahong')
LIMIT 1;

COMMIT;

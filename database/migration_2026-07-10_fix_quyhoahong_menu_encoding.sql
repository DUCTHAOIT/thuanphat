-- Migration: Sửa lỗi font (mojibake) của menu "Quỹ hoa hồng" do lần chạy migration trước không set
-- đúng charset kết nối khi INSERT (database/migration_2026-07-10_quyhoahong_menu.sql).
-- Date: 2026-07-10

START TRANSACTION;

UPDATE `sys_menu_admin` SET
  `namevn` = 'Quỹ hoa hồng',
  `nameen` = 'Quỹ hoa hồng',
  `namecn` = 'Quỹ hoa hồng',
  `desvn` = 'Theo dõi quỹ công ty, quỹ chia hoa hồng, hoa hồng/thưởng đã trả - pending, quỹ vận hành và ví'
WHERE `url` = '?m=quyhoahong';

COMMIT;

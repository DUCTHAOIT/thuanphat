-- Migration: Thêm menu admin "Quản lý sơ đồ" (Sơ đồ cây trực tiếp + Sơ đồ cây điều tầng)
-- Date: 2026-07-12
-- Ref: admin80/modules/sodo/truc_tiep.php (?m=sodo&f=truc_tiep), admin80/modules/sodo/dieu_tang.php (?m=sodo&f=dieu_tang)
--
-- `sys_menu_admin.id` không phải AUTO_INCREMENT (gán thủ công), lấy id kế tiếp bằng MAX(id)+1 giống
-- migration_2026-07-10_quyhoahong_menu.sql. Đặt SET NAMES utf8 để tránh lỗi mojibake đã gặp ở migration đó
-- (xem migration_2026-07-10_fix_quyhoahong_menu_encoding.sql).
--
-- Đồng thời cấp quyền xem 3 menu mới cho các tài khoản admin đang có sẵn trong `sys_member` (nối thêm id
-- vào cột `permit`), để không cần thao tác thủ công gán quyền sau khi chạy migration.

SET NAMES utf8;

START TRANSACTION;

SET @exists_check = (SELECT COUNT(*) FROM `sys_menu_admin` WHERE `url` IN ('?m=sodo&f=truc_tiep', '?m=sodo&f=dieu_tang'));

SET @parent_id = IF(@exists_check = 0, (SELECT MAX(id) + 1 FROM `sys_menu_admin`), NULL);
SET @child1_id = IF(@exists_check = 0, @parent_id + 1, NULL);
SET @child2_id = IF(@exists_check = 0, @parent_id + 2, NULL);

INSERT INTO `sys_menu_admin` (`id`, `parent`, `namevn`, `nameen`, `namecn`, `url`, `desvn`, `desen`, `descn`, `order`, `ctrl`, `icon`)
SELECT @parent_id, 0, 'Quản lý sơ đồ', 'Quản lý sơ đồ', 'Quản lý sơ đồ', '#',
       'Xem sơ đồ cây trực tiếp và cây điều tầng toàn hệ thống', NULL, NULL, 9996, 1, 'mdi mdi-sitemap'
WHERE @exists_check = 0;

INSERT INTO `sys_menu_admin` (`id`, `parent`, `namevn`, `nameen`, `namecn`, `url`, `desvn`, `desen`, `descn`, `order`, `ctrl`, `icon`)
SELECT @child1_id, @parent_id, 'Sơ đồ cây trực tiếp', 'Sơ đồ cây trực tiếp', 'Sơ đồ cây trực tiếp', '?m=sodo&f=truc_tiep',
       'Xem và tìm kiếm cây trực tiếp (theo ref_by) của toàn hệ thống', NULL, NULL, 1, 1, NULL
WHERE @exists_check = 0;

INSERT INTO `sys_menu_admin` (`id`, `parent`, `namevn`, `nameen`, `namecn`, `url`, `desvn`, `desen`, `descn`, `order`, `ctrl`, `icon`)
SELECT @child2_id, @parent_id, 'Sơ đồ cây điều tầng', 'Sơ đồ cây điều tầng', 'Sơ đồ cây điều tầng', '?m=sodo&f=dieu_tang',
       'Xem cây điều tầng toàn hệ thống, danh sách hàng chờ và xếp vị trí thay sponsor', NULL, NULL, 2, 1, NULL
WHERE @exists_check = 0;

UPDATE `sys_member`
SET `permit` = CONCAT(`permit`, ",'", @parent_id, "','", @child1_id, "','", @child2_id, "'")
WHERE @exists_check = 0;

COMMIT;

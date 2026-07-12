-- Migration: Cập nhật tỉ lệ hoa hồng cây lấp tầng (spillover_f1..f8) sang đồng đều 3%/tầng
-- Date: 2026-07-11
-- Ref: docs/BUSINESS_RULES.md mục 6 (Hoa hồng cây lấp tầng) — trước đó F1 16%, F2-F8 mỗi tầng 2% (tổng 30%,
-- xem migration_2026-07-10_spillover_rates.sql), nay đổi sang đồng đều mỗi tầng 3% (tổng 24%).
-- Giá trị này admin đã cập nhật trực tiếp trên DB production; migration này ghi lại thay đổi để môi trường
-- khác (dev/staging, cài mới) khớp đúng, tránh bị ghi đè về giá trị cũ nếu chạy lại
-- migration_2026-07-10_spillover_rates.sql.

START TRANSACTION;

INSERT INTO `sys_config` (`name`, `value`, `lang`) VALUES
  ('spillover_f1', '0.03', 'vn'),
  ('spillover_f2', '0.03', 'vn'),
  ('spillover_f3', '0.03', 'vn'),
  ('spillover_f4', '0.03', 'vn'),
  ('spillover_f5', '0.03', 'vn'),
  ('spillover_f6', '0.03', 'vn'),
  ('spillover_f7', '0.03', 'vn'),
  ('spillover_f8', '0.03', 'vn')
ON DUPLICATE KEY UPDATE `value` = VALUES(`value`);

COMMIT;

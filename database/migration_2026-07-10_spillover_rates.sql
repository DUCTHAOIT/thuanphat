-- Migration: Seed tỉ lệ hoa hồng cây lấp tầng (spillover_f1..f8)
-- Date: 2026-07-10
-- Ref: docs/BUSINESS_RULES.md mục 6 (Hoa hồng cây lấp tầng: 8 tầng, F1 16%, F2-F8 mỗi tầng 2%, tổng 30%)
-- Trước đây code fallback hard-code khi thiếu sys_config; seed rõ ràng vào DB theo đúng cách đã làm
-- với f4-f9 (mục 11.1 BUSINESS_RULES.md: "đã thêm f4-f9 trực tiếp trên DB").

START TRANSACTION;

INSERT INTO `sys_config` (`name`, `value`, `lang`) VALUES
  ('spillover_f1', '0.16', 'vn'),
  ('spillover_f2', '0.02', 'vn'),
  ('spillover_f3', '0.02', 'vn'),
  ('spillover_f4', '0.02', 'vn'),
  ('spillover_f5', '0.02', 'vn'),
  ('spillover_f6', '0.02', 'vn'),
  ('spillover_f7', '0.02', 'vn'),
  ('spillover_f8', '0.02', 'vn')
ON DUPLICATE KEY UPDATE `value` = VALUES(`value`);

COMMIT;

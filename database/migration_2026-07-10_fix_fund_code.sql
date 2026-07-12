-- Migration: Sửa ENUM admin_fund_transactions.fund_code cho khớp docs/BUSINESS_RULES.md mục 3
-- Date: 2026-07-10
-- Ref: quỹ con thứ 4 của quỹ vận hành là "IT support, vận hành web" (it_van_hanh), không phải "marketing"
-- như đã tạo nhầm ở migration_2026-07-09_wallet_mlm_schema.sql. Bảng đang rỗng (chưa có code nào INSERT),
-- nên đổi ENUM an toàn, không mất dữ liệu.

START TRANSACTION;

ALTER TABLE `admin_fund_transactions`
  MODIFY `fund_code` ENUM('thi_truong_leader','van_phong','dao_tao','it_van_hanh','du_phong') NOT NULL;

COMMIT;

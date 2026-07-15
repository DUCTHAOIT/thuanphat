-- Migration: Quỹ tiêu dùng tuần hoàn công ty (tách khỏi quỹ vận hành)
-- Date: 2026-07-15
-- Ref: docs/BUSINESS_RULES.md mục 6 (Thưởng tiêu dùng tuần hoàn)
--
-- Trước đây 30% còn lại của thưởng tiêu dùng tuần hoàn (source='card_bonus') đổ chung vào "quỹ vận hành"
-- 5 quỹ con (thi_truong_leader, van_phong, dao_tao, it_van_hanh, du_phong). Từ nay tách riêng thành
-- "Quỹ tiêu dùng tuần hoàn công ty", chia đều 3 phần (mỗi phần = 10% quỹ chia hoa hồng gốc, cộng lại đúng
-- 30% như cũ):
--   - cp_nen_tang: Chi phí nền tảng (nhân sự, IT)
--   - bdh_leader: Ban điều hành & Leader
--   - du_phong_the: Quỹ dự phòng riêng của khoản này (KHÁC quỹ dự phòng `du_phong` của quỹ vận hành, không
--     gộp chung số dư)
--
-- Chỉ thêm giá trị enum mới cho fund_code (dữ liệu cũ với 5 fund_code cũ giữ nguyên, không sửa/xóa), source
-- 'card_bonus' giữ nguyên tên (không đổi ý nghĩa "nguồn phát sinh" - chỉ đổi đích fund_code đi kèm kể từ đây
-- trở đi). Nguồn 'direct_commission' (10% quỹ chia hoa hồng mỗi đơn) không đổi, vẫn đổ vào 5 quỹ con cũ.

START TRANSACTION;

ALTER TABLE `admin_fund_transactions`
  MODIFY `fund_code` ENUM('thi_truong_leader','van_phong','dao_tao','it_van_hanh','du_phong','cp_nen_tang','bdh_leader','du_phong_the') NOT NULL;

COMMIT;

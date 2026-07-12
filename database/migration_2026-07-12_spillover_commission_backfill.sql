-- Migration: Thêm cột chống tính trùng cho cơ chế "tính bù" hoa hồng điều tầng
-- Date: 2026-07-12
-- Ref: admin80/include/order_commission.php - generateBackfillSpilloverCommissionIfEligible()
--
-- Bối cảnh: nếu business_active bị sửa tay = 1 TRƯỚC khi thành viên có đơn kích hoạt thật, thì lúc sponsor
-- xếp họ vào spillover_tree, placeSpilloverMember() không tìm thấy đơn kích hoạt nào (mục 3
-- BUSINESS_RULES.md) nên bỏ qua hoàn toàn việc tính hoa hồng điều tầng + 3 loại thưởng (mục 6) - không
-- phải pending, mà KHÔNG sinh ra gì cả. Tuyến trên mất hẳn khoản này nếu không xử lý gì thêm.
--
-- Cột `commission_order_id`: NULL = vị trí này CHƯA từng được tính hoa hồng điều tầng; có giá trị = đã
-- tính rồi (order_id đã dùng để tính), chống tính lại lần 2 (mục 8.1 BUSINESS_RULES.md).
--
-- Dữ liệu cũ: backfill đúng theo cùng logic tìm đơn mà placeSpilloverMember() đã dùng lúc xếp cây, để
-- không tính bù nhầm cho những vị trí ĐÃ được tính đúng lúc xếp (tránh cộng hoa hồng 2 lần cho tuyến trên).

ALTER TABLE `spillover_tree`
  ADD COLUMN `commission_order_id` INT NULL DEFAULT NULL AFTER `placed_at`;

UPDATE `spillover_tree` st
SET st.commission_order_id = (
    SELECT o.id FROM `orders` o
    WHERE o.user_id = st.user_id AND o.is_activation_package = 1 AND o.status = 'approved'
    ORDER BY o.id ASC LIMIT 1
);

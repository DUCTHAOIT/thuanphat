-- Migration: Tách cột commission_active khỏi business_active (mục 5 BUSINESS_RULES.md)
-- Date: 2026-07-11
-- Ref: docs/BUSINESS_RULES.md mục 5 (pending/release), mục 6 (Sơ đồ lấp tầng)
--
-- Mục đích: cho phép trường hợp đặc biệt admin set tay `business_active = 1` (chưa mua combo thật) mà
-- `commission_active` vẫn = 0 -> thành viên đó vẫn được xếp vào cây lấp tầng / xét danh hiệu / tái tiêu
-- dùng bình thường (vẫn theo business_active, không đổi), nhưng hoa hồng cây điều tầng + thưởng danh hiệu
-- + thưởng điểm thẻ tiêu dùng + thưởng tiêu dùng tuần hoàn phát sinh cho họ sẽ luôn ở trạng thái pending
-- cho tới khi họ thực sự mua combo (lúc đó commission_active mới chuyển sang 1, release hết 1 lần).
-- Hoa hồng cây trực tiếp (mục 4) không đổi - luôn released ngay, không phụ thuộc cột nào trong 2 cột này.
--
-- Theo yêu cầu: mặc định commission_active = 0 cho TẤT CẢ user hiện có, kể cả user đã business_active = 1
-- từ trước (không backfill theo business_active). Từ thời điểm áp dụng migration này, hoa hồng/thưởng nói
-- trên phát sinh mới cho user cũ sẽ về pending cho tới khi user đó phát sinh 1 đơn mua combo mới.

ALTER TABLE `user`
  ADD COLUMN `commission_active` TINYINT(1) NOT NULL DEFAULT 0 AFTER `business_active`;

-- Tự động thêm vào hàng chờ xếp cây lấp tầng (spillover_waiting_list) mỗi khi business_active chuyển từ
-- 0 sang 1, BẤT KỂ set qua app (activateBusinessIfEligible trong order_commission.php) hay sửa tay trực
-- tiếp trong database. Trước migration này việc thêm vào hàng chờ chỉ chạy trong code PHP nên không bắt
-- được trường hợp sửa tay; nay chuyển hẳn sang trigger để có 1 điểm xử lý duy nhất cho cả 2 đường.
-- Chống thêm trùng: bỏ qua nếu user đã có trong spillover_tree (đã xếp vị trí) hoặc đang có sẵn 1 dòng
-- chưa xếp (placed = 0) trong hàng chờ.
DROP TRIGGER IF EXISTS `trg_user_business_active_waitlist`;

DELIMITER $$
CREATE TRIGGER `trg_user_business_active_waitlist`
AFTER UPDATE ON `user`
FOR EACH ROW
BEGIN
    IF NEW.business_active = 1 AND OLD.business_active = 0 AND NEW.ref_by IS NOT NULL THEN
        IF NOT EXISTS (SELECT 1 FROM spillover_tree WHERE user_id = NEW.id)
           AND NOT EXISTS (SELECT 1 FROM spillover_waiting_list WHERE user_id = NEW.id AND placed = 0)
        THEN
            INSERT INTO spillover_waiting_list (user_id, sponsor_id) VALUES (NEW.id, NEW.ref_by);
        END IF;
    END IF;
END$$
DELIMITER ;

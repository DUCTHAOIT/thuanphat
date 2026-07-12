-- Migration: Cho phép user tự hủy yêu cầu rút tiền đang chờ duyệt
-- Date: 2026-07-11
-- Ref: docs/BUSINESS_RULES.md mục 7 (Rút tiền)
--
-- Thêm trạng thái 'cancelled' (user tự hủy) bên cạnh 'pending'/'approved'/'rejected' hiện có, để phân biệt
-- với 'rejected' (admin từ chối). Cả 2 đều hoàn lại ví khả dụng như nhau, chỉ khác người thực hiện.

START TRANSACTION;

ALTER TABLE `transactions`
  MODIFY `status` ENUM('pending','approved','rejected','cancelled') DEFAULT 'pending';

COMMIT;

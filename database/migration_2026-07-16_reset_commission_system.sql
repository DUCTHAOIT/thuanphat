-- Migration: Reset toàn bộ dữ liệu hoa hồng/thưởng/sơ đồ điều tầng + đơn hàng + rút tiền (yêu cầu Sếp 2026-07-16)
-- Đã backup trước khi chạy: database/backup/thuanphat_before_reset_20260716_210705.sql
-- Phạm vi: xoá orders/order_items/order_payments (đơn hàng gốc, theo xác nhận),
-- toàn bộ hoa hồng/thưởng/sơ đồ điều tầng, transactions (rút tiền, theo xác nhận).
-- KHÔNG đụng: sys_product.is_activation_combo (giữ nguyên cấu hình combo trên sản phẩm),
-- user (giữ tài khoản thành viên, chỉ reset 2 cột business_active/commission_active về 0),
-- ranks (danh mục danh hiệu - đây là cấu hình, không phải lịch sử phát sinh).

SET FOREIGN_KEY_CHECKS = 0;

TRUNCATE TABLE orders;
TRUNCATE TABLE order_items;
TRUNCATE TABLE order_payments;
TRUNCATE TABLE commissions;
TRUNCATE TABLE recurring_consumption_bonuses;
TRUNCATE TABLE accumulated_consumption_bonuses;
TRUNCATE TABLE card_point_bonuses;
TRUNCATE TABLE user_ranks;
TRUNCATE TABLE spillover_tree;
TRUNCATE TABLE spillover_waiting_list;
TRUNCATE TABLE rebuy_transactions;
TRUNCATE TABLE admin_fund_transactions;
TRUNCATE TABLE consumption_cards;
TRUNCATE TABLE user_wallets;
TRUNCATE TABLE wallet_transactions;
TRUNCATE TABLE transactions;

UPDATE user SET business_active = 0, commission_active = 0;

SET FOREIGN_KEY_CHECKS = 1;

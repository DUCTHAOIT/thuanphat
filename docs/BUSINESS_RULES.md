# BUSINESS_RULES.md

# Mục đích

Tài liệu này mô tả toàn bộ quy tắc nghiệp vụ của hệ thống.

Không mô tả code.
Không mô tả SQL.

Nếu code khác với tài liệu này thì cần kiểm tra lại trước khi sửa.

sys_config.f1 đến sys_config.f9 là tie lệ chia hoa hồng cây sơ đồ trực tiếp
tỉ lệ chia ví từ ví tổng fix cứng 60% vào ví khả dụng, 20% vào ví tiêu dùng, 10% về ví tái tiêu dùng, 10% ví thuế phí

---

# 1. Thành viên (Member)

## Đăng ký

Luồng:

Khách đăng ký
↓
Tạo tài khoản
↓
Trạng thái = Pending
↓
Admin duyệt
↓
Member Active


# 2. Mua hàng

Luồng

Khách đặt hàng
↓
Tạo Order
↓
Thanh toán
↓
Admin xác nhận
↓
Order Approved
↓
Sinh hoa hồng
↓
Cộng ví

nếu là combo 5 triệu thì user.business_active = 1 (được nhận full hoa hồng và thưởng hệ thống)
nếu business_active = 0 thì chỉ được nhận hoa hồng  sơ đồ trực tiếp
Quy tắc

- Hoa hồng chỉ sinh sau khi đơn được duyệt.
- Không sinh hoa hồng khi đơn bị huỷ, từ chối
- Một đơn chỉ được sinh hoa hồng một lần.
- 40% đơn hàng cho vào quỹ công ty
- 60% dùng để chia hoa hồng (ví dụ 5 triệu thì 2 triệu chia vào quỹ công ty, 3 triệu dùng để chia hoa hồng (quỹ chia hoa hồng))
- chia 10% từ quỹ hoa hồng vào các ví admin quản lý  (các ví này hiển thị trên admin, không làm gì)
1. thị trường leader 2%
2. văn phòng 2%
3. đào tạo 2%
4. marketing 2%
5. quỹ dự phòng 2%

---
# 3. Hoa hồng sơ đồ trực tiếp

## Điều kiện nhận
## Hoa hồng trực tiếp

- Đơn hàng phải admin duyệt.
- thành viên chưa kích hoạt bussiness_active = 0 vẫn được nhận, cộng ví ngay, không lưu pending (xem "Phân biệt cách xử lý theo business_active" bên dưới).
- chia hoa hồng trên % quỹ chia hoa hồng
- sau khi admin duyệt mới chia hoa hồng: chia 9 tầng f1 f2 f3 ... theo cài đặt sys_config.f1 , sys_config.f2 ...
- Sau khi nhận, Hoa hồng được cộng vào ví tổng của thành viên
- Khi tiền vào ví tổng, tự động chia vào các ví khác của user, ví tổng chỉ để theo dõi (tổng thu nhập)
- 60% vào ví khả dụng, 20% vào ví tiêu dùng, 10% về ví tái tiêu dùng, 10% ví thuế, phí
---

business_active = 0

- Chưa tham gia gói 5 triệu
- Không được xếp cây
- Không nhận thưởng hệ thống
- Không nhận hoa hồng cây
- Chỉ nhận hoa hồng giới thiệu trực tiếp

business_active = 1

- Được xếp cây
- Được nhận toàn bộ hoa hồng
- Được xét danh hiệu
- Được tái tiêu dùng

## Phân biệt cách xử lý theo business_active (quan trọng, không hỏi lại)

Có 2 cách xử lý khác nhau tuỳ loại hoa hồng/thưởng, không được dùng chung 1 logic:

1. **Hoa hồng cây trực tiếp (F1-F9, mục 3)**: LUÔN được tính cho mọi tầng, bất kể người nhận đã business_active hay chưa.
   - Người nhận `business_active = 0` → vẫn `status = released`, cộng ví ngay luôn (KHÔNG lưu pending).
   - Người nhận `business_active = 1` → `status = released`, cộng ví ngay.
   - Nói cách khác: hoa hồng cây trực tiếp không bao giờ ở trạng thái pending, luôn cộng ví ngay khi sinh ra.

2. **Hoa hồng cây lấp tầng, thẻ tiêu dùng tuần hoàn, thưởng danh hiệu (mục "sơ đồ lấp tầng")**: được tính khi phát sinh, nhưng:
   - Người nhận `business_active = 0` → tạo dòng hoa hồng/thưởng với `status = pending`, KHÔNG cộng ví.
   - Người nhận `business_active = 1` → `status = released`, cộng ví ngay.
   - Khi người nhận chuyển sang `business_active = 1` → release toàn bộ pending nhóm này đang có, cộng ví (xem mục "pending commission").

# pending commission
(Chỉ áp dụng cho hoa hồng cây lấp tầng, thẻ tiêu dùng tuần hoàn, thưởng danh hiệu - KHÔNG áp dụng cho hoa hồng cây trực tiếp, xem mục "Phân biệt cách xử lý theo business_active")

Điều kiện

Người nhận chưa business_active

Hệ thống

Không cộng ví

Chỉ lưu pending

Khi business_active =1

↓

Release toàn bộ pending

↓

Cộng ví.

#  thứ tự chia tiền cây sơ đồ trực tiếp

Admin duyệt
↓
Quỹ công ty
↓
Hoa hồng trực tiếp
↓

Cộng ví
# thứ tự chia tiền sơ đồ cây lấp tầng
user đạt điều kiện được xếp cây business_active =1
↓
hiển thị tại người giới thiệu chờ xếp cây
↓
user được xếp vào cây lấp tầng
↓
hoa hồng cây lấp tầng
↓
Thẻ tiêu dùng tuần hoàn
↓
Thưởng danh hiệu
↓
Cộng ví

# quy tắc Ví tái tiêu dùng
thành viên không được sử dụng ví này, chỉ theo dõi. KHi đạt đủ 5 triệu hệ thống tự động tái tiêu dùng. Ví này tối đa 258 triệu. Hơn không được cộng tiếp

khi ví tái tiêu dùng đạt đủ 5 triệu
↓

Tự động tạo một giao dịch Rebuy

↓

Sinh hoa hồng, thưởng

↓

Reset ví tái tiêu dùng

↓

Tăng số lần tái tiêu dùng

# quy tắc thanh toán mua hàng
đơn hàng được khách hàng thanh toán bằng các phương thức sau:
1. thanh toán 1 phần đơn hàng bằng điểm thẻ tiêu dùng (bao nhiêu % do admin đặt)
2. phần còn lại của đơn hàng thanh toán bằng ví tiêu dùng
3. nếu ví tiêu dùng hết điểm có thể thanh toán phần còn thiếu (sau khi trừ điểm ở thẻ tiêu dùng và ví tiêu dùng) bằng ví khả dụng.
4. nếu thanh toán bằng điểm thẻ tiêu dùng, ví tiêu dùng, ví khả dụng vẫn chưa hết giá trị đơn hàng thì có thể thanh toán phần còn lại bằng tiền mặt. 
hoa hồng tính theo giá trị đơn hàng sau khi đã trừ đi số thanh toán bằng điểm thẻ tiêu dùng
# quy tắc ví tái tiêu dùng
# 4. Ví

Các loại ví

khi tham gia gói 5 triệu đầu tiên thì được cộng 5 triệu điểm thẻ tiêu dùng (chỉ sử dụng để mua hàng với tỉ lệ 20 -50% tuỳ admin đặt), tiền còn lại của đơn hàng có thể thanh toán bằng tiền mặt (tính hoa hồng bằng số tiền mặt) hoặc bằng ví khả dụng (có tính hoa hồng trên số tiền chuyển) 
## ví tổng
tổng thu nhập của user bao gồm hoa hồng, thưởng. chỉ để theo dõi, không làm gì.
Khi tiền về ví tổng, lập tức chia vào các ví 60% vào ví khả dụng, 20% vào ví tiêu dùng, 10% về ví tái tiêu dùng, 10% ví thuế, phí
## ví khả dụng

chỉ ví này được rút về ngân hàng, được thanh toán hàng phần còn lại khi đơn hàng được thanh toán bằng điểm thẻ tiêu dùng

---

## ví tiêu dùng
chỉ được thanh toán đơn hàng, phần còn lại khi đã trừ điểm ở thẻ tiêu dùng, nếu hết điểm tiêu dùng, phần còn lại hiển thị QR chuyển khoản

---

## ví thuế, phí

Lưu tiền thuế.

Không được sử dụng trực tiếp.

---



## sơ đồ lấp tầng
khi F1 đạt business_active = 1 thì F0 có quyền đặt F1 vào vị trí trong sơ đồ lấp tầng (sơ đồ 1 ra 3)
Sau khi đặt thành viên đó vào vị trí thì bắt đầu chia hoa hồng và thưởng.
# thiết kế sơ đồ lấp tầng
chỉ thành viên giới thiệu ra được quyền xếp vị trí
chỉ được xếp vị trí 1 lần duy nhất
có danh sách thành viên đang chờ xếp tầng
## chia hoa hồng và thưởng dựa theo cây lấp tầng
hoa hồng và thưởng, nếu business_active = 0 thì lưu pending, không cộng ví.
Khi business_active = 1 thì release toàn bộ pending, cộng ví (xem mục "Phân biệt cách xử lý theo business_active").
# hoa hồng
tính hoa hồng cây lấp tầng: 
chia hoa hồng f1 f2 ... f9 mỗi tầng 3%
# thẻ tiêu dùng tuần hoàn
lấy 10% quỹ chia hoa hồng để chia vào thẻ tiêu dùng tuần hoàn. Với 10% đó chia 70% vào ví tổng của user, Còn lại 30% cộng vào các ví do admin quản lý 
1. thị trường leader 6%
2. văn phòng 6%
3. đào tạo 6%
4. marketing 6%
5. quỹ dự phòng 6%
có 1 trực tiếp thì chỉ nhận được 4 tầng
muốn nhận tầng 5 phải có 2 F1 trực tiếp 
muốn nhận tầng 6 phải có 3 F1 trực tiếp
muốn nhận tầng 7 phải có 4 F1 trực tiếp
muốn nhận tầng 8 phải có 5 F1 trực tiếp
# thưởng danh hiệu
điều kiện đạt danh hiệu
quản lý: khi lấp đầy tầng 5 : 243 thành viên và có 2 F1 trực tiếp
trưởng phòng: khi lấp đầy tầng 6 : 729 thành viên và có 3 F1 trực tiếp
phó giám đốc: khi lấp đầy tầng 7 : 2187 thành viên và có 4 F1 trực tiếp
giám đốc: khi lấp đầy tầng 8 : 6561 thành viên và có 5 F1 trực tiếp

danh được thưởng thêm: quản lý 3% trưởng phòng 3% phó giám đốc 2% giám đốc 2%
THưởng danh hiệu cộng vào ví tổng

# 5. Rút tiền

(cập nhật 2026-07-09: đổi thời điểm trừ ví — trừ ngay khi tạo yêu cầu thay vì lúc admin duyệt)

- chỉ rút ở ví khả dụng (kha_dung)
- ví khả dụng phải đủ số dư mới được tạo yêu cầu.

Luồng

Tạo yêu cầu
↓
Trừ ngay ví khả dụng (kha_dung) + ghi wallet_transactions (direction=debit, ref_type=withdraw)
↓
Pending
↓
Admin duyệt
↓
Approved (chỉ xác nhận đã chuyển khoản, không đụng ví vì đã trừ từ lúc tạo yêu cầu)

Nếu từ chối

↓

Rejected

↓

Hoàn lại tiền vào ví khả dụng (kha_dung) + ghi wallet_transactions (direction=credit, ref_type=refund)

Code: `debitWallet()` (trừ lúc tạo) và `processWithdrawDecision()` (duyệt/từ chối, hoàn tiền khi từ chối) trong `admin80/include/order_commission.php`. Gọi từ `modules/user/xu_ly_rut_tien.php` (tạo yêu cầu) và `admin80/modules/withdraw/index.php`, `approve.php`, `index_.php`, `admin80/modules/user/withdraw.php` (duyệt/từ chối).

---

# Ghi chú kỹ thuật database (bổ sung 2026-07-09)

Bảng `transactions` (database/thuanphat.sql) chỉ dùng cho nghiệp vụ Rút tiền (mục 5 - nạp/rút ngân hàng).

Không dùng bảng `transactions` để log biến động các loại ví (cộng/trừ ví, chuyển ví, sinh hoa hồng...).

Các biến động ví khác cần bảng log riêng (ví dụ wallet_transactions) khi triển khai.

## Điều kiện kích hoạt business_active

- Khi 1 đơn hàng đơn lẻ (không cộng dồn) có `amount >= 5,000,000` và đơn được Admin duyệt (`status = 'approved'`) thì set `user.business_active = 1` cho `user_id` của đơn đó.
- Chỉ set một lần: nếu `business_active` đã = 1 thì bỏ qua, không set lại.
- Không có luồng hạ `business_active` về 0 khi đơn bị hoàn/huỷ, vì nghiệp vụ hiện tại: đơn chỉ được duyệt sau khi đã nhận thanh toán, nên đơn kích hoạt coi như chắc chắn thành công, không bị huỷ ngược. (Có thể bổ sung sau nếu phát sinh nhu cầu.)

---

# 8. Quy tắc dữ liệu

Các chức năng sau phải đảm bảo không bị thực hiện hai lần:

- Sinh hoa hồng.
- Cộng ví.
- Trừ ví.
- Rút tiền.

Nếu nghi ngờ đã xử lý trước đó thì phải kiểm tra lịch sử.

---

# 9. Transaction

Các thao tác sau phải chạy trong cùng transaction:

- Sinh hoa hồng.
- Cộng ví.
- Trừ ví.
- Hoàn tiền.

Nếu lỗi

↓

Rollback.

---

# 10. Ghi log

Các thao tác phải lưu lịch sử

- Sinh hoa hồng.
- Rút tiền.
- Chuyển ví.
- Hoàn tiền.
- Hủy đơn.

---

# 11. Chính sách hiện tại


Hoa hồng nhóm Theo sys_config.


---

# 12. Những điểm cần lưu ý

Không thay đổi các quy tắc trên nếu chưa có yêu cầu.

Nếu phát hiện code và tài liệu khác nhau:

- Báo cáo sự khác biệt.
- Không tự ý sửa nghiệp vụ.

---

# 13. Đề xuất cấu trúc dữ liệu (chưa áp dụng vào database)

Mục này chỉ là tài liệu thiết kế, dùng làm căn cứ khi triển khai code. Chưa chạy vào database thật, chưa sửa `database/thuanphat.sql`.

## 13.1 Sửa bảng hiện có

### `user` (bổ sung cột)

| Cột | Kiểu | Chú thích |
|---|---|---|
| `business_active` | TINYINT(1) DEFAULT 0 | 1 = đã tham gia gói 5tr, được nhận full hoa hồng/thưởng hệ thống. Chỉ set 1 lần khi có đơn đơn lẻ `amount >= 5,000,000` được duyệt, không hạ về 0. |

### `orders` (bổ sung cột)

| Cột | Kiểu | Chú thích |
|---|---|---|
| `is_activation_package` | TINYINT(1) DEFAULT 0 | Đánh dấu đơn là đơn kích hoạt gói 5tr (amount >= 5,000,000), dùng để truy vết, không dùng để tính lại nghiệp vụ. |
| `commission_generated` | TINYINT(1) DEFAULT 0 | Chống sinh hoa hồng 2 lần cho cùng 1 đơn (mục 8 - Quy tắc dữ liệu). Set = 1 ngay sau khi sinh hoa hồng thành công. |

### `commissions` (bổ sung cột)

| Cột | Kiểu | Chú thích |
|---|---|---|
| `type` | ENUM('direct','spillover','card','rank_bonus') DEFAULT 'direct' | Phân biệt: direct = hoa hồng sơ đồ trực tiếp (f1-f9), spillover = hoa hồng cây lấp tầng, card = thẻ tiêu dùng tuần hoàn, rank_bonus = thưởng danh hiệu. |
| `status` | ENUM('pending','released') DEFAULT 'released' | pending = người nhận chưa business_active, chưa cộng ví (mục "pending commission"). released = đã cộng ví tổng. |
| `released_at` | DATETIME NULL | Thời điểm release pending commission khi business_active chuyển sang 1. |

### `sys_config` (bổ sung dữ liệu — đã thêm f4-f9 trực tiếp trên DB)

Cần thêm các key cấu hình còn thiếu để không hard-code trong code:

| name | Ý nghĩa |
|---|---|
| `spillover_f1`..`spillover_f9` | Tỉ lệ % hoa hồng cây lấp tầng mỗi tầng (hiện tài liệu ghi cố định 3%/tầng). |
| `card_recurring_percent` | % trích từ quỹ hoa hồng vào thẻ tiêu dùng tuần hoàn (tài liệu: 10%). |
| `card_payment_percent` | % thanh toán đơn hàng tối đa bằng điểm thẻ tiêu dùng, admin đặt (tài liệu: 20-50%). |

## 13.2 Bảng mới

### `user_wallets` — các ví của thành viên (mục 4)

| Cột | Kiểu | Chú thích |
|---|---|---|
| `id` | INT PK AI | |
| `user_id` | INT UNIQUE (FK user.id) | Mỗi user đúng 1 dòng. |
| `tong` | DECIMAL(15,2) DEFAULT 0 | Ví tổng — tổng thu nhập, chỉ theo dõi, không rút/thanh toán trực tiếp. |
| `kha_dung` | DECIMAL(15,2) DEFAULT 0 | Ví khả dụng — duy nhất được rút về ngân hàng, và thanh toán phần còn thiếu của đơn hàng. |
| `tieu_dung` | DECIMAL(15,2) DEFAULT 0 | Ví tiêu dùng — chỉ dùng thanh toán đơn hàng (sau khi trừ điểm thẻ tiêu dùng). |
| `tai_tieu_dung` | DECIMAL(15,2) DEFAULT 0 | Ví tái tiêu dùng — chỉ theo dõi, tối đa 258,000,000. Khi đạt 5,000,000 tự động tạo giao dịch Rebuy rồi reset về 0. |
| `thue_phi` | DECIMAL(15,2) DEFAULT 0 | Ví thuế, phí — không được sử dụng trực tiếp. |
| `rebuy_count` | INT DEFAULT 0 | Số lần đã tái tiêu dùng (tăng mỗi lần ví tái tiêu dùng reset). |
| `updated_at` | DATETIME ON UPDATE CURRENT_TIMESTAMP | |

### `wallet_transactions` — lịch sử biến động ví (mục 8, 9, 10)

Lưu ý: bảng `transactions` hiện có **chỉ dùng cho rút tiền ngân hàng**, không dùng chung cho mục này.

| Cột | Kiểu | Chú thích |
|---|---|---|
| `id` | INT PK AI | |
| `user_id` | INT | |
| `wallet_type` | ENUM('tong','kha_dung','tieu_dung','tai_tieu_dung','thue_phi') | Ví nào bị tác động. |
| `direction` | ENUM('credit','debit') | Cộng hay trừ. |
| `amount` | DECIMAL(15,2) | |
| `balance_after` | DECIMAL(15,2) | Số dư sau giao dịch, phục vụ đối soát/audit. |
| `ref_type` | ENUM('order','commission','withdraw','rebuy','refund','rank_bonus','card_bonus','admin_adjust') | Nguồn gốc phát sinh giao dịch. |
| `ref_id` | INT | id tham chiếu tới order/commission/... tương ứng. |
| `note` | VARCHAR(255) NULL | |
| `created_at` | DATETIME DEFAULT CURRENT_TIMESTAMP | |

### `consumption_cards` — thẻ tiêu dùng

| Cột | Kiểu | Chú thích |
|---|---|---|
| `id` | INT PK AI | |
| `user_id` | INT UNIQUE | |
| `balance` | DECIMAL(15,2) DEFAULT 0 | Số dư điểm thẻ tiêu dùng, được cộng 5,000,000 khi kích hoạt gói 5tr lần đầu. |
| `created_at` / `updated_at` | DATETIME | |

### `spillover_tree` — cây lấp tầng (sơ đồ 1 ra 3)

| Cột | Kiểu | Chú thích |
|---|---|---|
| `id` | INT PK AI | |
| `user_id` | INT UNIQUE | Thành viên được xếp vào cây. |
| `parent_id` | INT NULL | Vị trí cha trong cây lấp tầng — khác với `user.ref_by` (người giới thiệu trực tiếp). |
| `sponsor_id` | INT | Người có quyền xếp vị trí (chỉ người giới thiệu trực tiếp mới được xếp). |
| `level` | INT | Tầng trong cây (1-9). |
| `position` | TINYINT(1) | Vị trí con trong sơ đồ 1 ra 3: 1/2/3. |
| `placed_at` | DATETIME | Thời điểm xếp — chỉ được xếp 1 lần duy nhất. |

Ràng buộc: UNIQUE (`parent_id`, `position`) — 1 vị trí con chỉ chứa 1 người.

### `spillover_waiting_list` — danh sách chờ xếp tầng

| Cột | Kiểu | Chú thích |
|---|---|---|
| `id` | INT PK AI | |
| `user_id` | INT | Thành viên đã `business_active=1` nhưng chưa được xếp vào cây lấp tầng. |
| `sponsor_id` | INT | Người giới thiệu trực tiếp, có quyền xếp. |
| `placed` | TINYINT(1) DEFAULT 0 | Đánh dấu đã xếp xong (chuyển sang `spillover_tree`). |
| `created_at` | DATETIME | |

### `ranks` — danh mục danh hiệu

| Cột | Kiểu | Chú thích |
|---|---|---|
| `code` | VARCHAR(30) PK | quan_ly / truong_phong / pho_giam_doc / giam_doc |
| `name` | VARCHAR(100) | |
| `required_level` | INT | Tầng cần lấp đầy: 5/6/7/8 |
| `required_members` | INT | Số thành viên cần: 243/729/2187/6561 |
| `required_f1` | INT | Số F1 trực tiếp cần: 2/3/4/5 |
| `bonus_percent` | DECIMAL(5,4) | % thưởng thêm: 0.03/0.03/0.02/0.02 |

### `user_ranks` — lịch sử đạt danh hiệu

| Cột | Kiểu | Chú thích |
|---|---|---|
| `id` | INT PK AI | |
| `user_id` | INT | |
| `rank_code` | VARCHAR(30) (FK ranks.code) | |
| `achieved_at` | DATETIME | |

### `admin_fund_transactions` — 5 quỹ admin cố định

Các ví này chỉ hiển thị trên admin, không thao tác trực tiếp (theo mục 2 và mục "thẻ tiêu dùng tuần hoàn").

| Cột | Kiểu | Chú thích |
|---|---|---|
| `id` | INT PK AI | |
| `fund_code` | ENUM('thi_truong_leader','van_phong','dao_tao','marketing','du_phong') | |
| `source` | ENUM('direct_commission','card_bonus') | direct_commission = 2% từ quỹ chia hoa hồng trực tiếp; card_bonus = 6% từ thẻ tiêu dùng tuần hoàn. |
| `order_id` | INT | Đơn hàng gốc phát sinh khoản này. |
| `amount` | DECIMAL(15,2) | |
| `created_at` | DATETIME | |

### `order_payments` — breakdown thanh toán 1 đơn (mục "quy tắc thanh toán mua hàng")

| Cột | Kiểu | Chú thích |
|---|---|---|
| `id` | INT PK AI | |
| `order_id` | INT UNIQUE | |
| `card_amount` | DECIMAL(15,2) DEFAULT 0 | Số tiền trừ từ điểm thẻ tiêu dùng. |
| `tieu_dung_amount` | DECIMAL(15,2) DEFAULT 0 | Trừ từ ví tiêu dùng. |
| `kha_dung_amount` | DECIMAL(15,2) DEFAULT 0 | Trừ từ ví khả dụng (khi ví tiêu dùng hết). |
| `cash_amount` | DECIMAL(15,2) DEFAULT 0 | Tiền mặt/chuyển khoản phần còn thiếu. |
| `commission_base_amount` | DECIMAL(15,2) | Giá trị dùng để tính hoa hồng = amount đơn hàng - card_amount (theo quy tắc "hoa hồng tính theo giá trị đơn hàng sau khi đã trừ đi số thanh toán bằng điểm thẻ tiêu dùng"). |
| `created_at` | DATETIME | |

---
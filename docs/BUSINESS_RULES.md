# BUSINESS_RULES.md

# Mục đích

Tài liệu này mô tả toàn bộ quy tắc nghiệp vụ của hệ thống.

Không mô tả code. Không mô tả SQL.

Nếu code khác với tài liệu này thì cần kiểm tra lại trước khi sửa — báo cáo sự khác biệt, không tự ý sửa nghiệp vụ (xem mục 10).

---

# 1. Thành viên (Member)

## Đăng ký

Khách đăng ký
→ Tạo tài khoản, trạng thái = Pending
→ Admin duyệt
→ Member Active

---

# 2. Ví (Wallet)

## Các loại ví

| Ví | Công dụng |
|---|---|
| **Ví tổng** | Tổng thu nhập (hoa hồng, thưởng...). Chỉ để theo dõi, không rút/thanh toán trực tiếp. Tiền vào ví tổng lập tức tự động chia sang 4 ví bên dưới (xem quy tắc chia ví). |
| **Ví khả dụng** (`kha_dung`) | Ví duy nhất được rút về ngân hàng (mục 7). Dùng thanh toán phần còn thiếu của đơn hàng khi ví tiêu dùng đã hết. |
| **Ví tiêu dùng** (`tieu_dung`) | Chỉ dùng thanh toán đơn hàng, sau khi đã trừ điểm thẻ tiêu dùng. Hết điểm thì hiển thị QR chuyển khoản để thanh toán phần còn thiếu. |
| **Ví tái tiêu dùng** (`tai_tieu_dung`) | Thành viên không được dùng, chỉ theo dõi. Tối đa 258,000,000đ, vượt quá không cộng thêm. Khi đạt đủ 5,000,000đ → tự động tạo 1 giao dịch Rebuy → sinh hoa hồng/thưởng liên quan → reset ví về 0 → tăng số lần tái tiêu dùng (`rebuy_count`). |
| **Ví thuế, phí** (`thue_phi`) | Lưu tiền thuế. Không được sử dụng trực tiếp. |

## Quy tắc chia ví tổng

Áp dụng cho **mọi khoản tiền** đổ vào ví tổng — hoa hồng sơ đồ trực tiếp (mục 4), hoa hồng cây lấp tầng, thẻ tiêu dùng tuần hoàn, thưởng danh hiệu (mục 6):

- 60% → ví khả dụng
- 20% → ví tiêu dùng
- 10% → ví tái tiêu dùng
- 10% → ví thuế, phí

Tỉ lệ này **fix cứng**, không cấu hình qua sys_config.

---

# 3. Mua hàng (Order)

## Luồng

Khách đặt hàng → Tạo Order → Thanh toán → Admin xác nhận → Order Approved → Sinh hoa hồng → Cộng ví

## Quy tắc thanh toán đơn hàng (theo thứ tự ưu tiên)

1. Điểm thẻ tiêu dùng (tối đa bao nhiêu % giá trị đơn do admin đặt, xem `card_payment_percent` mục 11).
2. Phần còn lại → trừ vào ví tiêu dùng.
3. Nếu ví tiêu dùng hết điểm → phần còn thiếu trừ tiếp vào ví khả dụng.
4. Nếu cả 3 nguồn trên vẫn chưa đủ → thanh toán phần còn lại bằng tiền mặt/chuyển khoản. 

**Hoa hồng tính trên giá trị đơn hàng SAU KHI đã trừ phần thanh toán bằng điểm thẻ tiêu dùng.**

Khi kích hoạt gói 5 triệu lần đầu (xem bên dưới), thành viên được cộng 5,000,000 điểm thẻ tiêu dùng.

## Quy tắc sinh hoa hồng

- Hoa hồng chỉ sinh sau khi đơn được admin duyệt.
- Không sinh hoa hồng khi đơn bị huỷ, từ chối.
- Một đơn chỉ được sinh hoa hồng một lần (chống lặp — xem mục 8).

## Quỹ công ty / Quỹ chia hoa hồng / Quỹ vận hành

Mỗi đơn hàng được duyệt, giá trị đơn (sau khi trừ điểm thẻ tiêu dùng nếu có) chia:

- **40%** → quỹ công ty.
- **60%** → **quỹ chia hoa hồng** (ví dụ đơn 5,000,000đ → quỹ chia hoa hồng = 3,000,000đ).

Quỹ chia hoa hồng là **nền tính chung**, dùng để tính **2 khoản hoa hồng độc lập, không trừ lẫn nhau**:

1. Hoa hồng sơ đồ trực tiếp (mục 4) — tính ngay lúc admin duyệt đơn.
2. Hoa hồng + thưởng cây lấp tầng (mục 6) — chỉ tính khi đơn là đơn kích hoạt gói 5tr, vào lúc thành viên **được xếp vào cây lấp tầng** (thời điểm này có thể trễ hơn lúc duyệt đơn).

Ví dụ đơn 5tr: 3 triệu quỹ chia hoa hồng dùng để tính hoa hồng trực tiếp theo %, và **cũng chính 3 triệu đó** (không phải một khoản 3 triệu khác) được dùng lại để tính hoa hồng lấp tầng theo %.

## Quỹ vận hành

Quỹ vận hành do admin quản lý, nhận tiền từ 2 nguồn:

- **10%** quỹ chia hoa hồng của mỗi đơn hàng (mục này).
- **30%** còn lại của khoản thưởng tiêu dùng tuần hoàn (mục 6).

Bất kỳ khoản tiền nào cộng vào quỹ vận hành đều **tự động chia đều 20%** cho mỗi quỹ trong 5 quỹ con sau (hiển thị trên trang admin):

| Quỹ | Tỉ lệ (trên khoản tiền vào quỹ vận hành) |
|---|---|
| Thị trường leader | 20% |
| Văn phòng | 20% |
| Đào tạo | 20% |
| IT support, vận hành web | 20% |
| Quỹ dự phòng | 20% |

Lưu ý: đây là mô tả nghiệp vụ, **chưa yêu cầu code** — bảng `admin_fund_transactions` (mục 11.2) vẫn đang ở dạng thiết kế đề xuất, chưa áp dụng vào code/database thật.

## Kích hoạt gói 5 triệu (`business_active`)

(cập nhật 2026-07-10: đổi điều kiện kích hoạt từ "tổng đơn ≥ 5.000.000đ" sang "đơn có mua đúng sản phẩm combo kích hoạt")

- Admin đánh dấu sản phẩm nào là **"combo kích hoạt"** bằng cờ `sys_product.is_activation_combo` — tích checkbox "Combo kích hoạt" ngay trong form Thêm/Sửa sản phẩm (`?m=product`).
- Khi 1 đơn hàng được admin duyệt, nếu đơn đó **có chứa ít nhất 1 sản phẩm** được đánh dấu combo kích hoạt (dù giỏ hàng có kèm sản phẩm khác không phải combo) → set `user.business_active = 1` cho người mua.
- **Không còn tính theo tổng tiền đơn hàng** — 1 đơn hàng nhiều sản phẩm lẻ cộng dồn đủ 5 triệu nhưng không có sản phẩm combo kích hoạt thì **không** kích hoạt.
- Chỉ set **một lần duy nhất**: nếu đã = 1 thì bỏ qua, không set lại.
- Không có luồng hạ `business_active` về 0 khi đơn bị hoàn/huỷ sau đó (đơn chỉ được duyệt sau khi đã nhận thanh toán, coi như chắc chắn thành công).

---

# 4. Hoa hồng sơ đồ trực tiếp (F1 - F9)

## Quy ước F0/F1 và tầng

- **F0** = thành viên hiện tại (người nhận/đang được tính hoa hồng). F0 không tính là 1 tầng.
- **F1** = thành viên do F0 giới thiệu trực tiếp (`user.ref_by` trỏ về F0) → **tầng 1**.
- **F2** = thành viên do F1 giới thiệu trực tiếp → **tầng 2**. Tương tự đến **F9** = **tầng 9**.
- `sys_config.f1` .. `sys_config.f9` = tỉ lệ hoa hồng **F0 được nhận** khi **F1 .. F9 tương ứng** phát sinh đơn hàng (theo chuỗi `ref_by` đi ngược lên).

- Điều kiện: đơn hàng phải được admin duyệt.
- Chia 9 tầng (F1, F2, ... F9) theo người giới thiệu trực tiếp (`user.ref_by`), tỉ lệ mỗi tầng lấy từ `sys_config.f1` .. `sys_config.f9`.
- Tính trên quỹ chia hoa hồng của đơn hàng (mục 3).
- **Luôn `status = released`, cộng ví ngay lập tức** — không phân biệt người nhận đã `business_active` hay chưa, không bao giờ ở trạng thái pending (khác với hoa hồng cây lấp tầng, xem mục 5).

---

# 5. Quy tắc theo `business_active`

## `business_active = 0`

- Chưa tham gia gói kích hoạt 5 triệu.
- Không được xếp vào cây lấp tầng.
- Không được xét danh hiệu, không được tái tiêu dùng.
- Vẫn nhận hoa hồng sơ đồ trực tiếp bình thường (mục 4).
- Hoa hồng cây lấp tầng + thẻ tiêu dùng tuần hoàn + thưởng danh hiệu (gọi chung **"thưởng hệ thống"**, mục 6) khi phát sinh sẽ bị lưu **pending**, chưa cộng ví.

## `business_active = 1`

- Được xếp vào cây lấp tầng, được xét danh hiệu, được tái tiêu dùng.
- Nhận toàn bộ hoa hồng + thưởng hệ thống.
- Toàn bộ "thưởng hệ thống" đang pending được **release hết 1 lần**, cộng ví.

## Quy tắc pending / release (chỉ áp dụng cho "thưởng hệ thống" — hoa hồng cây lấp tầng, thẻ tiêu dùng tuần hoàn, thưởng danh hiệu; **không áp dụng cho hoa hồng sơ đồ trực tiếp**, xem mục 4)

- Lúc phát sinh, nếu người nhận `business_active = 0` → tạo dòng hoa hồng/thưởng với `status = pending`, KHÔNG cộng ví.
- Lúc phát sinh, nếu người nhận `business_active = 1` → `status = released`, cộng ví ngay.
- Khi người nhận chuyển từ 0 sang 1 → release toàn bộ pending đang có, cộng ví hết 1 lần.

---

# 6. Sơ đồ lấp tầng (Spillover)

## Mô hình cây

Toàn hệ thống là **1 cây chung duy nhất** (không phải mỗi người 1 cây riêng), sơ đồ **1 ra 3**, tối đa **9 tầng**.

## Xếp vị trí

- Khi 1 thành viên (F1) đạt `business_active = 1` → hệ thống tự thêm F1 vào **danh sách chờ xếp tầng**, hiển thị cho người giới thiệu trực tiếp (F0).
- Chỉ **người giới thiệu trực tiếp** mới có quyền xếp vị trí cho người mình giới thiệu.
- F0 tự thao tác đặt vị trí trên trang cá nhân của mình, **không qua admin duyệt**.
- F1 được đặt vào 1 vị trí trống **bất kỳ trong tầm với của F0** trong cây chung (không bắt buộc phải nằm ngay dưới F0).
- Mỗi thành viên chỉ được xếp vị trí **1 lần duy nhất**.
- Hạng/tầng của 1 thành viên được tính theo nhánh con tính **từ vị trí của chính người đó** trong cây chung.

## Nguồn quỹ hoa hồng + thưởng cây lấp tầng

Dùng chung quỹ chia hoa hồng của đơn hàng kích hoạt gói 5tr (mục 3) làm nền tính, **độc lập** với hoa hồng sơ đồ trực tiếp (không trừ lẫn nhau — xem mục 3). Thời điểm tính: lúc thành viên **được xếp vào cây**, không phải lúc admin duyệt đơn.

## Hoa hồng cây lấp tầng
tính trên cây lấp tầng (hay điều tầng)
Khi thành viên được xếp vào cây mới chia
Chia 8 tầng (F1..F8), mỗi tầng **3%** tổng 24 % trên quỹ chia hoa hồng. Không có điều kiện ràng buộc số F1 trực tiếp.
Nếu tầng nào không có thành viên thì không chia

## thưởng tiêu dùng tuần hoàn
tính trên cây lấp tầng (hay điều tầng)
Khi thành viên được xếp vào cây mới chia
Trích **10%** quỹ chia hoa hồng (ví dụ quỹ 3,000,000đ → trích 300,000đ) cho khoản này, chia:

- **70%** (210,000đ) → chia đều 8 tầng 
- **30%** (90,000đ) còn lại → cộng vào **quỹ vận hành** (xem mục 3 — tự động chia đều 20%/quỹ cho 5 quỹ con).

có điều kiện nhận thưởng tiêu dùng tuần hoàn giống thưởng danh hiệu
thưởng tiêu dùng tuần hoàn cộng vào ví tiêu dùng của thành viên
mỗi thành viên được nhận điểm thẻ tiêu dùng tối đa 258 triệu
## thưởng điểm thẻ tiêu dùng
tính trên cây lấp tầng (hay điều tầng)
Khi thành viên được xếp vào cây mới chia
Trích **10%** quỹ chia hoa hồng (ví dụ quỹ 3,000,000đ → trích 300,000đ) cho khoản này, chia đều cho 8 tầng từ tầng 1 đến tầng 8
thưởng điểm thẻ tiêu dùng cộng vào điểm tiêu dùng (thẻ)

## Thưởng danh hiệu
Khi đạt danh hiệu có hiển thị cấp bậc thành viên
tính trên cây lấp tầng (hay điều tầng)
Khi thành viên được xếp vào cây mới chia
Đạt danh hiệu khi thoả **đồng thời cả 2 điều kiện**: lấp đầy đúng số thành viên ở tầng quy định, VÀ đủ số F1 trực tiếp:

| Danh hiệu | Lấp đầy tầng | Số thành viên (3^tầng) | Số F1 trực tiếp cần | Thưởng thêm |
|---|---|---|---|---|
| Quản lý | 4 | 81 | 2 | 3% |
| Trưởng phòng | 5 | 243 | 3 | 3% |
| Phó giám đốc | 6 | 729 | 4 | 2% |
| Giám đốc | 7 | 2187 | 5 | 2% |

Thưởng danh hiệu cộng vào ví tổng.

---

# 7. Rút tiền

- Chỉ rút từ ví khả dụng (`kha_dung`).
- Ví khả dụng phải đủ số dư mới được tạo yêu cầu.

## Luồng

Tạo yêu cầu
→ Trừ ngay ví khả dụng (`kha_dung`) + ghi `wallet_transactions` (`direction=debit`, `ref_type=withdraw`)
→ Pending
→ Admin duyệt → Approved (chỉ xác nhận đã chuyển khoản, không đụng ví vì đã trừ từ lúc tạo yêu cầu)

Nếu admin từ chối → Rejected → Hoàn lại tiền vào ví khả dụng (`kha_dung`) + ghi `wallet_transactions` (`direction=credit`, `ref_type=refund`).

Code: `debitWallet()` (trừ lúc tạo) và `processWithdrawDecision()` (duyệt/từ chối, hoàn tiền khi từ chối) trong `admin80/include/order_commission.php`. Gọi từ `modules/user/xu_ly_rut_tien.php` (tạo yêu cầu) và `admin80/modules/withdraw/index.php`, `approve.php`, `index_.php`, `admin80/modules/user/withdraw.php` (duyệt/từ chối).

---

# 8. Quy tắc kỹ thuật chung

## 8.1 Không được thực hiện hai lần

Các chức năng sau phải đảm bảo không bị thực hiện hai lần: sinh hoa hồng, cộng ví, trừ ví, rút tiền, xếp vị trí cây lấp tầng.

Nếu nghi ngờ đã xử lý trước đó thì phải kiểm tra lịch sử trước khi xử lý lại.

## 8.2 Transaction

Các thao tác sau phải chạy trong cùng 1 transaction: sinh hoa hồng, cộng ví, trừ ví, hoàn tiền, xếp vị trí cây lấp tầng. Nếu lỗi → rollback toàn bộ.

## 8.3 Ghi log

Các thao tác sau phải lưu lịch sử: sinh hoa hồng, rút tiền, chuyển ví, hoàn tiền, hủy đơn, xếp vị trí cây lấp tầng.

---

# 9. Ghi chú kỹ thuật database

Bảng `transactions` (`database/thuanphat.sql`) **chỉ dùng cho nghiệp vụ Rút tiền** (mục 7 — nạp/rút ngân hàng). Không dùng bảng này để log biến động các loại ví (cộng/trừ ví, chuyển ví, sinh hoa hồng...) — các biến động ví dùng bảng `wallet_transactions` (mục 11).

---

# 10. Những điểm cần lưu ý khi sửa

Không thay đổi các quy tắc trong tài liệu này nếu chưa có yêu cầu.

Nếu phát hiện code và tài liệu khác nhau: báo cáo sự khác biệt, không tự ý sửa nghiệp vụ.

---

# 11. Đề xuất cấu trúc dữ liệu (chưa áp dụng vào database)

Mục này chỉ là tài liệu thiết kế, dùng làm căn cứ khi triển khai code. Chưa chạy vào database thật, chưa sửa `database/thuanphat.sql`.

## 11.1 Sửa bảng hiện có

### `user` (bổ sung cột)

| Cột | Kiểu | Chú thích |
|---|---|---|
| `business_active` | TINYINT(1) DEFAULT 0 | 1 = đã tham gia gói 5tr, được nhận full hoa hồng/thưởng hệ thống. Chỉ set 1 lần khi có đơn đơn lẻ `amount >= 5,000,000` được duyệt, không hạ về 0. |

### `orders` (bổ sung cột)

| Cột | Kiểu | Chú thích |
|---|---|---|
| `is_activation_package` | TINYINT(1) DEFAULT 0 | Đánh dấu đơn là đơn kích hoạt gói 5tr (đơn có chứa sản phẩm combo kích hoạt), dùng để truy vết, không dùng để tính lại nghiệp vụ. |
| `commission_generated` | TINYINT(1) DEFAULT 0 | Chống sinh hoa hồng 2 lần cho cùng 1 đơn (mục 8.1). Set = 1 ngay sau khi sinh hoa hồng thành công. |

### `sys_product` (bổ sung cột — đã áp dụng, xem `database/migration_2026-07-10_activation_combo.sql`)

| Cột | Kiểu | Chú thích |
|---|---|---|
| `is_activation_combo` | TINYINT(1) DEFAULT 0 | Đánh dấu sản phẩm là "combo kích hoạt gói 5tr". Admin tự tick chọn ngay trong form Thêm/Sửa sản phẩm (`?m=product`). Đơn hàng chứa ít nhất 1 sản phẩm này sẽ kích hoạt `business_active` cho người mua (mục 3). |

### `commissions` (bổ sung cột)

| Cột | Kiểu | Chú thích |
|---|---|---|
| `type` | ENUM('direct','spillover','card','rank_bonus') DEFAULT 'direct' | Phân biệt: direct = hoa hồng sơ đồ trực tiếp (F1-F9), spillover = hoa hồng cây lấp tầng, card = thẻ tiêu dùng tuần hoàn, rank_bonus = thưởng danh hiệu. |
| `status` | ENUM('pending','released') DEFAULT 'released' | pending = người nhận chưa business_active, chưa cộng ví (mục 5). released = đã cộng ví tổng. |
| `released_at` | DATETIME NULL | Thời điểm release pending commission khi business_active chuyển sang 1. |

### `sys_config` (bổ sung dữ liệu — đã thêm f4-f9 trực tiếp trên DB)

Cần thêm các key cấu hình còn thiếu để không hard-code trong code:

| name | Ý nghĩa |
|---|---|
| `spillover_f1`..`spillover_f9` | Tỉ lệ % hoa hồng cây lấp tầng mỗi tầng (tài liệu mục 6: cố định 3%/tầng). |
| `card_recurring_percent` | % trích từ quỹ hoa hồng vào thẻ tiêu dùng tuần hoàn (tài liệu mục 6: 10%). |
| `card_payment_percent` | % thanh toán đơn hàng tối đa bằng điểm thẻ tiêu dùng, admin đặt (tài liệu mục 3: 20-50%). |

## 11.2 Bảng mới

### `user_wallets` — các ví của thành viên (mục 2)

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

### `wallet_transactions` — lịch sử biến động ví (mục 8, 9)

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

### `spillover_tree` — cây lấp tầng (sơ đồ 1 ra 3, mục 6)

| Cột | Kiểu | Chú thích |
|---|---|---|
| `id` | INT PK AI | |
| `user_id` | INT UNIQUE | Thành viên được xếp vào cây. |
| `parent_id` | INT NULL | `user_id` của vị trí cha trong CÂY CHUNG (1 cây duy nhất toàn hệ thống) — khác với `user.ref_by` (người giới thiệu trực tiếp). NULL = vị trí gốc của cây. Không nhất thiết bằng `sponsor_id`. |
| `sponsor_id` | INT | Người CÓ QUYỀN đặt thành viên này vào vị trí (= người giới thiệu trực tiếp của `user_id`), không quyết định vị trí đặt ở đâu trong cây. |
| `level` | INT | Tầng trong cây (1-9). |
| `position` | TINYINT(1) | Vị trí con trong sơ đồ 1 ra 3: 1/2/3. |
| `placed_at` | DATETIME | Thời điểm xếp — chỉ được xếp 1 lần duy nhất. |

Ràng buộc: UNIQUE (`parent_id`, `position`) — 1 vị trí con chỉ chứa 1 người.

### `spillover_waiting_list` — danh sách chờ xếp tầng (mục 6)

| Cột | Kiểu | Chú thích |
|---|---|---|
| `id` | INT PK AI | |
| `user_id` | INT | Thành viên đã `business_active=1` nhưng chưa được xếp vào cây lấp tầng. |
| `sponsor_id` | INT | Người giới thiệu trực tiếp, có quyền xếp. |
| `placed` | TINYINT(1) DEFAULT 0 | Đánh dấu đã xếp xong (chuyển sang `spillover_tree`). |
| `created_at` | DATETIME | |

### `ranks` — danh mục danh hiệu (mục 6)

| Cột | Kiểu | Chú thích |
|---|---|---|
| `code` | VARCHAR(30) PK | quan_ly / truong_phong / pho_giam_doc / giam_doc |
| `name` | VARCHAR(100) | |
| `required_level` | INT | Tầng cần lấp đầy: 4/5/6/7 |
| `required_members` | INT | Số thành viên cần: 81/243/729/2187 |
| `required_f1` | INT | Số F1 trực tiếp cần: 2/3/4/5 |
| `bonus_percent` | DECIMAL(5,4) | % thưởng thêm: 0.03/0.03/0.02/0.02 |

### `user_ranks` — lịch sử đạt danh hiệu

| Cột | Kiểu | Chú thích |
|---|---|---|
| `id` | INT PK AI | |
| `user_id` | INT | |
| `rank_code` | VARCHAR(30) (FK ranks.code) | |
| `achieved_at` | DATETIME | |

### `admin_fund_transactions` — 5 quỹ con của quỹ vận hành

Các quỹ này chỉ hiển thị trên admin, không thao tác trực tiếp (mục 3 — Quỹ vận hành).

| Cột | Kiểu | Chú thích |
|---|---|---|
| `id` | INT PK AI | |
| `fund_code` | ENUM('thi_truong_leader','van_phong','dao_tao','it_van_hanh','du_phong') | |
| `source` | ENUM('direct_commission','card_bonus') | direct_commission = 10% từ quỹ chia hoa hồng (mục 3); card_bonus = 30% còn lại của thưởng tiêu dùng tuần hoàn (mục 6). Mỗi nguồn khi vào quỹ vận hành đều chia đều 20%/quỹ con. |
| `order_id` | INT | Đơn hàng gốc phát sinh khoản này. |
| `amount` | DECIMAL(15,2) | |
| `created_at` | DATETIME | |

### `order_payments` — breakdown thanh toán 1 đơn (mục 3)

| Cột | Kiểu | Chú thích |
|---|---|---|
| `id` | INT PK AI | |
| `order_id` | INT UNIQUE | |
| `card_amount` | DECIMAL(15,2) DEFAULT 0 | Số tiền trừ từ điểm thẻ tiêu dùng. |
| `tieu_dung_amount` | DECIMAL(15,2) DEFAULT 0 | Trừ từ ví tiêu dùng. |
| `kha_dung_amount` | DECIMAL(15,2) DEFAULT 0 | Trừ từ ví khả dụng (khi ví tiêu dùng hết). |
| `cash_amount` | DECIMAL(15,2) DEFAULT 0 | Tiền mặt/chuyển khoản phần còn thiếu. |
| `commission_base_amount` | DECIMAL(15,2) | Giá trị dùng để tính hoa hồng = amount đơn hàng - card_amount (mục 3 — hoa hồng tính trên giá trị đơn hàng sau khi trừ điểm thẻ tiêu dùng). |
| `created_at` | DATETIME | |

---

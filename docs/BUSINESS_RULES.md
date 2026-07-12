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
| **Ví tái tiêu dùng** (`tai_tieu_dung`) | Thành viên không được dùng, chỉ theo dõi. Tối đa 258,000,000đ, vượt quá không cộng thêm. Khi đạt/vượt 5,000,000đ → tự động trừ đúng 5,000,000đ (giữ lại phần dư nếu có, **không** reset về 0) → tạo 1 giao dịch Rebuy → sinh hoa hồng/thưởng liên quan (xem mục 6 — Giao dịch tái tiêu dùng tự động) → tăng số lần tái tiêu dùng (`rebuy_count`). Nếu phần dư sau khi trừ vẫn còn ≥5,000,000đ → tiếp tục tạo thêm giao dịch Rebuy khác, lặp lại đến khi dư <5,000,000đ. (cập nhật 2026-07-11) |
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

## Quy tắc thanh toán đơn hàng (theo thứ tự ưu tiên, đã code — cập nhật 2026-07-11)

Khách tự **tích chọn nguồn muốn dùng** bằng checkbox ngay trên trang giỏ hàng (`?m=basket&f=view_basket`,
`theme/default/templates/basket_list.tpl`) trước khi đặt hàng — không bắt buộc dùng hết. Trong các nguồn đã
chọn, hệ thống vẫn áp dụng đúng thứ tự ưu tiên sau:

**Sản phẩm chấp nhận nguồn nào** (bổ sung 2026-07-11): mỗi sản phẩm (`sys_product`) có 3 cờ riêng
`accept_card_payment` / `accept_tieu_dung_payment` / `accept_kha_dung_payment` (mặc định = 1, admin tự tắt
trong form Thêm/Sửa sản phẩm `?m=product` nếu muốn chặn). Chuyển khoản/tiền mặt **luôn luôn** được chấp
nhận, không cấu hình tắt được (phương án dự phòng cuối cùng đảm bảo khách luôn đặt được đơn). Giỏ hàng
nhiều sản phẩm: 1 nguồn chỉ **hiện cho khách chọn** nếu **TẤT CẢ** sản phẩm trong giỏ đều chấp nhận nguồn
đó (lấy giao — intersection, không tính riêng theo từng dòng sản phẩm). Server luôn tính lại giao này khi
tạo đơn (không tin lựa chọn checkbox gửi từ client) — xem `getAcceptedPaymentSources()` trong
`modules/basket/action.php`, dùng chung cho cả trang giỏ hàng (ẩn/hiện checkbox) và `modules/basket/order.php`
(chặn nguồn không được phép trước khi trừ tiền).

1. Điểm thẻ tiêu dùng — tối đa `card_payment_percent`% giá trị đơn (admin cấu hình tại trang admin
   `?m=config`, mục 11, mặc định 100% nếu chưa cấu hình).
2. Phần còn lại → trừ vào ví tiêu dùng.
3. Nếu ví tiêu dùng hết điểm → phần còn thiếu trừ tiếp vào ví khả dụng.
4. Nếu cả 3 nguồn trên vẫn chưa đủ (hoặc khách không tích chọn nguồn nào) → phần còn lại thanh toán bằng
   chuyển khoản — khách quét mã VietQR hiển thị đúng số tiền còn thiếu (cập nhật động theo lựa chọn), upload
   ảnh chứng từ chuyển khoản như luồng hiện có (không đổi).

**Trừ ngay lúc khách đặt đơn** (trước khi admin duyệt, trong cùng 1 transaction với việc tạo đơn — mục
8.2), ghi breakdown vào `order_payments` (mục 11). Nếu admin **từ chối** đơn sau đó → hoàn lại đúng số điểm
thẻ + ví đã trừ (không hoàn `cash_amount` vì không qua ví hệ thống), giống cơ chế hoàn tiền khi từ chối rút
tiền (mục 7). Nếu đơn được **duyệt** → không hoàn, giữ nguyên đã trừ.

Không có luồng chặn nếu số dư không đủ — cứ trừ được bao nhiêu hay bấy nhiêu, phần thiếu luôn rơi xuống
chuyển khoản, không báo lỗi/chặn đặt hàng.

**Hoa hồng tính trên "quỹ chia hoa hồng"** = tổng "hoa hồng sản phẩm" từng dòng trừ đi điểm thẻ đã dùng
(mục 3 — Quỹ công ty / Quỹ chia hoa hồng, không phải trừ trên giá trị đơn hàng gốc).

Khi kích hoạt gói 5 triệu lần đầu (xem bên dưới), thành viên được cộng 5,000,000 điểm thẻ tiêu dùng.

Code: `modules/basket/order.php` (trừ tiền lúc đặt đơn), `refundOrderPaymentIfAny()` trong
`admin80/include/order_commission.php` (hoàn tiền khi từ chối), `debitConsumptionCardUpTo()` /
`debitWalletUpTo()` (trừ tối đa theo số dư, không chặn nếu thiếu). Cấu hình `card_payment_percent` qua
`admin80/modules/config/action.php` + `admin80/theme/default/templates/config.tpl`.

## Quy tắc sinh hoa hồng

- Hoa hồng chỉ sinh sau khi đơn được admin duyệt.
- Không sinh hoa hồng khi đơn bị huỷ, từ chối.
- Một đơn chỉ được sinh hoa hồng một lần (chống lặp — xem mục 8).

## Quỹ công ty / Quỹ chia hoa hồng / Quỹ vận hành

(cập nhật 2026-07-11: đổi cách tính "quỹ chia hoa hồng" — không còn cố định 60% giá trị đơn hàng cho mọi
đơn. Đã code — `calculateCommissionFund()` trong `admin80/include/order_commission.php`.)

Mỗi sản phẩm (`sys_product`) có 1 cột **"hoa hồng sản phẩm"** (`commission_amount`) — số tiền VND cố định
do admin tự nhập tay cho từng sản phẩm (không tự tính theo % giá bán). Sản phẩm chưa được admin nhập mặc
định = 0, không đóng góp vào quỹ chia hoa hồng.

Mỗi đơn hàng được duyệt:

- **Quỹ chia hoa hồng** = tổng ("hoa hồng sản phẩm" × số lượng) của từng dòng sản phẩm trong đơn, **trừ đi**
  số tiền đã thanh toán bằng điểm thẻ tiêu dùng cho đơn đó (`order_payments.card_amount` — cột này hiện
  luôn = 0 vì luồng trừ điểm thẻ lúc tạo đơn chưa code, xem mục "Quy tắc thanh toán đơn hàng" phía trên;
  công thức đã sẵn sàng, sẽ tự động có hiệu lực khi luồng đó được triển khai).
- **Quỹ công ty** = giá trị đơn hàng − quỹ chia hoa hồng (tính trên số tiền **trước** khi trừ điểm thẻ —
  điểm thẻ chỉ làm giảm quỹ chia hoa hồng, không ảnh hưởng quỹ công ty). Không tự động 40% cố định nữa, tỉ
  lệ % thực tế tùy admin đặt "hoa hồng sản phẩm" bao nhiêu cho từng sản phẩm. Quỹ này chỉ mang tính khái
  niệm, không lưu/track ở đâu trong hệ thống (không có nghiệp vụ nào dùng tới).
- Ví dụ: đơn 1,000,000đ, tổng "hoa hồng sản phẩm" các dòng = 600,000đ, dùng 100,000đ điểm thẻ thanh toán →
  quỹ chia hoa hồng = 600,000 − 100,000 = 500,000đ; quỹ công ty vẫn = 1,000,000 − 600,000 = 400,000đ (không
  bị trừ điểm thẻ).
- Ví dụ combo kích hoạt: giá bán 5,000,000đ, admin đặt "hoa hồng sản phẩm" = 3,000,000đ (giữ đúng bằng công
  thức 60% cũ) → quỹ chia hoa hồng = 3,000,000đ (chưa dùng điểm thẻ), kết quả giống hệt công thức cũ.

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

(cập nhật 2026-07-10: đã code — `creditOperatingFund()` trong `admin80/include/order_commission.php`, ghi vào bảng `admin_fund_transactions` (mục 11.2), hiển thị tại trang admin `?m=quyhoahong`.)

## Kích hoạt gói 5 triệu (`business_active`)

(cập nhật 2026-07-10: đổi điều kiện kích hoạt từ "tổng đơn ≥ 5.000.000đ" sang "đơn có mua đúng sản phẩm combo kích hoạt")

- Admin đánh dấu sản phẩm nào là **"combo kích hoạt"** bằng cờ `sys_product.is_activation_combo` — tích checkbox "Combo kích hoạt" ngay trong form Thêm/Sửa sản phẩm (`?m=product`).
- Khi 1 đơn hàng được admin duyệt, nếu đơn đó **có chứa ít nhất 1 sản phẩm** được đánh dấu combo kích hoạt (dù giỏ hàng có kèm sản phẩm khác không phải combo) → set `user.business_active = 1` cho người mua.
- **Không còn tính theo tổng tiền đơn hàng** — 1 đơn hàng nhiều sản phẩm lẻ cộng dồn đủ 5 triệu nhưng không có sản phẩm combo kích hoạt thì **không** kích hoạt.
- Chỉ set **một lần duy nhất**: nếu đã = 1 thì bỏ qua, không set lại.
- Không có luồng hạ `business_active` về 0 khi đơn bị hoàn/huỷ sau đó (đơn chỉ được duyệt sau khi đã nhận thanh toán, coi như chắc chắn thành công).

---

# 4. Hoa hồng sơ đồ trực tiếp (F1 - F8)

(cập nhật 2026-07-10: bỏ tầng F9 — trước đó tài liệu/code tính 9 tầng F1-F9, nay chốt lại đúng 8 tầng F1-F8 để khớp tổng tỉ lệ 30%)

(cập nhật 2026-07-11: hoa hồng cây lấp tầng ở mục 6 đổi sang tỉ lệ đồng đều 3%/tầng — **không còn cùng cấu trúc** với hoa hồng sơ đồ trực tiếp ở mục này. 2 loại hoa hồng nay có tỉ lệ khác nhau, xem mục 6.)

## Quy ước F0/F1 và tầng

- **F0** = thành viên hiện tại (người nhận/đang được tính hoa hồng). F0 không tính là 1 tầng.
- **F1** = thành viên do F0 giới thiệu trực tiếp (`user.ref_by` trỏ về F0) → **tầng 1**.
- **F2** = thành viên do F1 giới thiệu trực tiếp → **tầng 2**. Tương tự đến **F8** = **tầng 8**.
- `sys_config.f1` .. `sys_config.f8` = tỉ lệ hoa hồng **F0 được nhận** khi **F1 .. F8 tương ứng** phát sinh đơn hàng (theo chuỗi `ref_by` đi ngược lên). Tầng 1 (F1) **16%**, 7 tầng còn lại (F2..F8) mỗi tầng **2%** — tổng **30%** trên quỹ chia hoa hồng. (Khác tỉ lệ với hoa hồng cây lấp tầng ở mục 6 — xem cập nhật 2026-07-11.)

- Điều kiện: đơn hàng phải được admin duyệt.
- Chia 8 tầng (F1, F2, ... F8) theo người giới thiệu trực tiếp (`user.ref_by`), tỉ lệ mỗi tầng lấy từ `sys_config.f1` .. `sys_config.f8`.
- Tính trên quỹ chia hoa hồng của đơn hàng (mục 3).
- **Luôn `status = released`, cộng ví ngay lập tức** — không phân biệt người nhận đã `business_active`/`commission_active` hay chưa, không bao giờ ở trạng thái pending (khác với hoa hồng cây lấp tầng, xem mục 5).

---

# 5. Quy tắc theo `business_active` / `commission_active`

(cập nhật 2026-07-11: tách riêng `commission_active` khỏi `business_active` — trước đó dùng chung 1 cờ
cho cả "điều kiện tham gia" lẫn "điều kiện pending/release", nay tách thành 2 cờ độc lập để hỗ trợ trường
hợp đặc biệt: admin set tay `business_active = 1` — chưa mua combo thật — trong khi `commission_active`
vẫn = 0. Xem `database/migration_2026-07-11_commission_active.sql`.)

Bình thường khi thành viên mua combo kích hoạt (mục 3), `business_active` và `commission_active` cùng
chuyển sang 1 trong cùng 1 lần duyệt đơn. Chỉ khác nhau khi admin chủ động sửa tay 1 trong 2 cột trực tiếp
trong database.

## `business_active = 0`

- Chưa tham gia gói kích hoạt 5 triệu.
- Không được xếp vào cây lấp tầng.
- Không được xét danh hiệu, không được tái tiêu dùng.
- Vẫn nhận hoa hồng sơ đồ trực tiếp bình thường (mục 4).

## `business_active = 1`

- Được xếp vào cây lấp tầng (tự động thêm vào hàng chờ `spillover_waiting_list` — kể cả khi cột này bị
  admin sửa tay trực tiếp trong database, xem trigger `trg_user_business_active_waitlist`), được xét danh
  hiệu, được tái tiêu dùng.
- Việc có nhận được **tiền/điểm thực tế** của hoa hồng cây lấp tầng + thưởng hệ thống (mục 6) hay không phụ
  thuộc `commission_active` (xem bên dưới), **không** tự động release chỉ vì `business_active = 1`.

## `commission_active = 0`

- Hoa hồng cây lấp tầng + thẻ tiêu dùng tuần hoàn + thưởng điểm thẻ tiêu dùng + thưởng danh hiệu (gọi
  chung **"thưởng hệ thống"**, mục 6) khi phát sinh sẽ bị lưu **pending**, chưa cộng ví — kể cả khi người
  nhận đang `business_active = 1`.

## `commission_active = 1`

- Nhận toàn bộ hoa hồng + thưởng hệ thống.
- Toàn bộ "thưởng hệ thống" đang pending được **release hết 1 lần**, cộng ví.

## Quy tắc pending / release (chỉ áp dụng cho "thưởng hệ thống" — hoa hồng cây lấp tầng, thẻ tiêu dùng tuần hoàn, thưởng điểm thẻ tiêu dùng, thưởng danh hiệu; **không áp dụng cho hoa hồng sơ đồ trực tiếp**, xem mục 4)

- Lúc phát sinh, nếu người nhận `commission_active = 0` → tạo dòng hoa hồng/thưởng với `status = pending`, KHÔNG cộng ví.
- Lúc phát sinh, nếu người nhận `commission_active = 1` → `status = released`, cộng ví ngay.
- Khi người nhận chuyển `commission_active` từ 0 sang 1 (mua combo thật) → release toàn bộ pending đang có, cộng ví hết 1 lần.

## Ví dụ trường hợp đặc biệt (admin sửa tay)

Admin sửa tay `business_active = 1` cho 1 thành viên chưa từng mua combo (`commission_active` vẫn giữ
nguyên = 0, mặc định):

- Thành viên **được** xếp vào cây lấp tầng, xét danh hiệu, tái tiêu dùng bình thường (theo `business_active`).
- Thành viên **vẫn nhận** hoa hồng cây trực tiếp bình thường (mục 4, không phụ thuộc 2 cờ này).
- Hoa hồng cây điều tầng + các thưởng ở mục 6: nếu lúc **được xếp vào cây** đã có sẵn đơn kích hoạt đã duyệt (dù `commission_active = 0`) thì phát sinh **pending**, chưa cộng ví. Nếu lúc xếp vào cây **chưa có đơn kích hoạt nào** (đúng ca này — chưa từng mua combo) thì **chưa phát sinh gì cả** ở bước xếp cây (không có quỹ chia hoa hồng nào để tính) — chỉ được **tính bù** khi thành viên thực sự mua đơn kích hoạt sau đó (cập nhật 2026-07-12, xem cơ chế bù ở mục 6 — "Nguồn quỹ hoa hồng + thưởng cây lấp tầng").
- Khi thành viên đó thực sự mua 1 đơn có combo kích hoạt → `commission_active` chuyển sang 1 → toàn bộ pending được release, cộng ví hết 1 lần (`business_active` đã = 1 từ trước nên không bị set lại, không cộng lại 5tr thẻ tiêu dùng lần 2).

---

# 6. Sơ đồ lấp tầng (Spillover)

## Mô hình cây

Toàn hệ thống là **1 cây chung duy nhất** (không phải mỗi người 1 cây riêng), sơ đồ **1 ra 3**, tối đa **9 tầng**.

## Xếp vị trí

- Khi 1 thành viên (F1) đạt `business_active = 1` → hệ thống tự thêm F1 vào **danh sách chờ xếp tầng**, hiển thị cho người giới thiệu trực tiếp (F0). (cập nhật 2026-07-11: chuyển sang trigger database `trg_user_business_active_waitlist`, chạy bất kể `business_active` được set qua app hay sửa tay trực tiếp trong database — xem mục 5, `database/migration_2026-07-11_commission_active.sql`.)
- Chỉ **người giới thiệu trực tiếp** mới có quyền xếp vị trí cho người mình giới thiệu.
- F0 tự thao tác đặt vị trí trên trang cá nhân của mình, **không qua admin duyệt**.
- (cập nhật 2026-07-12) Admin có công cụ hỗ trợ xếp vị trí **thay** F0 khi F0 nhờ hỗ trợ (`admin80/modules/sodo/xu_ly_xep_tang.php`, `?m=sodo`) — sponsor thật được tra lại từ `spillover_waiting_list` (không tin dữ liệu gửi từ client), rồi tái dùng nguyên hàm `placeSpilloverMember()` nên vẫn giữ đúng ràng buộc "chỉ được xếp trong tầm với của sponsor" như F0 tự thao tác — không phải 1 luồng nghiệp vụ khác, chỉ là admin bấm hộ.
- F1 được đặt vào 1 vị trí trống **bất kỳ trong tầm với của F0** trong cây chung (không bắt buộc phải nằm ngay dưới F0).
- Mỗi thành viên chỉ được xếp vị trí **1 lần duy nhất**.
- Hạng/tầng của 1 thành viên được tính theo nhánh con tính **từ vị trí của chính người đó** trong cây chung.

## Nguồn quỹ hoa hồng + thưởng cây lấp tầng

Dùng chung quỹ chia hoa hồng của đơn hàng kích hoạt gói 5tr (mục 3) làm nền tính, **độc lập** với hoa hồng sơ đồ trực tiếp (không trừ lẫn nhau — xem mục 3). Thời điểm tính: lúc thành viên **được xếp vào cây**, không phải lúc admin duyệt đơn.

(cập nhật 2026-07-12 — bù hoa hồng khi xếp cây trước khi có đơn kích hoạt thật): Nếu lúc xếp vào cây, thành
viên **chưa có đơn kích hoạt nào đã duyệt** (ví dụ admin sửa tay `business_active = 1` trước khi mua combo
thật, mục 5) → `placeSpilloverMember()` **không phát sinh gì cả** ở bước này (không có quỹ chia hoa hồng nào
để tính, kể cả pending). Khi thành viên đó **sau này** thực sự mua 1 đơn có combo kích hoạt và được duyệt →
`processOrderApproval()` tự động gọi thêm `generateBackfillSpilloverCommissionIfEligible()` để **tính bù**
toàn bộ hoa hồng cây lấp tầng + 3 khoản thưởng (thẻ tiêu dùng tuần hoàn, điểm thẻ tiêu dùng, danh hiệu) ngay
tại thời điểm đó, dùng quỹ chia hoa hồng của chính đơn kích hoạt thật này, áp dụng đúng quy tắc pending/release
theo `commission_active` (mục 5) như bình thường. Cột `spillover_tree.commission_order_id`
(`database/migration_2026-07-12_spillover_commission_backfill.sql`) đánh dấu vị trí đã được tính (dù tính
ngay lúc xếp cây hay tính bù sau đó), chống tính 2 lần nếu thành viên mua thêm đơn kích hoạt khác sau này
(mục 8.1). Code: `generateBackfillSpilloverCommissionIfEligible()` trong
`admin80/include/order_commission.php`, gọi từ `processOrderApproval()` ngay sau khi sinh hoa hồng sơ đồ trực
tiếp.

## Hoa hồng cây lấp tầng
tính trên cây lấp tầng (hay điều tầng)
Khi thành viên được xếp vào cây mới chia
Chia 8 tầng (F1..F8), tỉ lệ **đồng đều mỗi tầng 3%** — tổng **24%** trên quỹ chia hoa hồng. (cập nhật 2026-07-11: trước đó tầng 1 16%, tầng 2-8 mỗi tầng 2%, tổng 30% — đã đổi sang đồng đều 3%/tầng, khác cấu trúc với hoa hồng sơ đồ trực tiếp mục 4.) Không có điều kiện ràng buộc số F1 trực tiếp.
Nếu tầng nào không có thành viên thì không chia

## thưởng tiêu dùng tuần hoàn
tính trên cây lấp tầng (hay điều tầng)
Khi thành viên được xếp vào cây mới chia
Trích **16%** quỹ chia hoa hồng (ví dụ quỹ 3,000,000đ → trích 480,000đ) cho khoản này, chia: (cập nhật 2026-07-11: đổi từ 10% lên 16%)

- **70%** (336,000đ) → chia đều 8 tầng, đi lên theo cây lấp tầng bắt đầu từ người vừa xếp. **Điều kiện nhận: ancestor ở tầng đó phải đã đạt ít nhất 1 danh hiệu** (mục này, xác nhận 2026-07-10 — trước đó tài liệu ghi mơ hồ "điều kiện giống thưởng danh hiệu"). Tầng nào ancestor chưa đạt danh hiệu nào thì bỏ qua khoản của tầng đó (giống quy tắc "tầng không có thành viên thì không chia"), không dồn cho tầng khác. Áp dụng chung quy tắc pending/release theo `commission_active` (mục 5, cập nhật 2026-07-11 — trước đó theo `business_active`).
- **30%** (144,000đ) còn lại → cộng vào **quỹ vận hành** (xem mục 3 — tự động chia đều 20%/quỹ cho 5 quỹ con).

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

## Giao dịch tái tiêu dùng tự động (Rebuy)

(bổ sung 2026-07-11, cập nhật 2026-07-11: đã code — `processRebuyIfEligible()`, `executeRebuy()`,
`generateRebuyDirectCommission()`, `generateRebuySpilloverCommission()`, `generateRebuyRankBonus()` trong
`admin80/include/order_commission.php`. Được gọi tự động từ `creditTaiTieuDungCapped()` ngay sau khi cộng ví
tái tiêu dùng — không cần cron/tác vụ riêng, chạy trong transaction đang mở của nghiệp vụ gây ra khoản cộng
ví đó (duyệt đơn / xếp cây lấp tầng / 1 giao dịch Rebuy khác). Xem `database/migration_2026-07-11_rebuy_transactions.sql`.)

### Điều kiện kích hoạt

- Khi ví tái tiêu dùng (`tai_tieu_dung`, mục 2) của 1 thành viên đạt/vượt 5,000,000đ → hệ thống **tự động** thực hiện tái tiêu dùng cho thành viên đó, không cần thao tác, không qua admin duyệt.
- Trừ đúng **5,000,000đ** khỏi ví tái tiêu dùng (giữ lại phần dư nếu có — xem mục 2). Nếu dư sau khi trừ vẫn còn ≥5,000,000đ → tiếp tục tạo thêm giao dịch Rebuy khác, lặp lại đến khi dư <5,000,000đ.
- Mỗi giao dịch Rebuy tăng `rebuy_count` của thành viên thêm 1.

### Quỹ hoa hồng của giao dịch Rebuy

5,000,000đ vừa trừ **chính là quỹ hoa hồng** của giao dịch Rebuy này — **không** qua bước chia 40% quỹ công ty / 60% quỹ chia hoa hồng như đơn hàng thường (mục 3). Toàn bộ 5,000,000đ dùng làm nền tính cho 3 khoản dưới đây.

### Chia quỹ hoa hồng Rebuy — 3 khoản

Dùng chung cây hiện có của chính người vừa đủ 5 triệu, đi ngược lên tầng 1-8 (F1-F8):

1. **Hoa hồng trực tiếp** — theo `user.ref_by` (cùng cấu trúc mục 4): tầng 1 **16%**, tầng 2-8 mỗi tầng **2%** — tổng **30%** quỹ Rebuy. Luôn `status = released`, cộng ví ngay, không phân biệt `business_active`/`commission_active` (giống mục 4).
2. **Hoa hồng điều tầng** — theo vị trí đã xếp sẵn trong `spillover_tree` (cùng cấu trúc mục 6): 8 tầng, tỉ lệ đồng đều mỗi tầng **3%** — tổng **24%** quỹ Rebuy. Áp dụng quy tắc pending/release theo `commission_active` của người nhận (mục 5, cập nhật 2026-07-11 — trước đó theo `business_active`). Tầng nào không có thành viên thì bỏ qua, không dồn cho tầng khác.
3. **Thưởng danh hiệu** — theo bảng danh hiệu (mục 6): Quản lý 3%, Trưởng phòng 3%, Phó giám đốc 2%, Giám đốc 2% quỹ Rebuy, trả cho ancestor đã đạt danh hiệu tương ứng. Áp dụng quy tắc pending/release theo `commission_active` (mục 5, cập nhật 2026-07-11 — trước đó theo `business_active`). Danh hiệu nào chưa ai đạt thì bỏ qua.

Giao dịch Rebuy **không** sinh thêm thưởng tiêu dùng tuần hoàn và thưởng điểm thẻ tiêu dùng (2 khoản này chỉ áp dụng cho đơn kích hoạt gói 5tr, xem phần "thưởng tiêu dùng tuần hoàn" / "thưởng điểm thẻ tiêu dùng" ở trên).

### Phần còn lại → quỹ vận hành

Phần quỹ Rebuy còn dư sau khi trả đủ 3 khoản trên (kể cả phần dư do tầng trống không ai nhận, hoặc chưa ai đạt danh hiệu) → cộng hết vào **quỹ vận hành** (mục 3 — tự động chia đều 20%/quỹ cho 5 quỹ con).

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

## User tự hủy yêu cầu (đã áp dụng — `database/migration_2026-07-11_withdraw_cancel.sql`)

Thành viên có thể tự hủy yêu cầu rút tiền của **chính mình** khi còn đang `pending` (chưa admin xử lý), thao tác trực tiếp tại nút "Hủy" trên hàng tương ứng trong bảng lịch sử rút tiền (`?m=user&f=lich_su_rut_tien`), không đặt nút hủy trong modal tạo yêu cầu vì khó thao tác.

- Chỉ hủy được khi `status = pending`, và chỉ hủy được yêu cầu của chính mình (kiểm tra `user_id`).
- Set `status = cancelled` (khác `rejected` — phân biệt user tự hủy với admin từ chối) + hoàn lại `kha_dung` giống hệt nhánh admin từ chối.
- Hiển thị nhãn **"Đã Huỷ"** (không hiện chữ `cancelled` thô).

Code: `processWithdrawCancel()` trong `admin80/include/order_commission.php`, gọi từ `modules/user/huy_rut_tien.php`.

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
| `business_active` | TINYINT(1) DEFAULT 0 | 1 = đã tham gia gói 5tr, được xếp vào cây lấp tầng/xét danh hiệu/tái tiêu dùng. Chỉ set 1 lần khi có đơn chứa combo kích hoạt được duyệt, không hạ về 0. Có nhận được tiền/điểm thực tế của "thưởng hệ thống" (mục 6) hay không phụ thuộc `commission_active`, xem mục 5. |
| `commission_active` | TINYINT(1) DEFAULT 0 | (đã áp dụng — `database/migration_2026-07-11_commission_active.sql`) 1 = được release toàn bộ "thưởng hệ thống" pending, cộng ví. Bình thường set cùng lúc với `business_active` khi mua combo (mục 3); tách riêng để hỗ trợ ca đặc biệt admin set tay `business_active = 1` nhưng chưa mua combo thật (mục 5). Chỉ set 1 lần, không hạ về 0. |

### `orders` (bổ sung cột)

| Cột | Kiểu | Chú thích |
|---|---|---|
| `is_activation_package` | TINYINT(1) DEFAULT 0 | Đánh dấu đơn là đơn kích hoạt gói 5tr (đơn có chứa sản phẩm combo kích hoạt), dùng để truy vết, không dùng để tính lại nghiệp vụ. |
| `commission_generated` | TINYINT(1) DEFAULT 0 | Chống sinh hoa hồng 2 lần cho cùng 1 đơn (mục 8.1). Set = 1 ngay sau khi sinh hoa hồng thành công. |

### `sys_product` (bổ sung cột — đã áp dụng, xem `database/migration_2026-07-10_activation_combo.sql`)

| Cột | Kiểu | Chú thích |
|---|---|---|
| `is_activation_combo` | TINYINT(1) DEFAULT 0 | Đánh dấu sản phẩm là "combo kích hoạt gói 5tr". Admin tự tick chọn ngay trong form Thêm/Sửa sản phẩm (`?m=product`). Đơn hàng chứa ít nhất 1 sản phẩm này sẽ kích hoạt `business_active` cho người mua (mục 3). |
| `commission_amount` | DECIMAL(15,2) DEFAULT 0 | (đã áp dụng — `database/migration_2026-07-11_product_commission_amount.sql`) "Hoa hồng sản phẩm" — số tiền VND cố định admin tự nhập ngay trong form Thêm/Sửa sản phẩm, dùng làm nền tính "quỹ chia hoa hồng" (mục 3) thay cho công thức 60% giá bán cũ. Chưa nhập = 0, sản phẩm đó không đóng góp vào quỹ chia hoa hồng. |
| `accept_card_payment` / `accept_tieu_dung_payment` / `accept_kha_dung_payment` | TINYINT(1) DEFAULT 1 | (đã áp dụng — `database/migration_2026-07-11_product_payment_sources.sql`) Sản phẩm có chấp nhận thanh toán bằng điểm thẻ tiêu dùng / ví tiêu dùng / ví khả dụng hay không, admin tự tắt trong form Thêm/Sửa sản phẩm. Mặc định 1 (chấp nhận) cho mọi sản phẩm. Chuyển khoản/tiền mặt luôn được chấp nhận, không có cột riêng (mục 3). |

### `commissions` (bổ sung cột)

| Cột | Kiểu | Chú thích |
|---|---|---|
| `type` | ENUM('direct','spillover','card','rank_bonus') DEFAULT 'direct' | Phân biệt: direct = hoa hồng sơ đồ trực tiếp (F1-F8), spillover = hoa hồng cây lấp tầng, card = thẻ tiêu dùng tuần hoàn, rank_bonus = thưởng danh hiệu. |
| `status` | ENUM('pending','released') DEFAULT 'released' | pending = người nhận chưa commission_active, chưa cộng ví (mục 5, cập nhật 2026-07-11 — trước đó theo business_active). released = đã cộng ví tổng. |
| `released_at` | DATETIME NULL | Thời điểm release pending commission khi commission_active chuyển sang 1. |
| `rebuy_id` | INT NULL (đã áp dụng — `database/migration_2026-07-11_rebuy_transactions.sql`) | FK `rebuy_transactions.id`. NULL nếu dòng hoa hồng sinh từ đơn hàng (`order_id` có giá trị); có giá trị nếu sinh từ giao dịch Rebuy (`order_id` NULL) — xem mục 6, Giao dịch tái tiêu dùng tự động. |

### `sys_config` (bổ sung dữ liệu — đã thêm f4-f8 trực tiếp trên DB, không còn f9 — xem mục 4)

Cần thêm các key cấu hình còn thiếu để không hard-code trong code:

| name | Ý nghĩa |
|---|---|
| `spillover_f1`..`spillover_f8` | Tỉ lệ % hoa hồng cây lấp tầng mỗi tầng (tài liệu mục 6: đồng đều 3%/tầng, tổng 24% — cập nhật 2026-07-11, đã áp dụng trên DB). |
| `card_recurring_percent` | % trích từ quỹ hoa hồng vào thẻ tiêu dùng tuần hoàn (tài liệu mục 6: 16%, cập nhật 2026-07-11 — trước đó 10%). |
| `card_payment_percent` | (đã áp dụng — cập nhật 2026-07-11) % thanh toán đơn hàng tối đa bằng điểm thẻ tiêu dùng, admin tự đặt tại trang admin `?m=config`. Mặc định 100% nếu admin chưa cấu hình (chưa có dòng trong `sys_config`). |

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

### `recurring_consumption_bonuses` — thưởng tiêu dùng tuần hoàn (mục 6, đã áp dụng — `database/migration_2026-07-10_recurring_consumption_bonus.sql`)

| Cột | Kiểu | Chú thích |
|---|---|---|
| `id` | INT PK AI | |
| `order_id` | INT | Đơn kích hoạt gói 5tr làm nền tính quỹ. |
| `user_id` | INT | Người nhận (ancestor trong cây lấp tầng, đã đạt ít nhất 1 danh hiệu). |
| `level` | INT | Tầng (1-8). |
| `amount` | DECIMAL(15,2) | |
| `status` | ENUM('pending','released') | Theo `commission_active` của người nhận (mục 5, cập nhật 2026-07-11 — trước đó theo `business_active`). |
| `released_at` | DATETIME NULL | |
| `created_at` | DATETIME | |

Khác với `commissions`/`card_point_bonuses`: khi released, cộng thẳng vào `user_wallets.tieu_dung` (không qua quy tắc chia ví tổng 60/20/10/10 ở mục 2).

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

### `spillover_waiting_list` — danh sách chờ xếp tầng (mục 6, cập nhật 2026-07-11: insert do trigger `trg_user_business_active_waitlist` đảm nhận — xem `database/migration_2026-07-11_commission_active.sql`, không còn insert trực tiếp từ code PHP)

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
| `source` | ENUM('direct_commission','card_bonus','rebuy') | direct_commission = 10% từ quỹ chia hoa hồng (mục 3); card_bonus = 30% còn lại của thưởng tiêu dùng tuần hoàn (mục 6); rebuy = phần còn lại của quỹ hoa hồng Rebuy sau khi chia 3 khoản (mục 6, cập nhật 2026-07-11 — đã áp dụng). Mỗi nguồn khi vào quỹ vận hành đều chia đều 20%/quỹ con. |
| `order_id` | INT NULL | Đơn hàng gốc phát sinh khoản này. NULL nếu `source = 'rebuy'`. |
| `rebuy_id` | INT NULL (đã áp dụng — `database/migration_2026-07-11_rebuy_transactions.sql`) | FK `rebuy_transactions.id`, có giá trị nếu `source = 'rebuy'`. |
| `amount` | DECIMAL(15,2) | |
| `created_at` | DATETIME | |

### `rebuy_transactions` — giao dịch tái tiêu dùng tự động (mục 2, mục 6 — đã áp dụng, `database/migration_2026-07-11_rebuy_transactions.sql`)

| Cột | Kiểu | Chú thích |
|---|---|---|
| `id` | INT PK AI | |
| `user_id` | INT | Thành viên vừa đủ 5,000,000đ trong ví tái tiêu dùng. |
| `amount` | DECIMAL(15,2) | Luôn 5,000,000 — quỹ hoa hồng của giao dịch Rebuy này. |
| `created_at` | DATETIME | |

### `order_payments` — breakdown thanh toán 1 đơn (mục 3, đã áp dụng — `database/migration_2026-07-09_wallet_mlm_schema.sql` + `database/migration_2026-07-11_order_payment_flow.sql`)

(cập nhật 2026-07-11: đã code luồng ghi — `modules/basket/order.php` ghi 1 dòng ngay lúc tạo đơn, trong
cùng transaction với INSERT `orders`/`order_items` và các lệnh trừ điểm thẻ/ví. `card_amount` được
`calculateCommissionFund()` trong `admin80/include/order_commission.php` đọc lại để trừ khỏi quỹ chia hoa
hồng, mục 3.)

| Cột | Kiểu | Chú thích |
|---|---|---|
| `id` | INT PK AI | |
| `order_id` | INT UNIQUE | |
| `card_amount` | DECIMAL(15,2) DEFAULT 0 | Số tiền trừ từ điểm thẻ tiêu dùng (tối đa `card_payment_percent`% giá trị đơn, mục 3). Được `calculateCommissionFund()` đọc lại để trừ khỏi quỹ chia hoa hồng. |
| `tieu_dung_amount` | DECIMAL(15,2) DEFAULT 0 | Trừ từ ví tiêu dùng. Chỉ dùng để hoàn tiền khi đơn bị từ chối (`refundOrderPaymentIfAny()`) — **không** trừ khỏi quỹ chia hoa hồng (xác nhận 2026-07-11: quỹ chia hoa hồng chỉ trừ `card_amount`). |
| `kha_dung_amount` | DECIMAL(15,2) DEFAULT 0 | Trừ từ ví khả dụng (khi ví tiêu dùng hết/khách không chọn dùng). Chỉ dùng để hoàn tiền khi từ chối, tương tự `tieu_dung_amount`. |
| `cash_amount` | DECIMAL(15,2) DEFAULT 0 | Phần còn lại thanh toán chuyển khoản (khách quét mã VietQR + upload ảnh chứng từ, luồng có sẵn). Không hoàn khi từ chối vì không qua ví hệ thống. |
| `commission_base_amount` | DECIMAL(15,2) | Chỉ mang tính ghi nhận/audit = giá trị đơn hàng − `card_amount`. **Không** phải nền tính hoa hồng thực tế (nền tính hoa hồng dùng `calculateCommissionFund()` — tổng "hoa hồng sản phẩm" từng dòng trừ `card_amount`, xem mục 3). |
| `refunded_at` | DATETIME NULL (đã áp dụng — `database/migration_2026-07-11_order_payment_flow.sql`) | Thời điểm hoàn tiền khi đơn bị admin từ chối. NULL = chưa hoàn (hoặc đơn đã duyệt, không cần hoàn). Chống hoàn tiền 2 lần (mục 8.1). |
| `created_at` | DATETIME | |

---

# 12. Thông báo Telegram

(bổ sung 2026-07-11 — đã code, đã test gửi thành công)

Bot Telegram (cùng 1 bot) báo cho admin theo **2 nhóm chat riêng** tùy loại sự kiện:

**Nhóm đơn hàng** ("Đơn hàng Thuận Phát"):

1. **Đơn hàng mới** — ngay khi khách đặt đơn (trước khi admin duyệt), để admin biết vào xử lý.
2. **Đơn hàng được duyệt** — ngay sau khi admin duyệt đơn thành công (sau khi hoa hồng đã sinh xong).
3. **Đơn hàng bị từ chối** — ngay sau khi admin từ chối đơn (không sinh hoa hồng, không đụng ví).

**Nhóm rút tiền** ("Đơn Rút Tiền Thuận Phát"):

4. **Yêu cầu rút tiền mới** — ngay khi thành viên tạo yêu cầu rút tiền.
5. **Yêu cầu rút tiền bị hủy** — ngay khi thành viên tự hủy yêu cầu đang pending (mục 7).
6. **Admin duyệt/từ chối yêu cầu rút tiền** — ngay sau khi admin xử lý xong (cả 2 trường hợp duyệt và từ chối).

Tất cả tin nhắn liên quan thành viên (đơn hàng, rút tiền) đều kèm **tên khách hàng/thành viên**, không chỉ ID.

## Cấu hình

- Bot token dùng chung 1 bot, chat_id **fix cứng trong code** theo từng nhóm sự kiện (không qua `sys_config`) — xem hằng số `TELEGRAM_BOT_TOKEN`, `TELEGRAM_CHAT_ID_ORDER` (nhóm đơn hàng), `TELEGRAM_CHAT_ID_WITHDRAW` (nhóm rút tiền) đầu file `admin80/include/order_commission.php`.
- Gửi qua Telegram Bot API `sendMessage` (HTTPS, `curl`), `parse_mode=HTML`.
- **Best-effort**: nếu Telegram lỗi/mạng chậm chỉ ghi `error_log`, không rollback giao dịch, không chặn luồng nghiệp vụ chính (đơn hàng/ví/rút tiền vẫn xử lý bình thường dù thông báo gửi thất bại).

## Code

- Hàm dùng chung `sendTelegramNotify($message, $chatId)` trong `admin80/include/order_commission.php` (file này vốn đã được `require_once` từ cả phía storefront lẫn admin nên là nơi dùng chung phù hợp, không tạo thêm file mới). `$chatId` truyền `TELEGRAM_CHAT_ID_ORDER` hoặc `TELEGRAM_CHAT_ID_WITHDRAW` tùy sự kiện.
- Gọi từ:
  - `modules/basket/order.php` — ngay sau khi tạo đơn hàng (INSERT `orders` + `order_items`) — sự kiện 1.
  - `processOrderApproval()` — ngay sau `commit()` khi admin duyệt đơn — sự kiện 2.
  - `processOrderRejection()` — khi admin từ chối đơn (không có transaction/hoa hồng nên không cần commit riêng) — sự kiện 3. Gọi từ `admin80/modules/order/index.php` và `approve.php` (2 trang admin duyệt/từ chối đơn, xử lý y hệt nhau — `admin80/modules/order/rejected.php` có cùng handler nhưng nút duyệt/từ chối đã bị comment trong template nên không có hiệu lực trên UI, không cần sửa).
  - `modules/user/xu_ly_rut_tien.php` — ngay sau khi tạo yêu cầu rút tiền thành công — sự kiện 4.
  - `processWithdrawCancel()` — ngay sau `commit()` khi thành viên tự hủy — sự kiện 5.
  - `processWithdrawDecision()` — ngay sau `commit()` khi admin duyệt/từ chối — sự kiện 6. Hàm này được gọi từ 4 file admin (`admin80/modules/withdraw/index.php`, `approve.php`, `index_.php`, `admin80/modules/user/withdraw.php`, mục 7) nên chỉ cần hook 1 chỗ trong hàm dùng chung là bao phủ cả 4.

---

# CLAUDE.md

# Purpose

Đây là dự án PHP
luôn gọi Sếp, xưng em
Mục tiêu:

- Giữ ổn định hệ thống.
- Chỉ sửa đúng yêu cầu.
- Không refactor toàn bộ nếu chưa được yêu cầu.
- Không đọc file thư viện, ảnh, ignore, cấu hình nếu chưa được yêu cầu, nếu cần thiết phải đọc, sửa thì phải hỏi trước
- chưa rõ nghiệp vụ nào phải hỏi lại rõ, không tự ý quyết định nghiệp vụ

---

# Tech Stack

- PHP 5.x
- Smarty
- ADODB
- MySQL
- Apache
- Bootstrap
- jQuery

---

# Development Principles

- Ưu tiên thay đổi ít nhất.
- Giữ coding style hiện có.
- Không đổi tên database.
- Không đổi API.
- Không đổi public function.

---

# Before Editing

Luôn:

- Đọc module liên quan.
- Tìm nơi function được gọi.
- Kiểm tra database liên quan.
- Kiểm tra transaction.
- Kiểm tra ảnh hưởng tới hoa hồng.
- Kiểm tra ảnh hưởng tới ví.

---

# High Risk Modules

Các module sau cần cẩn thận:

- Order
- Commission
- Wallet
- Member
- Payment

---

# Working Process

Khi nhận yêu cầu:

1. Giải thích logic hiện tại.
2. Phân tích ảnh hưởng.
3. Đề xuất cách sửa.
4. Chỉ sửa sau khi đã hiểu đầy đủ.
5. Kiểm tra lỗi phát sinh.

---

# Response Format

Luôn trả lời:

Current Logic

↓

Problem

↓

Solution

↓

Files Modified

↓

Risk

---

# Documents

Đọc các tài liệu sau trước khi sửa:

docs/DATABASE.md

docs/BUSINESS_RULES.md

docs/FILE_MAP.md

docs/CHANGELOG.md

---

# Never

Không được:

- Refactor toàn project.
- Đổi cấu trúc database.
- Thêm framework.
- Xóa code legacy nếu chưa xác minh.

---

# Important

Nếu nghiệp vụ không rõ:

Hỏi lại.

Không được suy đoán.
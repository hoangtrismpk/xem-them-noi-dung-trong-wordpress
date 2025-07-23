Copy toàn bộ file vô Funtions của Wordpress là xài.

<img width="976" height="587" alt="Screenshot 2025-07-23 173227" src="https://github.com/user-attachments/assets/c8315782-0036-448c-ac3d-b393405767e4" />

Điều chỉnh số dòng giới hạn để rút gọn tại, ví dụ ngắt 3 dòng thì sẽ bắt đầu ẩn các thông số còn lại.
 $visible_limit = 3;

Nhớ chỉnh lại .td-post-content cho phù hợp với theme đang xài. Code này dành cho người xài theme Newpapaer

Nếu nội dung quá dài có thể bị cắt ở cuối thì chỉnh số của đoạn css này lại

.td-post-content.active .hidden-part {
    max-height: 50000px;
}

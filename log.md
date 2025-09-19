# การวิเคราะห์เว็บไซต์ Dedazen Store - ดีด้าเซนต์

## ภาพรวมของเว็บไซต์
เว็บไซต์ Dedazen Store เป็นระบบ e-commerce ที่ขายสินค้าประเภทเกมออนไลน์และบริการดิจิทัล โดยมีระบบสมาชิก ระบบเติมเงิน และระบบสั่งซื้อสินค้า

## เทคโนโลยีที่ใช้
- **Backend:** PHP (PDO), MySQL
- **Frontend:** HTML, CSS, JavaScript, Bootstrap 5, jQuery
- **API Integration:** Payment gateways, game APIs
- **Security:** reCAPTCHA, Session management

## โครงสร้างฐานข้อมูล

### ตาราง Users (users)
- เก็บข้อมูลผู้ใช้
- ฟิลด์สำคัญ: id, username, password (md5), email, point, total, rank, profile

### ตาราง Category (category)
- เก็บหมวดหมู่สินค้า
- ฟิลด์สำคัญ: c_id, c_name, des, img

### ตาราง Product (box_product)
- เก็บข้อมูลสินค้า
- ฟิลด์สำคัญ: id, name, price, price_vip, des, img, type, percent, salt_prize, c_type

### ตาราง Stock (box_stock)
- เก็บสต็อกสินค้า
- ฟิลด์สำคัญ: id, username, password, p_id

### ตาราง Order History (boxlog)
- เก็บประวัติการสั่งซื้อ
- ฟิลด์สำคัญ: id, date, username, category, price, prize_name, rand, uid, uimg

### ตาราง Settings (setting)
- เก็บการตั้งค่าเว็บไซต์
- ฟิลด์สำคัญ: name, des, logo, bg, main_color, sec_color, wallet, discord, fb, lined

### ตาราง Topup History (topup_his)
- เก็บประวัติการเติมเงิน
- ฟิลด์สำคัญ: id, link, amount, date, uid, uname, uimg

## ฟังก์ชันการทำงานหลัก

### 1. ระบบสมาชิก
- **สมัครสมาชิก:** หน้า register.php ใช้ระบบ register.php และ a_func.php
- **เข้าสู่ระบบ:** หน้า login.php ใช้ระบบ login.php และ a_func.php
- **โปรไฟล์:** หน้า profile.php สามารถเปลี่ยนรหัสผ่านและรูปโปรไฟล์ได้

### 2. ระบบสินค้า
- **หน้าร้านค้า:** หน้า shop.php แสดงสินค้าตามหมวดหมู่
- **หน้าสั่งซื้อสินค้า:** หน้า buy.php แสดงรายละเอียดสินค้า
- **ระบบสั่งซื้อ:** buybox.php จัดการการสั่งซื้อและลดเครดิตผู้ใช้

### 3. ระบบเติมเงิน
- **หน้าเติมเงิน:** หน้า topup.php แสดงช่องทางการเติมเงิน
- **Truemoney Wallet:** ระบบเติมเงินผ่านซองอั่งเปา
- **QR Payment:** ระบบจ่ายผ่าน QR Code
- **Gift Code:** ระบบแลกรหัสของขวัญ

### 4. ระบบจัดการด้านหลัง (Admin Panel)
- สำหรับผู้ใช้ที่มี rank = 1
- จัดการสินค้า หมวดหมู่ คำสั่งซื้อ ยอดเติมเงิน ฯลฯ

## ฟังก์ชันพิเศษ

### ระบบวงล้อเสี่ยงโชค (Games)
- หน้า games.php สำหรับเล่นวงล้อเสี่ยงโชค
- ระบบรางวัลแบบสุ่ม

### ระบบสุ่มไอดีเกม
- ระบบสุ่มไอดีเกมออนไลน์

### ระบบซื้อบัตรเงินสด
- หน้า cashcard.php สำหรับซื้อบัตรเงินสด

### ระบบเติมเงินมือถือ/แพคเกจเน็ต
- หน้า phoneTopup.php สำหรับเติมเงินมือถือและแพคเกจเน็ต

## การรักษาความปลอดภัย

1. **Session Management:** ใช้ session เพื่อตรวจสอบการเข้าสู่ระบบ
2. **Password Hashing:** ใช้ MD5 สำหรับรหัสผ่าน (ควรอัปเกรดเป็น bcrypt หรือ Argon2)
3. **reCAPTCHA:** ใช้ในการสมัครสมาชิกเพื่อป้องกัน spam
4. **Input Validation:** มีการตรวจสอบข้อมูลที่ผู้ใช้ป้อน
5. **Prepared Statements:** ใช้ PDO prepared statements เพื่อป้องกัน SQL Injection

## ข้อควรระวัง

1. **Password Security:** ระบบใช้ MD5 ซึ่งไม่ปลอดภัยเพียงพอ ควรเปลี่ยนเป็น bcrypt หรือ Argon2
2. **SQL Error Handling:** ในบางไฟล์ยังแสดง error ของ SQL ซึ่งอาจถูกใช้ในการโจมตี
3. **Session Security:** ควรมีการตรวจสอบ session timeout และ regenerate session ID

## ข้อเสนอแนะในการปรับปรุง

1. อัปเกรดระบบ password hashing
2. เพิ่มระบบ two-factor authentication
3. ปรับปรุง UI/UX ให้ทันสมัยขึ้น
4. เพิ่มระบบแจ้งเตือนผ่าน email หรือ Line
5. เพิ่มระบบจัดการ inventory ที่ซับซ้อนขึ้น
6. เพิ่มระบบ coupon/discount
7. เพิ่มระบบ affiliate/referral

## สรุป
เว็บไซต์ Dedazen Store เป็นระบบที่ค่อนข้างสมบูรณ์สำหรับการขายสินค้าดิจิทัล มีระบบสมาชิก ระบบเติมเงิน และระบบสั่งซื้อที่ทำงานได้ดี แต่มีบางจุดที่ควรปรับปรุงด้านความปลอดภัยและประสบการณ์ผู้ใช้
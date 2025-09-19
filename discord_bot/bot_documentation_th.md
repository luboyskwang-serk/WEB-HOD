# เอกสารคู่มือ Discord Bot สำหรับ Dedazen Store

## ภาพรวมระบบ

Discord Bot สำหรับ Dedazen Store เป็นระบบอัตโนมัติที่ช่วยให้ผู้ดูแลระบบสามารถจัดการและติดตามเว็บไซต์ผ่าน Discord ได้อย่างสะดวกและมีประสิทธิภาพ

## คุณสมบัติหลัก

### 1. การแจ้งเตือนอัตโนมัติ
- แจ้งเตือนเมื่อมีการสั่งซื้อใหม่
- แจ้งเตือนเมื่อมีการเติมเงิน
- แจ้งเตือนเมื่อสต็อกสินค้าต่ำ
- แจ้งเตือนเมื่อมีกิจกรรมความปลอดภัย

### 2. การจัดการระบบผ่าน Discord
- ดูสถิติเว็บไซต์แบบเรียลไทม์
- จัดการผู้ใช้ (แบน/ปลดแบน/ดูข้อมูล)
- จัดการสินค้า (เพิ่ม/ลบ/แก้ไข/ดูสต็อก)
- ดูรายงานการเงินและคำสั่งซื้อ

### 3. รายงานและ Analytics
- รายงานรายวัน/สัปดาห์/เดือน
- สถิติผู้ใช้ใหม่
- สถิติการขาย
- สถิติการเติมเงิน

## การติดตั้งและการตั้งค่า

### ขั้นตอนที่ 1: สร้าง Discord Application

1. เยี่ยมชม [Discord Developer Portal](https://discord.com/developers/applications)
2. คลิก "New Application"
3. ตั้งชื่อแอปพลิเคชัน (เช่น "Dedazen Store Bot")
4. ไปที่แท็บ "Bot" 
5. คลิก "Add Bot"
6. เปิดใช้งาน Privileged Gateway Intents:
   - Presence Intent
   - Server Members Intent  
   - Message Content Intent

### ขั้นตอนที่ 2: ตั้งค่า Permissions

1. ไปที่แท็บ "OAuth2" -> "URL Generator"
2. เลือก Scopes:
   - `bot`
   - `applications.commands`
3. เลือก Permissions:
   - View Channels
   - Send Messages
   - Embed Links
   - Attach Files
   - Read Message History
   - Mention Everyone
   - Use Slash Commands
4. คัดลอก URL ที่สร้างขึ้นมา
5. เปิด URL ในเบราว์เซอร์เพื่อเชิญ Bot เข้าสู่เซิร์ฟเวอร์ของคุณ

### ขั้นตอนที่ 3: ตั้งค่า API

1. สร้าง API Token ในระบบ Dedazen Store
2. ตั้งค่า Webhook URL สำหรับการแจ้งเตือน
3. กำหนดค่าการเชื่อมต่อฐานข้อมูล (หากจำเป็น)

## โครงสร้างไฟล์ของ Bot

```
discord_bot/
├── src/
│   ├── commands/           # โฟลเดอร์คำสั่ง
│   │   ├── admin/         # คำสั่งสำหรับผู้ดูแล
│   │   │   ├── stats.js    # สถิติเว็บไซต์
│   │   │   ├── users.js    # จัดการผู้ใช้
│   │   │   ├── products.js # จัดการสินค้า
│   │   │   └── orders.js   # จัดการคำสั่งซื้อ
│   │   ├── user/          # คำสั่งสำหรับผู้ใช้ทั่วไป
│   │   │   ├── help.js     # คำสั่งช่วยเหลือ
│   │   │   ├── ping.js     # ทดสอบการเชื่อมต่อ
│   │   │   └── info.js     # ข้อมูลเว็บไซต์
│   │   └── index.js       # ไฟล์โหลดคำสั่ง
│   ├── events/            # โฟลเดอร์ Event Handlers
│   │   ├── ready.js       # Event เมื่อ Bot พร้อมใช้งาน
│   │   └── interactionCreate.js # Event เมื่อผู้ใช้ใช้คำสั่ง
│   ├── utils/              # ฟังก์ชันช่วยเหลือ
│   │   ├── database.js     # การเชื่อมต่อฐานข้อมูล
│   │   ├── logger.js       # การบันทึก Logs
│   │   └── api.js          # การเชื่อมต่อ API
│   └── index.js            # ไฟล์หลักของ Bot
├── config/
│   └── config.json         # ไฟล์การตั้งค่า
├── package.json            # ข้อมูล Package
└── README.md              # เอกสารคู่มือ
```

## คำสั่งที่รองรับ

### คำสั่งสำหรับผู้ดูแลระบบ (/admin)

#### /stats
แสดงสถิติเว็บไซต์แบบเรียลไทม์
```
/stats [period: วัน|สัปดาห์|เดือน]
```

#### /users
จัดการผู้ใช้ในระบบ
```
/users list [page: หน้าที่ต้องการ]
/users info [user_id: ไอดีผู้ใช้]
/users ban [user_id: ไอดีผู้ใช้] [reason: เหตุผล]
/users unban [user_id: ไอดีผู้ใช้]
```

#### /products
จัดการสินค้าในระบบ
```
/products list [category: หมวดหมู่]
/products info [product_id: ไอดีสินค้า]
/products add [name: ชื่อสินค้า] [price: ราคา] [category: หมวดหมู่]
/products remove [product_id: ไอดีสินค้า]
/products stock [product_id: ไอดีสินค้า] [quantity: จำนวน]
```

#### /orders
ดูคำสั่งซื้อล่าสุด
```
/orders latest [limit: จำนวนสูงสุด]
/orders user [user_id: ไอดีผู้ใช้]
/orders search [keyword: คำค้นหา]
```

#### /topups
ดูการเติมเงินล่าสุด
```
/topups latest [limit: จำนวนสูงสุด]
/topups user [user_id: ไอดีผู้ใช้]
```

#### /inventory
จัดการสต็อกสินค้า
```
/inventory low [threshold: จำนวนขั้นต่ำ]
/inventory update [product_id: ไอดีสินค้า] [quantity: จำนวน]
```

#### /reports
ดูรายงานต่างๆ
```
/reports daily
/reports weekly
/reports monthly
/reports custom [start_date: วันที่เริ่มต้น] [end_date: วันที่สิ้นสุด]
```

#### /settings
ตั้งค่า Bot
```
/settings notifications [type: ประเภท] [enabled: เปิด/ปิด]
/settings status [message: ข้อความสถานะ]
```

### คำสั่งสำหรับผู้ใช้ทั่วไป (/user)

#### /help
แสดงคำสั่งที่ใช้งานได้
```
/help
```

#### /ping
ทดสอบการเชื่อมต่อ
```
/ping
```

#### /info
แสดงข้อมูลเว็บไซต์
```
/info
```

## การตั้งค่าไฟล์ config.json

```json
{
  "discord": {
    "token": "YOUR_DISCORD_BOT_TOKEN",
    "clientId": "YOUR_APPLICATION_CLIENT_ID",
    "guildId": "YOUR_SERVER_ID"
  },
  "api": {
    "baseUrl": "https://yourwebsite.com/api/bot",
    "token": "YOUR_API_AUTHENTICATION_TOKEN"
  },
  "database": {
    "host": "localhost",
    "user": "your_database_username",
    "password": "your_database_password",
    "database": "your_database_name"
  },
  "notifications": {
    "newOrder": true,
    "newTopup": true,
    "lowStock": true,
    "securityAlert": true,
    "newUser": false
  },
  "settings": {
    "timezone": "Asia/Bangkok",
    "locale": "th-TH",
    "currency": "THB"
  }
}
```

## การพัฒนาเพิ่มเติม

### การเพิ่มคำสั่งใหม่

1. สร้างไฟล์คำสั่งใหม่ใน `src/commands/`
2. ลงทะเบียนคำสั่งใน `src/commands/index.js`
3. เพิ่มการตรวจสอบสิทธิ์ (ถ้าจำเป็น)
4. ทดสอบคำสั่งใหม่
5. รีสตาร์ท Bot

### การเพิ่ม Event Handler

1. สร้างไฟล์ event ใน `src/events/`
2. เพิ่มการลงทะเบียน event ใน `src/index.js`
3. ทดสอบการทำงานของ event
4. รีสตาร์ท Bot

## การ Deploy และการจัดการ

### ใช้ PM2 สำหรับ Production

PM2 เป็น Process Manager ที่เหมาะสำหรับการรัน Bot ใน Production

1. ติดตั้ง PM2:
```bash
npm install -g pm2
```

2. รัน Bot ด้วย PM2:
```bash
pm2 start src/index.js --name "dedazen-store-bot"
```

3. ตั้งค่าให้ PM2 รันอัตโนมัติเมื่อเซิร์ฟเวอร์เริ่มต้น:
```bash
pm2 startup
pm2 save
```

4. คำสั่งจัดการ PM2:
```bash
pm2 list              # ดูรายการ Process
pm2 logs              # ดู Logs
pm2 restart <name>     # รีสตาร์ท Process
pm2 stop <name>       # หยุด Process
pm2 delete <name>     # ลบ Process
```

### การอัปเดต Bot

1. ดึงโค้ดเวอร์ชันล่าสุด:
```bash
git pull
```

2. อัปเดต Dependencies:
```bash
npm install
```

3. รีสตาร์ท Bot:
```bash
pm2 restart dedazen-store-bot
```

## การตรวจสอบและ Debug

### ดู Logs

ด้วย PM2:
```bash
pm2 logs dedazen-store-bot
```

ด้วย NPM Script:
```bash
npm run logs
```

### ตรวจสอบสถานะ

```bash
pm2 list
```

### รีสตาร์ท Bot

```bash
pm2 restart dedazen-store-bot
```

## ความปลอดภัย

### แนวทางปฏิบัติที่ดี

1. **ไม่เผยแพร่ Token**: อย่าเผยแพร่ Token ของ Bot ใน Repository สาธารณะ
2. **Environment Variables**: ใช้ Environment Variables สำหรับข้อมูลที่ละเอียดอ่อน
3. **ตรวจสอบสิทธิ์**: ตรวจสอบสิทธิ์การเข้าถึงของแต่ละคำสั่ง
4. **บันทึก Logs**: บันทึก Logs อย่างละเอียดเพื่อการตรวจสอบ
5. **อัปเดต Dependencies**: อัปเดต Dependencies อย่างสม่ำเสมอ

### การจัดการ Token

1. ใช้ Environment Variables:
```bash
DISCORD_BOT_TOKEN=your_token_here
API_AUTH_TOKEN=your_api_token_here
```

2. โหลดจากไฟล์ .env:
```javascript
require('dotenv').config();
const token = process.env.DISCORD_BOT_TOKEN;
```

## การแก้ปัญหาทั่วไป

### ปัญหา: Bot ไม่ออนไลน์

**สาเหตุและวิธีแก้ไข**:
1. ตรวจสอบ Token ของ Bot - สร้าง Token ใหม่ใน Developer Portal
2. ตรวจสอบการเชื่อมต่ออินเทอร์เน็ต - ทดสอบการเชื่อมต่อ
3. ตรวจสอบ Logs สำหรับข้อผิดพลาด - ดู PM2 logs

### ปัญหา: คำสั่งไม่ทำงาน

**สาเหตุและวิธีแก้ไข**:
1. ตรวจสอบว่าลงทะเบียนคำสั่งแล้วหรือยัง - รันคำสั่งลงทะเบียน
2. ตรวจสอบสิทธิ์ของ Bot - ตรวจสอบว่า Bot มีสิทธิ์ที่จำเป็น
3. ตรวจสอบว่ามีการอัปเดต API หรือไม่ - ตรวจสอบเวอร์ชัน API

### ปัญหา: การแจ้งเตือนไม่มา

**สาเหตุและวิธีแก้ไข**:
1. ตรวจสอบการตั้งค่า Notifications - ดูไฟล์ config
2. ตรวจสอบการเชื่อมต่อกับ API - ทดสอบการเชื่อมต่อ
3. ตรวจสอบว่า Event ถูก trigger แล้วหรือยัง - ดู Logs

## การตั้งค่าการแจ้งเตือน

### การแจ้งเตือนการสั่งซื้อใหม่
```javascript
// ตัวอย่างการแจ้งเตือนการสั่งซื้อใหม่
{
  "type": "new_order",
  "orderId": "ORDER123456",
  "productName": "สินค้าตัวอย่าง",
  "quantity": 1,
  "price": 99.99,
  "userId": "USER123",
  "userName": "ผู้ใช้ตัวอย่าง",
  "timestamp": "2023-01-01T12:00:00Z"
}
```

### การแจ้งเตือนการเติมเงิน
```javascript
// ตัวอย่างการแจ้งเตือนการเติมเงิน
{
  "type": "new_topup",
  "topupId": "TOPUP123456",
  "amount": 100.00,
  "userId": "USER123",
  "userName": "ผู้ใช้ตัวอย่าง",
  "paymentMethod": "Truemoney Wallet",
  "timestamp": "2023-01-01T12:00:00Z"
}
```

### การแจ้งเตือนสต็อกสินค้าต่ำ
```javascript
// ตัวอย่างการแจ้งเตือนสต็อกต่ำ
{
  "type": "low_stock",
  "productId": "PRODUCT123",
  "productName": "สินค้าตัวอย่าง",
  "currentStock": 5,
  "threshold": 10,
  "timestamp": "2023-01-01T12:00:00Z"
}
```

## การพัฒนาฟีเจอร์เพิ่มเติม

### การเพิ่มระบบ Ticket Support

1. สร้างคำสั่ง `/ticket`
2. สร้างระบบจัดการ Ticket
3. สร้างการแจ้งเตือนสำหรับ Support Team
4. สร้างรายงาน Ticket

### การเพิ่มระบบ Analytics

1. สร้างคำสั่ง `/analytics`
2. สร้างระบบรวบรวมข้อมูล
3. สร้างรายงานแบบกราฟิก
4. สร้างการแจ้งเตือนตามพฤติกรรมผู้ใช้

## การสนับสนุนและการติดต่อ

หากพบปัญหาหรือมีข้อเสนอแนะ กรุณาติดต่อ:

- **GitHub Issues**: [Repository Issues](https://github.com/your-repo/issues)
- **Discord Support Channel**: #support ในเซิร์ฟเวอร์ของคุณ
- **อีเมล**: support@dedazen.com

## ลิขสิทธิ์

MIT License - ดูไฟล์ LICENSE สำหรับรายละเอียดเพิ่มเติม

---

**หมายเหตุ**: เอกสารนี้เป็นคู่มือเบื้องต้นสำหรับการติดตั้งและการใช้งาน Discord Bot สำหรับ Dedazen Store หากต้องการข้อมูลเพิ่มเติมหรือการสนับสนุนทางเทคนิค กรุณาติดต่อทีมพัฒนา
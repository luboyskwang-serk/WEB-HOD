# Dedazen Store Discord Bot

บอท Discord สำหรับตรวจสอบและจัดการเว็บไซต์ Dedazen Store

## ฟีเจอร์

### ระบบตรวจสอบ
- ตรวจสอบสถานะเว็บไซต์แบบเรียลไทม์
- ตรวจสอบการเชื่อมต่อฐานข้อมูล
- แจ้งเตือนเมื่อเกิดข้อผิดพลาด

### ระบบรายงาน
- `/stats` - แสดงสถิติของเว็บไซต์
- `/recent` - ดูกิจกรรมล่าสุด
- `/user [id]` - ดูข้อมูลผู้ใช้
- `/product [id]` - ดูข้อมูลสินค้า
- `/report` - สร้างรายงานโดยละเอียด

### ระบบจัดการ (สำหรับแอดมิน)
- `/topup [amount] [user]` - เติมเงินให้ผู้ใช้
- `/admin status` - ตรวจสอบสถานะบอท
- `/admin monitor` - ควบคุมระบบตรวจสอบ
- `/admin restart` - รีสตาร์ทบอท
- `/setalerts [channel]` - ตั้งค่าช่องแจ้งเตือน

## การติดตั้ง

1. ติดตั้ง Node.js (v16.11.0 ขึ้นไป)
2. ติดตั้ง dependencies:
   ```bash
   npm install
   ```

3. ตั้งค่าไฟล์ `.env`:
   ```env
   # Discord Bot Configuration
   DISCORD_TOKEN=your_discord_bot_token_here
   CLIENT_ID=your_discord_client_id_here
   GUILD_ID=your_guild_id_here
   ADMIN_ROLE_ID=your_admin_role_id_here

   # Database Configuration
   DB_HOST=localhost
   DB_USER=root
   DB_PASSWORD=
   DB_NAME=kakarotc_demo

   # Website Configuration
   WEBSITE_URL=http://localhost

   # Monitoring Settings
   CHECK_INTERVAL=300000
   ```

4. รันบอท:
   ```bash
   npm start
   ```

## การติดตั้งอัตโนมัติ

### สำหรับ Windows:
เรียกใช้ไฟล์ `deploy-bot.bat`

### สำหรับ Linux/Mac:
เรียกใช้ไฟล์ `deploy-bot.sh`
```bash
chmod +x deploy-bot.sh
./deploy-bot.sh
```

## คำสั่งบอท

| คำสั่ง | คำอธิบาย | ต้องการสิทธิ์แอดมิน |
|--------|----------|-------------------|
| `/stats` | แสดงสถิติของเว็บไซต์ | ไม่ |
| `/recent` | ดูกิจกรรมล่าสุด | ไม่ |
| `/user [id]` | ดูข้อมูลผู้ใช้ | ไม่ |
| `/product [id]` | ดูข้อมูลสินค้า | ไม่ |
| `/report [type]` | สร้างรายงานโดยละเอียด | ไม่ |
| `/help` | แสดงคำสั่งทั้งหมด | ไม่ |
| `/topup [amount] [user]` | เติมเงินให้ผู้ใช้ | ใช่ |
| `/admin status` | ตรวจสอบสถานะบอท | ใช่ |
| `/admin monitor` | ควบคุมระบบตรวจสอบ | ใช่ |
| `/admin restart` | รีสตาร์ทบอท | ใช่ |
| `/setalerts [channel]` | ตั้งค่าช่องแจ้งเตือน | ใช่ |

## การพัฒนา

### โครงสร้างโปรเจกต์
```
discord-bot/
├── commands/          # คำสั่งบอท
├── database/          # ฟังก์ชันฐานข้อมูล
├── events/            # อีเวนต์ Discord
├── monitoring/        # ระบบตรวจสอบ
├── utils/             # เครื่องมือช่วย
├── logs/              # ไฟล์ log
├── .env               # ตั้งค่าสภาพแวดล้อม
├── index.js           # ไฟล์หลัก
├── deploy-bot.bat     # สคริปต์ติดตั้ง (Windows)
├── deploy-bot.sh      # สคริปต์ติดตั้ง (Linux/Mac)
└── package.json       # ข้อมูลโปรเจกต์
```

### การเพิ่มคำสั่งใหม่
1. สร้างไฟล์ใหม่ในโฟลเดอร์ `commands/`
2. ใช้โครงสร้าง:
   ```javascript
   const { SlashCommandBuilder } = require('discord.js');
   
   module.exports = {
     data: new SlashCommandBuilder()
       .setName('commandname')
       .setDescription('Command description'),
     
     async execute(interaction, client) {
       // Command logic here
     }
   };
   ```

## การตรวจสอบระบบ

ระบบจะตรวจสอบสถานะเว็บไซต์ทุกๆ 5 นาที (ค่าเริ่มต้น) และสามารถปรับได้ในไฟล์ `.env`

## การแก้ไขปัญหา

หากพบปัญหาในการใช้งาน:
1. ตรวจสอบไฟล์ log ในโฟลเดอร์ `logs/`
2. ตรวจสอบการตั้งค่าในไฟล์ `.env`
3. ตรวจสอบการเชื่อมต่อฐานข้อมูล
4. ตรวจสอบสิทธิ์ของบอทในเซิร์ฟเวอร์ Discord

## ความต้องการระบบ

- Node.js v16.11.0 ขึ้นไป
- MySQL 5.7 ขึ้นไป
- การเชื่อมต่ออินเทอร์เน็ต
- โทเค็นบอท Discord

## ลิขสิทธิ์

โปรเจกต์นี้เป็นโอเพนซอร์สภายใต้ใบอนุญาต MIT
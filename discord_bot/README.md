# Dedazen Store Discord Bot

## รายละเอียด
Discord Bot สำหรับจัดการและติดตามระบบ Dedazen Store อย่างครบวงจร

## ฟีเจอร์หลัก

### การแจ้งเตือนอัตโนมัติ
- แจ้งเตือนการสั่งซื้อใหม่
- แจ้งเตือนการเติมเงิน
- แจ้งเตือนสต็อกสินค้าต่ำ
- แจ้งเตือนความปลอดภัย

### การจัดการระบบผ่าน Discord
- ดูสถิติเว็บไซต์แบบเรียลไทม์
- จัดการผู้ใช้ (แบน/ปลดแบน)
- จัดการสินค้า (เพิ่ม/ลบ/แก้ไขสต็อก)
- ดูรายงานการเงิน

### รายงานและ Analytics
- รายงานรายวัน/สัปดาห์/เดือน
- สถิติผู้ใช้ใหม่
- สถิติการขาย
- สถิติการเติมเงิน

## วิธีการติดตั้ง

### 1. สร้าง Discord Application
1. ไปที่ [Discord Developer Portal](https://discord.com/developers/applications)
2. คลิก "New Application"
3. ตั้งชื่อแอปพลิเคชัน
4. ไปที่แท็บ "Bot"
5. คลิก "Add Bot"
6. เปิดใช้งาน Privileged Gateway Intents (Presence Intent, Server Members Intent, Message Content Intent)

### 2. ตั้งค่า Bot
1. คัดลอก "Token" ของ Bot
2. ไปที่แท็บ "OAuth2" -> "URL Generator"
3. เลือก Scope: `bot`, `applications.commands`
4. เลือก Permissions:
   - View Channels
   - Send Messages
   - Embed Links
   - Attach Files
   - Read Message History
   - Mention Everyone
   - Use Slash Commands
5. คัดลอก URL ที่สร้างขึ้นมาและเปิดในเบราว์เซอร์เพื่อเชิญ Bot เข้าเซิร์ฟเวอร์

### 3. ตั้งค่า API สำหรับ Bot
1. สร้าง API endpoint ในระบบ PHP สำหรับ Bot ใช้งาน
2. ตั้งค่า webhook สำหรับการแจ้งเตือน
3. สร้าง token สำหรับ authentication ระหว่าง Bot และระบบ

## โครงสร้างโปรเจกต์

```
discord_bot/
├── src/
│   ├── commands/
│   │   ├── admin/
│   │   │   ├── stats.js
│   │   │   ├── users.js
│   │   │   ├── products.js
│   │   │   └── orders.js
│   │   ├── user/
│   │   │   ├── help.js
│   │   │   ├── ping.js
│   │   │   └── info.js
│   │   └── index.js
│   ├── events/
│   │   ├── ready.js
│   │   ├── interactionCreate.js
│   │   └── messageCreate.js
│   ├── utils/
│   │   ├── database.js
│   │   ├── logger.js
│   │   └── api.js
│   └── index.js
├── config/
│   └── config.json
├── package.json
└── README.md
```

## คำสั่งที่รองรับ

### คำสั่งสำหรับ Admin
- `/stats` - แสดงสถิติเว็บไซต์
- `/users` - จัดการผู้ใช้
- `/products` - จัดการสินค้า
- `/orders` - ดูคำสั่งซื้อล่าสุด
- `/topups` - ดูการเติมเงินล่าสุด
- `/inventory` - จัดการสต็อกสินค้า
- `/reports` - ดูรายงาน
- `/settings` - ตั้งค่า Bot

### คำสั่งสำหรับผู้ใช้ทั่วไป
- `/help` - แสดงคำสั่งที่ใช้งานได้
- `/ping` - ทดสอบการเชื่อมต่อ
- `/info` - แสดงข้อมูลเว็บไซต์

## การตั้งค่า

### ไฟล์ config.json
```json
{
  "discord": {
    "token": "YOUR_BOT_TOKEN",
    "clientId": "YOUR_CLIENT_ID",
    "guildId": "YOUR_GUILD_ID"
  },
  "api": {
    "baseUrl": "https://yourwebsite.com/api",
    "token": "YOUR_API_TOKEN"
  },
  "database": {
    "host": "localhost",
    "user": "db_user",
    "password": "db_password",
    "database": "database_name"
  },
  "notifications": {
    "newOrder": true,
    "newTopup": true,
    "lowStock": true,
    "securityAlert": true
  }
}
```

## การพัฒนาเพิ่มเติม

### เพิ่มคำสั่งใหม่
1. สร้างไฟล์คำสั่งใหม่ใน `src/commands/`
2. ลงทะเบียนคำสั่งใน `src/commands/index.js`
3. รีสตาร์ท Bot

### เพิ่ม Event Handler
1. สร้างไฟล์ event ใน `src/events/`
2. เพิ่มการลงทะเบียน event ใน `src/index.js`

## การ Deploy

### ใช้ PM2 (แนะนำ)
```bash
npm install -g pm2
pm2 start src/index.js --name "dedazen-bot"
pm2 startup
pm2 save
```

### ใช้ Docker (สำหรับผู้เชี่ยวชาญ)
```dockerfile
FROM node:16-alpine
WORKDIR /app
COPY package*.json ./
RUN npm install
COPY . .
CMD ["node", "src/index.js"]
```

## การตรวจสอบและ Debug

### ดู Logs
```bash
pm2 logs dedazen-bot
```

### รีสตาร์ท Bot
```bash
pm2 restart dedazen-bot
```

### อัปเดต Bot
```bash
git pull
npm install
pm2 restart dedazen-bot
```

## ความปลอดภัย

### แนวทางปฏิบัติที่ดี
1. ไม่เผยแพร่ Token ของ Bot
2. ใช้ Environment Variables สำหรับข้อมูลที่ละเอียดอ่อน
3. ตรวจสอบสิทธิ์การเข้าถึงของคำสั่ง
4. บันทึก Logs อย่างละเอียด
5. อัปเดต Dependencies อย่างสม่ำเสมอ

## การแก้ปัญหาทั่วไป

### Bot ไม่ออนไลน์
- ตรวจสอบ Token ของ Bot
- ตรวจสอบการเชื่อมต่ออินเทอร์เน็ต
- ตรวจสอบ Logs สำหรับข้อผิดพลาด

### คำสั่งไม่ทำงาน
- ตรวจสอบว่าลงทะเบียนคำสั่งแล้วหรือยัง
- ตรวจสอบสิทธิ์ของ Bot
- ตรวจสอบว่ามีการอัปเดต API หรือไม่

### การแจ้งเตือนไม่มา
- ตรวจสอบการตั้งค่า Notifications
- ตรวจสอบการเชื่อมต่อกับ API
- ตรวจสอบว่า Event ถูก trigger แล้วหรือยัง

## การสนับสนุน

หากพบปัญหาหรือมีข้อเสนอแนะ สามารถติดต่อได้ที่:
- GitHub Issues
- Discord Support Channel
- อีเมล support@dedazen.com

## License

MIT License - ดูไฟล์ LICENSE สำหรับรายละเอียดเพิ่มเติม
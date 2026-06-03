#include <RTClib.h>
#include <LiquidCrystal_I2C.h>

LiquidCrystal_I2C lcd(0x27, 20, 4);
RTC_DS1307 rtc;

const int lightSensorPin = A0;  // ขา Analog สำหรับเซ็นเซอร์วัดแสง
const int ledPin = 6;           // ขาสำหรับไฟ LED
int lightThreshold = 65;        // ค่าที่กำหนดสำหรับแสง
unsigned long previousMillis = 0;
const long interval = 1000;  // อัพเดตทุก 1 วินาที

void setup() {
  pinMode(ledPin, OUTPUT);
  lcd.begin(20, 4);
  lcd.backlight();

  if (!rtc.begin()) {            // ตรวจสอบว่ามี RTC หรือไม่
    lcd.clear();
    lcd.print("No RTC found");   // แสดงข้อความถ้าไม่พบ RTC
  }
}

void loop() {
  DateTime now = rtc.now();      // อ่านเวลาจาก RTC
  unsigned long currentMillis = millis();
  int lightLevel = analogRead(lightSensorPin);           // อ่านค่าจากเซ็นเซอร์วัดแสง
  int mappedLightLevel = map(lightLevel, 0, 1023, 0, 100);  // แปลงค่าแสงเป็น %

  // เช็คเวลาปัจจุบันและควบคุมสถานะ LED
  int currentHour = now.hour();
  if (currentHour >= 9 && currentHour < 24) {
    if (mappedLightLevel < lightThreshold) {
      digitalWrite(ledPin, HIGH);
    } else {
      digitalWrite(ledPin, LOW);
    }
  } else {
    digitalWrite(ledPin, LOW);     // ปิดไฟ LED นอกช่วงเวลา
  }

  // อัพเดตการแสดงผลทุก 1 วินาที
  if (currentMillis - previousMillis >= interval) {
    previousMillis = currentMillis;

    // อัพเดตวันที่
    lcd.setCursor(0, 0);
    lcd.print(now.day());
    lcd.print('/');
    lcd.print(now.month());
    lcd.print('/');
    lcd.print(now.year());
    lcd.print("   ");  // เพิ่มช่องว่างเพื่อเคลียร์ข้อมูลเก่าหากข้อมูลใหม่สั้นลง

    // อัพเดตเวลา
    lcd.setCursor(12, 0);
    if (now.hour() < 10) lcd.print('0'); // แสดงเลขชั่วโมงสองหลัก
    lcd.print(now.hour());
    lcd.print(':');
    if (now.minute() < 10) lcd.print('0'); // แสดงเลขนาทีสองหลัก
    lcd.print(now.minute());
    lcd.print(':');
    if (now.second() < 10) lcd.print('0'); // แสดงเลขวินาทีสองหลัก
    lcd.print(now.second());
    lcd.print("   ");  // ช่องว่างเคลียร์ข้อมูลเก่า

    // อัพเดตข้อมูลระดับแสง
    lcd.setCursor(0, 2);
    lcd.print("LIGHT: ");
    lcd.print(mappedLightLevel);
    lcd.print("%   ");  // เพิ่มช่องว่างหลังข้อมูล

    // อัพเดตสถานะ LED
    lcd.setCursor(12, 2);
    lcd.print("LED: ");
    if ((mappedLightLevel < lightThreshold) && (currentHour >= 9 && currentHour < 24)) {
      lcd.print("ON");
    } else {
      lcd.print("OFF");
    }
    lcd.print("   ");  // ช่องว่างเคลียร์ข้อมูลเก่า
  }

    lcd.setCursor(5, 3);
    lcd.print("TEMP: ");
    lcd.print("C ");
}

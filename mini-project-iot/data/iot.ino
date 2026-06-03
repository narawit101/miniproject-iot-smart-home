#include <ESP32Servo.h>
#include <DHT.h>

#define LDR_PIN 34          
#define VIBRATION_PIN 35     
#define TRIG_PIN 32          
#define ECHO_PIN 33        
#define DHT_PIN 14         
#define LED 2
#define servoPin 4
#define BUZZER 16

Servo servo;
DHT dht(DHT_PIN, DHT11);
bool isOpen = false;  // ใช้ตรวจสอบสถานะของเซอร์โว

void setup() {
  Serial.begin(115200);

  pinMode(LDR_PIN, INPUT);
  pinMode(VIBRATION_PIN, INPUT);
  pinMode(TRIG_PIN, OUTPUT);
  pinMode(ECHO_PIN, INPUT);
  pinMode(LED, OUTPUT);
  pinMode(BUZZER, OUTPUT);

  servo.attach(servoPin, 500, 2400);
  dht.begin();
}

// ฟังก์ชันคำนวณระยะทางจากเซนเซอร์อัลตราโซนิก
float getWaterLevel() {
  digitalWrite(TRIG_PIN, LOW);
  delayMicroseconds(2);
  digitalWrite(TRIG_PIN, HIGH);
  delayMicroseconds(10);
  digitalWrite(TRIG_PIN, LOW);

  long duration = pulseIn(ECHO_PIN, HIGH);
  float distance = (duration * 0.0343) / 2; // คำนวณระยะทางเป็นเซนติเมตร (cm)

  return distance;
}

void loop() {
  int lightValue = analogRead(LDR_PIN);  // อ่านค่าความสว่างจาก LDR
  int vibrationValue = analogRead(VIBRATION_PIN);  // อ่านแรงสั่นสะเทือน
  float waterLevel = getWaterLevel();  // อ่านระดับน้ำจาก HC-SR04
  float temp = dht.readTemperature();  // อ่านค่าอุณหภูมิ (°C)
  float humidity = dht.readHumidity();  // อ่านค่าความชื้น (%)

  Serial.println("=============================");
  Serial.print("อุณหภูมิ: "); Serial.print(temp); Serial.println(" C");
  Serial.print("ความชื้น: "); Serial.print(humidity); Serial.println(" %");
  Serial.print("ระดับแสง: "); Serial.print(lightValue); Serial.println(" / 4095");
  Serial.print("แรงสั่นสะเทือน: "); Serial.print(vibrationValue); Serial.println(" / 4095");
  Serial.print("ระดับน้ำ: "); Serial.print(waterLevel); Serial.println(" cm");
  Serial.println("=============================\n");

  // ======= แจ้งเตือนเมื่อค่าถึงจุดกำหนด ======= //
  if (lightValue > 1000)
    Serial.println("แจ้งเตือน: ระดับแสงปกติ ");
  if (lightValue < 1000) {
    Serial.println("แจ้งเตือน: ระดับแสงต่ำ ");
    Serial.println("แจ้งเตือน: เปิดไฟ ");
    digitalWrite(LED, HIGH);
  } else {
    digitalWrite(LED, LOW); // ปิดไฟถ้าแสงเพียงพอ
  }
  if (vibrationValue > 2500) {
    Serial.println("แจ้งเตือน: ตรวจพบแรงสั่นสะเทือน อาจเกิดแผ่นดินไหว!");
    for (int i = 0; i < 10; i++) {
      tone(BUZZER, 3500);
      delay(50);
      noTone(BUZZER);      
      delay(100);          
    }
    noTone(BUZZER); // หยุดเสียง
  } else {
    Serial.println("แจ้งเตือน: สถานการณ์ปกติไม่มีแผ่นดินไหว");
  }
  if (waterLevel < 10.0) {
    Serial.println("แจ้งเตือน: ระดับน้ำปกติ");
    if (waterLevel < 10.0 && isOpen) {  // ถ้าน้ำลดต่ำกว่า 10 cm และเซอร์โวยังเปิดอยู่
      Serial.println("ปิดเซอร์โว!");
      servo.write(0);  // หมุนเซอร์โวกลับไปที่ 0°
      isOpen = false;  // ตั้งค่าเซอร์โวว่าอยู่ในสถานะปิด
    }
  }
  if (waterLevel > 20.0) {
    Serial.println("แจ้งเตือน: ระดับน้ำสูง !");
    if (waterLevel > 20.0 && !isOpen) {  // ถ้าระดับน้ำสูงกว่า 20 cm และเซอร์โวยังไม่เปิด
      Serial.println("เปิดเซอร์โว!");
      servo.write(180);  // หมุนเซอร์โวไปที่ 180°
      isOpen = true;  // ตั้งค่าเซอร์โวว่าเปิดอยู่
    }
  }
  if (temp > 32.0) {
    Serial.println("แจ้งเตือน: อุณหภูมิสูงผิดปกติ!");
  } else {
    Serial.println("แจ้งเตือน: อุณหภูมิปกติ");

  }

  if (humidity > 60.0) {
    Serial.println("แจ้งเตือน: ความชื้นสูงผิดปกติ!");
  } else {
    Serial.println("แจ้งเตือน: ความชื้นปกติ");

  }

  Serial.println("=============================\n");
  delay(2000);
}
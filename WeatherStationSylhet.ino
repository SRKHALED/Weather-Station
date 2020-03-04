#include <LiquidCrystal.h>
#include <SFE_BMP180.h>
#include <Wire.h>
#include <dht.h>

#define dht_apin A0
#define station_id 1

dht DHT;

SFE_BMP180 pressure;
#define ALTITUDE 35.0

//Use find Wind speed 
int count_1=0,rain=0;
double lastTime=0, thisTime=0,lt=0,tt=0,ct=0;
int count;
float speedmps, kmph;

//LCD
const int rs = 12, en = 11, d4 = 9, d5 = 8, d6 = 7, d7 = 6;
LiquidCrystal lcd(rs, en, d4, d5, d6, d7);

//GSM
byte gsmDriverPin[3] = {3,4,5};
void setup() {
  Serial.begin(9600);
  lcd.begin(16, 2);
  lcd.setCursor(5,0);
  lcd.print("Sylhet");
  lcd.setCursor(1,1);
  lcd.print("Weather Station");
  Serial.println("REBOOT");
  if (pressure.begin())
    Serial.println("BMP180 init success");
  else
  {
    Serial.println("BMP180 init fail\n\n");
    while(1);
  }

  attachInterrupt(0, anemo, RISING);

  for(int i = 0 ; i < 3; i++){
    pinMode(gsmDriverPin[i],OUTPUT);
  }
  digitalWrite(5,HIGH);//Output GSM Timing 
  delay(1500);
  digitalWrite(5,LOW);  
  digitalWrite(3,LOW);//Enable the GSM mode
  digitalWrite(4,HIGH);//Disable the GPS mode
  delay(2000);
  Serial.begin(9600);
  delay(5000);
  delay(5000);
  delay(5000);
  lcd.clear();

  
  Serial.println("AT");   
   delay(4000);
   Serial.println("ATD01741618005;");   
   delay(20000);

}

void loop() {
  char status;
  double T2,P,p0;
  int H,T1;

  //Work with Water Sensor
  int sensor = analogRead(A1);
  Serial.println(sensor);
  if(sensor>=100){
    Serial.println("Raining");
    rain=1;
    }
  
  //Work with DHT sensor
  DHT.read11(dht_apin);
  H = int(DHT.humidity)-12;
  T1 = int(DHT.temperature);
  Serial.print("Current humidity = ");
  Serial.print(H);
  Serial.println("%");
  Serial.print("Current temperature in DDHT 11 = ");
  Serial.print(T1); 
  Serial.println("deg C");

  //Work with BMP sensor
  status = pressure.startTemperature();
  if (status != 0)
  {
      delay(status);

      status = pressure.getTemperature(T2);
      if (status != 0)
      {
        Serial.print("Current temperature in BMP 108 = ");
        Serial.print(T2,2);
        Serial.print(" deg C, ");
        Serial.print((9.0/5.0)*T2+32.0,2);
        Serial.println(" deg F");
        
        status = pressure.startPressure(3);
        if (status != 0)
        {
          delay(status);
          status = pressure.getPressure(P,T2);
          if (status != 0)
          {
            Serial.print("Absolute pressure: ");
            Serial.print(P,2);
            Serial.println(" mbar ");
  
            p0 = pressure.sealevel(P,ALTITUDE); 
            Serial.print("Relative (sea-level) pressure: ");
            Serial.print(p0,2);
            Serial.println(" mbar ");

            //Work with LCD
            lcd.setCursor(0,0);
            lcd.print("T=");
            lcd.setCursor(2, 0);
            lcd.print(T2,1);
            lcd.setCursor(6, 0);
            lcd.print("C");
            lcd.setCursor(8, 0);
            lcd.print("P=");
            lcd.setCursor(10, 0);
            lcd.print(P);
            lcd.setCursor(0, 1);
            lcd.print("H=");
            lcd.setCursor(2, 1);
            lcd.print(H);
            lcd.setCursor(6, 1);
            lcd.print("%");
          }
          else Serial.println("error retrieving pressure measurement\n");
      }
      else Serial.println("error starting pressure measurement\n");
    }
    else Serial.println("error retrieving temperature measurement\n");
  }
  else Serial.println("error starting temperature measurement\n");

  thisTime=millis();
  if (thisTime-lastTime>=4000)
  {
    count=count_1;
    count_1=0;
    lastTime=thisTime;
    speedmps=2*3.14*count*0.15*0.25;
    // speedmps=speedmps/4;
    kmph = 0.001*speedmps*3600;
    Serial.print("Wind speed : ");
    Serial.print(speedmps);
    Serial.print(" m/s ,");
    Serial.print(kmph);
    Serial.println(" km/h");
    Serial.println();
    lcd.setCursor(8, 1);
    lcd.print("WS=");
    lcd.setCursor(11, 1);
    lcd.print(kmph);
  }
  tt=millis();
  //read_gsm(T2,H,P,kmph,rain);
  if (tt-lt>=60000){
    lt=tt;
    read_gsm(T2,H,P,kmph,rain);
    //ct=1;
  }
   delay(5000);
   
}
void anemo()
{
  count_1++;
}
void read_gsm(double t,int h,double p,double w,int r)
{
   String s1 = String(t);
   String s2 = String(h);
   String s3 = String(p);
   String s4 = String(w);
   String s5 = String(r);
   String s = "t="+s1+'&'+'h'+'='+s2+'&'+'p'+'='+s3+'&'+'w'+'='+s4+'&'+'r'+'='+s5+"&d=1";
   //Serial.println(s);
   int len = s.length();
   //Serial.println(len);
   Serial.println("AT");   
   delay(4000);
   Serial.println("AT+CREG?");   
   delay(2000);
   Serial.println("AT+SAPBR=3,1,\"APN\",\"gpinternet\"");
   delay(2000);
   Serial.println("AT+SAPBR=3,1,\"USER\",\"\"");   
   delay(2000);
   Serial.println("AT+SAPBR=3,1,\"PWD\",\"\"");   
   delay(2000);
   Serial.println("AT+SAPBR=3,1,\"Contype\",\"GPRS\"");   
   delay(2000);
   Serial.println("AT+SAPBR=1,1");   
   delay(2000);
   Serial.println("AT+HTTPINIT");   
   delay(2000);
   Serial.println("AT+SAPBR=2,1");   
   delay(2000);
   Serial.println("AT+HTTPPARA=\"CID\",1");   
   delay(2000);
   Serial.println("AT+HTTPPARA=\"URL\",\"http://weather2.shparvez.net/data.php\"");
   delay(2000);
   Serial.println("AT+HTTPPARA=\"CONTENT\",\"application/x-www-form-urlencoded\"");
   delay(2000);
   Serial.print("AT+HTTPDATA=");
   Serial.print(len);
   Serial.println(",10000");
   delay(200);
   Serial.println(s);
   delay(2000);
   Serial.println("AT+HTTPACTION=1");
   delay(2000);
   Serial.println("AT+HTTPREAD");
   delay(2000);
   lcd.clear();
   lcd.setCursor(3,0);
   lcd.print("Data Send");
   delay(5000);
   lcd.clear();
}

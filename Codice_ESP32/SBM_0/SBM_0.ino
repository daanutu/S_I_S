/*
 * SMB_0: Stand By Me (but not too much) versione 0.1
 * richiede ESP32 con  partition scheme NO OTA (large app)
 */
//Librerie BLE
#include "BLEDevice.h"
#include "BLEAdvertisedDevice.h" 

//Librerie WiFi
#include <WiFi.h>
#include <WiFiMulti.h>

//Librerie HTTP
#include <HTTPClient.h>

//Librerie JSON
#include <ArduinoJson.h>

//variabili globali
//variabile BLE
char myaddr[]="##:##:##:##:##:##";    //BTMAC locale ottenuto da BLEDevice init
char advaddr[]="##:##:##:##:##:##";   //BTMAC remoto di un dispositivo in ADV ottenuto da SCAN
//Struttura dell'archivio dispositivi
struct dvcs {                         
  char adr[18];                       //nome dispositivo (dal server)
  int rssi;                           //RSSI dispositivo (da SCAN)
  int preSt;                          //stato di prossimità nello SCAN precedente 0=ok, 1=alarm
  int curSt;                          //stato di prossimità nello SCAN attuale 0=ok, 1=alarm
};
//archivio dispositivi popolato dal server (max 25 ma limitato a 10 in questa demo)
#define MAXDEV 12
dvcs devices[MAXDEV];
BLEScan* pBLEScan;            //Oggetto SCAN (ottiene gli ADV dagli altri dispositivi)
BLEAdvertising *pAdvertising; //Oggetto ADV (genera gli ADV per gli altri dispositivi)
int scanTime = 1;             //Periodo di SCAN in secondi
int event=0;                  //flag di presenza di un evento in uno SCAN
#define LOWTHR  -80           //soglia di uscita dall'allarme 80
#define HIGHTHR -70           //soglia di entrata in allarme 70

//Variabili WiFi
WiFiMulti wifiMulti;          //Oggetto di connessione WiFi

//Variabili HTTP
HTTPClient http;              //Oggetto HTTP client
const char *baseurl = "http://192.168.1.13/Scuole_In_Sicurezza/api/"; //in caso cambi l'indirizzo da cambiare 
const char *initurl = "init.php?btmac=";
const char *evturl  = "sendevts_def.php?parms=";
char fullurl[500];

//Variabili JSON
StaticJsonDocument<512> doc;           //JSON object warning only 12 devices
StaticJsonDocument<768> doc2;          //JSON object warning only 12 devices
StaticJsonDocument<32> doc3;          //JSON object for servere response
DeserializationError error;           //JSON deserialization result
char evtBuffer[400];

//Gestione LED RGB
#define REDL 25
#define GREENL 32
#define BLUEL 33
#define REDR 19
#define GREENR 21
#define BLUER 22

//gestione ON/OFF
#define TBUTT T4
#define THRESHOLD 40
#define DEBTIME 25        //costante di tempo antirimbalzo
long startDeb;            //istante di inizio antirimbalzo
int oldT4;                //stato precedente del bottone on/off
int newT4;                //stato attuale del bottone on/off
int debEn;                //flag antirimbalzo in corso

void setup() {
  pinMode(REDL,OUTPUT);
  pinMode(GREENL,OUTPUT);
  pinMode(BLUEL,OUTPUT);
  pinMode(REDR,OUTPUT);
  pinMode(GREENR,OUTPUT);
  pinMode(BLUER,OUTPUT);
  pinMode(LED_BUILTIN,OUTPUT);
  newT4=touchRead(T4);
  oldT4=newT4;
  startDeb=millis();
  debEn=false;  
  Serial.begin(115200);
  lampTest();
  //inizializza archivio vuoto
  for(int i=0;i<MAXDEV;i++){
    strcpy(devices[i].adr,"00:00:00:00:00:00");
    devices[i].rssi=0;
    devices[i].preSt=0;
    devices[i].curSt=0;
    
  }
  //Inizializza BLEDevice senza nome, ottiene BTMAC, deinizializza
  Serial.println("Starting SMB device");
  Serial.println("Init BLE device...");
  //ottiene BTMAC locale
  getLocalMAC();
  Serial.print("Local Addr: ");
  Serial.println(myaddr);    
  //ottiene config dal server via WiFi
  getConfig();
  Serial.println("Configured devices");
  for(int i=0;i<MAXDEV;i++){
          Serial.println(devices[i].adr);    
  }
  delay(5000);
  //Avvia servizio BLE
  BLEDevice::init(myaddr);
  //Avvia advertising
  Serial.println("Starting Advertiser ...");
  startAdv();
  Serial.println("Advertiser started");
  //Avvia scanning
  Serial.println("Starting scanner ...");   
  startScan();
  Serial.println("Scanner started");  
}

void loop() {
  //Gestione Bottone ON/OFF
  onOff();
  //Gestione SCAN
  makeScan();
}

//Lamp test
void lampTest(){
  //Lamp test
  digitalWrite(LED_BUILTIN,LOW);
  red();
  delay(1000);
  digitalWrite(LED_BUILTIN,HIGH);
  green();
  delay(1000);
  digitalWrite(LED_BUILTIN,LOW);
  blue();
  delay(1000);
  digitalWrite(LED_BUILTIN,HIGH);
  white();
  delay(1000);
  digitalWrite(LED_BUILTIN,LOW);
  off();
  delay(1000);
  digitalWrite(LED_BUILTIN,HIGH);
}
//Segnala ok su led rgb
void setok(){
  digitalWrite(LED_BUILTIN,HIGH);
  green();
}
//Segnala allarme su led rgb
void setalarm(){
  digitalWrite(LED_BUILTIN,LOW);
  red();
}

//ottiene il BTMAC locale
void getLocalMAC(){
  BLEDevice::init("");
  strcpy(myaddr,BLEDevice::getAddress().toString().c_str());
  BLEDevice::deinit(false);
}

//Richiesta HTTP di configurazione al server
void getConfig(){
  wifiOn();
  //richiesta HTTP di inizializzazione al server  
  strcpy(fullurl,baseurl);
  strcat(fullurl,initurl);
  strcat(fullurl,myaddr);
  Serial.println(fullurl);
  http.begin(fullurl); //HTTP
  int httpCode = http.GET();
  Serial.println(httpCode);
  if(httpCode > 0) {
    if(httpCode == HTTP_CODE_OK) {
      String payload = http.getString();
      Serial.println(payload);
      error=deserializeJson(doc,payload);
      if(error){
          Serial.print("deserializeJson() failed: ");
          Serial.println(error.c_str());
      }             
      String sta=doc["status"];
      Serial.println(sta);
      JsonArray dataArray = doc["data"];
      int n=dataArray.size();
      for(int i=0;i<n;i++){
          String adr=doc["data"][i];
          Serial.println(adr);    
          strcpy(devices[i].adr,adr.c_str());   
      }
    }
  }
  http.end();
  //disabilita WiFi
  wifiOff();
}  

//avvia l'advertising
void startAdv(){
  pAdvertising = BLEDevice::getAdvertising();
  pAdvertising->setScanResponse(true);
  pAdvertising->setMinPreferred(0x06); 
  pAdvertising->setMinPreferred(0x12);
  BLEDevice::startAdvertising();  
}

//avvia lo scan
void startScan(){
  pBLEScan = BLEDevice::getScan();
  pBLEScan->setActiveScan(true);
  pBLEScan->setInterval(100);
  pBLEScan->setWindow(100);    
}

//effettua uno scan e se necessario manda eventi al server
void makeScan(){
  //inizio di uno scan
  long t0=millis();
  BLEScanResults results = pBLEScan->start(scanTime, false);
  long t1=millis();
  Serial.print("Scan done in ");
  Serial.print(t1-t0);
  Serial.println(" mS");
  Serial.print("Devices found: ");
  Serial.println(results.getCount());
  //per ogni dispositivo trovato in adv
  event=0;
  for (int i = 0; i < results.getCount(); i++) {
    //ottiene BTMAC e RSSI del dispositivo
    BLEAdvertisedDevice device = results.getDevice(i);
    strcpy(advaddr,device.getAddress().toString().c_str());
    int rssi = device.getRSSI();
    //cofronta dispositvo corrente con tutti i dispositivi configurati
    for(int j=0;j<MAXDEV;j++) {
      //verifica se il dispositivo corrente è nell'archivio dispositivi
      if(strncmp(advaddr+12,devices[j].adr+12,5)==0){ //dispositivo in archivio
        Serial.print("Adv Adr: ");
        Serial.print(advaddr);   
        Serial.print(" Rssi: ");
        Serial.println(rssi);
        //verifica lo stato di prossimità precedente
        if(devices[j].preSt==1){ //era in allarme
          //confronta con soglia inferiore dell'isteresi (uscita da allarme)
          if(rssi<LOWTHR) { //esce dall'allarme
            devices[j].curSt=0;   //attualmente non in allarme
            event=1;              //almeno un evento
          }
          else {           //rimane in allarme
            devices[j].curSt=1;  //attualmente in allarme
          }
        }
        else { //non era in allarme
          //confronta con soglia superiore dell'isteresi (entrata in allarme)
          if(rssi>HIGHTHR) { //entra in allarme
            devices[j].curSt=1;   //attualmente in allarme
            event=1;              //almeno un evento
          }
          else {          //rimane non in allarme
            devices[j].curSt=0;
          }          
        }
      }
    }
  }
  Serial.println();
  pBLEScan->clearResults();  
  //verifica se almeno un evento
  if(event){  //se almeno un evento di entrata/cessato allarme
    //costruisce oggetto JSON
    doc2["mymac"] = myaddr;
    JsonArray events = doc2.createNestedArray("events");
    //cerca gli eventi in archivio
    for(int j=0;j<MAXDEV;j++) {
      //verifica se entrata in allarme (preSt=0 e curSt=1 )
      if((devices[j].preSt==0)&&(devices[j].curSt==1)){ //entrata in allarme: aggiungi elemento
        Serial.print("Enter alarm:");
        Serial.println(devices[j].adr);              
        JsonObject event=events.createNestedObject();
        event["evt"] ="1";                //stato entrata in allarme
        event["adr"] = devices[j].adr;    //btmac del dispositivo che ha provocato l'allarme
      }
      //verifica se uscita da allarme (preSt=1 e curSt=0 )
      if((devices[j].preSt==1)&&(devices[j].curSt==0)){ //cessato allarme: aggiungi elemento
        Serial.print("Exit alarm:");
        Serial.println(devices[j].adr);
        JsonObject event=events.createNestedObject();
        event["evt"] ="0";              //stato cessato allarme
        event["adr"] = devices[j].adr;  //btmac del dispositivo che ha provocato il cessato allarme
      }
    }
    serializeJson(doc2, Serial);
    serializeJson(doc2,evtBuffer);
    //invia eventi al server
    //ferma BT
    BLEDevice::deinit(false);   
    //avvia WiFi
    wifiOn();
    //invia richiesta di registrazione eventi al server
    strcpy(fullurl,baseurl);
    strcat(fullurl,evturl);
    strcat(fullurl,evtBuffer);
    Serial.println(fullurl);
    http.begin(fullurl); //HTTP
    int httpCode = http.GET();
    Serial.println(httpCode);
    if(httpCode > 0) {
      if(httpCode == HTTP_CODE_OK) {
        String payload = http.getString();
        Serial.println(payload);
        error=deserializeJson(doc3,payload);
        if(error){
          Serial.print("deserializeJson() failed: ");
          Serial.println(error.c_str());
        }             
        String sta=doc3["status"];
        Serial.println(sta);
      }
    }
    http.end();
    //ferma WiFi
    wifiOff();
    //Avvia servizio BLE
    BLEDevice::init(myaddr);
    //Avvia advertising
    Serial.println("Starting Advertiser ...");
    startAdv();
    Serial.println("Advertiser started");
    //Avvia scanning
    Serial.println("Starting scanner ...");   
    startScan();
    Serial.println("Scanner started");  
  }
  //aggiorna stati per lo SCAN successivo
  int alarm=0;
  for(int j=0;j<MAXDEV;j++) {
    devices[j].preSt=devices[j].curSt;
    if(devices[j].curSt==1)alarm=1;
  }
  //verifica se almeno un allarme
  if(alarm==1) {
    setalarm();
  }
  else {
    setok();
  }
}

//gestione bottone on/off
void onOff(){ 
  Serial.println("test touchbutton");
  //legge lo stato del bottone touch
  newT4=touchRead(T4);
  if((newT4<THRESHOLD)&&(oldT4>=THRESHOLD)) { //fronte di discesa: avvia antirimbalzo
    startDeb=millis();
    debEn=true;
  }
  //gestione antirimbalzo
  if(debEn) { //verifica se antirimbalzo in corso
    if(millis()-startDeb > DEBTIME) { //antirimbalzo in corso: verifica se tempo scaduto
      debEn=false;  //scaduto: ferma antirimbalzo          
      newT4=touchRead(T4);  //rilegge stato bottone
      if(newT4<THRESHOLD) { //bottone ancora premuto: spegne dispositivo
        Serial.println("Going to sleep ... good night zzz ...");
        digitalWrite(LED_BUILTIN,HIGH);
        off();
        delay(5000);
        //collega interrupt al bottone touch e va in deep sleep
        touchAttachInterrupt(T4, callback, THRESHOLD);
        esp_sleep_enable_touchpad_wakeup();
        esp_deep_sleep_start();
      }  
    }
  }  
  oldT4=newT4;    //aggiorna stato del bottone
}
void callback(){
  //placeholder callback function
}
void red(){
  digitalWrite(REDL,HIGH);
  digitalWrite(GREENL,LOW);
  digitalWrite(BLUEL,LOW);
  digitalWrite(REDR,HIGH);
  digitalWrite(GREENR,LOW);
  digitalWrite(BLUER,LOW);
}
void green(){
  digitalWrite(REDL,LOW);
  digitalWrite(GREENL,HIGH);
  digitalWrite(BLUEL,LOW);
  digitalWrite(REDR,LOW);
  digitalWrite(GREENR,HIGH);
  digitalWrite(BLUER,LOW);  
}
void blue(){
  digitalWrite(REDL,LOW);
  digitalWrite(GREENL,LOW);
  digitalWrite(BLUEL,HIGH);
  digitalWrite(REDR,LOW);
  digitalWrite(GREENR,LOW);
  digitalWrite(BLUER,HIGH);  
}
void white(){
  digitalWrite(REDL,HIGH);
  digitalWrite(GREENL,HIGH);
  digitalWrite(BLUEL,HIGH);
  digitalWrite(REDR,HIGH);
  digitalWrite(GREENR,HIGH);
  digitalWrite(BLUER,HIGH);
}
void off(){
  digitalWrite(REDL,LOW);
  digitalWrite(GREENL,LOW);
  digitalWrite(BLUEL,LOW);
  digitalWrite(REDR,LOW);
  digitalWrite(GREENR,LOW);
  digitalWrite(BLUER,LOW);  
}
void wifiOn(){
  wifiMulti.addAP("Vodafone-30633300", "674xss82fi878t8");
  while(wifiMulti.run() != WL_CONNECTED){
    Serial.println("Waiting for WiFi connection");
  }
  Serial.println("WiFi connected");
}
void wifiOff(){
  Serial.println("End Configured devices");
  WiFi.disconnect(true);
  WiFi.mode(WIFI_OFF);  
}

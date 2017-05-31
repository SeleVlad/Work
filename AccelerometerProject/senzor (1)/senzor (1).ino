int xPin = 0;
int yPin = 1;
int zPin = 2;

float xReal = 0, yReal = 0, zReal = 1;
float xOffset, yOffset, zOffset;


void setup() {
  Serial.begin(9600);
  //  Serial.println("Calibreaza...");
  calibreaza();
  //  Serial.println("Done.");
  delay(1000);
}

void loop() {
  //  Serial.print("Acceleratia (x): ");
  float acceleratieX = convert(analogRead(xPin)) + xOffset;
   
  //  Serial.print("Acceleratia (y): ");
  float acceleratieY = convert(analogRead(yPin)) + yOffset;
  

  //  Serial.print("Acceleratia (z): ");
  float acceleratieZ = convert(analogRead(zPin)) + zOffset;
  
  String data = String(String(acceleratieX)+"*"+String(acceleratieY)+"*"+String(acceleratieZ));
  Serial.println(data);

  delay(200);
}

float convert(float in) {
  return ((in * 5 / 1024) - 3.3 / 2) / 0.3;
}

void calibreaza() {
  float xActual = 0, yActual = 0, zActual = 0;
  for (int i = 0; i < 10; i++) {
    xActual += convert(analogRead(xPin));
    yActual += convert(analogRead(yPin));
    zActual += convert(analogRead(zPin));
  }
  xActual = xActual / 10;
  yActual = yActual / 10;
  zActual = zActual / 10;
  xOffset = xReal - xActual;
  yOffset = yReal - yActual;
  zOffset = zReal - zActual;
}



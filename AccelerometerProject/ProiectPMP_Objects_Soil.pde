import processing.serial.*;
import java.util.StringTokenizer;
import processing.opengl.*;

Serial myPort;
PShape plane;

float xValue, yValue, zValue;
float pitch, roll, yaw;

float  PI=3.14159;
boolean[] drawn = new boolean[11];

int[] xPos = new int[11];
float[] zIncr = new float[11];

int n = 0;
int i = 0;
int xA;
int reset = 0;

boolean firstDraw = true;

void setup() {

  size(800, 600, P3D);
  beginCamera();
  camera();
  rotateY(-PI/20);
  //rotateX(-PI/20);
  endCamera();
  lights();
  smooth();
  println(Serial.list());
  int lastport = Serial.list().length;
  String portName = Serial.list()[lastport-1]; 

  myPort = new Serial(this, portName, 9600);
  myPort.bufferUntil('\n'); 

  background(255, 255, 255);

  for (int j = 0; j<11; j++)
  {
    int startVal = round(random(-400, 850));
    println("Start Vals : ", startVal);
    xPos[j] = startVal;
  }
  for (int j = 0; j<11; j++)
  {
    zIncr[j] = 0.7;
  }
  for (int j = 0; j<11; j++)
  {
    drawn[j] = false;
  }
}

float lastY = 0;
float yIncr = 2;

void draw() {
  n++;
  reset++;
  for (int j = 0; j<11; j++)
  {
    zIncr[j] += 0.9;
  }
  readData();

  // black background
  background(255, 255, 255);


  pushMatrix();
  translate(width / 2, height / 2);



  drawSoil();

  pushMatrix();
  translate(0, 0, zIncr[0]);
  drawObstacle(xPos[0], 200, 30, 1000, 500);
  if (reset%1200 == 0)
  {
    zIncr[0] = 0;
    xPos[0] = round(random(-400, 850));
  }
  popMatrix();


  pushMatrix();
  translate(0, 0, zIncr[1]);
  if (drawn[1]) {
    drawObstacle(xPos[1], 200, 30, 1010, 500);
  }
  if (reset%1400 == 0)
  {
    drawn[1] = true;
    zIncr[1] = 0;
    xPos[1] = round(random(-400, 850));
  }
  popMatrix();

  pushMatrix();
  translate(0, 0, zIncr[2]);
  if (drawn[2]) {
    drawObstacle(xPos[2], 200, 30, 1020, 500);
  }
  if (reset%1500 == 0)
  {
    drawn[2]=true;
    zIncr[2] = 0;
    xPos[2] = round(random(-400, 850));
  }
  popMatrix();

  pushMatrix();
  translate(0, 0, zIncr[3]);
  if (drawn[3]) {
    drawObstacle(xPos[3], 200, 30, 1030, 500);
  }
  if (reset%1900 == 0)
  {
    drawn[3]=true;
    zIncr[3] = 0;
    xPos[3] = round(random(-400, 850));
  }
  popMatrix();


  pushMatrix();
  translate(0, 0, zIncr[4]);
  if (drawn[4]) {

    drawObstacle(xPos[4], 200, 30, 1040, 500);
  }
  if (reset%2100 == 0)
  {
    drawn[4]=true;
    zIncr[4] = 0;
    xPos[4] = round(random(-400, 850));
  }
  popMatrix();

  pushMatrix();
  translate(0, 0, zIncr[5]);
  if (drawn[5]) {
    drawObstacle(xPos[5], 200, 30, 1050, 500);
  }
  if (reset%2400 == 0)
  {
    drawn[5]=true;
    zIncr[5] = 0;
    xPos[5] = round(random(-400, 850));
  }
  popMatrix();

  pushMatrix();
  translate(0, 0, zIncr[6]);
  if (drawn[6]) {
    drawObstacle(xPos[6], 200, 30, 1060, 500);
  }
  if (reset%2800 == 0)
  {
    drawn[6]=true;
    zIncr[6] = 0;
    xPos[6] = round(random(-400, 850));
  }
  popMatrix();

  pushMatrix();
  translate(0, 0, zIncr[7]);
  if (drawn[7]) {
    drawObstacle(xPos[7], 200, 30, 1070, 500);
  }
  if (reset%3100 == 0)
  {
    drawn[7]=true;
    zIncr[7] = 0;
    xPos[7] = round(random(-400, 850));
  }
  popMatrix();

  pushMatrix();
  translate(0, 0, zIncr[8]);
  if (drawn[8]) {
    drawObstacle(xPos[8], 200, 30, 1080, 500);
  }
  if (reset%3600 == 0)
  {
    drawn[8]=true;
    zIncr[8] = 0;
    xPos[8] = round(random(-400, 850));
  }
  popMatrix();

  pushMatrix();
  translate(0, 0, zIncr[9]);
  if (drawn[9]) {
    drawObstacle(xPos[9], 200, 30, 1090, 500);
  }
  if (reset%4000 == 0)
  {
    drawn[9]=true;
    zIncr[9] = 0;
    xPos[9] = round(random(-400, 850));
  }
  popMatrix();


  pushMatrix();
  translate(0, 0, zIncr[10]);
  if (drawn[10]) {
    drawObstacle(xPos[10], 200, 30, 1100, 500);
  }
  if (reset%4400 == 0)
  {
    drawn[10]=true;
    zIncr[10] = 0;
    xPos[10] = round(random(-400, 850));
  }
  popMatrix(); 
  
    translate(width / 2, height / 2);
  //uno
  rotateZ(-pitch);//rotate dupa axa X de fapt
  rotateX(-roll);//rotate dupa axa Y de fapt
  
   //mega
  //rotateZ(pitch);//rotate dupa axa X de fapt
  //rotateX(roll);//rotate dupa axa Y de fapt
  
  drawBasicPlane();
  lastY = yValue;
  popMatrix();
} 




void readData() {
  String inString = myPort.readStringUntil('\n');
  if (inString != null) {
    println("---Acceleratia---");
    inString = trim(inString);
    StringTokenizer strTok = new StringTokenizer(inString, "*");
    xValue = Float.parseFloat(strTok.nextElement().toString());
    println("x: " + xValue);
    yValue = Float.parseFloat(strTok.nextElement().toString());
    println("y: " + yValue);
    zValue = Float.parseFloat(strTok.nextElement().toString());
    println("z: " + zValue);  
    println("-----");


    pitch = computeAngle(xValue, yValue, zValue);
    //println("ANGLE x: " + degrees(pitch));  


    roll = computeAngle(yValue, xValue, zValue);
    //println("ANGLE y: " + degrees(roll));

    //yaw = computeAngle(zValue, xValue, yValue);
    //println("ANGLE z: " + degrees(yaw));
  }
}

float computeAngle(float x, float y, float z) {
  float squareY = y*y;
  float squareZ = z*z;

  if (squareY + squareZ == 0) {
    return PI/2;
  }

  return atan(x/(sqrt(squareY + squareZ)));
}

void drawObjectPlane() {
  scale(20, 20);
  rotateX(PI);
  rotateY(PI/2);
  shape(plane);
}

void drawBasicPlane() {
  // draw main body in red
  fill(255, 0, 0, 200);
  box(10, 10, 200);


  // draw front-facing tip in blue
  fill(247, 255, 0, 200);//yellow
  pushMatrix();
  translate(0, 0, -120);
  rotateX(PI/2);
  drawCylinder(0, 20, 20, 8);
  popMatrix();


  // draw wings and tail fin in green
  fill(0, 0, 255, 200);
  beginShape(TRIANGLES);
  vertex(-100, 2, 30); 
  vertex(0, 2, -80); 
  vertex(100, 2, 30);  // wing top layer
  vertex(-100, -2, 30); 
  vertex(0, -2, -80); 
  vertex(100, -2, 30);  // wing bottom layer
  vertex(-2, 0, 98); 
  vertex(-2, -30, 98); 
  vertex(-2, 0, 70);  // tail left layer
  vertex( 2, 0, 98); 
  vertex( 2, -30, 98); 
  vertex( 2, 0, 70);  // tail right layer
  endShape();
  beginShape(QUADS);
  vertex(-100, 2, 30); 
  vertex(-100, -2, 30); 
  vertex(  0, -2, -80); 
  vertex(  0, 2, -80);
  vertex( 100, 2, 30); 
  vertex( 100, -2, 30); 
  vertex(  0, -2, -80); 
  vertex(  0, 2, -80);
  vertex(-100, 2, 30); 
  vertex(-100, -2, 30); 
  vertex(100, -2, 30); 
  vertex(100, 2, 30);
  vertex(-2, 0, 98); 
  vertex(2, 0, 98); 
  vertex(2, -30, 98); 
  vertex(-2, -30, 98);
  vertex(-2, 0, 98); 
  vertex(2, 0, 98); 
  vertex(2, 0, 70); 
  vertex(-2, 0, 70);
  vertex(-2, -30, 98); 
  vertex(2, -30, 98); 
  vertex(2, 0, 70); 
  vertex(-2, 0, 70);
  endShape();
}


void drawCylinder(float topRadius, float bottomRadius, float tall, int sides) {
  float angle = 0;
  float angleIncrement = TWO_PI / sides;
  beginShape(QUAD_STRIP);
  for (int i = 0; i < sides + 1; ++i) {
    vertex(topRadius*cos(angle), 0, topRadius*sin(angle));
    vertex(bottomRadius*cos(angle), tall, bottomRadius*sin(angle));
    angle += angleIncrement;
  }
  endShape();

  // If it is not a cone, draw the circular top cap
  if (topRadius != 0) {
    angle = 0;
    beginShape(TRIANGLE_FAN);

    // Center point
    vertex(0, 0, 0);
    for (int i = 0; i < sides + 1; i++) {
      vertex(topRadius * cos(angle), 0, topRadius * sin(angle));
      angle += angleIncrement;
    }
    endShape();
  }

  // If it is not a cone, draw the circular bottom cap
  if (bottomRadius != 0) {
    angle = 0;
    beginShape(TRIANGLE_FAN);

    // Center point
    vertex(0, tall, 0);
    for (int i = 0; i < sides + 1; i++) {
      vertex(bottomRadius * cos(angle), tall, bottomRadius * sin(angle));
      angle += angleIncrement;
    }
    endShape();
  }
}

void drawSoil() {
  translate(-width / 2, -height / 2);
  fill(19, 68, 24, 200);
  beginShape(QUADS);
  vertex(-200, 700);
  vertex(-200, 500);
  vertex(900, 500);
  vertex(900, 700);
  endShape();
} 

//x,y - upper left vertex
void drawObstacle(int x, int y, int w, int z, int h) {
  translate(0, 0, -z);
  fill(90, 90, 90, 200);
  rect(x, y, w, h);
}
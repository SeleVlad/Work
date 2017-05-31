// OpenCVApplication.cpp : Defines the entry point for the console application.
//

#include "stdafx.h"
#include "common.h"
#include <conio.h>
#include <vector>
#include <stdio.h>



Mat Color2Gray(Mat img)
{
	

		int height = img.rows;
		int width = img.cols;

		Mat dst = Mat(height,width,CV_8UC1);

		// Asa se acceseaaza pixelii individuali pt. o imagine RGB 24 biti/pixel
		// Varianta ineficienta (lenta)
		for (int i=0; i<height; i++)
		{
			for (int j=0; j<width; j++)
			{
				Vec3b v3 = img.at<Vec3b>(i,j);
				uchar b = v3[0];
				uchar g = v3[1];
				uchar r = v3[2];
				dst.at<uchar>(i,j) = (r+g+b)/3;
			}
		}
		
		//imshow("input image",img);
		//imshow("gray image",dst);
		//waitKey();

		return dst;
}

Mat convertRGBtoHSV(Mat img) {

	
	
		
		Mat h(img.rows, img.cols, CV_8UC1);
		Mat s(img.rows, img.cols, CV_8UC1);
		Mat v(img.rows, img.cols, CV_8UC1);

		//imshow("Original", img);

		float r, g, b, M, m, C;
		float H, S, V;

		float M1, m1;

		for (int i = 0; i < img.rows; i++)
		{
			for (int j = 0; j < img.cols; j++)
			{

				b = (float)img.at<Vec3b>(i, j)[0] / 255;
				g = (float)img.at<Vec3b>(i, j)[1] / 255;
				r = (float)img.at<Vec3b>(i, j)[2] / 255;

				M1 = max(r, g);
				M = max(M1, b);

				//M = max(r, g, b);

				m1 = min(r, g);
				m = min(m1, b);

				//m = min(r, g, b);
				C = M - m;


				//Value
				V = M;


				//Saturation
				if (C)
					S = C / V;
				else//Grayscale
					S = 0;


				if (C)
				{
					if (M == r)
						H = 60 * (g - b) / C;
					if (M == g)
						H = 120 + 60 * (b - r) / C;
					if (M == b)
						H = 240 + 60 * (r - g) / C;

				}
				else//Grayscale
					H = 0;
				if (H < 0)
					H = H + 360;

				//Normalizare
				h.at<uchar>(i, j) = H * 255 / 360;
				s.at<uchar>(i, j) = S * 255;
				v.at<uchar>(i, j) = V * 255;
			}
		}

		Mat imgHSV(img.rows, img.cols, CV_8UC3);
		std::vector<Mat> vect;

		vect.push_back(h);
		vect.push_back(s);
		vect.push_back(v);

		//IMAGINE HSV
		merge(vect, imgHSV);
		//imshow("imgHSV", imgHSV);


		//waitKey(0);

		return imgHSV;

}


Mat filterColors(Mat img)//Metoda folosind functii
{
	//Pastram doar pixelii albi si galbeni din imagine

	Mat imgHSV;
	//imgHSV = convertRGBtoHSV(img); //CONVERTU NU E ASA OK CA SI CEL DIN OPENCV , DIN GALBEN FACE PORTOCALIU
	cvtColor(img, imgHSV, cv::COLOR_BGR2HSV);


	Mat yellowFilter, whiteFilter;
	Mat res1,res2;
	Mat result;


	//input img low filter , high filter and dest
	inRange(img, cv::Scalar(200, 200, 200), cv::Scalar(255, 255, 255), whiteFilter);
	bitwise_and(img, img,res1, whiteFilter);
	

	//input img and filter
	//inRange(imgHSV2, cv::Scalar(90, 100, 100), cv::Scalar(110, 255, 255), yellowFilter);
	inRange(imgHSV, cv::Scalar(20, 100, 100), cv::Scalar(30, 255, 255), yellowFilter);
	bitwise_and(img, img, res2, yellowFilter);

	//Combina Imaginile , face blending
	addWeighted(res1, 1.0, res2, 1.0, 0.0, result);
	
	//imshow("Mask White", whiteFilter);
	//imshow("Mask Yellow", yellowFilter);
	//imshow("Final", result);
	//waitKey();

	return result;
}

Mat filterColors2(Mat img)//Metoda Manuala
{
	Mat imgHSV,dst;
	//imgHSV = convertRGBtoHSV(img);
	cvtColor(img, imgHSV, cv::COLOR_BGR2HSV);

	int h, s, v;
	int h2, s2, v2;

	dst = Mat::zeros(img.rows,img.cols, CV_8UC3);

	for (int i = 0; i < imgHSV.rows; i++)
	{
		for (int j = 0; j < imgHSV.cols; j++)
		{

			h = imgHSV.at<Vec3b>(i, j)[0];
			s = imgHSV.at<Vec3b>(i, j)[1];
			v = imgHSV.at<Vec3b>(i, j)[2];

			h2 = img.at<Vec3b>(i, j)[0];
			s2 = img.at<Vec3b>(i, j)[1];
			v2 = img.at<Vec3b>(i, j)[2];

			if ((h >= 20 && s >= 100 && v >= 100) && (h <= 30 && s <= 255 && v <= 255))
			{
				dst.at<Vec3b>(i, j) = imgHSV.at<Vec3b>(i, j);
			}
			else
				//if ((h >= 200 && s >= 200 && v >= 200) || (h <= 255 && s <= 255 && v <= 255))
				if ((h2 >= 200 && s2 >= 200 && v2 >= 200) && (h2 <= 255 && s2 <= 255 && v2 <= 255))

				{
					dst.at<Vec3b>(i, j) = img.at<Vec3b>(i, j);

				}
				else
				{
					dst.at<Vec3b>(i, j) = 0;
				}
		}
	}

	//imshow("Final", dst);
	//waitKey();

	return dst;
}

Mat regionOfInterst(Mat img)
{
	

	////x,y,width,height
	//Rect rec(330, 300, 420, 300);

	//in mat , rect,color,thickness,lnetype and shift pos
	//rectangle(img, rec, Scalar(255), 1, 8, 0);


	//return img;
	
	//now only keep the area selected
	//Mat roi = img(rec);

	//roi.copyTo(rez);
	//return roi;

	//make a black mask
	Mat mask = img.clone();
	mask.setTo(0);

	//vertices for poly
	std::vector<Point> roi_poli,roi_vert;

	roi_vert.push_back(Point(450,320));
	roi_vert.push_back(Point(600,320));
	roi_vert.push_back(Point(900,600));
	roi_vert.push_back(Point(100,600));

	//aprox a poly
	approxPolyDP(roi_vert, roi_poli, 1.0, true);

	//fill poly with white : img , points , inpts , color, line type and shift pos
	fillConvexPoly(mask, &roi_poli[0], roi_poli.size(), 255, 8, 0);

	//imshow("mask", mask);

	Mat imgD = Mat(img.rows, img.cols, CV_8UC3);
	bitwise_and(img, mask, imgD);

	//imshow("done", imgD);
	//waitKey();

	return imgD;
}


double Slope(int x0, int y0, int x1, int y1) {
	return (double)(y1 - y0) / (x1 - x0);
}

void fullLine(cv::Mat *img, cv::Point a, cv::Point b, cv::Scalar color) {
	double slope = Slope(a.x, a.y, b.x, b.y);

	Point p(0, 0), q(img->cols, img->rows);

	p.y = -(a.x - p.x) * slope + a.y;
	q.y = -(b.x - q.x) * slope + b.y;

	line(*img, p, q, color, 2, 8, 0);

}

Mat hough(Mat img, Mat img2)
{
	std::vector<Vec4i> lines;
	Mat cdst,dst;

	//make color to display the lines
	//cvtColor(img, cdst, CV_GRAY2BGR);

	//apply probabilistc hough lines 
	HoughLinesP(img, lines, 3, CV_PI/180, 15, 10, 10);//init 50 maxGap

	/*for (int i = 0; i < lines.size(); i++)
	{
		Vec4i l = lines[i];
		line(cdst, Point(l[0], l[1]), Point(l[2], l[3]), Scalar(0,0,255), 3, CV_AA);
	}
*/

	//for (int i = 0; i < lines.size(); i++)
	//{
	//	Vec4i l = lines[i];
	//	line(img2, Point(l[0], l[1]), Point(l[2], l[3]), Scalar(0,0,255), 3, CV_AA);
	//}

	//incercare de a trasa linii
	//std::vector<Point2f> points;
	//for each (Vec4i var in lines)
	//{
	//	points.push_back(Point2f(var[0], var[1]));
	//	points.push_back(Point2f(var[2], var[3]));

	//}
	//

	//Mat curve(points, true);
	//curve.convertTo(curve, CV_32S); //adapt type for polylines
	//polylines(img2, curve, false, Scalar(0, 0, 255), 3,CV_AA);

	Mat imgCopy = img2.clone();

	for (int i = 0; i < lines.size()-10; i++)//lines.size()/2
	{
		fullLine(&img2, Point(lines[i][0], lines[i][1]), Point(lines[i][2], lines[i][3]), Scalar(0, 0, 255));
	}

	//imshow("Hough", img2);
	//restaurare fotografie 
	for (int i = 0; i < imgCopy.rows/2 + imgCopy.rows / 8; i++)
	{
		for (int j = 0; j < imgCopy.cols; j++)
		{
			img2.at<Vec3b>(i, j) = imgCopy.at<Vec3b>(i, j);
		}
	}

	//imshow("Result", img2);
	//waitKey();
	return img2;
}



Mat colorRoad(Mat img)
{
	Mat img2 = img.clone();


		//for (int i = 0; i < img.rows; i++)
		//{
		//	bool red = false;
		//	bool first = true;

		//	for (int j = 0; j < img.cols; j++)
		//	{


		//		if (img.at<Vec3b>(i, j) == Vec3b(0, 0, 255))
		//		{
		//			if (j + 1 < img.cols)
		//			{
		//				if (img.at<Vec3b>(i, j + 1) != Vec3b(0, 0, 255))
		//				{
		//					
		//					if (first)
		//					{
		//						red = true;
		//						first = false;
		//					}
		//					else
		//						red = false;
		//				}
		//			}


		//		}

		//		if (red)
		//		{
		//			img.at<Vec3b>(i, j)[0] = 0;
		//			img.at<Vec3b>(i, j)[1] = 255;
		//			img.at<Vec3b>(i, j)[2] = 0;

		//		}
		//	}
		//}



	for (int i = 0; i < img.rows; i++)
	{
		bool red = false;
		bool first = true;

		int z = 0;

		for (int j = 0; j < img.cols; j++)
		{

			
			if (img.at<Vec3b>(i, j) == Vec3b(0, 0, 255))
			{
				
				red = true;

				if (z > 50)
					red = false;
			}

			

			if (red)
			{
				z++;
				img.at<Vec3b>(i, j)[0] = 0;
				img.at<Vec3b>(i, j)[1] = 255;
				img.at<Vec3b>(i, j)[2] = 0;

			}
		}
	}

	

	//imshow("Result Solid", img);

	double alpha = 0.3;
	addWeighted(img, alpha, img2, 1.0 - alpha, 0.0, img2);

	//imshow("Result Transparent", img2);
	return img2;
}


int main()
{
	//Deschidere Imagine
	char fname[MAX_PATH];
	openFileDlg(fname);
	Mat img2, dst, img;
	img = imread(fname, CV_LOAD_IMAGE_COLOR);
	dst = img.clone();
	img2 = img.clone();
	imshow("Original", img);

	//First Step , Filter Image Keep only White and Yellow pixels
	dst = filterColors(img);
	//dst = filterColors2(img);
//	imshow("Filter", dst);

	//Second Step , Convert Color to Gray
	cvtColor(dst, dst, COLOR_BGR2GRAY);
	//dst = Color2Gray(dst);
//	imshow("Gray", dst);

	//Third Step , Gaussian Smoothing ( Noise Kernel , Size 3)
	GaussianBlur(dst, dst, Size(3, 3),0,0 );
//	imshow("Gaussian Filter", dst);

	//Fourth Step , Canny Edge Detector , low trsh =50 , high trsh =120
	Canny(dst,dst,50,120);
//	imshow("Canny Edge", dst);

	//Apply ROI
	dst = regionOfInterst(dst);
//	imshow("ROI", dst);
	
	//Apply Hough Lines
	dst = hough(dst, img2);

	//Draw road color
	dst = colorRoad(dst);


	imshow("Final", dst);


	waitKey();
	return 0;
}
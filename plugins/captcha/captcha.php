<?php
    /**
     * Created by PhpStorm.
     * User: 81061
     * Date: 2016/4/9 0009
     * Time: 23:17
     */
    session_start();
    $image = imagecreatetruecolor(100, 30);
    $bgcolor = imagecolorallocate($image, 255, 255, 255);
    imagefill($image, 0, 0, $bgcolor);
    //imagefill($image2, 0, 0, $bgcolor);
//
//    for ($i = 0; $i < 4; $i++) {
//        $fontsize = 6;
//        $fontcolor = imagecolorallocate($image, rand(0, 120), rand(0, 120), rand(0, 120));
//        $fontcontent = rand(0, 9);
//
//        $x = ($i * 100 / 4) + rand(5, 10);
//        $y = rand(5, 10);
//
//        imagestring($image, $fontsize, $x, $y, $fontcontent, $fontcolor);
//    }

    $captch_code='';
    for($i=0;$i<4;$i++){
        $font=5;
        $fonttype='../../fonts/msyh.ttc';
        $fontcolor = imagecolorallocate($image, rand(50, 120), rand(50, 120), rand(50, 120));
        $data='abcdefghijklmnopqrstuvwxyz1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $fontcontent=substr($data,rand(0,strlen($data)-1),1);
        $captch_code.=$fontcontent;
        $x = ($i * 100 / 4) + rand(5, 10);
        $y = rand(16, 26);
        imagettftext($image,16,0,$x,$y,$fontcolor,$fonttype,$fontcontent);
        //imagestring($image, $fontsize, $x, $y, $fontcontent, $fontcolor);
    }
    $_SESSION['authcode']=strtolower($captch_code);
    for ($i=0;$i<200;$i++){
        $pointcolor=imagecolorallocate($image,rand(50,200),rand(50,200),rand(50,200));
        imagesetpixel($image,rand(1,99),rand(0,29),$pointcolor);
    }

    for ($i=0;$i<3;$i++){
        $linecolor=imagecolorallocate($image,rand(80,220),rand(80,220),rand(80,220));
        imageline($image,rand(1,99),rand(1,29),rand(1,99),rand(1,29),$linecolor);
    }
    //header('content-type:text/html');
    header('content-type:image/png');
    imagepng($image);
    imagedestroy($image);

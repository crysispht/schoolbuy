<?php
    /**
     * Created by PhpStorm.
     * User: 81061
     * Date: 2016/5/2 0002
     * Time: 9:44
     */


    include_once "../plugins/LaneWeChat/lanewechat.php";
    $timestamp = $_GET['timestamp'];
    $nonce = $_GET['nonce'];
    $token='schoolbuy';
    $signature=$_GET['signature'];
    $array=array($timestamp,$nonce,$token);
    sort($array);


    $tmpstr=implode($array);
    $tmpstr=sha1($tmpstr);

    if($tmpstr==$signature){
        return true;
    }else{
        return false;
    }
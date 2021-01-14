<?php
include "pdo.php";
header("Access-Control-Allow-Origin: *");



//查询数据库是否有记录  并且过期

$pdo = getPdo();
$sql = "select * from p_weather where w_city=".$A;
$res = $pdo->query($sql);
$data = $res->fetch(PDO::FETCH_ASSOC);

if($data){
    if($data['w_time']>time()){
        echo $data['info'];
        die;
    }
}


$url = 'https://devapi.qweather.com/v7/weather/now?location='.$A.'&key=577cef88286449eb9a5010194e9a2473';
$str = file_get_contents($url);
// print_r($str);die;
$result= gzdecode($str);
$sql = "delete from p_weather where w_city=".$A;
$pdo->exec($sql);

//添加新纪录
$w_time = time() + 1800;
$sql = "insert into p_weather ('w_city','w_info','w_time')values($A,'{$result}',$w_time)";
// var_dump($sql);die;
$pdo->exec($sql);

echo  $result;


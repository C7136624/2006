<?php
session_start();
include "pdo.php";
 $uid = $_GET['userid'];
 $pdo = getPdo();
 $q = "select * from p_users where user_id='$uid'";
 $res = $pdo->query($q);
 $d = $res->fetch(PDO::FETCH_ASSOC);
 
if (isset($_SESSION["name"]) && $_SESSION["name"] === true) {
    $response = [
        'errno' => 0,
        'msg'   => 'ok',
        'dta'=>$d
    ]; 
    unset($_SESSION['name']);
} else {  
    $response = [
        'errno' => 400012,
        'msg'   => '无权访问'
    ];
}
echo json_encode($response);



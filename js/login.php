<?php

    include "pdo.php";
    
    $pdo = getPdo();
    $name = $_POST['username'];     //用户名 Email Mobile
    $pass = $_POST['pass'];
    $q = "select user_id from p_users where user_name='$name'";
    $res = $pdo->query($q);
    $d = implode($res->fetch(PDO::FETCH_ASSOC));
     $_SESSION['name'] = null;
    setcookie('name',$name,time()+25200);
    setcookie('uid',$d,time()+25200);
        
    // 验证用户名是否存在
    $sql = "select * from p_users where user_name='{$name}' or email='{$name}' or mobile='{$name}'";
    $res = $pdo->query($sql);
    $data = $res->fetch(PDO::FETCH_ASSOC);
   
    if($data)       //查询到用户
    {
        //验证密码
        if(password_verify($pass,$data['password'])){       //密码正确 登录成功
            $response = [
                'errno' => 0,
                'msg'   => 'ok'
            ];
            session_start();
            $_SESSION["name"] = true;
        }else{  //密码不正确 登录失败
            $response = [
                'errno' => 400012,
                'msg'   => '密码不正确'
            ];
        }
    }else{
        $response = [
            'errno' => 400003,
            'msg'   => '用户名或密码错误'
        ];
    }


    echo json_encode($response);

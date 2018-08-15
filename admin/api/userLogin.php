<?php
    $email = $_POST['email'];
    $password = $_POST['password'];
    require_once '../../static/comment.php';
    $sql = "select * from users where email='$email' and password='$password' and status='activated'";
    $arr = query($sql);
    if($arr){
        $result['code'] = 1;
        $result['msg'] = '验证成功';
        session_start();
        $_SESSION['userInfo'] = $arr[0];
    } else{
        $result['code'] = 0;
        $result['msg'] = '验证失败'; 
    }
    echo json_encode($result);
?>
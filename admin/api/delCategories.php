<?php
    $categoryId = $_GET['categoryId'];
    $conn = mysqli_connect('localhost','root','root','baixiu');
    $sql = "delete from categories where id=$categoryId";
    $res = mysqli_query($conn,$sql);
    if($res){
        $result['code'] = 1;
        $result['msg'] = '操作成功';
    } else{
        $result['code'] = 0;
        $result['msg'] = '操作失败';
    }
    echo json_encode($result);
?>
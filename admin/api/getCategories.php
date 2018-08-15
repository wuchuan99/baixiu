<?php
    require_once '../../static/comment.php';
    $sql = "select * from categories ";
    $arr = query($sql);
    $result = array(
        "code" => 0,
        "msg" => "加载失败"
    );
    if($arr){
        $result['code'] = 1;
        $result['msg'] = "加载成功";
        $result['data'] = $arr;
    };
    echo json_encode($result);
?>
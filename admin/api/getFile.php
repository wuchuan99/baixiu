<?php
    $file = $_FILES['file'];
    $ext = strrchr($file['name'],'.');
    $fileName = time().rand(1000,9999).$ext;
    $res = move_uploaded_file($file['tmp_name'],'../../static/uploads/'.$fileName);
    if($res){
        $result['code'] = 1;
        $result['msg'] = '上传成功';
        $result['src'] = '/static/uploads/'.$fileName;
    } else{
        $result['code'] = 0;
        $result['msg'] = '上传失败';
    }
    echo json_encode($result);
?>
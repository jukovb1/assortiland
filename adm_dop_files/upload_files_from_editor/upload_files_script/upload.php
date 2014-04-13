<?php

    include "config.php";

if (isset($_FILES['file'])){
    $file_type = strtolower($_FILES['file']['type']);
    $name = strtolower($_FILES['file']['name']);
    $temp_ar_name = explode('.',$name);
    $exist = end($temp_ar_name);
    if ($file_type == 'image/png'
        || $file_type == 'image/jpg'
        || $file_type == 'image/gif'
        || $file_type == 'image/jpeg'
        || $file_type == 'image/pjpeg')
    {
        $date_r=date('YmdHis');
        copy($_FILES['file']['tmp_name'], IMAGES_ROOT.md5_file($_FILES['file']['tmp_name']).'.'.$exist);
        echo $files_path.'images/'.md5_file($_FILES['file']['tmp_name']).'.'.$exist;
    }
}

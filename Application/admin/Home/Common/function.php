<?php
/**
 * Created by PhpStorm.
 * User: guolixun
 * Date: 2017/5/9
 * Time: 15:55
 */
//文件上传函数
 function Upload($files){
     $default_config = array(
         'maxSize'   =>    '3145728' ,// 设置附件上传大小
         'exts'      =>     array('jpg', 'gif', 'png', 'jpeg'),// 设置附件上传类型
         'rootPath'  =>     './', // 设置附件上传根目录
         'savePath'  =>      'Public/Uploads/avatars/' // 设置附件上传（子）目录
     );

    $upload = new \Think\Upload($default_config);// 实例化上传类
    // 上传文件
    return $info   =   $upload->upload($files);
}

/*
 * 清除Runtime下的DATA和Cache中的缓存
 */
function CacheClear(){
    $fondorArr = array('DATA','Cache');
    foreach ($fondorArr as $v){
        $dh = opendir(TEMP_PATH.'/'.$v);
        while ($file = readdir($dh)) {
            if ($file != "." && $file != "..") {
                $fullpath = TEMP_PATH . "/" . $file;
                if (!is_dir($fullpath)) {
                    unlink($fullpath);
                } else {
                    deldir($fullpath);
                }
            }
        }
    }
}


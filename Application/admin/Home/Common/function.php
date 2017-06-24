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
 * 清除文件缓存(暂时支持后台即admin模块)
 */
function CacheClear($fileArr){
    foreach ($fileArr as $v){
       switch (strtoupper($v)){
           case 'DATA':
               _clear(DATA_PATH);
           case 'CACHE':
               _clear(CACHE_PATH);
           case 'LOGS':
               _clear(LOG_PATH);
           case 'TEMP':
               _clear(TEMP_PATH);
           default:
               _clear(CACHE_PATH);
       }
      }
}


/**
 * 删除目录及目录下所有文件或删除指定文件
 * @param str $path   待删除目录路径
 * @param int $delDir 是否删除目录，1或true删除目录，0或false则只删除文件保留目录（包含子目录）
 * @return bool 返回删除状态
 */
function _clear($path, $delDir = FALSE) {
    $handle = opendir($path);
    if ($handle) {
        while (false !== ( $item = readdir($handle) )) {
            if ($item != "." && $item != "..")
                is_dir("$path/$item") ? _clear("$path/$item", $delDir) : unlink("$path/$item");
        }
        closedir($handle);
        if ($delDir)
            return rmdir($path);
    }else {
        if (file_exists($path)) {
            return unlink($path);
        } else {
            return FALSE;
        }
    }
}



<?php
/**
 * 图片上传处理类
 * Created by PhpStorm.
 * User: guolixun
 * Date: 2017/5/8
 * Time: 14:03
 */
namespace Home\Controller;
use Think\Controller;
use Think\Upload;
class UploadController extends Controller{

    public function index()
    {
        $upload = new Upload();// 实例化上传类

//        'mimes'         =>  array(), //允许上传的文件MiMe类型
//        'maxSize'       =>  0, //上传的文件大小限制 (0-不做限制)
//        'exts'          =>  array(), //允许上传的文件后缀
//        'autoSub'       =>  true, //自动子目录保存文件
//        'subName'       =>  array('date', 'Y-m-d'), //子目录创建方式，[0]-函数名，[1]-参数，多个参数使用数组
//        'rootPath'      =>  './Uploads/', //保存根路径
//        'savePath'      =>  '', //保存路径
//        'saveName'      =>  array('uniqid', ''), //上传文件命名规则，[0]-函数名，[1]-参数，多个参数使用数组
//        'saveExt'       =>  '', //文件保存后缀，空则使用原后缀
//        'replace'       =>  false, //存在同名是否覆盖
//        'hash'          =>  true, //是否生成hash编码
//        'callback'      =>  false, //检测文件是否存在回调，如果存在返回文件信息数组
//        'driver'        =>  '', // 文件上传驱动
//        'driverConfig'  =>  array(), // 上传驱动配置


        $upload->maxSize   =     3145728 ;// 设置附件上传大小
        $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
        $upload->rootPath  =     WEBROOT_PATH.'/Public/Uploads/'; // 设置附件上传根目录
        $upload->savePath  =      '/avatars/'; // 设置附件上传（子）目录
        //$upload->autoSub = false;  // 关闭子目录

        // 上传文件
        $info   =   $upload->upload();
        if(!$info) {// 上传错误提示错误信息
            $this->error($upload->getError());
        }else{// 上传成功 获取上传文件信息
            $pathArr = array();
            foreach($info as $file){
                array_push($pathArr, "Uploads/".$file['savepath'].$file['savename']);
            }
            echo json_encode($pathArr);
        }

    }

}
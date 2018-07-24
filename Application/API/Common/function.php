<?php
/**
 * Created User: Administrator
 * Created Date: 2018/4/17 10:58
 * Current User:Administrator
 * History User:历史修改者
 * Description:这个文件主要做什么事情
 */
//对称加密
function f_Encrypt($string) {
    $skey = C('XCRYPT_KEY');
    $strArr = str_split(base64_encode($string));
    $strCount = count($strArr);
    foreach (str_split($skey) as $key => $value) {
        $key < $strCount && $strArr[$key] .= $value;
    }
    return str_replace(array('=', '+', '/'), array(
        'O0O0O',
        'o000o',
        'oo00o'
    ), join('', $strArr));
}

//对称解密
function f_Decrypt($string) {
    $skey = C('XCRYPT_KEY');
    $strArr = str_split(str_replace(array('O0O0O', 'o000o', 'oo00o'), array(
        '=',
        '+',
        '/'
    ), $string), 2);
    $strCount = count($strArr);
    foreach (str_split($skey) as $key => $value) {
        $key <= $strCount && isset($strArr[$key]) && $strArr[$key][1] === $value && $strArr[$key] = $strArr[$key][0];
    }
    return base64_decode(join('', $strArr));
}

function checkMobile($mobile){
    if(preg_match("/^1[34578]\d{9}$/", $mobile)){
        return true;
    }
    return false;
}

/**
 * 生成随机数
 * @param int $len
 * @param null $chars
 * @return string
 */
function getRandString($len=6, $chars=null)
{
    if(is_null($chars)){
        $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    }else{
        $chars = '0123456789';
    }
    mt_srand(10000000*(double)microtime());
    for($i=0,$str='',$lc=strlen($chars)-1;$i<$len;$i++){
        $str.=$chars[mt_rand(0,$lc)];
    }
    return $str;
}

/**
 * 获取亿美短信服务对象
 * @return \Common\ThirdSDK\Emay
 */
//function getEmay() {
//    import('ThirdSDK.Emay', APP_PATH . 'Common/Common');
//    return \Common\ThirdSDK\Emay::getInstance();
//}


/**
 * 获取订单号，算法规则待定
 * @return string
 */
//function getOrderId() {
//    return getMicrotime();
//}

/**
 * 获取毫秒级时间戳
 * @return int
 */
//function getMicrotime() {
//    list ($usec, $sec) = explode(" ", microtime());
//    return (( int ) ($usec * 1000) + ( float ) $sec * 1000) . '';
//}

/**
 * 写入短信发送记录
 */
//function writeSMSLog($data) {
//    $data['send_body_name'] = '系统自动';
//    array_walk($data['mobile'], function ($val) use ($data) {
//        $data['phone'] = $val;
//        D('Student/SmsSend')->addSms($data);
//    });
//}
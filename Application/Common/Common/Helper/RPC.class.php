<?php
/**
 * 
 * Created by PhpStorm.
 * User: xiao
 * Date: 2016年11月3日
 * Time: 上午10:48:29
 * 
 * 时间助手类
 * 
 * @author 刘志淳 <chun@engineer.com>
 * @link https://github.com/top-think/think-helper/blob/master/src/Time.php
 * @copyright thinkphp
 */

namespace Common\Common\Helper;

class RPC
{
    public static function http($url, $method = 'GET', $data = null)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TTMEOUT, 2);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        if($method != 'GET' && isset($data)){
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        }
        $info = curl_exec($ch);
        curl_close($ch);
        $jsonInfo = json_decode($info, true);
        if(empty($jsonInfo)){
            throw new \LogicException("请求数据空");
        }
        return $jsonInfo;
    }

    public static function postDataCurl($url, $header, $data=array()){
        if(is_array($data)){
            $json=json_encode($data);
        }else{
            $json=$data;
        }
        //dump($json);
        $timeout = 5000;
        $ch = curl_init();
        curl_setopt ($ch, CURLOPT_URL, $url);
        curl_setopt ($ch, CURLOPT_POST, 1);
        curl_setopt ($ch, CURLOPT_POSTFIELDS, $json);
        curl_setopt ($ch, CURLOPT_HEADER, false);
        curl_setopt ($ch, CURLOPT_HTTPHEADER,$header);
        curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER,false);
        curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);

        $result = curl_exec($ch);
        if (false === $result) {
            $result =  curl_errno($ch);
          echo 'Curl error: ' . curl_error($ch);
        }
        curl_close($ch);
        return json_decode($result,true) ;
    }

}

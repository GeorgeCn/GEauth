<?php
/**
 * 第三方sdk配置信息
 * Created by PhpStorm.
 * User: yuan
 * Date: 2016/9/27
 * Time: 12:24
 */
$host = $_SERVER['HTTP_HOST'];
if(in_array($host,C('onlineHost'))){
    return array(
        //七牛配置信息
        'QINIU' => array(
            //七牛AK
            'accessKey' => 'DE-X5JveaPjaIT6fj7pl8R6atW9FpbBvxWBXCGYa',
            //七牛SK
            'secretKey' => 'xezpDLhYNN20dPXu2qScDnK1e1xw2OM21hHr95kl',
            //七牛域名
          'domain' => 'courseware.uuabc.com/',
          'bucket' => 'uuabc-east-china',
          'domain_temp' => 'temp.uuabc.com/',
          'bucket_temp' => 'uuabc-temp',
          'bucket_domain' => 'www.uuabc.com',
          'protocol'   => 'https://',
        ),
        //亿美配置信息
        'EMAY' => array(
            //网关地址
            'gwUrl' => 'http://hprpt2.eucp.b2m.cn:8080/sdk/SDKService?wsdl',
            'gwUrlForPopu' => 'http://sdktaows.eucp.b2m.cn:8080/sdk/SDKService?wsdl',
            //签名
            'signature' => '【优氏英语】',
            // 序列号,请通过亿美销售人员获取
            //密码,请通过亿美销售人员获取
            'serialNumber' => '8SDK-EMY-6699-RKQPP',//通知使用序列号
            'password' => '109044',//通知使用密码，特服号884504
            'serialNumberForPopu' => '6SDK-EMY-6666-RJTTS',//推广使用序列号
            'passwordForPopu' => '109118',//推广使用密码，特服号684660 
            //字符集，与ide设置一致
            'charSet' => 'UTF-8',
            //连接超时时间，单位为秒
            'connectTimeOut' => '2',
            //远程信息读取超时时间，单位为秒
            'readTimeOut' => '10',
            //可选，代理服务器地址，默认为 false ,则不使用代理服务器
            'proxyhost' => false,
            //可选，代理服务器端口，默认为 false
            'proxyport' => false,
            //可选，代理服务器用户名，默认为 false
            'proxyusername' => false,
            //可选，代理服务器密码，默认为 false
            'proxypassword' => false,
        ),
    );
}else{
    return array(
        //七牛配置信息
        'QINIU' => array(
            //七牛AK
            'accessKey' => 'DE-X5JveaPjaIT6fj7pl8R6atW9FpbBvxWBXCGYa',
            //七牛SK
            'secretKey' => 'xezpDLhYNN20dPXu2qScDnK1e1xw2OM21hHr95kl',
            //七牛域名
            'domain' => 'uutest2.uuabc.com/',
            'bucket' => 'uutest2',
            'domain_temp' => 'uutest.uuabc.com/',
            'bucket_temp' => 'uutest',
            'bucket_domain' => 'dev.uuabc.com',
            'protocol'   => 'https://',
        ),
        //亿美配置信息
        'EMAY' => array(
            //签名
            'signature' => '【优氏英语】',
            //网关地址
            'gwUrl' => 'http://hprpt2.eucp.b2m.cn:8080/sdk/SDKService?wsdl',
            // 序列号,请通过亿美销售人员获取
            'serialNumber' => '8SDK-EMY-6699-RKQPP',//通知使用序列号
            //密码,请通过亿美销售人员获取
            'password' => '109044',//通知使用密码，特服号884504
            //字符集，与ide设置一致
            'charSet' => 'UTF-8',
            //连接超时时间，单位为秒
            'connectTimeOut' => '2',
            //远程信息读取超时时间，单位为秒
            'readTimeOut' => '10',
            //可选，代理服务器地址，默认为 false ,则不使用代理服务器
            'proxyhost' => false,
            //可选，代理服务器端口，默认为 false
            'proxyport' => false,
            //可选，代理服务器用户名，默认为 false
            'proxyusername' => false,
            //可选，代理服务器密码，默认为 false
            'proxypassword' => false,
        ),
    );
}

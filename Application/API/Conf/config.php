<?php
/**
 * Created User: wangkun
 * Created Date: 2018/3/19 下午4:35
 * Current User:wangkun
 * History User:wangkun
 * Description:这个文件主要做什么事情
 */
return [
    'RETURN_CODE' => [
        '200' => '成功',

        // 账户（权限）相关错误
        '300' => '您还未登录',
        '301' => '登录信息失效，请重新登录',
        '302' => '您无此操作权限',
        '303' => '账号或者密码错误',
        '304' => '手机号无效',
        '305' => '验证码有误',
        '306' => '发送验证码失败',
        '307' => '手机号已经存在',

        //数据操作相关错误
        '400' => '数据服务失败',
        '401' => '数据库操作失败',
        '402' => '数据库查询失败',

        //参数问题
        '500' => '参数缺失',
        '501' => '必填参数为空',

        //自定义
        //'999' => '自定义错误',
    ],
    'SMS_CONTENT' => [
        'Common' => '亲爱的%username%，UU哥提示您：您的手机验证码为%smsCode%，请在十分钟内完成验证。如非本人操作，请勿理会哦!',
    ],
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
];
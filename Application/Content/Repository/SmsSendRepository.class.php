<?php

namespace Content\Repository;

use Think\Cache\Driver\Redis;

class SmsSendRepository
{
    private $Redis;
    private $SmsSend;

    public function __construct()
    {
        $this->Redis = new Redis();
        $this->SmsSend = D('Content/SmsSend');
    }

    /**
     * 发送验证码
     * @param $phone
     * @param $content
     * @param $code
     * @param $type 0--默认 1--注册（SMS_Registered + 手机号） 2--找回密码（SMS_RetrievePassword + 手机号）,3--登录（SMS_Login + 手机号）
     */
    public function sendSms($phone, $content, $code, $type = 0)
    {
        if (empty($phone)) {
            throw new \LogicException('手机号码为空');
        }
        if (empty($content)) {
            throw new \LogicException('发送内容为空');
        }
        $emay = getEmay();
        $data['mobile'] = $phone;
        $data['content'] = $content;
        $data['order_id'] = getOrderId();
        $request = $emay->sendSMS($data);
        //if($request && $type > 0){
        if ($type > 0) {
            $redis = new Redis();
            if ($type == 1) {
                $name = C('SMS_RedisRegistered') . $phone;
            } elseif ($type == 2) {
                $name = C('SMS_RedisRetrievePassword') . $phone;
            }elseif ($type == 3) {
                $name = C('SMS_Login') . $phone;
            }

            $redis->set($name, $code, 600);
        }
    }

    /**
     * * 验证码验证
     * @param $phone
     * @param $code
     * @param int $type 0--默认 1--注册（Registered + 手机号） 2--找回密码（RetrievePassword + 手机号）,3--登录（SMS_Login + 手机号）
     * @return bool
     */
    public function checkCode($phone, $code, $type = 0)
    {
        $request['status'] = 0;
        $request['msg'] = '';
        /*if($type == 0){
            preg_match_all('/\d+/',$this->SmsSend->getFind(['phone'=>$phone])['content'],$verification);
            if(end($verification[0]) == $code){
                $request['status'] = 1;
                $request['msg'] = '验证码正确';
            }
        }*/
        if (!$code) {
            $request['msg'] = '验证码不能为空';
            return $request;
        }
        if ($type == 1) {
            $name = C('RedisRegistered') . $phone;
        } elseif ($type == 2) {
            $name = C('RedisRetrievePassword') . $phone;
        }elseif ($type == 3) {
            $name = C('SMS_Login') . $phone;
        }
        $redisCode = $this->Redis->get($name);
        if ($redisCode) {
            if ($redisCode == $code) {
                //$this->Redis->del($name);
                $request['status'] = 1;
                $request['msg'] = '验证码正确';
            } else {
                $request['msg'] = '验证码错误';
            }
            return $request;
        } else {
            preg_match_all('/\d+/', $this->SmsSend->getFind(['phone' => $phone])['content'], $verification);
            if (end($verification[0]) == $code) {
                $request['msg'] = '验证码已失效';
            } else {
                $request['msg'] = '验证码错误';
            }
        }
        return $request;
    }
}

<?php
/**
 * Created by PhpStorm.
 * User: yuan
 * Date: 2016/9/28
 * Time: 10:08
 */
namespace Common\Lib;
/**
 * 引入亿美的Client文件
 */
define('SCRIPT_ROOT', dirname(__FILE__) . '/');
require_once SCRIPT_ROOT . 'Emay/include/Client.php';

class Emay
{
    static private $instance;
    private $sessionKey = '123456';
    private $config;
    private $Emay;

    private function __construct()
    {
        $config = C('EMAY');
        $this->config = $config;
        $this->Emay = new \Client($config['gwUrl'], $config['serialNumber'], $config['password'], $config['sessionKey'], $config['proxyhost'], $config['proxyport'], $config['proxyusername'], $config['proxypassword'], $config['connectTimeOut'], $config['readTimeOut']);
        $this->Emay->setOutgoingEncoding($config['charSet']);
        $this->login();
    }

    public function __clone()
    {
        exit;
        // TODO: Implement __clone() method.
    }

    static public function getInstance()
    {
        if (!(self::$instance instanceof self)) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    private function login()
    {
        $statusCode = $this->Emay->login($this->sessionKey);
        $this->sessionKey = $this->Emay->getSessionKey();
    }

    /**
     * 短信发送  (注:此方法必须为已登录状态下方可操作)
     * @param array $data
     * @param mixed $data['mobile'] 手机号,如果需要多个手机号群发,如 array('159xxxxxxxx','159xxxxxxx2')
     * @param string $data['content'] 短信内容
     * @param int $data['level'] 优先级,1-5依次提高优先级,默认5
     * @param int $data['order_id'] 信息序列ID(唯一的正整数)
     * @return int 操作结果状态码
     */

    public function sendSMS(array $data)
    {
        $mobile = $data['mobile'];
        if(!is_array($mobile)){
            $mobile = array($mobile);
            $data['mobile'] = $mobile;
        }
        if(empty($data['level'])){
            $data['level'] = 3;
        }
        $data['content'] = $this->config['signature'].$data['content'];
        if(!empty(C('sendSms'))){
          $data['response'] = $this->Emay->sendSMS($mobile, $data['content'], '', '', $this->config['charSet'], $data['level'], $data['order_id']);
          writeSMSLog($data);
        }else{
          $data['response'] = 0;
          writeSMSLog($data);
        }

        return $data['response'];
    }

}
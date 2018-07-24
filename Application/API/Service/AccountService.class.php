<?php
/**
 * Created User: wangkun
 * Created Date: 2018/3/19 下午5:11
 * Current User:wangkun
 * History User:wangkun,
 * Description:这个文件主要做什么事情
 */

namespace API\Service;

use API\Common\BaseService;
use Think\Cache\Driver\Redis;
use Content\Repository\ProxyAdminRepository;

class AccountService extends BaseService
{
    private $stuRepo;
    private $dealerRepo;

    public function __construct()
    {
        parent::__construct();
        $this->dealerRepo = new ProxyAdminRepository();
    }

    /**
     * @param $phone
     * @param bool $unique 是否检查手机号在数据库是否已经存在
     * @return array
     * @author wangkun
     * @description: 检查手机号是否符合规则
     */
    public function checkPhone($phone, $unique=false)
    {
        if (!checkMobile($phone)){
            return $this->served(0,'手机号有误',304);
        }
        $repoD = $this->dealerRepo->getProxyInfo(['phone'=>$phone]);
        if ($repoD['code']==1001){
            return$this->served(1);
        }
        if ($repoD['code']!=1000){
            return $this->served(0,$repoD['msg']);
        }
        if ($unique && $repoD['data']['id']){
            return $this->served(0,'手机号已经存在',307);
        }
        return $this->served(1);
    }

    /**
     * @param $phone
     * @param $smsCode
     * @author wangkun
     * @return bool
     * @description:检查短信验证码是否正确
     */
    public function checkSmsCode($phone, $smsCode, $template='Common')
    {
        $redis = new Redis();
        $key = 'smsCode_'.$template.'_'.$phone;
        if ($smsCode == $redis->get($key)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param $phone
     * @param $smsCode
     * @return array
     * @author wangkun
     * @description:检查手机号在数据库中是否存在，存在则返回id，前提是短信验证码正确
     */
    public function checkAccount($phone, $smsCode)
    {
        if ($this->checkSmsCode($phone, $smsCode)){
            $userId = $this->dealerRepo->getProxyInfo(['phone'=>$phone]);
            if ($userId['code']==1000){
                if ($userId['data']['status']!=1){
                    return $this->served(0,'请等待审核');
                }
                $userId = $userId['data']['id'];
            }elseif($userId['code']==1001) {
                return $this->served(0,'当前手机号并没有注册');
            }else{
                return $this->served(0);
            }
            return $this->served(1,'',$userId);
        }else{
            return $this->served(0,'手机号或验证码有误');
        }
    }

    /**
     * @param $data
     * @return array
     * @author wagnkun
     * @description: 完成注册相关的操作
     */
    public function setReg($data)
    {
        $data = [
            'name' => $data['name'],
            'phone' => $data['phone'],
            'channel' => $data['channel'],
            'status' => 2
        ];
        $servD = $this->dealerRepo->addRow($data);
        return $servD;
//        if ($servD['code']==1000){
//            return $this->served(1,'',$servD['data']['id']);
//        }else{
//            return $this->served(0);
//        }
    }

    /**
     * @param $userId
     * @return array
     * @author wangkun
     * @description: 完成登录相关的操作
     */
    public function setLogin($userId)
    {
        //生成token
        $token = $this->setToken($userId);
        return $this->served(1,'',$token);
    }

    /**
     * @param string $phone 需要替换的内容 支持
     * @param string $template 短信模板
     * @author wangkun
     * @return array
     * @description:发送短信
     */
    public function sendSms($phone, $template='Common')
    {
        $content = C('SMS_CONTENT.'.$template);
        $smsCode = getRandString(6, 1);
        $username = substr($phone, -4);
        $content = str_replace('%smsCode%', $smsCode, $content);
        $content = str_replace('%username%', $username, $content);
        //调用第三方接口发短信
        $emay = getEmay();
        $data['mobile'] = $phone;
        $data['content'] = $content;
        $data['order_id'] = getOrderId();
        $request = $emay->sendSMS($data);


        //不验证易美是否发送成功
        $key =  'smsCode_'.$template.'_'.$phone;
        $redis = new Redis();
        $redis->set($key,$smsCode,600);
        return $this->served(1);

//        if ($request){
//            $key =  'smsCode_'.$template.'_'.$phone;
//            $redis = new Redis();
//            $redis->set($key,$smsCode,600);
//            return $this->served(1);
//        }else{
//            //临时放置，for测试
//            $key =  'smsCode_'.$template.'_'.$phone;
//            $redis = new Redis();
//            $redis->set($key,$smsCode,600);
//            return $this->served(0,'为测试零时放置的验证码');
//        }
    }

    /**
     * @param $userId
     * @return bool|string
     * @author wangkun
     * @description:这个方法做了什么
     */
    private function setToken($userId)
    {
        if(!$userId){
            return false;
        }
        $token = md5(time().'USER_TOKEN');
        $value = f_Encrypt($userId);
        $redis = new Redis();
        if(!$redis->exists($token)){
            $redis->set($token,$value,3600*24*30);
        }
        return $token;
    }

    /**
     * 删除pad/iphone用户登录标示
     * @param  [type] $string [description]
     * @return [type]         [description]
     */
    private function delPadUser($string,$tag=''){
        $redis = new Redis();
        $user = f_Decrypt(str_replace($tag,'',$string));
        $key = $this->PadUserKey . $tag . $user;
        $redis->del($key);
    }
}
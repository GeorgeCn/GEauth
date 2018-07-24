<?php
/**
 * Created User: wangkun
 * Created Date: 2018/3/18 下午11:53
 * Current User:wangkun
 * History User:历史修改者
 * Description: 账号
 */

namespace API\Controller;

use API\Common\ApiController;
use API\Service\AccountService;
use API\Service\DealerService;
use Think\Cache\Driver\Redis;

class AccountController extends ApiController
{
    private $accountServ;
    private $dealerServ;

    public function __construct()
    {
        parent::__construct();
        $this->accountServ = new AccountService();
        $this->dealerServ = new DealerService();
    }

    /**
     * @author 作者
     * @description:代理人账户财务信息
     */
    public function finance()
    {
        $year = $this->params['year'] ? $this->params['year'] : date('Y');
        $this->quickRes($this->dealerServ->getFinance($this->userId, $year));
    }

    /**
     * @author 作者
     * @description:保存用户信息接口
     */
    public function savePersonal()
    {
        $this->needParams(['bankPlace', 'bankAccount']);
        $this->quickRes($this->dealerServ->saveInfo($this->userId, [
            'bank_account_open' => $this->params['bankPlace'],
            'bank_account' => $this->params['bankAccount']
        ]));
    }

    /**
     * @author wangkun
     * @description:获取用户信息接口
     */
    public function personal()
    {
        $info = $this->quickD($this->dealerServ->getInfo($this->userId));
        $this->res(200,$info);
    }

    /**
     * @author 作者
     * @description:代理人登录接口
     */
    public function login()
    {
        $this->needParams(['phone', 'smsCode']);
        //验证手机号的合法性、验证码
        $dealerId = $this->checkServ($this->accountServ->checkAccount($this->params['phone'],$this->params['smsCode']));
        if ($dealerId){
            $token = $this->quickD($this->accountServ->setLogin($dealerId));
            $this->res(200,['token'=>$token]);
        }else{
            $this->res(305);
        }
    }

    /**
     * @author 作者
     * @description:代理人注册接口
     */
    public function reg()
    {
        $this->needParams(['name','phone','channel','smsCode']);
        $this->checkServ($this->accountServ->checkPhone($this->params['phone'], true));
        if ($this->accountServ->checkSmsCode($this->params['phone'],$this->params['smsCode'])){
            //判断是否是后台导入的 -> status==2 && phone==''
            $dealerInfo = $this->quickD($this->dealerServ->getInfo('',['name'=>$this->params['name'], 'channel'=>$this->params['channel']]));
            if($dealerInfo['status']==2 && $dealerInfo['phone']==''){
                //后台导入的，加手机号即可完成注册
                $id = $dealerInfo['dealerId'];
                $this->dealerServ->saveInfo($id, ['phone'=>$this->params['phone'], 'status'=>1]);
                $token = $this->quickD($this->accountServ->setLogin($id));
                return $this->res(201,['token'=>$token]);
            }else{
                //非后台导入注册的代理人,不给token
                $id = $this->quickD($this->accountServ->setReg($this->params));
                //$token = $this->quickD($this->accountServ->setLogin($id));
                return $this->res(200);
            }
        }else{
            $this->res(305);
        }
    }

    /**
     * @author wangkun
     * @description:发送短信验证码接口
     */
    public function sendSms()
    {
        $this->needParams(['phone']);
        //验证手机号的合法性、
        $this->checkServ($this->accountServ->checkPhone($this->params['phone']  ));
        $this->quickRes($this->accountServ->sendSms($this->params['phone']),306);
    }

    public function logout()
    {
        $this->needParams(['token']);
        $redis = new Redis();
        $redis->del($this->params['token']);
        $this->res(200);
    }

    public function forgot()
    {

    }

    public function changePwd()
    {

    }
}
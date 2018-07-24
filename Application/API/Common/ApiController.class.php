<?php
/**
 * Created User: wangkun
 * Created Date: 2018/3/19 下午4:11
 * Current User:wangkun
 * History User:wangkun
 * Description:控制器基类
 */

namespace API\Common;

use Think\Controller;
use Think\Cache\Driver\Redis;

class ApiController extends Controller
{
    protected $params;
    protected $userId;

    //配置不需要登录的页面
    private $loginNoNeed = [
        'Account' => ['login', 'reg', 'sendSms'],
        'Channel' => ['tree'],
    ];

    public function __construct()
    {
        parent::__construct();
        $this->initParams();    //初始化类属性
        $this->checkLogin();    //检查登录
    }

    /**
     * @param array $params 需要检查的参数
     * @param bool $needNotEmtpy 是否需要参数为非空 true:需要 false:不需要
     * @author wangkun
     * @description:检查必须的参数，如果没有，则直接返回错误信息给调用者
     */
    protected function needParams($params, $needNotEmtpy=true)
    {
        $emptyFlag = false;
        foreach ($params as $p) {
            if (!array_key_exists($p    , $this->params)) {
                $this->res(500);
            }elseif ($needNotEmtpy && empty($this->params[$p])){
                $emptyFlag = true;
            }
        }
        if ($emptyFlag){
            $this->res(501);
        }
    }

    protected function optionalParams($params)
    {

    }

    /**
     * @param array $arr 选填的参数
     * @return array
     * @author wangkun
     * @description:将选填参数提取出来，并且将驼峰写法转为下划线写法
     */
    protected function loadOptional($arr)
    {
        $data = [];
        array_walk($arr, function (&$val) use(&$data) {
            if (array_key_exists($val, $this->params)) {
                $key = preg_replace_callback("/[A-Z]/", function($ma){return "_".strtolower($ma[0]);},  $val);
                $data[$key] = $this->params[$val];
            }
        });
        return $data;
    }

    /**
     * @param string $code 状态码
     * @param mixed $data 需要返回的数据
     * @param string $msg 需要返回的提示消息
     * @author wangkun
     * @description: 以统一格式返回数据
     */
    protected function res($code, $data = '', $msg = '')
    {
        $msg = empty($msg) ? C('RETURN_CODE.' . $code) : $msg;
        header('Content-Type:application/json; charset=utf-8');
        exit(json_encode(['code' => $code, 'msg' => $msg, 'data' => $data]));
    }

    protected function quickRes($servData,$code=400, $msg='')
    {
        if ($servData['status']) {
            if (empty($servData['data'])){
                $this->res(200,[]);
            }else{
                $this->res(200, $servData['data']);
            }
        } else {
            $this->res($code,$servData['data']);
        }
    }

    /**
     * @param $servData
     * @param int $code
     * @return mixed
     * @author wagnkun
     * @description:快速拿出service返回数据中的data，如果有误则直接返回给调用者失败信息
     */
    protected function quickD($servData, $code = 400)
    {
        if ($servData['status']) {
            return $servData['data'];
        } else {
            $this->res($code);
        }
    }

    /**
     * @param array $servData service返回的数据
     * @author wangkun
     * @return string
     * @description:检查service返回的数据是否通过，不通过返回给调用者失败原因
     */
    protected function checkServ($servData)
    {
        if ($servData['status']==0){
            $code = $servData['data'] ? $servData['data'] : 999;
            $this->res($code,'',$servData['msg']);
        }else{
            return $servData['data'];
        }
    }

    /**
     * @author wangkun
     * @description:初始化类属性
     */
    private function initParams()
    {
        $this->params = $this->pickInputs();
        //$this->params['token'] = 'MPTAEDx_NUgUO0O0OAO0O0OB';
        $this->userId = array_key_exists('token',
            $this->params) ? $this->getUserId($this->params['token']) : 0;
        //$this->userId = 1095;
        //$this->userId = 1952;
    }

    /**
     * @return mixed
     * @author wangkun
     * @description:接收传递给接口的参数
     */
    private function pickInputs()
    {
        $post = I('request.');
        $json = json_decode(file_get_contents("php://input"), true);
        if ($json){
            $post = array_merge($post,$json);
        }   
        return $post;
    }

    /**
     * @param $token
     * @param string $tag 用于兼容pad4.0版本以下登录接口产生的token。为空表示pad，iphone表示iPhone
     * @return bool|string  string：用户id，false：无效的token
     * @author wangkun
     * @description:根据token获取用户id
     */
    private function getUserId($token, $tag='')
    {
        $redis = new Redis();
        if ($redis->get($token)){
            $value = $redis->get($token);
            $userId = f_Decrypt($value);
            return $userId;
        }else{
            return false;
        }
    }

    /**
     * @author wangkun
     * @description: 检查用户登录状态
     */
    private function checkLogin()
    {
        if (!in_array(ACTION_NAME, $this->loginNoNeed[CONTROLLER_NAME])) {
            if ($this->userId === false) {
                $this->res(301);    //token失效
            } elseif ($this->userId === 0) {
                $this->res(300);    //未登录
            }
        }
    }
}
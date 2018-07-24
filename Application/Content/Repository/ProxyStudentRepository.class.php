<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/13
 * Time: 10:54
 */

namespace Content\Repository;

class ProxyStudentRepository
{
    //ProxyStudentModel
    private $proxyStudent;

    public function __construct()
    {
        $this->proxyStudent = D('Content/ProxyStudent');
    }


    /*************************** Model 映射方法 Start ********************************/

    /**
     * 添加
     */
    public function addRow($data)
    {
        return $this->proxyStudent->addRow($data);
    }


    /**
     * 编辑
     */
    public function saveRow($data, $where = [])
    {
        return $this->proxyStudent->saveRow($data, $where);
    }


    /**
     * 获取单条数据
     */
    public function getRow($where, $field = '*')
    {
        return $this->proxyStudent->getRow($where, $field);
    }


    /**
     * 获取多条数据
     */
    public function getAll($where, $field = '*', $order = '')
    {
        return $this->proxyStudent->getAll($where, $field, $order);
    }


    /**
     * 获取数量
     */
    public function getCount($where = [])
    {
        return $this->proxyStudent->getCount($where);
    }

    /*************************** Model 映射方法 End **********************************/

    /**
     * @param $proxy_id int 代理id
     * @param $channel_id string 渠道id逗号隔开的字符串 因为有子渠道
     * @param $activity_id int 活动id
     * @return int 数量
     * @author zhangchao
     * @description:获取学生注册数
     */
    public function getRegisterStudentCount(
        $proxy_id = 0,
        $channel_id = '',
        $activity_id = 0
    ) {
        //定义返回数据格式
        $return = [
            'code' => 1000,
            'msg' => 'ok',
            'data' => []
        ];

        $where = [];

        if ($proxy_id) {
            $where['proxy_id'] = $proxy_id;
        }

        if ($channel_id) {
            $where['channel'] = ['in',$channel_id];
        }

        if ($activity_id) {
            $where['activity_id'] = $activity_id;
        }

        $return['data'] = $this->getCount($where);

        return $return;
    }


    /**
     * @param $proxy_id int 代理id
     * @param $channel_id string 渠道id逗号隔开的字符串 因为有子渠道
     * @param $activity_id int 活动id
     * @return int 数量
     * @author zhangchao
     * @description:获取开课学生数
     */
    public function getOpenCourseStudentCount(
        $proxy_id = 0,
        $channel_id = '',
        $activity_id = 0
    ) {
        //定义返回数据格式
        $return = [
            'code' => 1000,
            'msg' => 'ok',
            'data' => []
        ];

        $where = [];

        if ($proxy_id) {
            $where['proxy_student.proxy_id'] = $proxy_id;
        }

        if ($channel_id) {
            $where['proxy_student.channel'] = ['in',$channel_id];
        }

        if ($activity_id) {
            $where['proxy_student.activity_id'] = $activity_id;
        }

        //开课的条件
        $where['ac.course_type'] = 3;
        $where['ac.status'] = 3;
        $where['ac.disabled'] = 0;

        $return['data'] = $this->proxyStudent
            ->join("appoint_course as ac on ac.student_user_id=proxy_student.stu_id",
                "left")
            ->where($where)->count();

        return $return;
    }


    /**
     * @param $proxy_id int 代理id
     * @param $channel_id string 渠道id逗号隔开的字符串 因为有子渠道
     * @param $activity_id int 活动id
     * @return int 数量
     * @author zhangchao
     * @description:获取参加活动的付费学生数
     */
    public function getPayStudentCount(
        $proxy_id = 0,
        $channel_id = '',
        $activity_id = 0
    ) {
        //定义返回数据格式
        $return = [
            'code' => 1000,
            'msg' => 'ok',
            'data' => []
        ];

        $where = [];

        if ($proxy_id) {
            $where['proxy_student.proxy_id'] = $proxy_id;
        }

        if ($channel_id) {
            $where['proxy_student.channel'] = ['in',$channel_id];
        }

        if ($activity_id) {
            $where['proxy_student.activity_id'] = $activity_id;
        }

        //付费学生的条件
        $where['su.type'] = 2;

        $return['data'] = $this->proxyStudent
            ->join("student_user as su on su.id=proxy_student.stu_id", "left")
            ->where($where)->count();

        return $return;
    }


    /**
     * @param $proxy_id int 代理id
     * @param $channel_id string 渠道id逗号隔开的字符串 因为有子渠道
     * @param $activity_id int 活动id
     * @param $student_id int 学生id
     * @return float 付款总金额
     * @author zhangchao
     * @description:付款总金额
     */
    public function getPayStudentSumMoney(
        $proxy_id = 0,
        $channel_id = '',
        $activity_id = 0,
        $student_id = 0
    ) {
        //定义返回数据格式
        $return = [
            'code' => 1000,
            'msg' => 'ok',
            'data' => []
        ];

        $where = [];

        if ($proxy_id) {
            $where['ps.proxy_id'] = $proxy_id;
        }

        if ($channel_id) {
            $where['ps.channel'] = ['in',$channel_id];
        }

        if ($activity_id) {
            $where['ps.activity_id'] = $activity_id;
        }

        if ($student_id) {
            $where['ps.stu_id'] = $student_id;
        } else {
            //要统计所有proxy_student里面的学生的付款总额
            //如果不加这个条件限制 当统计所有活动学生的时候就变成统计所有contract_payment里面的数据了
            $where['ps.stu_id'] = ['gt', 0];
        }

        //合同付费记录 成功的条件
        $where['cp.is_success'] = 2;

        /*
         * amount 订单实际支付总额 包括代金券
         */
        $field = 'SUM(case when (cp.card_coupons_detail_id>0 and cp.card_coupons_status=0) then (cp.amount-cp.card_coupons_fee) else cp.amount end) as amount';

        $amount = M('contract_payment as cp')
            ->field($field)
            ->join("contract as c on c.id=cp.contract_id", "left")
            ->join("proxy_student as ps on ps.stu_id=c.student_id", "left")
            ->where($where)->find();

        $return['data'] = ($amount && $amount['amount']) ? $amount['amount'] : '0';

        return $return;
    }


    /**
     * @param $proxy_id int 代理id
     * @param $channel_id string 渠道id逗号隔开的字符串 因为有子渠道
     * @param $activity_id int 活动id
     * @return int 数量
     * @author zhangchao
     * @description:付费转化率
     */
    public function getPayStudentRate(
        $proxy_id = 0,
        $channel_id = '',
        $activity_id = 0
    ) {
        //定义返回数据格式
        $return = [
            'code' => 1000,
            'msg' => 'ok',
            'data' => []
        ];

        //获取学生注册数
        $registerStudentCount = $this->getRegisterStudentCount($proxy_id,
            $channel_id, $activity_id);

        //获取付费学生数
        $payStudentCount = $this->getPayStudentCount($proxy_id, $channel_id,
            $activity_id);

        $return['data'] = $registerStudentCount == 0 ? 0 : sprintf('%.2f',
            $payStudentCount / $registerStudentCount);

        return $return;
    }

    /**
     * 根据代理商获取我推广的学生信息
     * @param string $dealerId 代理商id
     * @param string $stuName 学生名字
     * @param string $phone 手机号码
     * @param string $startTime 开始时间
     * @param string $endTime 结束时间
     * @return array
     */
    public function getProxyStudent(
        $dealerId = "",
        $stuName = "",
        $phone = "",
        $startTime = "",
        $endTime = ""
    ) {
        $where['proxy_student.proxy_id'] = $dealerId;
        if ($stuName) {
            $where['student_user.name'] = ['like', '%' . $stuName . '%'];
        }
        if ($phone) {
            $where['student_user.phone'] = $phone;
        }
        if ($startTime) {
            $where['student_user.create_time'] = ['EGT', utctime($startTime)];
        }
        if ($endTime) {
            $where['student_user.create_time'] = ['ELT', utctime($endTime)];
        }
        $field = 'student_user.id,student_user.type,student_user.name,student_user.phone,activity.title,student_user.create_time';
        $proxyStudents = $this->proxyStudent->getProxyStudent($field, $where);

        if ($proxyStudents) {
            $contractRpst = new ContractRepository();
            $appointCourseRpst = new AppointCourseRepository();
            foreach ($proxyStudents as &$value) {

                if ($value['type'] == 2) {
                    $payment = $contractRpst->getRow([
                        'student_id' => $value['id'],
                        'is_del' => 1,
                        'status' => ['in',[4,5]],
                    ], 'sucess_at', false, 'sucess_at ASC');
                    $value['paymentDate'] = $payment['sucess_at'] + 8 * 3600;
                } else {
                    $value['paymentDate'] = '';
                }

                $appointCourse = $appointCourseRpst->getRow([
                    'student_user_id' => $value['id'],
                    'course_type' => 3,
                    'status' => 3,
                ], 'start_time', false, 'start_time ASC');
                if($appointCourse){
                    $value['openDate'] = $appointCourse['start_time'] + 8 * 3600;
                } else {
                    $value['openDate'] = '';
                }
                $value['activityName'] = $value['title'];
                $value['regDate'] = $value['create_time'] + 8 * 3600;
                unset($value['title']);
                unset($value['create_time']);
                unset($value['id']);
                unset($value['type']);
            }
            $result = [
                'code' => 1000,
                'msg' => '查询成功',
                'data' => $proxyStudents,
            ];
        } else {
            $result = [
                'code' => 1001,
                'msg' => '没有数据',
                'data' => ['count' => 0, 'student' => []],
            ];
        }

        return $result;
    }

}
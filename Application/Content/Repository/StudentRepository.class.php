<?php
namespace Content\Repository;


class StudentRepository extends BaseRepository
{
    
    public function __construct()
    {
        $this->model = D('Content/Student');
    }

    /**
     * @param string $type 1-注册、2-付费、3-开课
     * @param string $agentIDs 代理ID数组
     * @param string $channel 智慧、优氏渠道
     * @param string $startTime 注册时间开始
     * @param string $endTime 注册时间结束
     * @param string $limit 分页
     * @return array 结果数组
     */
    public function getStudentData($type="", $agentIDs="", $channel="", $startTime="", $endTime="",$limit="")
    {
        $count = $this->model->getStudentStatisticsCount($type, $agentIDs, $channel, $startTime, $endTime);
        $student = $this->model->getStudentStatistics($type, $agentIDs, $channel, $startTime, $endTime,$limit);

        if($student){
            $ContractRpst = new ContractRepository();
            foreach ($student as &$value){
                //付费学生首付金额
                if($value['stu_type'] == 2){
                    $value['stu_type_name'] = '付费';
                    $payment = $ContractRpst->getStudentFirstAmount($value['stu_id']);
                    $value['payment'] = formatMoney($payment);
                }elseif($value['stu_type'] == 3){
                    $value['stu_type_name'] = '开课';
                    $value['payment'] = '';
                }else{
                    $value['stu_type_name'] = '注册';
                    $value['payment'] = '';
                }
            }
            $result = [
                'code'=> 1000,
                'msg'=> '查询成功',
                'data'=>['count'=>$count,'student'=>$student],
            ];
        }else{
            $result = [
                'code'=> 1001,
                'msg'=> '没有数据',
                'data'=> ['count'=>0,'student'=>[]],
            ];
        }

        return $result;
    }
}
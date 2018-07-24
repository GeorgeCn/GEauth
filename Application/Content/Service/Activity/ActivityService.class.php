<?php
/**
 * [学生管理 Service]
 * @Author   George              
 * @DateTime 2018-04-16T10:23:08+0800
 */
namespace Content\Service\Activity;
use Content\Service\BaseService;
use Content\Repository\ProxyActivityChannelRepository;
use Content\Repository\ProxyStudentRepository;
use Content\Repository\ProxyAdminRepository;

class ActivityService extends BaseService
{
    private $stuRep;

    public function __construct()
    {
        parent::__construct();
        $this->actRep = new ProxyActivityChannelRepository();
        $this->stuRep = new  ProxyStudentRepository();
    }

    /**
     * [获取用户基本信息]
     * @param int $userId 学生用户信息
     * @author George
     * @return array
     */
    public function getActivityData($startTime, $endTime, $activityID, $activityName, $agentName, $channelID, $limit)
    {
        $dataArr = array();
        //表头字段+样式
        $thead = array(
            array(
                'name'  => '活动名称',
                'field' => 'activity_id',
                'width' => '60',
                'order' => 'desc'
            ),
            array(
                'name'  => '代理名称',
                'field' => 'name',
                'width' => '90',
                'order' => ''
            ),
            array(
                'name'  => '来源',
                'field' => 'channel_id',
                'width' => '90',
                'order' => ''
            ),
            array(
                'name'  => '注册领取数',
                'field' => 'registerStudentCount',
                'width' => '90',
                'order' => ''
            ),
            array(
                'name'  => '开课数',
                'field' => 'openCourseStudentCount',
                'width' => '90',
                'order' => ''
            ),
            array(
                'name'  => '付费转化数',
                'field' => 'payStudentCount',
                'width' => '90',
                'order' => ''
            ),
            array(
                'name'  => '付费金额',
                'field' => 'payStudentSumMoney',
                'width' => '90',
                'order' => ''
            ),
        );
        $dataArr['thead'] = $thead;

        if($activityName) {
            $activityFinalID = getActivityIDByName($activityName);
            if(!$activityFinalID) {
                $dataArr['tbody'] = []; 
                $dataArr['count'] = 0;
                return $dataArr;
            }
        }
        if($activityID) {
            $activityFinalID = $activityID;
        }
        $agentIDs = 0;
        if (!empty($agentName)) {
            $admRep = new ProxyAdminRepository();
            $agentIDs = $admRep->getProxyAdminIds($agentName);
            if(!$agentIDs) {
                $dataArr['tbody'] = []; 
                $dataArr['count'] = 0;
                return $dataArr;
            }
        }
        if(!empty($startTime)) {
            $startTime = strtotime($startTime .' - 8 hours');
        }
        if(!empty($endTime)) {
            $endTime = strtotime($endTime .' - 8 hours');
        }
        $field = 'activity_id,name,channel_id';
        $actData = $this->actRep->getProxyActivityList($activityFinalID, $agentIDs, $channelID, $startTime, $endTime, 2, $limit, $field);
        if(1000 == $actData['code'] && !empty($actData['data'])) {
            foreach ($actData['data'] as $key=>$val) {
                $actData['data'][$key]['registerStudentCount']=$this->stuRep->getRegisterStudentCount($val['pid'])['data'];
                $actData['data'][$key]['openCourseStudentCount']=$this->stuRep->getOpenCourseStudentCount($val['pid'])['data'];
                $actData['data'][$key]['payStudentCount']=$this->stuRep->getPayStudentCount($val['pid'])['data'];
                $money = $this->stuRep->getPayStudentSumMoney($val['pid'])['data'];
                $actData['data'][$key]['payStudentSumMoney']=formatMoney($money);
                $actData['data'][$key]['activity_id']=getActivityNameById($val['activity_id']);
                $actData['data'][$key]['channel_id']=getChannelNameById($val['channel_id']);
            }
            $dataArr['tbody'] = $actData['data']; 
            $dataArr['count'] = $actData['count'];
        } else {
            $dataArr['tbody'] = []; 
            $dataArr['count'] = 0;
        }

        return $dataArr;
    }
}
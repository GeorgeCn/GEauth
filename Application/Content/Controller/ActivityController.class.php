<?php
/**
 * [后台活动管理]
 * @Author   George                   <[<923143925@qq.com>]>
 * @DateTime 2018-04-19T19:20:26+0800
 * @return   [type]                   [description]
 */
namespace Content\Controller;
use Content\Service\Activity\ActivityService;
use Common\Common\Helper\ExcelWriter;

class ActivityController extends PublicController
{
    private $actService;

    public function __construct()
    {
        parent::__construct();
        $this->actService = new ActivityService();
    }

    public function lists()
	{
        $startTime = I('post.start_time');
        $endTime = I('post.end_time');
        $activityID = I('post.activity_id', 0,'intval');
        $activityName = I('post.activity_name');
        $agentName = I('post.agent_name');
        $channelID = I('post.channel_id');
        $num = C('PAGENUM');
        $currentPage = I('post.currentPage', 1, 'intval');
        $dataArr = $this->actService->getActivityData($startTime, $endTime, $activityID, $activityName, $agentName, $channelID, ($currentPage - 1) * $num . "," . $num);
        $list = self::_page($dataArr['count'], $num);
        $list['thead'] = $dataArr['thead'];
        $list['tbody'] = $dataArr['tbody'];
        if(IS_POST){
            $list['statusCode'] = 200;
            $list['message'] = '操作成功';
            die(json_encode($list));
        }

        self::_channelList('ChannelList','渠道分类','level ASC', 'channel_list');
        $this->assign('lists', json_encode($list));
        $this->display();
	}

    /**
     * [一键导出活动 Excel]
     * @Author   George  
     * @DateTime 2018-04-17T11:36:57+0800
     * @return   [type]                   [description]
     */
    public function activityExcel()
    {
        $startTime = I('post.start_time');
        $endTime = I('post.end_time');
        $activityID = I('post.activity_id');
        $agentName = I('post.agent_name');
        $channelID = I('post.channel_id');
        $dataArr = $this->actService->getActivityData($startTime, $endTime, $activityID, $agentName, $channelID, '');
        $data = $dataArr['tbody'];
        $excel = array();
        $header = [
            'activity_id' => '活动名称',
            'name' => '代理名称',
            'channel_id' => '来源',
            'registerStudentCount' => '注册领取数',
            'openCourseStudentCount' => '开课数',
            'payStudentCount' => '付费转化数',
            'payStudentSumMoney' => '付费金额',
        ];
        $excel[] = $header;
        foreach($data as $key =>$value) {
                $temp['activity_id'] = $value['activity_id'];
                $temp['name'] = $value['name'];
                $temp['channel_id'] = $value['channel_id'];
                $temp['registerStudentCount'] = $value['registerStudentCount'];
                $temp['openCourseStudentCount'] = $value['openCourseStudentCount'];
                $temp['payStudentCount'] = $value['payStudentCount'];
                $temp['payStudentSumMoney'] = $value['payStudentSumMoney'];
                $excel[] = $temp;
        }

        $writer = new ExcelWriter();
        if ($writer->writeDocument($excel)) {
            $name = '活动信息列表' . date('Y-m-d H:i:s');
            $fileName = $writer->saveDocument();
            if (!empty($fileName)) {
                $writer->downDocument($name, 'xls');
            }
        };
    }
}
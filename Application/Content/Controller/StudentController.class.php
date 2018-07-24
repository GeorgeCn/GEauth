<?php
/**
 * [学生管理 Controller]
 * @Author   George              
 * @DateTime 2018-04-16T10:23:08+0800
 */
namespace Content\Controller;
use Content\Service\Student\StudentService;
use Common\Common\Helper\ExcelWriter;

class StudentController extends PublicController
{
    private $stuService;

    public function __construct()
    {
        parent::__construct();
        $this->stuService = new StudentService();
    }
	
    /**
     * [后台学生管理列表]
     * @Author   George     
     * @DateTime 2018-04-17T17:48:38+0800
     * @return   [type]                   [description]
     */
    public function lists()
	{
        $type = I('post.type');
        $startTime = I('post.start_time');
        $endTime = I('post.end_time');
        $agentName = I('post.agent_name');
        $channelID = I('post.channel_id');
        $num = C('PAGENUM');
        $currentPage = I('post.currentPage', 1, 'intval');
        $dataArr = $this->stuService->getStudentData($type, $startTime, $endTime, $agentName, $channelID, ($currentPage - 1) * $num . "," . $num);
        $list = self::_page($dataArr['count'], $num);
        $list['thead'] = $dataArr['thead'];
        $list['tbody'] = $dataArr['tbody'];
        if(IS_POST){
            $list['statusCode'] = 200;
            $list['message'] = '操作成功';
            die(json_encode($list));
        }

        self::_channelList('ChannelList','优胜教育','level ASC', 'channel_list');
        $this->assign('lists', json_encode($list));
		$this->display();
	}

	/**
     * [一键导出学生 Excel]
     * @Author   George  
     * @DateTime 2018-04-17T11:36:57+0800
     * @return   [type]                   [description]
     */
    public function studentExcel()
    {
        $type = I('post.type');
        $startTime = I('post.start_time');
        $endTime = I('post.end_time');
        $agentName = I('post.agent_name');
        $channelID = I('post.channel_id');
        $dataArr = $this->stuService->getStudentData($type, $startTime, $endTime, $agentName, $channelID, '');
        $data = $dataArr['tbody'];
        $excel = array();
        $header = [
            'stu_id' => '学生ID',
            'proxy_name' => '代理名称',
            'channel_name' => '来源',
            'stu_name' => '学生姓名',
            'stu_phone' => '手机号码',
            'stu_type_name' => '学生类型',
            'payment' => '付费金额',
        ];
        $excel[] = $header;
        foreach($data as $key =>$value) {
            unset($value['stu_type']);
            $excel[] = $value;
        }

        $writer = new ExcelWriter();
        if ($writer->writeDocument($excel)) {
            $name = '学生信息列表' . date('Y-m-d H:i:s');
            $fileName = $writer->saveDocument();
            if (!empty($fileName)) {
                $writer->downDocument($name, 'xls');
            }
        };
    }
}
<?php
/**
 * [学生管理 Controller]
 * @Author   George              
 * @DateTime 2018-04-16T10:23:08+0800
 */
namespace Content\Controller;
use Content\Service\Reward\RewardService;
use Common\Common\Helper\ExcelWriter;

class RewardController extends PublicController
{
    private $rewService;

    public function __construct()
    {
        parent::__construct();
        $this->rewService = new RewardService();
    }

	/**
     * [后台奖金管理列表]
     * @Author   George
     * @DateTime 2018-04-16T16:58:26+0800
     * @return   [type]                   [description]
     */
    public function lists()
	{
        //增加保持操作
        $toolsOptionArr = array(
                array('保存',2,'保存奖金','rewsave', U('rewSave'), '你确认要保存奖金吗？'),
                array('发送到前台',2,'发送到前台','rewshow', U('rewShow'), '你确认要发送到前台吗？'),
            );
        $toolsOption = self::_listBut($toolsOptionArr);
        $month = I('post.month');
        $agentName = I('post.agent_name');
        $channelID = I('post.channel_id');
        $num = C('PAGENUM');
        $currentPage = I('post.currentPage', 1, 'intval');
        $dataArr = $this->rewService->getRewardData($month, $agentName, $channelID, ($currentPage - 1) * $num . "," . $num, $toolsOption);
        $list = self::_page($dataArr['count'], $num);
        $list['toolsOption'] = $dataArr['toolsOption'];
        $list['thead'] = $dataArr['thead'];
        $list['tbody'] = $dataArr['tbody'];
        if(IS_POST){
            $list['statusCode'] = 200;
            $list['message'] = '操作成功';
            die(json_encode($list));
        }
        self::_channelList('ChannelList','优胜教育','level ASC', 'channel_list');
        $this->assign('lists', json_encode($list));
        $this->assign('date', date('Y-m-d'));
		$this->display();
	}

    /**
     * [奖金导出Excel]
     * @Author   George  
     * @DateTime 2018-04-17T11:36:57+0800
     * @return   [type]                   [description]
     */
    public function rewardExcel()
    {
        $month = I('post.month');
        $agentName = I('post.agent_name');
        $channelID = I('post.channel_id');
        $dataArr = $this->rewService->getRewardData($month, $agentName, $channelID, '');
        $data = $dataArr['tbody'];
        $excel = array();
        $header = [
            'month' => '月份',
            'id' => '代理ID',
            'proxy_name' => '代理名称',
            'channel_name' => '渠道名称',
            'sum_money' => '应发金额',
            'deduct_money' => '扣无效数据',
            'tax_money' => '扣个税',
            'actual_money' => '实发金额',
            'comment' => '备注'
        ];
        $excel[] = $header;
        foreach($data as $key =>$value) {
                $temp['month'] = $value['month'];
                $temp['id'] = $value['id'];
                $temp['proxy_name'] = $value['proxy_name'];
                $temp['channel_name'] = $value['channel_name'];
                $temp['sum_money'] = $value['sum_money'];
                $temp['deduct_money'] = $value['deduct_money'];
                $temp['tax_money'] = $value['tax_money'];
                $temp['actual_money'] = $value['actual_money'];
                $temp['comment'] = $value['comment'];
                $excel[] = $temp;
        }
        $writer = new ExcelWriter();
        if ($writer->writeDocument($excel)) {
            $name = '代理奖金列表' . date('Y-m-d H:i:s');
            $fileName = $writer->saveDocument();
            if (!empty($fileName)) {
                $writer->downDocument($name, 'xls');
            }
        };
    }

    /**
     * [保存奖金]
     * @Author   George        
     * @DateTime 2018-04-20T14:37:24+0800
     * @return   [type]                   [description]
     */
    public function rewSave() 
    {
        $data['month'] = I('post.month');
        $data['proxy_id'] = I('post.proxy_id');
        $data['sum_money'] = I('post.sum_money');
        $data['deduct_money'] = I('post.deduct_money');
        $data['tax_money'] = I('post.tax_money');
        $data['actual_money'] = I('post.actual_money');
        $data['comment'] = I('post.comment');
        $rewData = $this->rewService->saveRewardData($data);
        if (1000 == $rewData['code']) {
            $this->ajaxReturn(['status'=>1000, 'msg'=>'操作成功']);
        } 
        $this->ajaxReturn(['status'=>1001, 'msg'=>'操作失败']);
    }

    /**
     * [更改奖金显示状态]
     * @Author   George        
     * @DateTime 2018-04-20T14:37:24+0800
     * @return   [type]                   [description]
     */
    public function rewShow() 
    {
        $id = I('post.id');
        $data['id'] = $id;
        $rewData = $this->rewService->showRewardData($data);
        if (1000 == $rewData['code']) {
            $this->ajaxReturn(['status'=>1000, 'msg'=>'操作成功']);
        } 
        $this->ajaxReturn(['status'=>1001, 'msg'=>'操作失败']);
    }
}
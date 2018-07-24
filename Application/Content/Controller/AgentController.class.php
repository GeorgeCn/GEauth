<?php
/**
 * [代理管理 Controller]
 * @Author   George    
 * @DateTime 2018-04-18T10:37:56+0800
 */
namespace Content\Controller;
use Content\Service\ProxyAdmin\ProxyAdminService;
use Common\Common\Helper\ExcelWriter;

class AgentController extends PublicController
{
    private $ageService;

    public function __construct()
    {
        parent::__construct();
        $this->ageService = new ProxyAdminService();
    }

	/**
     * [后台代理管理列表]
     * @Author   George       
     * @DateTime 2018-04-18T10:40:05+0800
     * @return   [type]                   [description]
     */
    public function lists()
	{
        //添加代理按钮 暂时不做
        // $but = array(
        //     array(
        //         'url'   => 'agedit',
        //         'name'  => '添加代理库',
        //         'title' => '添加代理',
        //         'type'  => 1
        //     ),
        // );
        // self::isBut($but);
        //添加新增编辑按钮
        $status = I('post.status', 2, 'intval');
        if(2 == $status) {
            $toolsOptionArr = array(
                array('添加',2,'添加代理','agemove', U('agejoin', array('id' => '___id___', 'status' => 1)), '你确认要添加吗？'),
            );
        } else {
            $toolsOptionArr = array(
                array('查看',4,' 查看代理','catInfo', U('catInfo', array('id' => '___id___'))),
                array('移出',2,'移出代理','agemove', U('agemove', array('id' => '___id___', 'status' => 2)), '你确认要移出吗？'),
                array('删除',2,'删除代理','agedel', U('agedel', array('id' => '___id___', 'status' => 0)), '你确认要删除吗？'),
            );
        }
        $toolsOption = self::_listBut($toolsOptionArr);

        $startTime = I('post.start_time');
        $endTime = I('post.end_time');
        $agentName = I('post.agent_name');
        $channel = I('post.channel');
        $channelID = I('post.channel_id');
        $phone = I('post.agent_phone');
        $num = C('PAGENUM');
        $currentPage = I('post.currentPage', 1, 'intval');
        $dataArr = $this->ageService->getProxyAdminList($agentName, $channelID, $startTime, $endTime, $status, $phone, ($currentPage - 1) * $num . "," . $num, $toolsOption);
        $list = self::_page($dataArr['count'], $num);
        $list['toolsOption'] = $dataArr['toolsOption'];
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
     * [查看代理详情]
     * @Author   George       
     * @DateTime 2018-04-19T09:50:29+0800
     * @return   [type]                   [description]
     */
    public function catInfo()
    {
        $agentID = I('get.id');
        $dataArr = $this->ageService->catProxyAdminInfo($agentID);
        $list['toolsOption'] = $dataArr['toolsOption'];
        $list['thead'] = $dataArr['thead'];
        $list['tbody'] = $dataArr['tbody'];

        $this->assign('lists', json_encode($list));
        $this->display();
    }

    /**
     * [代理添加]
     * @Author   George   
     * @DateTime 2018-04-18T13:37:17+0800
     * @return   [type]                   [description]
     */
    public function agejoin()
    {
        $id = I('get.id',0,'intval');
        $status = I('get.status',0,'intval');
        $res = $this->ageService->updateProxyAdminStatus($id, $status);

        if ($res) {
            $this->error('操作成功');
        }
        $this->error('操作失败');
    }
    /**
     * [代理移出]
     * @Author   George   
     * @DateTime 2018-04-18T13:37:17+0800
     * @return   [type]                   [description]
     */
    public function agemove()
    {
        $id = I('get.id',0,'intval');
        $status = I('get.status',0,'intval');
        $res = $this->ageService->updateProxyAdminStatus($id, $status);

        if ($res) {
            $this->error('操作成功');
        }
        $this->error('操作失败');
    }
    /**
     * [代理删除]
     * @Author   George   
     * @DateTime 2018-04-18T13:37:17+0800
     * @return   [type]                   [description]
     */
    public function agedel()
    {
        $id = I('get.id',0,'intval');
        $status = I('get.status',0,'intval');
        $res = $this->ageService->updateProxyAdminStatus($id, $status);

        if ($res) {
            $this->error('操作成功');
        }
        $this->error('操作失败');
    }

    /**
     * [一键导出代理 Excel]
     * @Author   George 
     * @DateTime 2018-04-18T11:14:49+0800
     * @return   [type]                   [*.xcl文件]
     */
    public function agentExcel()
    {
        $status = I('post.status');
        $startTime = I('post.start_time');
        $endTime = I('post.end_time');
        $agentName = I('post.agent_name');
        $channel = I('post.channel');
        $channelID = I('post.channel_id');
        $phone = I('post.agent_phone');
        $dataArr = $this->ageService->getProxyAdminList($agentName, $channelID, $startTime, $endTime, $status, $phone,'');
        $data = $dataArr['tbody'];
        $excel = array();
        $header = [
            'id' => '代理ID',
            'name' => '代理名称',
            'phone' => '手机号码',
            'channel' => '来源',
            'registerStudentCount' => '注册领取数',
            'openCourseStudentCount' => '开课数',
            'payStudentCount' => '付费转化数',
            'payStudentSumMoney' => '付费金额',
        ];
        $excel[] = $header;
        foreach($data as $key =>$value) {
                $excel[] = $value;
        }

        $writer = new ExcelWriter();
        if ($writer->writeDocument($excel)) {
            $name = '代理人员列表' . date('Y-m-d H:i:s');
            $fileName = $writer->saveDocument();
            if (!empty($fileName)) {
                $writer->downDocument($name, 'xls');
            }
        };
    }
    /**
     * [一键导入代理 Excel]
     * @Author   George
     * @DateTime 2018-04-18T11:14:49+0800
     * @return   [type]                   [*.xcl文件]
     */
    public function agentUpload()
    {
        if(!$_FILES['upfile']){
            $this->error('文件错误');
        }
        $result = $this->ageService->importProxyAdmin($_FILES['upfile']);
        $array = array(
            'statusCode' => 200,
            'message'    => '成功',
            'data'    => $result,
        );
        die(json_encode($array));
        
    }
    public function info(){
        echo phpinfo();
    }
}
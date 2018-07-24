<?php
/**
 * [学生管理 Service]
 * @Author   George              
 * @DateTime 2018-04-16T10:23:08+0800
 */
namespace Content\Service\Channel;
use Content\Repository\ChannelListRepository;

class ChannelService
{
    private $chaRep;

    public function __construct()
    {
        $this->chaRep = new ChannelListRepository();
    }

    /**
     * [获取用户基本信息]
     * @param int $userId 学生用户信息
     * @author George
     * @return array
     */
    public function getStudentData($type, $startTime, $endTime, $agentName, $channelID, $limit)
    {
        $dataArr = array();
        //表头字段+样式
        $thead = array(
            array(
                'name'  => '序号',
                'field' => 'id',
                'width' => '80',
                'order' => 'desc'
            ),
            array(
                'name'  => '学生类型',
                'field' => 'stu_type',
                'width' => '120',
                'order' => ''
            ),
            array(
                'name'  => '代理名称',
                'field' => 'proxy_name',
                'width' => '120',
                'order' => ''
            ),
            array(
                'name'  => '渠道名称',
                'field' => 'channel_name',
                'width' => '120',
                'order' => ''
            ),
            array(
                'name'  => '学生姓名',
                'field' => 'stu_name',
                'width' => '120',
                'order' => ''
            ),
            array(
                'name'  => '学生电话',
                'field' => 'stu_phone',
                'width' => '120',
                'order' => ''
            ),
            array(
                'name'  => '付费类型',
                'field' => 'payment',
                'width' => '120',
                'order' => ''
            ),
        );
        $dataArr['thead'] = $thead;

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
        $stuData = $this->stuRep->getStudentData($type, $agentIDs, $channelID, $startTime, $endTime,$limit);
        if(1000 == $stuData['code'] && !empty($stuData['data'])) {
            $dataArr['tbody'] = $stuData['data']['student']; 
            $dataArr['count'] = $stuData['data']['count'];
        } else {
            $dataArr['tbody'] = []; 
            $dataArr['count'] = 0;
        }
        
        return $dataArr;
    }
}
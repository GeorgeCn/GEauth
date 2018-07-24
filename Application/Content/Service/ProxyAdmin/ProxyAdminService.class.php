<?php
namespace Content\Service\ProxyAdmin;

use Common\Common\Helper\ExcelRead;
use Content\Repository\ChannelListRepository;
use Content\Service\BaseService;
use Content\Repository\ProxyAdminRepository;
use Content\Repository\ProxyStudentRepository;

class ProxyAdminService extends BaseService
{
    private $proxyAdmin;

    public function __construct()
    {
        parent::__construct();
        $this->admRep = new ProxyAdminRepository();
        $this->stuRep = new  ProxyStudentRepository();
    }

    public function getProxyAdminList(
        $proxy_name = '',
        $channel_id = 0,
        $start_time = 0,
        $end_time = 0,
        $status = 2,
        $phone = 0,
        $limit = '0,10',
        $toolsOption = null
    ) {
        $dataArr = array();
        //表头字段+样式
        $thead = array(
            array(
                'name'  => 'ID',
                'field' => 'id',
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
                'name'  => '手机',
                'field' => 'phone',
                'width' => '90',
                'order' => ''
            ),
            array(
                'name'  => '来源',
                'field' => 'channel',
                'width' => '90',
                'order' => '',
                'attribute' => 'title'
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
            array(
                'name'  => '操作',
                'width' => '80',
                'field' => '__TOOLS',
                'type'  => 'TOOLS'
            ),
        );
        foreach ($thead as $key => $value) {
            if(empty($toolsOption) && $value['field'] == '__TOOLS'){
                unset($thead[$key]);
            }
        }
        $dataArr['toolsOption'] = $toolsOption;
        $dataArr['thead'] = $thead;

        $proxy_id = 0;
        if (!empty($proxy_name)) {
            $proxyData = $this->admRep->getProxyAdminIds($proxy_name);
            if(1000 == $proxyData['code'] && !empty($proxyData['data'])) $proxy_id = $proxyData['data'];
            if(!$proxy_id){
                $dataArr['tbody'] = []; 
                $dataArr['count'] = 0;
                return $dataArr;
            } 
        }
        if(!empty($start_time)) {
            $start_time = strval(strtotime($start_time .' - 8 hours'));
        }
        if(!empty($end_time)) {
            $end_time = strval(strtotime($end_time .' - 8 hours'));
        }

        $field = 'id,name,phone,channel';
        $admData = $this->admRep->getProxyAdminList($proxy_id, $channel_id, $start_time, $end_time, $status, $phone, $limit, $field);

        if(1000 == $admData['code'] && !empty($admData['data'])) {
            foreach ($admData['data'] as $key=>$val) {
                $admData['data'][$key]['channel'] = getChannelNameById($admData['data'][$key]['channel']);
                $admData['data'][$key]['registerStudentCount']=$this->stuRep->getRegisterStudentCount($val['id'])['data'];
                $admData['data'][$key]['openCourseStudentCount']=$this->stuRep->getOpenCourseStudentCount($val['id'])['data'];
                $admData['data'][$key]['payStudentCount']=$this->stuRep->getPayStudentCount($val['id'])['data'];
                $money = $this->stuRep->getPayStudentSumMoney($val['id'])['data'];
                $admData['data'][$key]['payStudentSumMoney']=formatMoney($money);
            }
            $dataArr['tbody'] = $admData['data']; 
            $dataArr['count'] = $admData['count'];
        } else {
            $dataArr['tbody'] = []; 
            $dataArr['count'] = 0;
        }

        return $dataArr;
    }

    public function updateProxyAdminStatus($id, $status)
    {
        if(empty($id)){
            $this -> error = '参数错误';
            return false;
        }
        $where = array(
            'id' => $id,
            );
        $data = array(
            'status' => $status,
            );

        return $this->admRep->saveRow($data, $where);
    }

    public function catProxyAdminInfo(
        $proxy_id = ''
    ) {
        $dataArr = array();
        //表头字段+样式
        $thead = array(
            array(
                'name'  => 'ID',
                'field' => 'id',
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
                'name'  => '手机',
                'field' => 'phone',
                'width' => '90',
                'order' => ''
            ),
            array(
                'name'  => '来源',
                'field' => 'channel',
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
        $dataArr['toolsOption'] = [];
        $dataArr['thead'] = $thead;

        $adminList = $this->admRep->getProxyAdminList($proxy_id); 

        foreach ($adminList['data'] as $key=>$val) {
            $adminList['data'][$key]['registerStudentCount']=$this->stuRep->getOpenCourseStudentCount($val['id'])['data'];
            $adminList['data'][$key]['openCourseStudentCount']=$this->stuRep->getOpenCourseStudentCount($val['id'])['data'];
            $adminList['data'][$key]['payStudentCount']=$this->stuRep->getPayStudentCount($val['id'])['data'];
            $adminList['data'][$key]['payStudentSumMoney']=$this->stuRep->getPayStudentSumMoney($val['id'])['data']/100;
        }
        $dataArr['tbody'] = $adminList['data']; 
        $dataArr['count'] = $adminList['count'];  
         
        return $dataArr;
    }

    /**
     * @param $file 上传的文件
     */
    public function importProxyAdmin($file){

            list($fileName, $allowType) = explode('.', $file['name']);
            $reader = new ExcelRead($file['tmp_name'], $allowType);
            $data = $reader->readDocument();
            unset($data[0]);
            $proxyAdminRpst = new ProxyAdminRepository();
            $channelRpst = new ChannelListRepository();
            $channelList  = $channelRpst->getList(['type'=>1,'status'=>1],'id,channel_name');
            $channelList = array_column($channelList,'channel_name','id');
            $result = [];
            foreach ($data as $key=>$value){
                if(!$value[0]){
                    continue;
                }
                $result[$key]['name'] = $value[0];
                $channelId = '';
                if($value[2] ){
                    $channelId = array_search($value[2], $channelList);
                }elseif ($value[1]){
                    $channelId = array_search($value[1], $channelList);
                }else{
                    $result[$key]['status'] = '渠道为空';
                    continue;
                }
                if(!$channelId){
                    $result[$key]['status'] = '渠道不存在';
                    continue;
                }
                try{
                    $proxyNew = ['name'=>$value[0],'channel'=>$channelId];
                    if($value[3]){
                        $proxyNew['phone'] = $value[3];
                    }
                    $proxy = $proxyAdminRpst->getRow($proxyNew);
                    if(!$proxy){
                        $proxyAdminRpst->addRow($proxyNew);
                        $result[$key]['status'] = '导入成功';
                    }else{
                        $result[$key]['status'] = '已存在';
                    }
                }catch (\Exception $e){
                    $result[$key]['status'] = '数据写入失败';
                    continue;
                }
            }
            return $result;

    }
}
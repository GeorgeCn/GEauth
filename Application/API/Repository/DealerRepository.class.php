<?php
/**
 * Created User: wangkun
 * Created Date: 2018/4/19 10:50
 * Current User:wangkun
 * History User:wangkun
 * Description:代理人Repository
 */

namespace API\Repository;

use API\Common\BaseRepository;
use Common\Helper\Util;

class DealerRepository extends BaseRepository
{
    public function __construct()
    {
        $this->model = D('API/ProxyAdmin');
    }

    public function getInfo($filter)
    {
        if ($filter['dealerId']){
            $where = ['id'=>$filter['dealerId']];
        }
        if ($filter['phone']){
            $where = ['phone'=> $filter['phone']];
        }
        if ($filter['channel']){
            $where = ['channel'=> $filter['channel']];
        }
        if ($filter['name']){
            $where = ['name'=> $filter['name']];
        }
        if (empty($where)){
            return ['code'=>1005,'data'=>'','msg'=>'参数缺失'];
        }
        $field = 'id as dealer_id,name,phone,channel as channel_id,bank_account_open as bank_place,bank_account,status';
        $modelD = $this->find($where,$field);
        if ($modelD['code']==1000 && $modelD['data']){
            $modelD['data'] = Util::underlineToCamel($modelD['data']);
            $modelD['data']['bankName'] = '招商银行';
        }
        return $modelD;
    }

    public function saveInfo($filter, $info)
    {
        return $this->editData($filter,$info);
    }
}
<?php
namespace Content\Repository;


class ContractRepository extends BaseRepository
{

    public function __construct()
    {
        $this->model = D('Content/Contract');
    }
    /**
     * 获取单条数据
     */
    public function getRow ($where,$field='*',$except = false,$order='')
    {
        return $this->model->getRow($where,$field,$except,$order);
    }
    /*
    * 查询首付金额
    */
    public function getStudentFirstAmount($stuId)
    {
        $where['contract.student_id'] = $stuId;
        $where['contract.`status`'] = ['in', [3, 4]];
        $where['contract.is_del'] = 1;
        $where['contract.contract_type'] = 1;
        $amount = $this->model->getStudentFirstAmount('contract_payment.total_fee', $where, 'contract_payment.create_at', '1');
        if ($amount) {
            return $amount['total_fee'];
        } else {
            return '';
        }


    }

}
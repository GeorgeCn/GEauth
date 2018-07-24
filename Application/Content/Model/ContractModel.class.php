<?php
namespace Content\Model;

class ContractModel extends BaseModel
{
    protected $tableName = 'contract';

    /*
    * 查询首付金额
    */
    public function getStudentFirstAmount($field,$where,$order,$limit)
    {
        return $this->field($field)
            ->join('LEFT JOIN contract_payment ON contract_payment.contract_id = contract.id AND contract_payment.is_success = 2')
            ->where($where)
            ->order($order)
            ->limit($limit)
            ->find();
        
    }
    
    
}
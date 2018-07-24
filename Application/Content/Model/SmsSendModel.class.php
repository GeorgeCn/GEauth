<?php
/**
 * Created by PhpStorm.
 * User: yuan
 * Date: 2016/9/28
 * Time: 12:05
 */
namespace Content\Model;
class SmsSendModel extends BaseModel{
    /**
     * 插入数据
     * @param array $data
     * @return mixed
     */
    public function addSms(array $data){
        $data['create_at'] = utctime();
        return $this->add($data);
    }
    public function getList($where,$field = '*',$order = 'order_id DESC'){
        $list = $this->field($field)->where($where)->order($order)->select();
        array_walk($list,function(&$val){
            $val['create_at'] = date('Y-m-d H:i:s',$val['create_at']+date('Z'));
            $val['phone'] = unserialize($val['phone'] );
        });
        return $list;
    }

    /**
     * 回调
     * @param $order_id
     * @param $phone
     * @param $callback
     * @return bool
     */
    public function callbackSms($order_id,$phone,$callback){
        $where['order_id'] = $order_id;
        $where['phone'] = $phone;
        $data['callback'] = $callback;
        return $this->where($where)->save($data);
    }

    /**
     * 删除数据
     * @param array $where
     * @return mixed
     */
    public function delete(array $where){
        return $this->delete($where);
    }
    public function getSuccessSms(){

    }

    /**
     * 获取条件的单条数据
     * @param $where
     * @param string $field
     * @param string $order
     * @return mixed
     */
    public function getFind($where,$field = '*',$order = 'id DESC'){
        return $this->field($field)->where($where)->order($order)->find();
    }
}
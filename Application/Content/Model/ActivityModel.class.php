<?php
namespace Content\Model;
class ActivityModel extends BaseModel{
    /**
     * 获取单条数目
     *
     * @param array $filter 筛选条件
     * @param string $fields 字段
     * @param bool $except 字段是否是排除
     * @return array|bool
     * */
    public function getRow(array $filter, $fields = "*", $except = false)
    {
        $activity = $this->where($filter)->field($fields, $except)->find();
        if($fields == '*'){
            $activity['start_time'] = $activity['start_time'] + date('Z');
            $activity['end_time'] = $activity['end_time'] + date('Z');
            $activity['week'] = unserialize($activity['week']);
            $activity['first_activity'] = $activity['first_activity'] + date('Z');
            $activity['last_activity'] = $activity['last_activity'] + date('Z');
        }
        return $activity;
    }
}
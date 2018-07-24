<?php
namespace Content\Model;

class StudentModel extends BaseModel
{
    public $studentType = [1 => '注册', 2 => '付费', 3 => '开课'];
    protected $tableName = 'student_user';

    /*
     * 查询数量
     */
    public function getStudentStatisticsCount($type, $agentIDs, $channel, $startTime, $endTime)
    {
        $sql = ' SELECT count(*) as totalcount FROM proxy_student' . $this->studentStatistics($type, $agentIDs, $channel, $startTime, $endTime);
        $result = $this->query($sql);
        return $result[0]['totalcount'];
    }
    /*
     * 查询数据
     */
    public function getStudentStatistics($type, $agentIDs, $channel, $startTime, $endTime,$limit)
    {
        $sql = ' SELECT ';
        $sql .= ' proxy_student.stu_id, ';
        $sql .= ' (CASE WHEN student_user.type = 2 THEN 2 WHEN ac.student_user_id > 0 THEN 3 ELSE 1 END) stu_type, ';
        $sql .= ' proxy_admin.`name`  as proxy_name, ';
        $sql .= ' channel_list.channel_name, ';
        $sql .= ' student_user.`name` as stu_name, ';
        $sql .= ' student_user.phone as stu_phone ';
        $sql .= ' FROM proxy_student ';
        $sql .= $this->studentStatistics($type, $agentIDs, $channel, $startTime, $endTime);
        if($limit){
            $sql .= ' limit ' . $limit;
        }
        return $this->query($sql);
    }

    private function studentStatistics($type, $agentIDs, $channel, $startTime, $endTime){
        $sql = ' LEFT JOIN student_user ON student_user.id = proxy_student.stu_id ';
        if($startTime){
            $sql .= ' AND student_user.create_time >=' . $startTime;
        }
        if($endTime){
            $sql .= ' AND student_user.create_time <=' . $endTime;
        }
        if($type == 2){
            $sql .= ' AND student_user.type = 2 ';
        }elseif($type == 3){
            $sql .= ' AND student_user.type != 2 ';
        }
        $sql .= ' LEFT JOIN proxy_admin ON proxy_admin.id = proxy_student.proxy_id ';
        $sql .= ' LEFT JOIN channel_list ON channel_list.id = proxy_student.channel AND channel_list.type = 1 ';
        $sql .= ' LEFT JOIN (select DISTINCT student_user_id from appoint_course where course_type = 3 and STATUS = 3) as ac ON proxy_student.stu_id = ac.student_user_id ';
        $sql .= ' WHERE student_user.id IS NOT NULL ';
        if($agentIDs){
            $sql .= ' AND proxy_student.proxy_id IN ('.implode(',',$agentIDs).') ';
        }
        if($channel){
            $sql .= ' AND proxy_student.channel in (' . $channel .')';
        }
        if($type == 3){
            $sql .= ' AND ac.student_user_id IS NOT NULL ';
        }
        return $sql;
    }
}
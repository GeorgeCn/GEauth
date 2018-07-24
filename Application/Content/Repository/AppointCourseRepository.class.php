<?php
namespace Content\Repository;


class AppointCourseRepository extends BaseRepository
{

    public function __construct()
    {
        $this->model = D('Content/AppointCourse');
    }
    /**
     * 获取单条数据
     */
    public function getRow ($where,$field='*',$except = false,$order='')
    {
        return $this->model->getRow($where,$field,$except,$order);
    }
   

}
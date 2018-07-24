<?php
namespace Content\Repository;


class ChannelListRepository extends BaseRepository
{

    public function __construct()
    {
        $this->model = D('Content/ChannelList');
    }
    /**
     * 获取多条数据
     */
    public function getList($where, $field = '*',$except = false, $order = 'id DESC')
    {
        return $this->model->getList($where, $field,$except, $order);
    }
    /**渠道列表
     * @param string $id
     * @param string $pid
     */
    public function treeList($id = 'id', $pid = 'pid')
    {
        $rows = $this->model->getList(['status' => 1, 'type' => 1,'pid'=>['neq',0]], "id,channel_name,pid");
        $items = array();
        foreach ($rows as $row) {
            $items[$row[$id]] = $row;
        }
        foreach ($items as $item) {
            $items[$item[$pid]]['children'][$item[$id]] = &$items[$item[$id]];
        }
        $res = isset($items[1]['children']) ? $items[1]['children'] : array();
        return $res;
    }

    /**获取所有子类
     * @param $data
     * @param $pid
     * @return array
     */
    function getTreeChild($pid) {
        $data = $this->getList(['status' => 1,'type'=>1]);
        $result = array();
        $pids = array($pid);
        do {
            $cids = array();
            $flag = false;
            foreach($pids as $fid) {
                for($i = count($data) - 1; $i >=0 ; $i--) {
                    $node = $data[$i];
                    if($node['pid'] == $fid) {
                        array_splice($data, $i , 1);
                        $result[] = $node['id'];
                        $cids[] = $node['id'];
                        $flag = true;
                    }
                }
            }
            $pids = $cids;
        } while($flag === true);
        return $result;
    }
}
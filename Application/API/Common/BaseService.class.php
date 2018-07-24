<?php
/**
 * Created User: wangkun
 * Created Date: 2018/3/19 下午4:12
 * Current User:wangkun
 * History User:wangkun,
 * Description:Service基类
 */

namespace API\Common;


class BaseService
{
    public function __construct()
    {
    }

    /**
     * @param int $status 1和0表示true或者false，或者有无数据
     * @param mixed $data 服务处理好的数据
     * @param string $msg 错误信息
     * @return array
     * @author wangkun
     * @description: 向Controller层返回固定格式数据
     */
    protected function served($status, $msg='', $data='')
    {
        return ['status'=>$status, 'msg'=>$msg, 'data'=>$data];
    }


    protected function servedD($repoData)
    {
        if ($repoData['code']==1000){
            return $repoData['data'];
        }else{
            return ['code'=>$repoData['code'], 'msg'=>$repoData['msg']];
        }
    }

}
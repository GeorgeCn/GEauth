<?php
/**
 * Created User: Administrator
 * Created Date: 2018/4/18 15:46
 * Current User:Administrator
 * History User:历史修改者
 * Description:这个文件主要做什么事情
 */

namespace API\Service;

use API\Common\BaseService;
use Content\Repository\ChannelListRepository;

class ChannelService extends BaseService
{
    private $channelRepo;

    public function __construct()
    {
        parent::__construct();
        $this->channelRepo = new ChannelListRepository();
    }

    public function getLists($parentId=0)
    {
        $servD = $this->channelRepo->getLists($parentId);
        if ($servD['code']==1000){
            return $this->served(1,'',$servD['data']);
        }else{
            return $this->served(0);
        }
    }

    public function getTree()
    {
        $servD = $this->channelRepo->treeList();
        return $this->served(1,'', $servD);
//        if ($servD['code']==1000){
//            return $this->served(1,'',$servD['data']);
//        }else{
//            return $this->served(0);
//        }
    }
}
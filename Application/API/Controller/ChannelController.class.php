<?php
/**
 * Created User: Administrator
 * Created Date: 2018/4/17 11:08
 * Current User:Administrator
 * History User:历史修改者
 * Description:这个文件主要做什么事情
 */

namespace API\Controller;
use API\Common\ApiController;
use API\Service\ChannelService;

class ChannelController extends ApiController
{
    private $channelServ;

    public function __construct()
    {
        parent::__construct();
        $this->channelServ = new ChannelService();
    }

    public function getLists()
    {
        $this->needParams(['parentId'],false);
        $this->quickRes($this->channelServ->getLists($this->params['parentId']));
    }

    public function tree()
    {
        $this->quickRes($this->channelServ->getTree());
    }
}
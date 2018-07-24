<?php
/**
 * [渠道管理]
 * @Author   George                   <[<923143925@qq.com>]>
 * @DateTime 2018-04-20T13:30:53+0800
 * @return   [type]                   [description]
 */
namespace Content\Controller;
use Content\Service\Channel\ChannelService;

class ChannelController extends PublicController
{
    private $chaService;

    public function __construct()
    {
        parent::__construct();
        $this->chaService = new ChannelService();
    }

	public function channel(){
		self::_channelList('ChannelList','优胜教育','level ASC', 'channel_list');
        $this -> display();
	}
 	
 	public function channelInfo()
    {
        $this->model = D('ChannelList');
        $id = I('get.id', 0, 'intval');
        if($id != 0){
            $where = array(
                'id'    => $id,
                'statu' => 1
            );
            $info = self::_oneInquire($where,2);
        }else{
            $info['id'] = 0;
        }
        if(self::_is_check_url('edit',1)){//临时
            $info['butadd'] = self::_catebut('edit', '添加分类', $info['id']);
        }
        if(self::_is_check_url('catedel',1)){//临时
            $info['butdel'] = self::_catebut('catedel', '删除分类', $info['id'], '您确认要删除该分类吗?', 2);
        }

        $this->assign('info', $info);
        $this->display();
    }

     /**
     * channel 添加分类
     **/
    public function edit()
    {
        $model = D('ChannelList');
        if(IS_POST){
            //先判断channel_tag唯一性
            $where = array(
                'channel_tag' => $_POST['channel_tag'],
                'status' => 1,
                'type' => 1);
            $info = $model->where($where)->count();
            if($info) {
                $this->error('渠道标识已存在');
            }
            $_POST['type'] = 1;
            $_POST['created_at'] = time();
            $data = $model->editCate();
            if($data){
                delTemp();
                $this->success($data['id'] ? '更新成功' : '添加成功', U('channel'));
            }else{
                $this->error($model->getError());
            }
        }

        $this -> assign('info',$info);
        $this->display();
    }

     /**
     * channel 更新分类
     **/
    public function upChannel(){
        $model = D('ChannelList');
        //先判断channel_tag唯一性
        $where = array(
            'channel_tag' => $_POST['channel_tag'],
            'status' => 1,
            'type' => 1);
        $info = $model->where($where)->count();
        if($info) {
            $this->error('渠道标识已存在');
        }
        $_POST['updated_at'] = time();
        $data  = $model -> updateCate();
        if($data){
            $this -> success('操作成功',U('channel'));
        }
        $this -> error('操作失败');
    }

    /**
     * channel 删除分类
     **/
    public function catedel()
    {
        $model = D('ChannelList');
        $res = $model ->delcate();
        if($res){
            $this -> success('操作成功',U('channel'));
        }
		$this -> error($model->getError());
    }

}

<?php
namespace Content\Controller;
use Content\Service\Account\AccountService;

class IndexController extends PublicController 
{
    public function index(){
    	$staService = new AccountService();
    	$data = $staService->getStaticData();
		//调用首页跳转处理方法
        $this->assign('list', $data);
        $this->display('Index/info');
	}
}

<?php
namespace Home\Controller;
use Think\Controller;

class IndexController extends AuthController
{
    /*后台首页*/
    public function index()
    {
        
        $this->display();
    }
}
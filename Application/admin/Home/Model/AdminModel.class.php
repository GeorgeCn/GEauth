<?php
namespace Home\Model;
use Think\Model;
class AdminModel extends Model{
	protected $token;

	//生成加密的用户密码
	public function GetMd5Pwd($pwd){
		$tk = $this->token = C("TOKEN");
		return md5($pwd.$tk);
	}

	//删除用户图片
	public function delImg($id){
		$img_dir = M('admin')->where("id = %d",$id)->getFiled('avatar');
		if(!empty($img_dir)){
			unlink($img_dir);
		}
	}
}
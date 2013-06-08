<?php
//个人中心模块
class PersonalAction extends CommonAction {
	
	//个人中心首页
	public function me() {
		$User = M('User');						//用户表
		$uid = $_SESSION['authId'];	//用户id
		
		$Content = $User->where(array('id'=>$uid))->find();
		
		$this->assign('Content',$Content);
		$this->display();
	}

	//用户修改
	public function meSave() {

		$User = M('User');						//用户表
		$uid = $_SESSION['authId'];	//用户id
		if (isPost($_POST)) {

			//写入数据库
			if (!$User->create())  $this->error($Project->getError());
			//验证数据
			$pass1 = $this->_post('password1');
			$pass2 = $this->_post('password2');
			if ($pass1) {
				if (mb_strlen(trim($pass1),'utf-8') <  6) $this->error('密码不得小于6位数');
				if ($pass1 != $pass2) $this->error('二次密码输入必须一致');
				$User->password = md5($pass1);
			}
			
			//写入数据库
			$User->where(array('id'=>$uid))->save() ? $this->success('修改成功') : $this->error('没有数据被修改');
		}
		
	}
		
		
		

}
?>
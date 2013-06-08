<?php
// 用户权限管理
class UserAction extends CommonAction {
    
	
	//用户列表
	public function user() {
		
		$User = M('user');
		$UserList = $User->where(array('is_admin'=>0))->select();
		$this->assign('UserLis',$UserList);
		$this->display();
	}
	//添加用户
	public function addUser() {
		$User = M('User');		//用户表

		if (isPost($_POST)) {
			//验证用户是否已存在
			if ($User->where(array('account'=>$this->_post('account')))->find()) {
				$this->error('此用户已存在');
			}
			
			//密码不一致验证
			if (!checkEquals($_POST['password'],$_POST['passwordTwo'])) $this->error('二次密码输入不一致');
			
			//添加新的用户
			$User->create();
			$User->password = md5($User->password);						//密码
			$User->status = 1;																	//状态
			$User->create_time = strtotime($User->create_time);		//在职时间
			$User->last_login_time = time();											//在职时间
			$User->last_login_ip = get_client_ip();;								//登陆id
			$uid = $User->add();
			if ($uid){
				$this->success('添加用户成功！','?s=/User/userDetailed/'.$uid);
				exit;
			} else {
				$this->error('添加用户失败');
				exit;
			}
		}
		//$this->assign('PREV_URL',C('PREV_URL'));
		$this->display();
	}
	//修改用户
	public function updateUser() {
		//初始化数据
		$User = M('user');								//用户表
		$Role = M('Role');								//组表
		$Role_user = M('Role_user');			//组与用户表
		$id = $_GET['_URL_'][2];			
		
		if (isPost($_POST)) {
			//修改用户信息
			$User->create();
			if (trim($this->_post('password')) == '') {		//如果不输入密码，就是原始密码
				$User->password = $this->_post('password_bak');
			} else {																//如果输入了密码，就是新密码
				$User->password = md5($User->password);
			}
			$User->create_time = strtotime($User->create_time);			//在职时间
			$User->save() ? $this->success('修改成功','?s=/User/userDetailed/'.$_POST['id']) : $this->error('没有数据被修改',$_POST['PREV_URL']);
			exit;
		}
		
		$userFind = $User->where(array('id'=>$id))->find();							//当前用户数据
		$userFind['create_time'] = date('m/d/Y',$userFind['create_time']);	//格式化时间

		$this->assign('userFind',$userFind);
		$this->assign('PREV_URL',C('PREV_URL'));
		$this->display();
	}
	//修改员工信息
	public function deleteUser() {
		
		//初始化数据
		$User = M('User');
		$uid = $_GET['_URL_'][2];		//操作id
		$status = $_GET['_URL_'][3];	//状态
		$type = $_GET['_URL_'][4];		//操作类型
		if ($type == 'leave')	 {	//离职修改
			$time = time();							//修改时间
			$User->where(array('id'=>$uid))->save(array('status'=>$status,'update_time'=>$time)) ? $this->success('修改成功') : $this->error('修改失败');
		} elseif ($type == 'delete') {
			$User->where(array('id'=>$uid))->delete() ? $this->success('删除成功') : $this->error('删除失败');
		}
		
		
	}
	
	//用户详细信息
	public function userDetailed() {
		$User = M('User');
		$id = $_GET['_URL_'][2];
		$UserContent = $User->where(array('id'=>$id))->find();
		$UserContent['create_time'] = date('Y-m-d',$UserContent['create_time']);		//入职时间
		if (empty($UserContent['update_time'])) {
			$UserContent['update_time'] = '';
		} else {
			$UserContent['update_time'] = date('Y-m-d',$UserContent['update_time']);		//离职时间
		}
		$UserContent['last_login_time'] = date('Y-m-d',$UserContent['last_login_time']);		//最后登陆时间
		$this->assign('UserContent',$UserContent);
		$this->display();
	}
	
	

//用户与组显示
	public function group() {
		$Role = M('role');						//组表
		$roleList = $Role->where(array('status'=>1))->select();	
		$this->assign('roleList',$roleList);
		$this->display();
	}
	//组编辑
	public function groupEdit() {
		$type = $_GET['_URL_'][2];		//类型
		$id = $_GET['_URL_'][3];			//操作id
		$Role = M('Role');						//组表
		
		if ($type == 'delete') {						//删除
			$Role->where(array('id'=>$id))->save(array('status'=>0)) ? $this->success('删除成功') : $this->error('删除失败');
			exit;
			
		} else if ($type == 'add') {				//添加
			if (isPost($_POST)) {
				$Role->create();
				$Role->status = 1;
				$Role->add() ? $this->success('添加成功',$_POST['PREV_URL']) : $this->error('添加失败');
				exit;
			}
			$this->assign('setName','新建组');
		} else if ($type == 'update') {			//修改
			$content  = $Role->where(array('id'=>$id))->find();	//当前组内容信息
			if (isPost($_POST)) {
				$Role->create();
				$Role->save() ? $this->success('修改成功',$_POST['PREV_URL']) : $this->error('修改失败');
				exit;
			}
			$this->assign('setName','修改组');
			$this->assign('id',$content['id']);			
			$this->assign('name',$content['name']);		
			$this->assign('remark',$content['remark']);			
		}
	
		
		$this->assign('PREV_URL',C('PREV_URL'));
		$this->display();
	}

	
	
	//添加用户到组
	public function groupUser () {
		$Role = M('role');						//组表
		$User = M('User');						//用户表
		$Role_user = M('role_user');		//用户与组关系表
		$role_id = $_GET['_URL_'][2];		//组id
		
		//修改
		if (isPost($_POST['send'])) {
			$userid = $this->_post('userid');		//用户id
			$roleid = $this->_post('role_id');		//节点id
			
			//删除组下所有用户
			$deleteUser = $Role_user->where(array('role_id'=>$role_id))->delete();		
			
			//添加新的用户到组中
			foreach ($userid as $key=>$val) {		
				 $data['role_id'] = $role_id;
				 $data['user_id'] = $val;
				 $Role_user->add($data);
			}	
			$this->success('修改成功',$_POST['PREV_URL']);
			exit;
		}
		
	//显示	
		//当前组名
		$roleName = $Role->where(array('id'=>$role_id))->getField('name');

		//所有用户列表
		$userList = $User->where(array('is_admin'=>0,'status'=>1))->select();
		
		//已有用户
		$userYesList = M()->table('oa_role_user AS r')->join("oa_user AS u ON r.user_id=u.id")->where(array('r.role_id'=>$role_id,'u.status'=>1))->select();
		
		//计算当前组下已有的用户id
		$userid_a = array();
		foreach($userYesList as $key=>$val) {
			$userid_a[] =  $val['user_id'];
		} 		
		
		//计算当前组下没有的用户信息
		$htmlUser = array();
		foreach ($userList as $key =>$val) {
			if (!in_array($val['id'],$userid_a)) {
				$htmlUser[] = $val;
			}
		}
		
		$this->assign('role_id',$role_id);
		$this->assign('roleName',$roleName);
		$this->assign('htmlUser',$htmlUser);
		$this->assign('userList',$userList);
		$this->assign('userYesList',$userYesList);
		$this->assign('PREV_URL',C('PREV_URL'));
		$this->display();
	}
	
	

	
	//组权限管理
	public function power() {
		//初始化数据
		$Role = M('Role');								//组表
		$Access = M('Access');					//权限表
		$Node = M('Node');							//节点表
		$RoleId = $_GET['_URL_'][2] ? $_GET['_URL_'][2] : 1;				//组id
		$NolePid3 = $_GET['_URL_'][3] ;		//二级节点pid
		$NolePid4 = $_GET['_URL_'][4] ;		//三级节点pid
		
	//组下拉列表
		$RoleName = $Role->where(array('id'=>$RoleId))->getField('name');			//当前组名			
		$RoleList = $Role->where(array('status'=>1))->select();								//所有组列表
	
	//节点表
		$NodeHome = $Node->where(array('level'=>1,'status'=>1))->select();										//一级节点
		$NodeAction = $Node->where(array('level'=>2,'status'=>1,'pid'=>$NolePid3))->select();			//二级节点
		$NodeFn = $Node->where(array('level'=>3,'status'=>1,'pid'=>$NolePid4))->select();				//三级节点
		
	//当前组下所有授权的组	
		$AccessList = $Access->where(array('role_id'=>$RoleId))->select();
		
	//计算出当前组下已有的节点id
	$AccessYes = array();
		foreach ($AccessList as $key=>$val) {
			$AccessYes[$key] = $val['node_id'];
		}
		
	//给当前组下已有的节点加上首选
		foreach ($NodeHome as $key=>$val) {		
			if (in_array($val['id'],$AccessYes)) {
				$NodeHome[$key]['checked'] ='checked="checked"';
			}
		}
		foreach ($NodeAction as $key=>$val) {
			if (in_array($val['id'],$AccessYes)) {
				$NodeAction[$key]['checked'] ='checked="checked"';
			}
		}
		foreach ($NodeFn as $key=>$val) {
			if (in_array($val['id'],$AccessYes)) {
				$NodeFn[$key]['checked'] ='checked="checked"';
			}
		}

		
		$this->assign('RoleId',$RoleId);
		$this->assign('NolePid3',$NolePid3);
		
		$this->assign('NodeHome',$NodeHome);
		$this->assign('NodeAction',$NodeAction);
		$this->assign('NodeFn',$NodeFn);
		
		$this->assign('RoleName',$RoleName);
		$this->assign('RoleList',$RoleList);
		$this->display();
	}
	
	//修改权限
	public function powerUpdate() {
		$Access = M('Access');					//权限表
		if (isPost($_POST)) {
			$node_one=$_POST['node_one'];
			$node_two=$_POST['node_two'];
			$node_three=$_POST['node_three'];

			//修改第一个
			foreach($node_one as &$node){
				//计算数据行数
				$num=$Access->where(array('role_id'=>$node['role_id'],'node_id'=>$node['node_id']))->count();
				if($node['checked']!=''){	//如果提交的是选中的数据
					if($num=='0'){		//并且没有这条数据，则添加
						$Access->add(array('role_id'=>$node['role_id'],'node_id'=>$node['node_id'],'level'=>$node['level'],'pid'=>$node['pid']));
					}
				}else{			//如果提交的不是选中的数据
					if($num>'0'){	//并且有这条数据，则删除。
						$Access->where(array('role_id'=>$node['role_id'],'node_id'=>$node['node_id']))->delete();
					}
				}
			}
			
			//修改第二个
			foreach($node_two as &$node){
				$num=$Access->where(array('role_id'=>$node['role_id'],'node_id'=>$node['node_id']))->count();
				if($node['checked']!=''){
					if($num=='0'){
						$Access->add(array('role_id'=>$node['role_id'],'node_id'=>$node['node_id'],'level'=>$node['level'],'pid'=>$node['pid']));
					}
				}else{
					if($num>'0'){
						$Access->where(array('role_id'=>$node['role_id'],'node_id'=>$node['node_id']))->delete();
					}
				}
			}
			
			//修改第三个
			foreach($node_three as &$node){
					
				$num=$Access->where(array('role_id'=>$node['role_id'],'node_id'=>$node['node_id']))->count();
				if($node['checked']!=''){
					if($num=='0'){
						$Access->add(array('role_id'=>$node['role_id'],'node_id'=>$node['node_id'],'level'=>$node['level'],'pid'=>$node['pid']));
					}
				}else{
					if($num>'0'){
						$Access->where(array('role_id'=>$node['role_id'],'node_id'=>$node['node_id']))->delete();
					}
				}
			}
			//跳转
			redirect(C('PREV_URL'));
			
	
		}
	}
	

	
	//节点列表
	public function node() {
		$Node = M('node');
		$pid = $_GET['_URL_'][2];			
		$pid2 =  $_GET['_URL_'][3];
		
		$node1 = $Node->where(array('level'=>1))->select();								//第一级节点
		
		$node2 = $Node->where(array('level'=>2,'pid'=>$pid))->select();				//第二级节点
		
		$node3 = $Node->where(array('level'=>3,'pid'=>$pid2))->select();				//第三级节点
		
		$this->assign('pid',$pid);
		$this->assign('pid2',$pid2);
		$this->assign('node1',$node1);
		$this->assign('node2',$node2);
		$this->assign('node3',$node3);
		$this->display();
	}
	//添加节点
	public function nodeEdit () {	
		$Node = M('Node');					//节点表
		
		$type = $_GET['_URL_'][2];		//操作类型
		$pid = $_GET['_URL_'][3];		//节点pid
		$level = $_GET['_URL_'][4];		//节点等级
		
		if ($type == 'add') {							//添加
			if (isPost($_POST)) {
				$Node->create();
				$Node->add() ? $this->success('添加成功',$_POST['PREV_URL']) : $this->error('添加失败');
				exit;
			}
		
		} else if ($type == 'update') {			//修改
			if (isPost($_POST)) {
				$data['name'] = $this->_post('name');
				$data['title'] = $this->_post('title');
				$Node->where(array('id'=>$pid))->save($data) ? $this->success('修改成功',$_POST['PREV_URL']) : $this->error('没有数据被修改');
				exit;
			}
			$nodeFind = $Node->where(array('id'=>$pid))->find();		//取得当前用户信息
			$this->assign('nodeFind',$nodeFind);
		} else if ($type == 'delete') {			//删除
			
			$Node->where(array('id'=>$pid))->delete() ? $this->success('删除成功') : $this->error('删除失败');
			exit;	
		}

		$this->assign('pid',$pid);
		$this->assign('level',$level);
		$this->assign('PREV_URL',C('PREV_URL'));
		$this->display();
	}
	
	//状态管理
	public function status() {
		$Node = M('Node');
		$status = $_GET['_URL_'][2];		//状态
		$id = $_GET['_URL_'][3];				//id
		$Node->where(array('id'=>$id))->save(array('status'=>$status)) ? $this->success('修改成功') : $this->error('修改失败');
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}
<?php
//项目管理
class ProjectAction extends CommonAction {
	
	// 框架首页
	public function index() {
		
		//所有项目于参与者列表
		$List = M()->table('oa_project AS p')->join("oa_time AS t ON p.pid = t.pid")->join('oa_user AS u ON u.id=t.uid')->field('p.pid,p.pname,p.start_time,p.end_time,p.state,t.uid,u.nickname,t.spend')->where(array('p.is_del'=>0))->order('p.pid ASC,u.id ASC')->select();
				
		$html = array();
		
		//重组数组
		foreach($List as $key=>$val) {
			$html[$val['pid']]['pid'] = $val['pid'];
			 $html[$val['pid']]['pname'] = $val['pname'];
			 $html[$val['pid']]['start_time'] = $val['start_time'];
			 $html[$val['pid']]['end_time'] = $val['end_time'];
			 $html[$val['pid']]['state'] = $val['state'];
			 $html[$val['pid']]['time'][$val['nickname']] += $val['spend'];					//总时间
		}
			
		//组合人员与时间
		foreach ($html as $key=>$val) {
			foreach ($val['time'] as $k=>$v) {
				$html[$key]['time'][$k] = $k.' ('.$v.'H)';
			}
		}

		$this->assign('html',$html);
		$this->display();
	}
	//项目编辑
	public function edit() {
		$pid = $_GET['_URL_'][2];
		$list=M('Project')->where(array('pid'=>$pid))->find();
		$list['start_time']=time_conversion_2($list['start_time']);
		if($list['end_time']!=''){
			$list['end_time']=time_conversion_2($list['end_time']);
		}
		$this->assign('list',$list);
		$this->display();
	}
	//数据保存
	public function save() {
		$Project=D("Project");
		if (sizeof($_POST)) {
			if (!$Project->create()) {
	            $this->error($Project->getError());
	        }else{
				$Project->start_time=time_conversion($_POST['start_time']);
				if(sizeof($_POST['end_time'])){
					$Project->end_time=time_conversion($_POST['end_time']);
				}
				if($_POST['pid']!=''){
					$Project->update_time=date("Y-m-d H:i:s");
					$pid=$Project->save();
					if ($pid){
						$this->success('数据修改成功！','?s=/Project/index');
						exit;
					} else {
						$this->error('数据修改失败');
						exit;
					}
				}else{
					$Project->create_time=date("Y-m-d H:i:s");
					$pid=$Project->add();
					if ($pid){
						$this->success('项目添加成功！','?s=/Project/index');
						exit;
					} else {
						$this->error('项目添加失败');
						exit;
					}
				}
			}
		}
	}
	
	//项目负责人
	public function PM() {
		//初始化数据
		$User = M('User');													//用户表
		$Project = M('Project');											//项目表
		$Project_user = M('Project_user');						//项目于用户表
		$pid = $_GET['_URL_'][2] ? $_GET['_URL_'][2]  : 1;		//当前项目pid
		
	//修改信息
		if (isPost($_POST['send'])) {
			$userid = $this->_post('userid');		//已在本项目中的所有用户id ，数组
			$pid = $this->_post('pid');					//当前项目id

			//删除组下所有用户
			$deleteUser = $Project_user->where(array('pid'=>$pid))->delete();

			foreach ($userid as $key=>$val) {
				$data['pid'] = $pid;		//项目id
				$data['uid'] = $val;		//用户id
				$Project_user->add($data);
			}
			$this->success('修改成功',$_POST['PREV_URL']);
			exit;
			
		}
		
		
	//显示数据	
		//当前组名

		$projectContent = $Project->where(array('pid'=>$pid))->field('pname,state')->find();
		//所有用户列表
		$userList = $User->where(array('is_admin'=>0,'status'=>1))->select();	
		//已有用户列表
		$userYesList = M()->table('oa_project_user AS pu')->join("oa_user AS u ON pu.uid=u.id")->where(array('pu.pid'=>$pid,'u.status'=>1))->select();
		
		//计算当前组下已有的用户
		$userid_a = array();
		foreach($userYesList as $key=>$val) {
			$userid_a[] =  $val['uid'];
		}
				
		//计算当前组下没有的用户信息
		$htmlUser = array();
		foreach ($userList as $key =>$val) {
			if (!in_array($val['id'],$userid_a)) {
				$htmlUser[] = $val;
			}
		}
		
		$this->assign('pid',$pid);
		$this->assign('projectContent',$projectContent);
		$this->assign('htmlUser',$htmlUser);
		$this->assign('userList',$userList);
		$this->assign('userYesList',$userYesList);
		$this->assign('PREV_URL',C('PREV_URL'));
		$this->display();
	}
	//项目删除
	public function projectDelete() {
		//初始化数据
		$Project = M('Project'); 
		$pid = $_GET['_URL_'][2];
		
		$Project->where(array('pid'=>$pid))->save(array('is_del'=>1)) ? $this->success('删除成功') : $this->error('删除失败');
		
	}
	
	
	
	//时间轴
	public function timeAxis() {
		
		//PM完成任务列表
		$pmDoneList = M()->table('oa_role AS r')->join('oa_role_user AS ru ON r.id = ru.role_id')->join('oa_user AS u ON u.id = ru.user_id ')->join('RIGHT JOIN oa_time AS t ON t.uid = u.id ')->join('oa_project AS p ON t.pid = p.pid')->field('t.create_time,u.nickname,t.uid,p.pname,t.spend,t.content')->where(array('r.id'=>4,'u.status'=>1,'u.is_admin'=>0))->order('t.create_time DESC,u.id ASC')->select();
		//User完成任务列表
		$userDoneList = M()->table('oa_role AS r')->join('oa_role_user AS ru ON r.id = ru.role_id')->join('oa_user AS u ON u.id = ru.user_id ')->join('RIGHT JOIN oa_time AS t ON t.uid = u.id ')->join('oa_project AS p ON t.pid = p.pid')->field('t.create_time,u.nickname,t.uid,p.pname,t.spend,t.content')->where(array('r.id'=>2,'u.status'=>1,'u.is_admin'=>0))->order('t.create_time DESC,u.id ASC')->select();
		
		
		$html = array();
	
		foreach ($pmDoneList as $key=>$val)  {
			$html[$val['create_time']]['pm'][$val['uid']][] = $val;
			$html[$val['create_time']]['date'] = $val['create_time'];
		}

		foreach ($userDoneList as $key=>$val)  {
			$html[$val['create_time']]['user'][$val['uid']][] = $val;
		}

		$this->assign('html',$html);
		$this->display();
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}
?>
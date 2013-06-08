<?php
// 工作表
class ContentAction extends CommonAction {
	
	//获取日期
	private function getTime() {
		$nowDate = $_GET['_URL_'][2] ? explode('-',$_GET['_URL_'][2]) : explode('-', date('Y-m-d')); //转换当前日期为数组
		$year = $nowDate[0];			//年
		$month  = $nowDate[1];	//月
		$day  = $nowDate[2];			//日
		return getDateNum($day,$month,$year,"Y-m-d");		//返回日期
	}
	
	public function tables() {
		
		//日期
		$time = $this->getTime();

		//每日内容
		$contentList = M()->table('oa_user AS u')->join("oa_content AS c ON c.uid=u.id  AND c.create_time='$time'")->field("u.id,u.nickname,c.am,c.pm,c.cid")->where(array('u.is_admin'=>0,'u.status'=>1))->select();
		
		//所有人员当日内容
		$timeList = M()->table("oa_time AS t")->join("oa_user AS u ON t.uid = u.id")->join("oa_project AS p ON p.pid = t.pid")->field("u.id,t.spend,t.content,p.pname")->where(array('t.create_time'=>$time))->select();
		
		
		//找出当前用户下，所有time内容
		foreach($contentList as $key=>$val) {
			foreach ($timeList as $k=>$v) {
				if ($val['id'] == $timeList[$k]['id']) {
					$contentList[$key]['other'][] = $timeList[$k];
				}
			}
		}
		
		//日期分页
		$page = explode('-',$time);
		$page[] = $page[2] - 1;
		$page[] = $page[2] + 1;
		$page['next'] = getDateNum($page[4],$page[1],$page[0],"Y-m-d");		//下一天
		$page['prev'] = getDateNum($page[3],$page[1],$page[0],"Y-m-d");		//上一天
		
		
		//注入变量
		$this->assign('page',$page);
		$this->assign('time',$time);
		$this->assign('timeList',$timeList);
		$this->assign('contentList',$contentList);
		$this->display();
		
	}
	
	//价动修改
	public function save() {
		if (isPost($_POST)) {
			//初始化数据
			$Time = M('Time');
			$time = $_POST['time'];				//提交时间
			$uid= $_POST['uid'];						//用户id
			$pid = $_POST['pid'];					//项目id
			$spend = $_POST['spend'];			//项目花费时间
			$content = $_POST['content'];		//项目内容
			
			//为空验证
			foreach ($spend as $key=>$val) {
				if (trim($val) == '' || trim($content[$key]) == '' ) {
					$this->error('内容不得为空');
				}
			}
			
			//写入数据库
			$data = array();
			foreach ($pid as $key=>$val) {
				$data['pid'] = $val;		//项目id
				$data['uid'] = $uid;		//用户id
				$data['spend'] = $spend[$key];			//花费时间
				$data['content'] = $content[$key];		//内容
				$data['create_time'] = $time;				//创建时间
				$isOk = $Time->add($data);
			}
			
			empty($isOk) ? $this->error('添加失败')	: $this->success('添加成功') ;
		}
	}
	
	
	
	
	
	
	//AJAX修改内容
	public function update() {
		$Content = M('Content');		//内容表

		$cid = $this->_post('cid');						//cid
		$uid = $this->_post('uid');						//uid
		$time = $this->_post('time');					//当前日期	
		$filed = $this->_post('filed');					//字段名
		$content = $this->_post('content');		//内容
		
		if (isPost($_POST)) {			
			$cid =  $Content->where(array('uid'=>$uid,'create_time'=>$time))->getField('cid');
			if (empty($cid)) {		//如果数据不存在，添加一条数据
				$data['uid'] = $uid;
				$data[$filed] = $content;
				$data['create_time'] = $time;
				$Content->data($data)->add();	
			} else {						//如果数据存在，则修改数据
				$data[$filed]= $content;
				$data['update_time'] = date('Y-m-d H:i:s');
				$Content->where(array('cid'=>$cid))->save($data);
			}
	
		}
	}
	//获取select内容
	public function select_data(){
		$id = $this->_post('id');
		//$id=4;
		$projectName=M()->table("oa_project_user as u")->join("oa_project as p on u.pid=p.pid")->field("p.pname,p.pid")->where(array("u.uid"=>$id))->select();
		$html='<div name="abc" id="abc"><select class="textbox03" name="pid[]">';
		foreach($projectName as &$val){
			$html.="<option value='".$val['pid']."'>".$val['pname']."</option>";
		}
		$html.='</select><input class="textbox04" type="textbox"  name="spend[]" value="" />H<input class="textbox02" type="textbox"  name="content[]" value="" /><button name="btn" class="btn btn04" onclick="move(this);"><span class="icomoon-icon-cancel-3" ></button></div>';
		echo $html;
	}
}
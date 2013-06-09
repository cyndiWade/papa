<?php 

/**
 * 主题管理类
 */
class TopicAction extends BaseAction {
	
	
	
	//显示所有主题列表
	public function _show() {
		$Topic = D('Topic');					//主题表
		$Papauser = D('Papauser');		//用户表
		$File = D('File');						//文件表
		$Comment = D('Comment');		//评论表
		
		$list = $Topic->show(array('status'=>0));			//主题数据列表
		
		//用户数据
		$this->fixData($Papauser, $list, 'user_id','id,nickname');
		$this->fixData($File, $list, 'pic','id,url');
		$this->fixData($File, $list, 'voice','id,size,url');
		
		//评论数据处理
		$aComIds =  getArrayByField($list,'new_comids', 'id');		//找出数组中的new_comids字段，并且按照id分组
		$comIds =  implode(',',$aComIds);							
		if (!empty($comIds)) {
			$aComs = $Comment->getDataById($comIds,'id', '*');
		}
		$this->fixData($Papauser, $aComs, 'uid','id,account,header_pic');
		$this->fixData($File, $aComs, 'voice');
		
		//组合数据
		foreach ($list AS $key=>$val) {		//取得对应的用户数据
			$ids = explode(',',$aComIds[$val['id']]);
			$list[$key]['coms'] = array(
					$aComs[$ids[0]], 
					$aComs[$ids[1]],
					$aComs[$ids[2]],
			);
		}

		return $list;
		
	}	

	public function show() {
		$this->assign('list',$this->_show());
		$this->display();
	}
}


?>
<?php 

/**
 * 主题管理类
 */
class TopicAction extends Action {
	
	public function fixData($M, &$list, $field, $pk='id', $fields = '*') {
		$aIds = getArrayByField($list, $field);		
		$aData = $M->getDataById(implode(',',$aIds),$pk , $fields);	
		foreach ($list AS $key=> &$val) {		
			$val[$field] = $aData[$val[$field]];
		}
	}
	
	//显示所有主题列表
	public function show() {
		$Topic = D('Topic');					//主题表
		$Papauser = D('Papauser');		//用户表
		$File = D('File');						//文件表
		$Comment = D('Comment');		//评论表
		
		$list = $Topic->show(array('status'=>0));			//主题数据列表
		
		//用户数据
		$this->fixData($Papauser, $list, 'user_id');
		$this->fixData($File, $list, 'pic');
		$this->fixData($File, $list, 'voice');
		
		//评论数据处理
		$aComIds =  getArrayByField($list,'new_comids', 'id');		//找出数组中的new_comids字段，并且按照id分组
		$comIds =  implode(',',$aComIds);							
		if (!empty($comIds)) {
			$aComs = $Comment->getDataById($comIds,'id', '*');
			dump($aComs);
		}
		$this->fixData($Papauser, $aComs, 'uid');
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

		print_r($list);
		//$this->display();
	}	

}


?>
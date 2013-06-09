<?php 

/**
 * 主题管理类
 */
class TopicAction extends Action {
	
	function xxx() {
		
	}
	
	//显示所有主题列表
	public function show() {
		$Topic = D('Topic');					//主题表
		$Papauser = D('Papauser');		//用户表
		$File = D('File');						//文件表
		$Comment = D('Comment');		//评论表
		
		$list = $Topic->show(array('status'=>0));			//主题数据列表
		
		//用户数据
		$aUserids = getArrayByField($list,'user_id');		//主题数据中所有的user_id
		$aUsers = $Papauser->getDataById(implode(',',$aUserids),'id', 'id,nickname');	//通过user_id，查询用户表中的用户数据
		foreach ($list AS $key=>&$val) {		//取得对应的用户数据
			$list[$key]['users'] = $aUsers[$val['user_id']]['nickname'];
		}
		
		//文件数据处理
		//图片数据
		$aPicIds = getArrayByField($list,'pic');		
		$aFiles = $File->getDataById(implode(',',$aPicIds),'id', 'id,url');	
		//音频数据
		$aVoiceIds = getArrayByField($list,'voice');		
		$aVoices = $File->getDataById(implode(',',$aVoiceIds),'id', 'id,url');	
		
		//评论数据处理
		$aComIds =  getArrayByField($list,'new_comids', 'id');		//找出数组中的new_comids字段，并且按照id分组
		$comIds =  implode(',',$aComIds);							
		if (!empty($comIds)) {
			$aComs = $Comment->getDataById($comIds,'id', '*');
			dump($aComs);
		}
	
		foreach ($aComs AS $key=>$val) {
			
		}
		
		
		//组合数据
		foreach ($list AS $key=>$val) {		//取得对应的用户数据
			$list[$key]['users'] = $aUsers[$val['user_id']]['nickname'];
			$list[$key]['pics'] = $aFiles[$val['pic']]['url'];
			$list[$key]['voices'] = $aVoices[$val['voice']]['url'];

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
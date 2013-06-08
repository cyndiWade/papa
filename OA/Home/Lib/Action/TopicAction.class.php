<?php 

/**
 * 主题管理类
 */
class TopicAction extends Action {
	
	public function show() {
		$Topic = D('Topic');
		//$list = $this->show(array('status'=>0));
		//dump($list);
		$this->display();
	}	

}


?>
<?php
/**
 * 评论表
 */

class CommentModel extends CommonModel {
	
	public function show($condition) {
		
		$data = $this->where($condition)->select();
		return $data;
	}
	
	public function get_one($condition) {
		return $this->where($condition)->find();
	}
	
	public function add() {
		return $this->add();
	}
	
	public function del($condition) {
		return $this->where($condition)->delete();
	}

	
}
?>
<?php
class TopicModel extends CommonModel {
	
	
	
	public function show($condition) {
		return $this->where($condition)->select();
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
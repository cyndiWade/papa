<?php
/**
 *拍拍用户表
 */

class PapauserModel extends CommonModel {
	
	
	public function show($condition) {
		
		$data = $this->where($condition)->select();
		return $data;
	}

	
	public function add() {
		return $this->add();
	}
	
	public function del($condition) {
		return $this->where($condition)->delete();
	}

	
}
?>
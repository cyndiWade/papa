<?php 

/**
 * 小张
 * @author Administrator
 *
 */
class ApizhangAction extends Action {
	
	public function show() {
		$Topic = A('Topic');

		echo json_encode($Topic->_show());
	}
	
	public function user() {
		
	}
	
}

?>
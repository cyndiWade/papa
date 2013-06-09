<?php 
/**
 * 公共方法类
 * @author Administrator
 *
 */
class BaseAction extends Action {
	
	protected   function fixData($M, &$list, $field, $fields = '*', $pk='id') {
		$aIds = getArrayByField($list, $field);
		$aData = $M->getDataById(implode(',',$aIds),$pk , $fields);
		foreach ($list AS $key=> &$val) {
			$val[$field] = $aData[$val[$field]];
		}
	}
}

?>
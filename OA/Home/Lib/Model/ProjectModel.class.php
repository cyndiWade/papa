<?php
// 用户模型
class ProjectModel extends CommonModel {
	public $_validate	=	array(
		array('pname','require','项目名必须'),
		array('start_time','require','开始时间必须'),
		);
}
?>
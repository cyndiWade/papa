<?php
/**
 * 评论表
 */

class CommentModel extends CommonModel {
	
	public function show($condition) {
		
		$data = $this->where($condition)->select();
		return $data;
	}
	
	//获取所有评论内容
	public function all_com($condition,$first,$last) {
		return $this->query("
			SELECT 
							c.id,
							c.tid,
							c.uid,
							c.content,
							c.voice,
							(SELECT url FROM oa_file  WHERE id=c.voice LIMIT 1) AS voice_url,
							(SELECT header_pic FROM oa_papauser  WHERE id=c.uid LIMIT 1) AS pic_url							
				FROM 
						oa_comment  AS c
			WHERE 
						c.tid='$condition'		
			LIMIT
						$first,$last
		");
	}
	
	
	
	public function add() {
		return $this->add();
	}
	
	public function del($condition) {
		return $this->where($condition)->delete();
	}

	
}
?>
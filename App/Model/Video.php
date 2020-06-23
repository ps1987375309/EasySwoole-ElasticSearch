<?php
namespace App\Model;

class Video extends Base{
	public $tableName = "video";
	
    public $db2 = "";
    
    /*
     * 第二套数据库连接方式，扩展插件，第一套在父类base中
     */
    public function __construct() {
        if(empty($this->tableName)) {
            throw new \Exception("table error");
        }
        $db2 = new \MysqliDb('127.0.0.1','root','root','easyswoole',3306,'utf8');
        $this->db2 = $db2;
        
    }
    
	/**
	 * 通过条件获取数据库里面的video
	 * @auth   singwa
	 * @param  array   $condition [description]
	 * @param  integer $page      [description]
	 * @param  integer $size      [description]
	 * @return 
	 */
	public function getVideoData($condition = [], $page = 1, $size =10) {

		if(!empty($condition['cat_id'])) {
			$this->db2->where("cat_id", $condition['cat_id']);
		}
		// 获取正常的内容
		$this->db2->where("status", 1);
		if(!empty($size)) {
			$this->db2->pageLimit = $size;
		}

		$this->db2->orderBy("id", "desc");
		$res = $this->db2->paginate($this->tableName, $page);
		//echo $this->db2->getLastQuery();
		
		$data = [
			'total_page' => $this->db2->totalPages,
			'page_size' => $size,
			'count' => intval($this->db2->totalCount),
			'lists' => $res,

		];
		return $data;

	}

	/**
	 * [getVideoCacheData description]
	 * @auth   singwa
	 * @param  array   $condition [description]
	 * @param  integer $size      [description]
	 * @return 
	 */
	public function getVideoCacheData($condition = [], $size = 1000) {

		if(!empty($condition['cat_id'])) {
			$this->db2->where("cat_id", $condition['cat_id']);
		}
		// 获取正常的内容
		$this->db2->where("status", 1);
		if(!empty($size)) {
			$this->db2->pageLimit = $size;
		}

		$this->db2->orderBy("id", "desc");
		$res = $this->db2->paginate($this->tableName, 1);
		//echo $this->db2->getLastQuery();
		return $res;

	}
}
<?php
namespace App\Model;
use EasySwoole\Component\Di;
class Base {
	public $db = "";
	public $builder ="";
	public function __construct() {
	    
// 	    Di::getInstance()->get("MYSQL")->queryBuilder()->get('video');
// 	    $result = Di::getInstance()->get("MYSQL")->execBuilder();
	   
		if(empty($this->tableName)) {
			throw new \Exception("table error");
		}

		$db = Di::getInstance()->get("MYSQL");
		$this->db = $db;

	}

	/**
	 * [add description]
	 * @auth  singwa
	 * @date  2018-10-21T16:38:42+0800
	 * @param 
	 */
	public function add($data) {
	    
		if(empty($data) || !is_array($data)) {
			return false;
		}
		$this->db->queryBuilder()->insert($this->tableName, $data);
		$this->db->execBuilder();
	    return "插入成功";
	}

	/**
     * 通过ID 获取 基本信息
     *
     * @param 
     * @return void
     */
    public function getById($id) {
        $id = intval($id);
        if(empty($id)) {
            return [];
        }

        $this->db->where ("id", $id);
        $result = $this->db->getOne($this->tableName);
        return $result ?? [];
    }
}
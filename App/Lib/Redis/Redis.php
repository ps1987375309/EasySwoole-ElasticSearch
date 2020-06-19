<?php
namespace App\Lib\Redis;
ini_set('default_socket_timeout', -1);
//use EasySwoole\Core\AbstractInterface\Singleton;
use EasySwoole\Component\Singleton;

use EasySwoole\EasySwoole\Config as Configs;

class Redis {
	
	use Singleton;

	public $redis = "";

	public function __construct() {
		ini_set('default_socket_time', -1);
		/*
		 * 检查扩展是否存在
		 */
// 		if(!extension_loaded('redis')) {
// 			throw new \Exception("redis.so文件不存在");
// 		}
		try {
		    //配置文件写法一：配置文件在dev.php中
// 			$redisConfig = Configs::getInstance()->getConf("REDIS");
			
			//当前文件写法二：
// 			$redisConfig = [
// 			     'host' => '127.0.0.1',
// 			     'port' => '6379',
// 			     'time_out' => 5,
// 			     'serialize' => \EasySwoole\Redis\Config\RedisConfig::SERIALIZE_NONE,
// 			];

		    //Yaconf是php的一个配置文件管理工具，需要安装扩展(推荐)
			$redisConfig = \Yaconf::get('Redis');
			
			$this->redis = new \EasySwoole\Redis\Redis(new \EasySwoole\Redis\Config\RedisConfig($redisConfig));
			$result = $this->redis;
		} catch(\Exception $e) {
			throw new \Exception("redis服务异常");
		}

		if($result === false) {
			throw new \Exception("redis 链接失败");
		} 
	}

	/**
	 * [get description]
	 * @auth   singwa
	 * @date   2018-10-07T21:19:29+0800
	 * @param                     $key 
	 * @return                         
	 */
	public function get($key) {
		if(empty($key)) {
			return '';
		}

		return $this->redis->get($key);
	}

	/**
	 * [set description]
	 * @auth  singwa
	 * @param   $key   
	 * @param   $value 
	 * @param integer $time  
	 */
	public function set($key, $value, $time = 0) {
		if(empty($key)) {
			return '';
		}
		if(is_array($value)) {
			$value = json_encode($value);
		}
		if(!$time) {
			return $this->redis->set($key, $value);
		}
		return $this->redis->setex($key, $time, $value);
	}

	public function lPop($key) {
		if(empty($key)) {
			return '';
		}

		return $this->redis->lPop($key);
	}

	/**
	 * [rPush description]
	 * @auth   singwa
	 * @date   2018-10-13T23:45:42+0800
	 * @param                     $key   
	 * @param                     $value 
	 * @return                           
	 */
	public function rPush($key, $value) {
		if(empty($key)) {
			return '';
		}

		return $this->redis->rPush($key, $value);
	}

	public function zincrby($key, $number, $member) {
		if(empty($key) || empty($member)) {
			return false;
		}

		return $this->redis->zincrby($key, $number, $member);
	}

	/**
	 * 当类中不存在该方法时候，直接调用call 实现调用底层redis相关的方法
	 * @auth   singwa
	 * @param   $name      
	 * @param   $arguments 
	 * @return             
	 */
	public function __call($name, $arguments) {
		
		///var_dump(...$arguments);
		return $this->redis->$name(...$arguments);
	}


}
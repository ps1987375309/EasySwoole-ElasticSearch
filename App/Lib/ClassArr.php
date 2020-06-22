<?php
namespace App\Lib;

/**
 * 做一些反射机制有关的 处理
 */
class ClassArr {

	/**
	 * [uploadClassStat description]
	 * @auth   singwa
	 * @date   2018-10-21T11:23:12+0800
	 * @return  
	 */
	public function uploadClassStat() {
		return [
			"image" => "\App\Lib\Upload\Image",
			"video" => "\App\Lib\Upload\Video",
		    "txt" => "\App\Lib\Upload\Txt",
		];
	}

	/**
	 * [initClass description]
	 * @auth   
	 */
	public function initClass($type, $supportedClass, $params = [], $needInstance = true) {
		if(!array_key_exists($type, $supportedClass)) {
			return false;
		}

		$className = $supportedClass[$type];

		return $needInstance ? (new \ReflectionClass($className))->newInstanceArgs($params) : $className;
	}

}
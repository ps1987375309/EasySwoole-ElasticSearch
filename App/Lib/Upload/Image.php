<?php
namespace App\Lib\Upload;

class Image extends Base{

	/**
	 * fileType
	 * @var string
	 */
	public $fileType = "image";

	public $maxSize = 12200;

	/**
	 * 文件后缀的medaiTypw
	 * @var 
	 */
	public $fileExtTypes = [
		'png',
		'jpeg',
		// todo
	];
}
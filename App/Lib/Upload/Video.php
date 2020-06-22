<?php
namespace App\Lib\Upload;

class Video extends Base{

	/**
	 * fileType
	 * @var string
	 */
	public $fileType = "video";

	public $maxSize = 12200;

	/**
	 * 文件后缀的medaiTypw
	 * @var 
	 */
	public $fileExtTypes = [
		'mp4',
		'x-flv',
		// todo
	];
}
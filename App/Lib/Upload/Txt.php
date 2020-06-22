<?php
namespace App\Lib\Upload;

class Txt extends Base{

	/**
	 * fileType
	 * @var string
	 */
	public $fileType = "txt";

	public $maxSize = 12222;
    
	public $fileExtTypes = [
	    'plain',
	    // todo
	];
	
}
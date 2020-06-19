<?php

namespace App\HttpController\Api;

use EasySwoole\Http\AbstractInterface\Controller;

/**
 * Api模块下的基础类库
 * Class Index.
 * @package App\HttpController
 */
class Base extends Controller
{
    /**
     * 放一些请求的参数数据
     * @var array
     */
    public $params = [];
    public function index() {
        return $this->writeJson(201, 'OK', ['aas']);
    }
}
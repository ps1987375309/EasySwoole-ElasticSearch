<?php

namespace App\HttpController\Api;

use App\Lib\ClassArr;
/**
 * 文件上传逻辑 - 视频 图片
 * @package App\HttpController
 */
class Upload extends Base
{

    public function file() {
        
        $request = $this->request();
        $files = $request->getSwooleRequest()->files;
        $types = array_keys($files);
        $type = $types[0];
        if(empty($type)) {
            return $this->writeJson(400, '上传文件不合法');
        }
        
        
        // PHP 反射机制
         
        try {
//             $obj = new \App\Lib\Upload\Video($request);
//             $obj = new \App\Lib\Upload\Image($request);
            
            $classObj = new ClassArr();
            $classStats = $classObj->uploadClassStat();
            $uploadObj = $classObj->initClass($type, $classStats, [$request, $type]);
            $file = $uploadObj->upload();
        }catch(\Exception $e) {
            return $this->writeJson(400, $e->getMessage(), []);
        }
        if(empty($file)) {
            return $this->writeJson(400, "上传失败", []);
        }

        $data = [
            'url' => $file,
        ];
        return $this->writeJson(200, "OK", $data);

        /*使用postman调试可用
        $request = $this->request();
        $videos = $request->getUploadedFile("video");

        $flag = $videos->moveTo("/root/workspace/EasySwoole/webroot/video/1.mp4");
        $data = [
            'url' => "/1.mp4",
            'flag' => $flag
        ];
        if($flag) {
            return $this->writeJson(200, 'OK', $data);
        } else {
            return $this->writeJson(400, 'OK', $data);
        }
        */
    }

}

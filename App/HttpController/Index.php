<?php


namespace App\HttpController;


use EasySwoole\Http\AbstractInterface\Controller;
use App\Lib\AliyunSdk\AliVod;
use Elasticsearch\ClientBuilder;

class Index extends Controller
{

    public function index()
    {
        // 测试 php-elasticsearch demo
        $params = [
            "index" => "imooc_video",
            "type" => "video",
            //"id" => 1,
            'body' => [
                'query' => [
                    'match' => [
                        'name' => '刘德华'
                    ],
                ],
            ],
        ];
        $client = ClientBuilder::create()->setHosts(["127.0.0.1:8301"])->build();
        $result = $client->search($params);
        return $this->writeJson(200, "OK", $result);
    }

    protected function actionNotFound(?string $action)
    {
        $this->response()->withStatus(404);
        $file = EASYSWOOLE_ROOT.'/vendor/easyswoole/easyswoole/src/Resource/Http/404.html';
        if(!is_file($file)){
            $file = EASYSWOOLE_ROOT.'/src/Resource/Http/404.html';
        }
        $this->response()->write(file_get_contents($file));
    }
    public function testali() {
        $obj = new AliVod();
        $title = "singwa-imooc-video";
        $videoName = "1.mp4";
        $result = $obj->createUploadVideo($title, $videoName);
        $uploadAddress = json_decode(base64_decode($result->UploadAddress), true);
        $uploadAuth = json_decode(base64_decode($result->UploadAuth), true);
        $obj->initOssClient($uploadAuth, $uploadAddress);
        $videoFile = "/root/workspace/EasySwoole/webroot/video/2018/10/7648e6280470bbbc.mp4";
        $result = $obj->uploadLocalFile($uploadAddress, $videoFile);
        print_r($result);
    }
    public function getVideo() {
        $videoId = "345183ba6d54420080ae63830afb663c";
        $obj = new AliVod();
        print_r($obj->getPlayInfo($videoId));
    }
}
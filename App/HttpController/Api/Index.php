<?php
namespace App\HttpController\Api;
use App\Lib\Redis\Redis;
use EasySwoole\Component\Di;
use App\Model\Video as VideoModel;
use EasySwoole\Http\Message\Status;

use App\Lib\Cache\Video as VideoCache;

use EasySwoole\FastCache\Cache;
/**
 *
 * Class Index.
 * @package App\HttpController
 */
class Index extends Base
{
    /**
     * 第一套方案 原始  - 读取 Mysql
     * [lists description]
     * @auth   singwa
     * @return 
     */
    public function lists0() {
        $condition = [];
        if(!empty($this->params['cat_id'])) {
            $condition['cat_id'] = intval($this->params['cat_id']);
        }
        try {
            $videoModel = new VideoModel();
            $data = $videoModel->getVideoData($condition, $this->params['page'], $this->params['size']);
//             $data = $videoModel->getVideoData($condition, 1,5);
        }catch(\Exception $e) {
            return $this->writeJson(Status::CODE_BAD_REQUEST, "服务异常");
        }
//         var_dump($data);
        if(!empty($data['lists'])) {
            foreach($data['lists'] as &$list) {
                $list['create_time'] = date("Ymd H:i:s", $list['create_time']);
                $list['video_duration'] = gmstrftime("%H:%M:%S", $list['video_duration']);
            }
        }
    }
    
    /**
     * 第二套方案 直接读取 静态化 json数据
     * [lists description]
     * @auth   singwa
     * @return 
     */
    public function lists() {
//         Cache::getInstance()->set('a',time());
//         var_dump(Cache::getInstance()->get('a'));
        
        $catId = !empty($this->params['cat_id']) ? intval($this->params['cat_id']) : 0;
        try {
            $videoData = (new VideoCache())->getCache($catId);
        }catch(\Exception $e) {
            return $this->writeJson(Status::CODE_BAD_REQUEST , "请求失败");
        }
        return $this->writeJson(Status::CODE_OK, "OK", $videoData); 

        $count = count($videoData);
        return $this->writeJson(Status::CODE_OK, "OK", $this->getPagingDatas($count, $videoData)); 
    }
    
    
    /**
     * 首页方法
     * @author : evalor <master@evalor.cn>
     */
    public function video()
    {
        $video = [
            'id' => 1222,
            'name' => 'imooc',
            'params' => $this->request()->getRequestParam()
            
        ];
        return $this->writeJson(201, 'OK', $video);
    }
    
    public function getVideo() {
        /*
         * 
         * 框架配置文件注入写法
         * 注册文件EasySwooleEvent.php
         */
        
        Di::getInstance()->get("MYSQL")->queryBuilder()->get('video');
        $result = Di::getInstance()->get("MYSQL")->execBuilder();
        var_dump($result);
        return $this->writeJson(200, 'OK', $result);
        
        
        /*
         * 
         * 原生配置方法
         */
        
        $config = new \EasySwoole\Mysqli\Config([
            'host'          => '127.0.0.1',
            'port'          => 3306,
            'user'          => 'root',
            'password'      => 'root',
            'database'      => 'TPVUE',
            'timeout'       => 5,
            'charset'       => 'utf8mb4',
        ]);
        
        $db = new \EasySwoole\Mysqli\Client($config);
        
        /*
         * 使用了go函数，这些数据只会被打印到终端
         * 由于这个easyswoole是API框架，页面接收数据都需要使用return返回值 例如：下列var_dump的数据库只会显示在终端而不会在页面输出
         */
        
//         go(function ()use($db){
            //构建sql
            $db->queryBuilder()->get('think_user');
            //执行sql
            $result = $db->execBuilder();
//             var_dump($result);
            return $this->writeJson(200, 'OK', $result);
//         });
    }
    /*
     * 下列var_dump的数据库只会显示在终端而不会在页面输出
     */
    public function getRedis() {
        /*
         * 原始写法
         */
//         $redis = new \EasySwoole\Redis\Redis(new \EasySwoole\Redis\Config\RedisConfig([
//             'host' => '127.0.0.1',
//             'port' => '6379',
//             'serialize' => \EasySwoole\Redis\Config\RedisConfig::SERIALIZE_NONE
//         ]));
//         var_dump($redis->set('a',1));
//         var_dump($redis->get('a'));
//         $result = $redis->get('a');
        /*
         * 封装类写法
         * new Redis可以调用公共类
         * edis::getInstance()可以调用私有类
         */
        $redis = new Redis();
        $redis->set('b',2);
        $result[] = $redis->get('b');
        
        Redis::getInstance()->set('c',3);
        $result[] = Redis::getInstance()->get('c');
        return $this->writeJson(200, 'OK', $result);
    }
    
    public function yaconf() {
        $result = \Yaconf::get("Redis");    //Yaconf是php的一个配置文件管理工具，需要安装扩展(推荐)
        return $this->writeJson(200, 'OK', $result);
    }
    //测试样例：http://127.0.0.1:8000/api/index/pub?f=15
    public function pub() {
        $params = $this->request()->getRequestParam();
        Di::getInstance()->get("REDIS")->rPush('imooc_list_test', $params['f']);
    }
}
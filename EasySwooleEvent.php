<?php
namespace EasySwoole\EasySwoole;

use EasySwoole\EasySwoole\Swoole\EventRegister;
use EasySwoole\EasySwoole\AbstractInterface\Event;
use EasySwoole\Http\Request;
use EasySwoole\Http\Response;

use EasySwoole\Component\Di;
use App\Lib\Redis\Redis;
use App\Lib\Process\ConsumerTest;
use EasySwoole\Component\Process\Manager;

use EasySwoole\EasySwoole\Crontab\Crontab;
use App\Lib\OddNumber;


use EasySwoole\Component\Timer;
use App\Lib\Cache\Video as videoCache;

class EasySwooleEvent implements Event
{

    public static function initialize()
    {
        // TODO: Implement initialize() method.
        date_default_timezone_set('Asia/Shanghai');
    }

    public static function mainServerCreate(EventRegister $register)
    {
        // TODO: Implement mainServerCreate() method.
        
        $mysql_config = new \EasySwoole\Mysqli\Config(\Yaconf::get("mysql"));
        
        Di::getInstance()->set('MYSQL', new \EasySwoole\Mysqli\Client($mysql_config));
        
        Di::getInstance()->set('REDIS', Redis::getInstance());    //注册REDIS，下次其他地方就可以直接调用，就相当于REDIS = Redis::getInstance()
        /*
         * 自动后台添加进程
         */
//         $allNum = 3;
//         for ($i = 0 ;$i < $allNum;$i++){
//             $processConfig= new \EasySwoole\Component\Process\Config();
//             $processConfig->setProcessName('ConsumerTest'.$i);//设置进程名称
//             Manager::getInstance()->addProcess(new ConsumerTest($processConfig));
//         }
        // 开始一个定时任务计划
//         Crontab::getInstance()->addTask(OddNumber::class);
        
        
        //使用定时器将数据写入到json中，以后客户获取数据不进行数据库访问，更加快速
        
//         $cacheVideoObj = new videoCache();
//         Timer::getInstance()->loop(1000*2, function() use($cacheVideoObj) {
//             $cacheVideoObj->setIndexVideo();
//         });
        
        
    }

    public static function onRequest(Request $request, Response $response): bool
    {
        // TODO: Implement onRequest() method.
        return true;
    }

    public static function afterRequest(Request $request, Response $response): void
    {
        // TODO: Implement afterAction() method.
    }
}
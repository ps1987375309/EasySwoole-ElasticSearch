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
        
        $allNum = 3;
        for ($i = 0 ;$i < $allNum;$i++){
            $processConfig= new \EasySwoole\Component\Process\Config();
            $processConfig->setProcessName('ConsumerTest'.$i);//设置进程名称
            Manager::getInstance()->addProcess(new ConsumerTest($processConfig));
        }
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
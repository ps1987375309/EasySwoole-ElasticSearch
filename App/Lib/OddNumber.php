<?php
namespace App\Lib;

use EasySwoole\EasySwoole\Crontab\AbstractCronTask;

class OddNumber extends AbstractCronTask
{
    
    public static function getRule(): string
    {
        // TODO: Implement getRule() method.
        //奇数cron表达式
        return '1-59/2 * * * *';
    }
    
    public static function getTaskName(): string
    {
        // TODO: Implement getTaskName() method.
        //定时任务名称
        return  '奇数时间运行';
    }
    
    function run(int $taskId, int $workerIndex)
    {
        // TODO: Implement run() method.
        // 定时任务处理逻辑
        var_dump('奇数运行 '.date('Y-m-d H:i'));
    }
    
    function onException(\Throwable $throwable, int $taskId, int $workerIndex)
    {
        // TODO: Implement onException() method.
        echo $throwable->getMessage();
    }
}
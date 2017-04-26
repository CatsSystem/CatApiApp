<?php
/**
 * Created by PhpStorm.
 * User: lidanyang
 * Date: 16/6/15
 * Time: 上午11:08
 */

namespace app\api\module\home;

use app\common\Error;
use base\framework\BaseController;
use core\common\Globals;
use core\component\pool\PoolManager;
use core\component\task\AsyncTask;
use Redis;

class Api extends BaseController
{
    private $mysql_pool;
    private $redis_pool;

    public function __construct()
    {
        $this->mysql_pool = PoolManager::getInstance()->get('mysql_master');
        $this->redis_pool = PoolManager::getInstance()->get('redis_master');
    }

    public function testApi()
    {
        $redis_result = yield $this->redis_pool->pop()->multi(Redis::PIPELINE);
        if($redis_result['code'] != Error::SUCCESS)
        {
            return $this->error($redis_result['code']);
        }
        return $redis_result;
    }

    public function testMulti()
    {
        $task = new AsyncTask("SampleTask");
        $result = yield $task->sample_task("hello", 1);
        return $result;
    }

    public function testCache()
    {

    }

    public function testHttp()
    {

    }

    public function testTimer()
    {

    }
}

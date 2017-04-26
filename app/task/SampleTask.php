<?php
/**
 * Created by PhpStorm.
 * User: lidanyang
 * Date: 17/1/5
 * Time: 下午4:03
 */

namespace app\task;

use app\common\Error;
use core\common\Globals;
use core\component\pool\PoolManager;
use core\component\task\IRunner;

class SampleTask extends IRunner
{
    private $redis_pool;

    public function __construct()
    {
        $this->redis_pool = PoolManager::getInstance()->get('redis_master');
    }

    public function sample_task($name, $id)
    {
        //TODO: 实现任务逻辑
        $redis_result = yield $this->redis_pool->pop()->get('cache');
        Globals::var_dump($redis_result['data']);

        return [
            'code' => Error::SUCCESS,
            'data' => $redis_result
        ];
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: lidanyang
 * Date: 16/6/15
 * Time: 上午11:08
 */

namespace app\api\module\home;

use base\framework\BaseController;
use core\common\Globals;
use core\component\pool\PoolManager;

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
        $redis_result = yield $this->redis_pool->pop()->get('cache');
        Globals::var_dump($redis_result['data']);
        return $redis_result;
    }

    public function testMulti()
    {

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

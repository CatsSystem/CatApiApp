<?php
/**
 * Created by PhpStorm.
 * User: lidanyang
 * Date: 16/12/15
 * Time: 上午12:28
 */
namespace app\cache;

use app\common\Constants;
use app\common\Error;
use core\component\cache\ILoader;
use core\concurrent\Promise;

class SampleCache extends ILoader
{
    /**
     * 初始化加载器, 定义加载器id 和 tick 数量
     */
    public function init()
    {
        $this->id = Constants::CACHE_SAMPLE;
        $this->tick = 60;                   //  每60个tick更新一次,即600s
    }

    public function load(Promise $promise)
    {
        // 更新缓存数据, 结果使用$promise->resolve()返回

        $promise->resolve([
            'code'  => Error::SUCCESS,
            'data'  => "Hello World"
        ]);
    }


}

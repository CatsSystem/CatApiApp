<?php
/**
 * Created by PhpStorm.
 * User: lidanyang
 * Date: 17/1/5
 * Time: 下午4:03
 */

namespace app\task;

use app\common\Error;
use core\component\task\IRunner;

class SampleTask extends IRunner
{
    public function sample_task($name, $id)
    {
        //TODO: 实现任务逻辑
        return [
            'code' => Error::SUCCESS,
            'data' => "task data"
        ];
    }
}
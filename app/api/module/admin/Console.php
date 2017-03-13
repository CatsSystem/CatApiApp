<?php
/**
 * Created by PhpStorm.
 * User: lidanyang
 * Date: 17/2/9
 * Time: 22:01
 */

namespace app\api\module\admin;

use base\framework\BaseController;
use app\common\Error;

class Console extends BaseController
{
    public function index()
    {

    }

    public function stats()
    {
        return [
            'code'  => Error::SUCCESS,
            'data'  => $this->request->getSocket()->stats()
        ];
    }

    public function shutdown()
    {
        $this->request->getSocket()->shutdown();
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: lidanyang
 * Date: 16/6/15
 * Time: 上午10:48
 */

return array(
    'debug' => true,

    'project'=>array(
        'pid_path'          => __DIR__ . '/../../',
        'project_name'      => 'micro_service',

        'ctrl_path'         => 'app\\api\\module',
        'main_callback'     => "app\\server\\HttpServer",
    ),

    'server' => array(
        'host'          => '0.0.0.0',
        'port'          => 9501,

        'socket_type'   => 'http',
    ),

    'swoole' => [
        'daemonize' => 0,

        'worker_num' => 1,
        'dispatch_mode' => 2,

        'task_worker_num' => 1,

        'package_max_length'    => 524288,
    ],
);

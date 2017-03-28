<?php
/**
 * Created by PhpStorm.
 * User: lidanyang
 * Date: 16/12/2
 * Time: 上午11:13
 */

function usage()
{
    echo "php run.php start | restart | stop | reload [-c config_path]\n";
}

if( !isset($argv[1]) )
{
    usage();
    exit;
}

$cmd = $argv[1];

if( isset($argv[2]) &&  $argv[2] == '-c' ) {
    $debug = $argv[3];
} else {
    $debug = "debug";
}

$config = include "config/{$debug}/config.php";
$pid_path = $config['project']['pid_path'] . '/' . $config['project']['project_name'] . '_master.pid';
$manager_pid_path = $config['project']['pid_path'] . '/' . $config['project']['project_name'] . '_manager.pid';

switch($cmd)
{
    case 'start':
    {
        require_once 'main.php';
        break;
    }
    case 'restart':
    {

        shell_exec("kill -15 `cat {$manager_pid_path}`");
        shell_exec("kill -15 `cat {$pid_path}`");
        echo "restarting...\n";
        sleep(3);
        require_once 'main.php';
        break;
    }
    case 'stop':
    {
        shell_exec("kill -15 `cat {$manager_pid_path}`");
        shell_exec("kill -15 `cat {$pid_path}`");
        break;
    }
    case 'reload':
    {
        shell_exec("kill -USR1 `cat {$manager_pid_path}`");
        shell_exec("kill -USR1 `cat {$pid_path}`");
        break;
    }
}


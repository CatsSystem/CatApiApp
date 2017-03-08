<?php
/**
 * Created by PhpStorm.
 * User: lidanyang
 * Date: 16/6/15
 * Time: 上午11:03
 */

namespace app\server;

use base\Entrance;
use base\framework\Route;
use base\protocol\Request;
use base\socket\BaseCallback;
use core\common\Globals;
use core\component\cache\CacheLoader;
use core\component\config\Config;
use core\component\log\Log;
use core\component\pool\PoolManager;

class HttpServer extends BaseCallback
{
    public function onWorkerStart($server, $workerId)
    {
        // 加载配置
        Config::load(Entrance::$rootPath . '/config');

        // 初始化连接池
        PoolManager::getInstance()->init('mysql_master');
        PoolManager::getInstance()->init('redis_master');
    }

    public function before_start()
    {
        // 打开内存Cache进程
        $this->open_cache_process(function(){
            Globals::setProcessName(Config::getField('project', 'project_name') . 'cache process');
            $cache_config = Config::getField('component', 'cache');

            PoolManager::getInstance()->init('mysql_master');
            PoolManager::getInstance()->init('redis_master');

            CacheLoader::getInstance()->init(Entrance::$rootPath . $cache_config['cache_path'],
                $cache_config['cache_path']);

            return $cache_config['cache_tick'];
        });
    }

    /**
     * @param \swoole_http_request $request
     * @param \swoole_http_response $response
     */
    public function onRequest(\swoole_http_request $request, \swoole_http_response $response)
    {
        if( !in_array($request->server['path_info'], Config::get('route'))) {
            $response->status(403);
            $response->end("");
            return;
        }
        $path = explode('/' , $request->server['path_info']);
        $module     = isset( $path[1] ) ? $path[1] : "";
        $controller = isset( $path[2] ) ? $path[2] : "";
        $method     = isset( $path[3] ) ? $path[3] : "";

        $handle = new Request();
        $handle->setRequest($request);
        $handle->setResponse($response);
        $handle->setSocket($this->server);
        $handle->init($module, $controller, $method,
            isset( $request->post ) ? $request->post : $request->rawContent());

        try {
            $result = yield Route::route($handle);
            $response->header('Content-Type', 'application/json');
            $response->end(json_encode($result, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
        } catch ( \Exception $e ) {
            Log::ERROR('Exception', var_export($e, true));
            $response->status(502);
            $response->end("");
        } catch ( \Error $e ) {
            Log::ERROR('Exception', var_export($e, true));
            $response->status(502);
            $response->end("");
        }
    }
}

## 介绍
Swoole Http API 应用

## 依赖

[CatApi](https://github.com/CatSyatem/CatApi)


## 安装

### Composer安装

```bash
composer create-project --no-dev cat-sys/cat-api-app {project_name}
```

> 注： 测试阶段请使用 `composer create-project --stability=dev --no-dev cat-sys/cat-api-app {project_name}`命令安装


## 异步API

### 异步Task

```php
// 实例化异步任务
$task = new AsyncTask('TestTask');
// 发送任务请求
$result = yield $task->test_task(1, "test", [1, 2, 3 ]);
```

### Redis访问

```php
// 获取连接池
$redis_pool = PoolManager::getInstance()->get('redis_master');

// 发起请求
$redis_result = yield $redis_pool->pop()->get('cache');

```

### MySQL访问

```php

// 获取连接池
$mysql_pool = PoolManager::getInstance()->get('mysql_master');

// 发起请求
$sql_result = yield MySQLStatement::prepare()
    ->select("Test",  "*")
    ->limit(0,2)
    ->query($mysql_pool->pop());

```

### Http请求

```php
$http = new Http("www.baidu.com");
yield $http->init();
$result = yield $http->get('/');

```

## 环境支持

* PHP 7 <br>
* MySQLi 扩展
* Swoole 1.8.8 以上版本 (不适用于Swoole 2.0以上版本)
* [hiredis 库](https://github.com/redis/hiredis)
* [phpredis 扩展](https://github.com/phpredis/phpredis)
* [swoole_serialize 扩展](https://github.com/swoole/swoole_serialize)

## 配置

配置文件均在`config`目录下

## 运行

在项目目录下，执行以下命令
```bash
php run.php start
```
进入DEBUG模式。

执行以下命令
```bash
php run.php start -c release
```
指定配置文件目录

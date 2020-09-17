SimpleTask
------------

> SimpleTask 是一个简单的异步队列任务列表管理器，致力于解决耗时较长的任务（如：生成数据/导出表单之类...），依赖于 `laravel` 


安装
------------
```
composer require jackchow/simple-task
```


配置
------------
```
php artisan vendor:publish --provider="JackChow\SimpleTask\SimpleTaskServiceProvider"
```
配置文件 `config/simpletask.php` 会生成，你可以在这里修改应用默认的配置.

同时，会生成 migrations 数据库迁移文件。 

## 快速开始

1. 该包主要使用 laravel 内置的队列管理，如果不太了解，[请移步](https://learnku.com/docs/laravel/7.x)

2. 运行 `php artisan queue:work` 命令，开启任务监听进程。Tip：任何代码改动都需要重启该进程，否则不会生效.


### 示例代码
Test.php
``` 
use JackChow\SimpleTask\SimpleTask;

class Test
{
    public function index()
    {
        $task = new SimpleTask();
        
        // 创建任务
        $task->initialize([
            'name' => '测试任务 - 导出2020年9月份订单数据', // 任务名称
            'type' => '导出任务', // 任务类型（标识/描述）
            'creator_id' => 0,  // 发起者id
            'params' => ['the_month' => '2020-09'], // 任务参数
            'params_desc' => '所属月份：2020-09', // 参数描述
        ])->handle(TestJob::class);
        
        // 获取任务列表
        SimpleTask::model()->all();
        
        // 获取当前是否有任务进行
        SimpleTask::isProcessing();
        SimpleTask::name('测试任务 - 导出2020年9月份订单数据')->isProcessing();
        SimpleTask::name('测试任务 - 导出2020年9月份订单数据')->creator(0)->isProcessing();
        
        // 查询指定任务是否已创建
        SimpleTask::name('测试任务 - 导出2020年9月份订单数据')->creator(0)->isCreated();
    }
}

```

TestJob.php
```
use JackChow\SimpleTask\SimpleTaskJob;

class TestJob extends SimpleTaskJob
{
    // 处理任务的逻辑
    public function deal()
    {
        // do something ...
    }
}
```


### 提示
本队列默认超市时间为 10 分钟， 若超过该时间进程将会被kill掉.





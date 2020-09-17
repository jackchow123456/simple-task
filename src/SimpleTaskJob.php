<?php
/**
 * Created by PhpStorm.
 * User: zhouminjie
 * Date: 2020-09-14
 * Time: 14:15
 */

namespace JackChow\SimpleTask;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

abstract class SimpleTaskJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $task;

    /**
     * 重试任务前等待的秒数
     *
     * @var int
     */
    public $retryAfter = 5;


    /**
     * 任务可尝试的次数
     *
     * @var int
     */
    public $tries = 3;

    /**
     * 在超时之前任务可以运行的秒数
     *
     * @var int
     */
    public $timeout = 600;

    public function __construct($task)
    {
        $this->task = $task;
    }

    /**
     * 执行任务
     *
     * @throws \Exception
     */
    public function handle()
    {
        $this->task->status = 1;
        $this->task->save();

        $this->deal();

        $this->task->status = 2;
        $this->task->save();
//        throw new \Exception('测试错误信息');
    }

    /**
     *  任务未能处理
     *
     * @param \Exception $exception
     * @throws \Exception
     */
    public function failed(\Exception $exception)
    {
        $this->task->status = 4;
        $this->task->message = $exception->getMessage();
        $this->task->save();
        throw $exception;
    }

    public function getParameter($key)
    {
        return data_get($this->task->params, $key, '');
    }

    abstract public function deal();
}
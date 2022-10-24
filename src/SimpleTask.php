<?php
/**
 * Created by PhpStorm.
 * User: zhouminjie
 * Date: 2020-09-14
 * Time: 14:15
 */

namespace JackChow\SimpleTask;

/**
 * Class SimpleTask
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\JackChow\SimpleTask\SimpleTaskModel name($name)
 * @method static \Illuminate\Database\Eloquent\Builder|\JackChow\SimpleTask\SimpleTaskModel creator($creator)
 *
 * @package JackChow\SimpleTask
 */
class SimpleTask
{
    public $task;
    public $callback;

    /**
     * 初始化任务
     *
     * @param array $configs
     *
     * @return $this
     */
    public function initialize(array $configs)
    {
        $this->task = app(config('simpletask.model'))::create($configs);
        return $this;
    }

    /**
     * 处理方法
     *
     * @param $job
     *
     * @return mixed
     */
    public function handle($job)
    {
        return $job::dispatch($this->task);
    }

    /**
     * 获取模型
     * @return mixed
     */
    public static function model()
    {
        return app(config('simpletask.model'));
    }

    /**
     * 魔术方法
     * @param $name
     * @param $arguments
     *
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        return app(config('simpletask.model'))->$name(...$arguments);
    }

    /**
     * 魔术方法，静态
     *
     * @param $name
     * @param $arguments
     *
     * @return mixed
     */
    public static function __callStatic($name, $arguments)
    {
        return self::model()->$name(...$arguments);
    }
}
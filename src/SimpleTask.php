<?php
/**
 * Created by PhpStorm.
 * User: zhouminjie
 * Date: 2020-09-14
 * Time: 14:15
 */

namespace SimpleTask;

class SimpleTask
{
    public $task;
    public $callback;

    public function initialize(array $configs)
    {
        $this->task = app(config('simpletask.model'))::create($configs);
        return $this;
    }

    public function handle($job)
    {
        $job::dispatch($this->task);
    }

    public static function model()
    {
        return app(config('simpletask.model'));
    }
}
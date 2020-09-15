<?php
/**
 * Created by PhpStorm.
 * User: zhouminjie
 * Date: 2020-09-14
 * Time: 14:15
 */

namespace SimpleTask;

use Illuminate\Database\Eloquent\Model;

class SimpleTaskModel extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'params' => 'array'
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->setTable(config('simpletask.table_name'));
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: zhouminjie
 * Date: 2020-09-14
 * Time: 14:15
 */

namespace JackChow\SimpleTask;

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


    public function scopeIsProcessing($query)
    {
        return $query->where('status', 1)->first() ? true : false;
    }


    public function scopeIsCreated($query)
    {
        return $query->whereIn('status', [0, 1])->first() ? true : false;
    }

    public function scopeName($query, $name)
    {
        return $query->where('name', $name);
    }

    public function scopeCreator($query, $creatorId)
    {
        return $query->where('creator_id', $creatorId);
    }
}
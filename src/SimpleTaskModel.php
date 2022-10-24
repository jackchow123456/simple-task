<?php
/**
 * Created by PhpStorm.
 * User: zhouminjie
 * Date: 2020-09-14
 * Time: 14:15
 */

namespace JackChow\SimpleTask;

use Illuminate\Database\Eloquent\Model;


/**
 * Class SimpleTaskModel
 *
 * @method  static bool IsCreated()
 * @method  static bool IsProcessing()
 *
 * @package JackChow\SimpleTask
 */
class SimpleTaskModel extends Model
{
    /**
     * 查询/修改黑名单
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * 数据转换
     * @var array
     */
    protected $casts = [
        'params' => 'array'
    ];

    /**
     * 构造方法，初始化Model
     *
     * SimpleTaskModel constructor.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->setTable(config('simpletask.table_name'));
    }

    /**
     * 检查任务是否在运行
     *
     * @param $query
     *
     * @return bool
     */
    public function scopeIsProcessing($query)
    {
        return $query->where('status', 1)->first() ? true : false;
    }

    /**
     * 检查任务是否已被创建
     *
     * @param $query
     *
     * @return bool
     */
    public function scopeIsCreated($query)
    {
        return $query->whereIn('status', [0, 1])->first() ? true : false;
    }

    /**
     * 全局查询，名称
     *
     * @param $query
     * @param $name
     *
     * @return mixed
     */
    public function scopeName($query, $name)
    {
        return $query->where('name', $name);
    }

    /**
     * 全局查询，创建者
     *
     * @param $query
     * @param $creatorId
     *
     * @return mixed
     */
    public function scopeCreator($query, $creatorId)
    {
        return $query->where('creator_id', $creatorId);
    }
}
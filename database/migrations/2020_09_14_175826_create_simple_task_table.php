<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSimpleTaskTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(config('simpletask.table_name'), function (Blueprint $table) {
            $table->bigIncrements('id')->comment('主键ID');
            $table->integer('creator_id')->default(0)->comment('发起任务用户Id');
            $table->text('name')->comment('任务名称');
            $table->text('type')->comment('任务类型');
            $table->tinyInteger('status')->comment('任务状态{0:未开始，1:进行中，2:已完成，3:已取消，4:异常终止}');
            $table->longText('params')->comment('任务参数');
            $table->longText('file_path')->comment('数据文件路径');
            $table->tinyInteger('is_deleted')->comment('文件是否已经被删除{0:否，1:是}');
            $table->text('message')->comment('异常终止信息');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(config('simpletask.table_name'));
    }
}

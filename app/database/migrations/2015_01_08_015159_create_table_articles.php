<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableArticles extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('cid')->default(0);
            $table->integer('uid')->default(0);
            $table->string('title',150);
            $table->string('description',250)->nullable();
            $table->string('litpic',255)->nullable();
            $table->mediumText('content_html')->nullable();//正文源码
            $table->mediumText('content_md')->nullable();//正文渲染后的html
            $table->timestamps();
            $table->index('cid');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('articles');
    }

}

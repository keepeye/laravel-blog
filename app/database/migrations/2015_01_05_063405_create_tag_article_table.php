<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTagArticleTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tag_article', function(Blueprint $table)
		{
			$table->integer('tid');//标签id
            $table->integer('aid');//文档id
            $table->primary(['tid','aid']);//联合主键
            $table->index('aid');//索引文档id
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tag_relations');
	}

}

<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTableCategories extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('categories', function(Blueprint $table)
		{
            //是否最终分类，文档只允许关联最终分类，非最终分类才可以创建子分类
            $table->tinyInteger('final')->default(0)->after('name');
            //父分类id
			$table->integer('parent')->default(0)->after('final');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('categories', function(Blueprint $table)
		{
			$table->dropColumn('parent');
            $table->dropColumn('final');
		});
	}

}

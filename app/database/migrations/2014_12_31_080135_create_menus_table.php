<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenusTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('menus',function($table){
            $table->increments('id');
            $table->integer('pid')->default(0);
            $table->string('name',50)->nullable()->default(null);
            $table->string('title',50);
            $table->string('url',200)->nullable()->default(null);
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::dropIfExists('menus');
	}

}

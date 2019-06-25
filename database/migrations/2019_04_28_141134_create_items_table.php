<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateItemsTable extends Migration {

	public function up()
	{
		Schema::create('items', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('restaurant_id')->unsigned();
			$table->string('name');
			$table->integer('price');
			$table->text('description');
			$table->string('image')->nullable();
			$table->time('prepare_time');
		});
	}

	public function down()
	{
		Schema::drop('items');
	}
}
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOffersTable extends Migration {

	public function up()
	{
		Schema::create('offers', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('name');
			$table->integer('restaurant_id')->unsigned();
			$table->integer('price');
			$table->text('description');
			$table->string('image')->nullable();
			$table->datetime('start_from');
			$table->datetime('end_at');
		});
	}

	public function down()
	{
		Schema::drop('offers');
	}
}
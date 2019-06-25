<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRatesTable extends Migration {

	public function up()
	{
		Schema::create('rates', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('client_id')->unsigned();
			$table->integer('restaurant_id')->unsigned();
			$table->string('comment');
			$table->enum('rate', array('1', '2', '3', '4', '5'));
			$table->datetime('date');
		});
	}

	public function down()
	{
		Schema::drop('rates');
	}
}
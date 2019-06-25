<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePaymentsTable extends Migration {

	public function up()
	{
		Schema::create('payments', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('restaurant_id')->unsigned();
			$table->integer('restaurant_sales');
			$table->integer('commission');
			$table->integer('pay_off');
			$table->integer('remaning');
		});
	}

	public function down()
	{
		Schema::drop('payments');
	}
}
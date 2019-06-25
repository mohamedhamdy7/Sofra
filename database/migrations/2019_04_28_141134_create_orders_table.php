<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOrdersTable extends Migration {

	public function up()
	{
		Schema::create('orders', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('restaurant_id')->unsigned();
			$table->enum('status', array('pending', 'accepted', 'rejected', 'deliverd', 'canceled'))->nullable();
			$table->string('address');
			$table->integer('order_number');
			$table->integer('price')->nullable();

			$table->integer('total')->nullable();
			$table->integer('client_phone');
			$table->integer('client_id')->unsigned();
			$table->text('privte_order')->nullable();
			$table->float('comission')->nullable();
			$table->float('net')->nullable();
			$table->enum('payment', array('cash', 'network'))->nullable();
		});
	}

	public function down()
	{
		Schema::drop('orders');
	}
}
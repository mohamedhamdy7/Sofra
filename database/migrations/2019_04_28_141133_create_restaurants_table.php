<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRestaurantsTable extends Migration {

	public function up()
	{
		Schema::create('restaurants', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('name');
			$table->integer('region_id')->unsigned();

			$table->string('email');
			$table->string('password');
			$table->enum('status', array('open', 'close'));
			$table->integer('min_price');
			$table->integer('delivery_cost');
			$table->integer('phone');
			$table->integer('whatsapp');
			$table->string('image');
			$table->string('api_token')->nullable();
			$table->integer('pin_code')->nullable();
			$table->string('delivery_way');
            $table->tinyInteger('activated')->default(0);
		});
	}

	public function down()
	{
		Schema::drop('restaurants');
	}
}
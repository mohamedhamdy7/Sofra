<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateClientsTable extends Migration {

	public function up()
	{
		Schema::create('clients', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('name');
			$table->string('email');
			$table->integer('phone');

			$table->integer('region_id')->unsigned();
			$table->text('description');
			$table->string('password')->unique();
			$table->string('image')->nullable();
			$table->string('api_token')->nullable();
			$table->string('pin_code')->nullable();
            $table->tinyInteger('activated')->default(0);
		});
	}

	public function down()
	{
		Schema::drop('clients');
	}
}
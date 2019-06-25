<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateNotificationsTable extends Migration {

	public function up()
	{
		Schema::create('notifications', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('title');
			$table->text('content');
            $table->integer('order_id');
            $table->integer('notifiable_id');
            $table->string('notifiable_type');
		});
	}

	public function down()
	{
		Schema::drop('notifications');
	}
}
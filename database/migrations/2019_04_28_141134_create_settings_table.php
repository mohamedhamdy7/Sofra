<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSettingsTable extends Migration {

	public function up()
	{
		Schema::create('settings', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('facebook_url');
			$table->string('android_app_url');
			$table->string('instagram_url');
			$table->string('twitter_url');
			$table->text('about_app');
            $table->float('comission')->nullable();
		});
	}

	public function down()
	{
		Schema::drop('settings');
	}
}
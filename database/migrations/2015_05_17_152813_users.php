<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class Users extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('users', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->string('username')->unique();
			$table->string('email')->unique();
			$table->string('first_name')->nullable();
			$table->string('last_name')->nullable();
			$table->string('picture')->default('placeholders/profile.png');
			$table->string('password')->nullable();
			$table->rememberToken();
			$table->timestamps();
		});

		Schema::create('user_social_accounts', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->bigInteger('user_id')->unsigned();
			$table->string('source');
			$table->string('source_id');
			$table->string('access_token');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('users');
		Schema::drop('user_social_accounts');
	}

}

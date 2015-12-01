<?php

use Illuminate\Database\Migrations\Migration;

class UserUpdates extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('user_updates', function ($table) {
			$table->bigIncrements('id');
			$table->bigInteger('user_id');
			$table->bigInteger('source_id');
			$table->string('previous_level')->nullable();
			$table->string('current_level')->nullable();
			$table->timestamps();

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		//
	}
}

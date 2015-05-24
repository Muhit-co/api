<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateIssuesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('issues', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->integer('user_id')->unsigned();
			$table->string('title');
			$table->text('desc');
			$table->string('status')->default('new');
			$table->integer('city_id')->unsigned()->nullable();
			$table->integer('district_id')->unsigned()->nullable();
			$table->integer('hood_id')->unsigned()->nullable();
			$table->string('location')->nullable();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('issues');
	}

}

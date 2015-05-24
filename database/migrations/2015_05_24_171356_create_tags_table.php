<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTagsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('tags', function (Blueprint $table) {
			$table->increments('id');
			$table->string('name');
			$table->string('background')->default('default');
			$table->timestamps();
		});
		Schema::create('issue_tag', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->integer('tag_id')->unsigned();
			$table->bigInteger('issue_id')->unsigned();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('tags');
		Schema::drop('issue_tag');
	}

}

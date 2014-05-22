<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class GenerateCitiesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('cities', function(Blueprint $table) {
			$table->increments('id')->unsigned();
			$table->string('name');
			$table->integer('region')->nullable();
			$table->float('population')->nullable();
			$table->double('longitude', 12, 7)->nullable();
			$table->double('latitude', 12, 7)->nullable();
			$table->integer('country_id')->unsigned()->nullable();
			$table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('cities');
	}

}

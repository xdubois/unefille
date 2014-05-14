<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateUserTableAddFields extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::table('users', function (Blueprint $user) {
			$user->boolean('sex')->nullable();
			$user->string('username');
			$user->smallInteger('age')->nullable();
			$user->boolean('certified')->default(0);
			$user->integer('visit_count')->default(0);
		});	

	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::table('users', function(Blueprint $user) {
			$user->dropColumn('sex', 'age', 'certified', 'visit_count');
		});
	}

}

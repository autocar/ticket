<?php

use Illuminate\Database\Migrations\Migration;

class CreateMembersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('members', function($table)
        {
            $table->increments('id');
            $table->string('email');
            $table->string('password');
            $table->string('name');
            $table->string('mobile');
            $table->string('product');
            $table->timestamp('start_time');
            $table->timestamp('end_time');
            $table->timestamps();
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::drop('members');
	}

}
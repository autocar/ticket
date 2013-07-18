<?php

use Illuminate\Database\Migrations\Migration;

class CreateTitleTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('titles', function($table)
        {
            $table->increments('id');
            $table->integer('job_id')->unsigned();
            $table->integer('member_id')->unsigned();
            $table->string('title');
            $table->text('content');
            $table->timestamp('start_time');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::drop('titles');
	}

}
<?php

use Illuminate\Database\Migrations\Migration;

class CreateProjectTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('projects', function($table)
        {
            $table->increments('id');
            $table->integer('job_id')->unsigned();
            $table->integer('title_id')->unsigned();
            $table->integer('operator_id')->unsigned();
            $table->text('content');
            $table->timestamp('end_time');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::drop('projects');
	}
}
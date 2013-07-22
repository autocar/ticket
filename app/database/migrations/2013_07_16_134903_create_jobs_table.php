<?php

use Illuminate\Database\Migrations\Migration;

class CreateJobsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('jobs', function($table)
        {
            $table->increments('id');
            $table->integer('member_id')->unsigned();
            $table->integer('operator_id')->unsigned();
            $table->integer('trouble_id')->unsigned();
            $table->enum('status', array('0', '1','2','3'));
            $table->enum('level', array('0', '1','2'));
            $table->enum('assess', array('0', '1','2','3'));
            $table->string('title');
            $table->text('content');
            $table->string('file');
            $table->timestamp('start_time');
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
        Schema::drop('jobs');
	}
}
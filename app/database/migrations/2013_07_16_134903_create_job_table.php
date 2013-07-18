<?php

use Illuminate\Database\Migrations\Migration;

class CreateJobTable extends Migration {

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
            $table->enum('repeat', array('0', '1'));
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
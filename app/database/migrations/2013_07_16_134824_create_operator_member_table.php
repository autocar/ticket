<?php

use Illuminate\Database\Migrations\Migration;

class CreateOperatorMemberTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('operator_member', function($table)
        {
            $table->increments('id');
            $table->integer('operator_id')->unsigned();
            $table->integer('member_id')->unsigned();
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::drop('operator_member');
	}

}
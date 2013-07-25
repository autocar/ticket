<?php

use Illuminate\Database\Migrations\Migration;

class CreateProjectsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function ($table)
        {
            $table->increments('id');
            $table->integer('job_id')->unsigned();
            $table->integer('member_id')->unsigned();
            $table->integer('operator_id')->unsigned();
            $table->enum('type', array(
                                      '0',
                                      '1',
                                      '2'
                                 ));
            $table->text('content');
            $table->integer('image_id')->unsigned();
            $table->timestamp('reply_time');
            $table->enum('append', array(
                                        '0',
                                        '1'
                                   ));
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
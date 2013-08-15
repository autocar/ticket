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
        Schema::create('members', function ($table)
        {
            $table->increments('id');
            $table->string('bn');
            $table->string('email');
            $table->string('password');
            $table->string('name');
            $table->string('mobile');
            $table->string('company');
            $table->string('introduction');
            $table->timestamp('start_time');
            $table->timestamp('end_time');
            $table->integer('trouble_id')->unsigned();
            $table->integer('cgroup_id')->unsigned();
            $table->integer('image_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();
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
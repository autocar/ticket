<?php

class UsersTableSeeder extends Seeder {

    /**
     * 用户初始化数据
     */
    public function run()
    {
        // 前台用户
        DB::table('members')->delete();

        $users = array(
            array(
                'id'          => '10000',
                'email'       => 'demo@ecdo.cc',
                'password'    => Hash::make('demo'),
                'name'        => 'demo',
                'mobile'      => '13000000000',
                'product'     => '',
                'bn'          => '',
                'operator_id' => '1',
                'start_time'  => new DateTime,
                'created_at'  => new DateTime,
            )
        );

        DB::table('members')->insert($users);

        // 后台管理
        DB::table('operators')->delete();

        $users = array(
            array(
                'username'   => 'admin',
                'password'   => Hash::make('admin'),
                'name'       => 'admin',
                'email'      => 'cc@ecdo.cc',
                'mobile'     => '13500000000',
                'lv'         => '2',
                'created_at' => new DateTime,
            )
        );

        DB::table('operators')->insert($users);
    }

}

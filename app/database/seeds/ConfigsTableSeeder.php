<?php

class ConfigsTableSeeder extends Seeder {

    /**
     * 初始化系统配置
     */
    public function run()
    {
        DB::table('configs')->delete();

        $configs = array(
            array(
                'key'   => 'auto_close',
                'value' => '0',
            ),
            array(
                'key'   => 'auto_close_time',
                'value' => '24',
            )
        );

        DB::table('configs')->insert($configs);
    }

}

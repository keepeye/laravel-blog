<?php
class OptionSeeder extends Seeder {

    public function run()
    {
        // 清空数据
        DB::table('options')->truncate();
        //默认配置项
        Option::insert(array(
            array(
                'key' => 'site.name',
                'value' => '我的网站',
            )
        ));

    }
}
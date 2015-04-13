<?php
class SentrySeeder extends Seeder {

    public function run()
    {
        // 清空数据
        DB::table('users')->truncate();
        DB::table('groups')->truncate();
        DB::table('users_groups')->truncate();

        //创建用户组
        $group = Sentry::createGroup(array(
            'name' => '管理员',
            'permissions' => array(
                'superuser' => '1'
            )
        ));

        // 创建用户
        $user = Sentry::createUser(array(
            'email'      => 'admin',
            'password'   => "123456",
            'first_name' => 'admin',
            'last_name'  => '',
            'activated'  => 1,
        ));

        //关联用户组
        $user->addGroup($group);
    }
}
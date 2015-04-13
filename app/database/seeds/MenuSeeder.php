<?php
class MenuSeeder extends Seeder {

    public function run()
    {
        // 清空数据
        DB::table('menus')->truncate();
        //填充预设菜单
        $home = Menu::create(array(
            'title' => '首页',
            'pid'   => 0,
            'name' => 'admin.index.index',
        ));

        $content = Menu::create(array(
            'title' => '内容',
            'pid' => 0,
        ));

        //文章权限
        $article = Menu::create(array(
            'title' => '文章管理',
            'pid' => $content->id,
            'name' => 'admin.article.index',
        ));

        Menu::create(array(
            'title' => '新建',
            'pid' => $article->id,
            'name' => 'admin.article.create'
        ));

        Menu::create(array(
            'title' => '保存新建',
            'pid' => $article->id,
            'name' => 'admin.article.store'
        ));

        Menu::create(array(
            'title' => '编辑',
            'pid' => $article->id,
            'name' => 'admin.article.edit'
        ));

        Menu::create(array(
            'title' => '保存编辑',
            'pid' => $article->id,
            'name' => 'admin.article.update'
        ));

        Menu::create(array(
            'title' => '批量操作',
            'pid' => $article->id,
            'name' => 'admin.article.batch'
        ));

        //单页权限
        $page = Menu::create(array(
            'title' => '单页面管理',
            'pid' => $content->id,
            'name' => 'admin.page.index',
        ));

        Menu::create(array(
            'title' => '新建',
            'pid' => $page->id,
            'name' => 'admin.page.create'
        ));

        Menu::create(array(
            'title' => '保存新建',
            'pid' => $page->id,
            'name' => 'admin.page.store'
        ));

        Menu::create(array(
            'title' => '编辑',
            'pid' => $page->id,
            'name' => 'admin.page.edit'
        ));

        Menu::create(array(
            'title' => '保存编辑',
            'pid' => $page->id,
            'name' => 'admin.page.update'
        ));

        Menu::create(array(
            'title' => '批量操作',
            'pid' => $page->id,
            'name' => 'admin.page.batch'
        ));


        $usermanage = Menu::create(array(
            'title' => '用户',
            'pid' => 0,
        ));

        //用户管理权限
        $user = Menu::create(array(
            'title' => '用户管理',
            'pid' => $usermanage->id,
            'name' => 'admin.user.index',
        ));
        Menu::create(array(
            'title' => '新建',
            'pid' => $user->id,
            'name' => 'admin.user.create'
        ));

        Menu::create(array(
            'title' => '保存新建',
            'pid' => $user->id,
            'name' => 'admin.user.store'
        ));

        Menu::create(array(
            'title' => '编辑',
            'pid' => $user->id,
            'name' => 'admin.user.edit'
        ));

        Menu::create(array(
            'title' => '保存编辑',
            'pid' => $user->id,
            'name' => 'admin.user.update'
        ));

        Menu::create(array(
            'title' => '批量操作',
            'pid' => $user->id,
            'name' => 'admin.user.batch'
        ));

        //用户组
        $group = Menu::create(array(
            'title' => '用户组管理',
            'pid' => $usermanage->id,
            'name' => 'admin.group.index',
        ));
        Menu::create(array(
            'title' => '新建',
            'pid' => $group->id,
            'name' => 'admin.group.create'
        ));

        Menu::create(array(
            'title' => '保存新建',
            'pid' => $group->id,
            'name' => 'admin.group.store'
        ));

        Menu::create(array(
            'title' => '编辑',
            'pid' => $group->id,
            'name' => 'admin.group.edit'
        ));

        Menu::create(array(
            'title' => '保存编辑',
            'pid' => $group->id,
            'name' => 'admin.group.update'
        ));

        Menu::create(array(
            'title' => '批量操作',
            'pid' => $group->id,
            'name' => 'admin.group.batch'
        ));

        $system = Menu::create(array(
            'title' => '系统',
            'pid' => 0,

        ));

        $menu = Menu::create(array(
            'title' => '菜单管理',
            'pid' => $system->id,
            'name' => 'admin.menu.index',
        ));

        Menu::create(array(
            'title' => '新建',
            'pid' => $menu->id,
            'name' => 'admin.menu.create'
        ));

        Menu::create(array(
            'title' => '保存新建',
            'pid' => $menu->id,
            'name' => 'admin.menu.store'
        ));

        Menu::create(array(
            'title' => '编辑',
            'pid' => $menu->id,
            'name' => 'admin.menu.edit'
        ));

        Menu::create(array(
            'title' => '保存编辑',
            'pid' => $menu->id,
            'name' => 'admin.menu.update'
        ));

        Menu::create(array(
            'title' => '批量操作',
            'pid' => $menu->id,
            'name' => 'admin.menu.batch'
        ));

        $category = Menu::create(array(
            'title' => '分类管理',
            'pid' => $system->id,
            'name' => 'admin.category.index',
        ));

        Menu::create(array(
            'title' => '新建',
            'pid' => $category->id,
            'name' => 'admin.category.create'
        ));

        Menu::create(array(
            'title' => '保存新建',
            'pid' => $category->id,
            'name' => 'admin.category.store'
        ));

        Menu::create(array(
            'title' => '编辑',
            'pid' => $category->id,
            'name' => 'admin.category.edit'
        ));

        Menu::create(array(
            'title' => '保存编辑',
            'pid' => $category->id,
            'name' => 'admin.category.update'
        ));

        Menu::create(array(
            'title' => '批量操作',
            'pid' => $category->id,
            'name' => 'admin.category.batch'
        ));

        $option = Menu::create(array(
            'title' => '站点设置',
            'pid' => $system->id,
            'name' => 'admin.option.index',
        ));

        Menu::create(array(
            'title' => '保存',
            'pid' => $option->id,
            'name' => 'admin.option.save'
        ));



        $systool = Menu::create(array(
            'title' => '系统工具',
            'pid' => $system->id,
            'name' => 'admin.systool.index',
        ));

        Menu::create(array(
            'title' => '缓存清理',
            'pid' => $systool->id,
            'name' => 'admin.systool.flushcache'
        ));

    }
}
<?php
//登出操作
Route::get('logout',['as'=>'logout',function(){
    Sentry::logout();
    return Redirect::route('admin.authentication.create');
}]);

//登陆
Route::resource('admin/authentication','Controllers\Admin\AuthenticationController',array(
    'only' => ['store','create','destroy']
));

//后台路由组，需要检测登陆和授权
Route::group(['prefix'=>'admin','namespace'=>'Controllers\Admin','before'=>['checkLogin']],function(){
    //后台首页
    Route::resource('index','IndexController');
    //分类
    Route::resource('category','CategoryController');
    Route::post('category/batch',['uses'=>'CategoryController@batch','as'=>'admin.category.batch']);
    //用户
    Route::resource('user','UserController');
    Route::post('user/batch',['uses'=>'UserController@batch','as'=>'admin.user.batch']);
    //用户组
    Route::resource('group','GroupController');
    Route::post('group/batch',['uses'=>'GroupController@batch','as'=>'admin.group.batch']);
    //菜单
    Route::resource('menu','MenuController');
    Route::post('menu/batch',['uses'=>'MenuController@batch','as'=>'admin.menu.batch']);
    //文章
    Route::resource('article','ArticleController');
    Route::post('article/batch',['uses'=>'ArticleController@batch','as'=>'admin.article.batch']);
    //单页
    Route::resource('page','PageController');
    Route::post('page/batch',['uses'=>'PageController@batch','as'=>'admin.page.batch']);
    //站点设置
    Route::get('option',['uses'=>'OptionController@index','as'=>'admin.option.index']);
    Route::post('option/save',['uses'=>'OptionController@save','as'=>'admin.option.save']);
    //系统工具
    Route::get('systool/index',['uses'=>'SysToolController@index','as'=>'admin.systool.index']);
    Route::get('systool/flushcache',['uses'=>'SysToolController@flushCache','as'=>'admin.systool.flushcache']);
    //插件管理
    Route::resource('plugin','PluginController');
    //默认路由
    Route::any('/',function(){
        return Redirect::route('admin.index.index');
    });
});


//前台路由
Route::get('/',['uses'=>'IndexController@index','as'=>'index']);//首页
Route::get('/category/{id}',['uses'=>'CategoryController@show','as'=>'category.show']);//分类页
Route::get('/article/{id}',['uses'=>'ArticleController@show','as'=>'article.show']);//文章页
Route::get('/page/{id}',['uses'=>'PageController@show','as'=>'page.show']);//单页
Route::get('/tag/{name}',['uses'=>'TagController@show','as'=>'tag.show']);//tag页

//全局表单跨站请求过滤器
Route::when('*','csrf',array('post','put','delete'));
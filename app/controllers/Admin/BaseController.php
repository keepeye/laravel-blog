<?php namespace Controllers\Admin;
use View,Sentry,Msgbox,Route,Menu;

class BaseController extends \Controller {

    public $user;

    public function __construct()
    {
        //加载一些只有后台需要的类库
        $this->injectServices();
        //
        $ctrl = $this;
        //根据resource路由的route name检测访问权限、初始化$this->user
        $this->beforeFilter(function() use ($ctrl){
            $user = Sentry::getUser();
            if(!$user->hasAccess(Route::currentRouteName())){
                return Msgbox::error('对不起，你没有权限访问该页面');
            }
            $ctrl->user = $user;
            //用户模型绑定到视图
            View::share('user',$user);
        });
    }

    //注入一些特殊服务
    protected function injectServices()
    {
        \App::singleton('Markdown','Michelf\Markdown');
    }


    protected function setupLayout()
    {
        if ( ! is_null($this->layout))
        {
            $this->layout = View::make($this->layout);
        }
    }
}
<?php

/**
 * 前端控制器基类
 * Class BaseController
 */
class BaseController extends Controller {
    public function __construct()
    {
        //获取主题配置
        if ($theme = Config::get('site.theme','default')) {
            $path = App::make('path').'/views/frontend/'.$theme;
            View::getFinder()->setDefaultNamespace($theme,$path);
        }
    }

}
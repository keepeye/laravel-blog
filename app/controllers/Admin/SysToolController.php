<?php namespace Controllers\Admin;
use View,Msgbox;

/**
 * 系统工具类
 * Class SysToolController
 * @package Controllers\Admin
 */
class SysToolController extends BaseController {
    /**
     * 工具列表
     */
    public function index()
    {
        return View::make('admin.systool.index');
    }

    /**
     * 清空缓存
     */
    public function flushCache($tag="")
    {
        switch($tag){
            case "options":
            case "index.index.articles":
            case "hotTags":
            case "navPages":
            case "navList":
                \Cache::forget($tag);
                break;
            default:
                \Cache::flush();
        }
        return Msgbox::info('清理成功');
    }

}

<?php namespace Controllers\Admin;
use View;
/**
 * Class PluginController
 * 插件管理
 * @package Controllers\Admin
 */
class PluginController extends BaseController {
    private $pluginPath;

    public function __construct()
    {
        parent::__construct();
        $this->pluginPath = \App::getFacadeRoot()['path.plugins'];

    }

    public function index()
    {
        $plugins = array();
        $classes = $this->getPluginClasses();
        foreach($classes as $class){
            $plugins[$class::PLUGIN_IDENTITY] = array(
                'name' => $class::PLUGIN_NAME,
                'description' => $class::PLUGIN_DESCRIPTION,
                'version' => $class::PLUGIN_VERSION,
                'author' => $class::PLUGIN_AUTHOR,
                'homePage' => $class::PLUGIN_HOME_PAGE
            );
        }

        $bindings = array(
            "plugins" => &$plugins
        );
        return View::make('admin.plugin.index',$bindings);
    }

    private function getPluginClasses()
    {
        $classes = array();
        foreach (glob($this->pluginPath.'/*',GLOB_ONLYDIR) as $dir) {
            $namespace = basename($dir);
            foreach (glob($dir.'/*',GLOB_ONLYDIR) as $pluginDir) {
                $pluginName = basename($pluginDir);
                $class = 'Plugins\\'.$namespace.'\\'.$pluginName.'\\'.$pluginName;
                if (!$this->checkClass($class)) {
                    continue;
                }
                $classes[] = $class;
            }
        }
        return $classes;
    }

    private function checkClass($class)
    {
        if (!class_exists($class,true)) {
            return false;
        }

        return true;
    }

}
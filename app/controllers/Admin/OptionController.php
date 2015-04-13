<?php namespace Controllers\Admin;
use View,Input,Msgbox;
class OptionController extends BaseController {
    public function index()
    {
        $options = array();
        foreach (\Option::all() as $option) {
            $options[$option->key] = $option->value;
        }
        return View::make('admin.option.index')->with('options',$options);
    }

    public function save()
    {
        \Option::setVals(Input::get('data',array()));
        return Msgbox::info('保存完成');
    }
}
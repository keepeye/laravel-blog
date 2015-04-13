<?php
class CategoryObserver {
    public function saving($category)
    {
        if (!$category->validateParent()) {
            $category->pushError("父分类不存在或者是最终分类，或者是当前分类后代");
            return false;
        }

        $dataArr = $category->toArray();

        $rules = array(
            'name' => ['required']
        );

        $messages = array(
            'name.required' => '分类名称不能留空'
        );

        $validator = Validator::make($dataArr,$rules,$messages);

        if($validator->fails()){
            $category->pushError($validator->messages()->first());
            return false;
        }
    }

    public function saved($category)
    {
        //清除缓存
        Cache::forget('category_'.$category->id);
    }

    public function deleted($category)
    {
        //清除缓存
        Cache::forget('category_'.$category->id);
    }
}
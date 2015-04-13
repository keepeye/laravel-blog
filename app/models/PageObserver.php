<?php

/**
 * Article模型观察者
 */
class PageObserver {

    /**
     * 创建数据时
     * @param $page
     */
    public function creating($page)
    {
        $page->uid = \Sentry::getUser()->id;
    }


    /**
     * 保存数据之前
     * @param $page
     * @return bool
     */
    public function saving($page)
    {
        //autocomplete
        $this->parseContent($page);
        //validate
        if ($this->validateFields($page) === false) return false;
    }


    /**
     * 保存成功后
     * @param $page
     */
    public function saved($page)
    {
        //清除缓存
        Cache::forget('page_'.$page->id);
    }


    /**
     * 删除事件
     * @param $page
     */
    public function deleting($page)
    {

    }

    public function deleted($page)
    {
        //清除缓存
        Cache::forget('page_'.$page->id);
    }

    /**
     * 解析content源码并转换成html
     * @param $page
     */
    private function parseContent($page)
    {
        if (!empty($page->content_md)) {
            //$page->content_md = htmlspecialchars($page->content_md);
            $markdown = \App::make('Markdown');
            $page->content_html = $markdown->defaultTransform($page->content_md);
        }
    }





    /**
     * 验证表单字段
     * @param $page
     * @return bool
     */
    private function validateFields($page)
    {
        if (!$page->title) {
            $page->pushError('标题不能为空');
            return false;
        }

        return true;
    }




}
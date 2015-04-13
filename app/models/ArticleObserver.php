<?php

/**
 * Article模型观察者
 */
class ArticleObserver {

    /**
     * 创建数据时
     * @param $model
     */
    public function creating($model)
    {
        $model->uid = \Sentry::getUser()->id;
    }

    /**
     * 保存数据之前
     * @param $model
     * @return bool
     */
    public function saving($model)
    {
        //处理内容
        $this->parseContent($model);
        //验证
        if ($this->validateFields($model) === false) return false;
    }

    /**
     * 保存成功后
     * @param $model
     */
    public function saved($model)
    {
        //清理缓存
        Cache::forget('article_'.$model->id);
        $this->saveTags($model, Input::get('tags'));
    }

    /**
     * 删除事件
     * @param $model
     */
    public function deleting($model)
    {
        //tag weight -1
        $tids = DB::table('tag_article')->where('aid','=',$model->id)->lists('tid');

        if (!$tids) return;

        DB::table('tags')->whereIn('id',$tids)->decrement('weight');
        //删除与tag的关联
        DB::table('tag_article')->where('aid','=',$model->id)->delete();

    }

    public function deleted($model)
    {
        //清理缓存
        Cache::forget('article_'.$model->id);
    }

    /**
     * 解析content源码并转换成html
     * @param $model
     */
    private function parseContent($model)
    {
        if (!empty($model->content_md)) {
            //$model->content_md = htmlspecialchars($model->content_md);
            $markdown = \App::make('Markdown');
            $model->content_html = $markdown->defaultTransform($model->content_md);
        }
    }

    /**
     * 验证表单字段
     * @param $model
     * @return bool
     */
    private function validateFields($model)
    {
        if (!$model->title) {
            $model->pushError('标题不能为空');
            return false;
        }

        if ($model->cid > 0) {
            $category = Category::find($model->cid);
            if (!$category || $category->final != 1) {
                $model->pushError('分类不是最终分类');
                return false;
            }
        }

        return true;
    }


    /**
     * 更新tags
     * @param $model
     * @param string $tags
     */
    public function saveTags($model, $tags="")
    {
        if (!$model->id) return;
        //只取前5个tags
        $tags = strtolower(strip_tags(trim($tags)));
        if ($tags != "") {
            $tags = array_slice(explode(",",$tags),0,5);
        } else {
            $tags = array();
        }

        DB::beginTransaction();
        //读取已关联tagid
        $oldtids = DB::table('tag_article')->where('aid','=',$model->id)->lists('tid');
        $tids = array();

        //逐个处理tag
        foreach ($tags as $tagName) {
            $tag = DB::table('tags')->where('name','=',$tagName)->first();
            if (!$tag) {
                $tag = new Tag;
                $tag->name = $tagName;
                if (!$tag->save()) {
                    continue;
                }
            }
            $tids[] = $tag->id;
        }

        //新tag建立关系
        $newtids = array_diff($tids,$oldtids);
        if (!empty($newtids)) {
            foreach ($newtids as $tid) {
                DB::table('tag_article')->insert(array(
                    'tid' => $tid,
                    'aid' => $model->id
                ));
            }
            //新tag weight+1
            DB::table('tags')->whereIn('id',$newtids)->increment('weight');
        }

        //删除关系
        $unlinktids = array_diff($oldtids,$tids);
        if (!empty($unlinktids)) {
            DB::table('tag_article')->where('aid','=',$model->id)->whereIn('tid',$unlinktids)->delete();
            //weight -1
            DB::table('tags')->whereIn('id',$unlinktids)->decrement('weight');
        }
        DB::commit();
    }

}
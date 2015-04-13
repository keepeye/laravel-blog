<?php
class Article extends BaseModel {
    public $timestamps = true;
    protected $guarded = array('id','deleted_at','updated_at');

    public static function boot()
    {
        parent::boot();

        self::observe(new ArticleObserver);
    }


    /**
     * 关联分类模型
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo('Category','cid');
    }


    /**
     * 关联tags模型
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags()
    {
        return $this->belongsToMany('Tag','tag_article','aid','tid');
    }

    /**
     * 关联user
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('User','uid');
    }

    /**
     * 获取文章的tags，并拼成字符串
     * @return string
     */
    public function getTags()
    {
        $tags = $this->tags()->lists('name');
        return implode(",",$tags);
    }

}

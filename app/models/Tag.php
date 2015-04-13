<?php
class Tag extends BaseModel {

    protected $guarded = array('id','deleted_at','created_at','updated_at');

    public static function boot()
    {
        parent::boot();

    }

    public function articles()
    {
        return $this->belongsToMany('Article','tag_article','tid','aid');
    }


    public static function getHotTags($num=20)
    {
        return Cache::want('hotTags',60,function() use ($num){
            return Tag::orderBy('weight','desc')->take($num)->get();
        });
    }

}
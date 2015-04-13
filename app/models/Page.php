<?php
class Page extends BaseModel {
    public $timestamps = true;
    protected $guarded = array('id','deleted_at','updated_at');

    public static function boot()
    {
        parent::boot();

        self::observe(new PageObserver);
    }

    /**
     * 关联user
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('User','uid');
    }

    public static function getNavPages()
    {
        return Cache::want('navPages',0,function() {
            return Page::get(['title', 'id']);
        });
    }

}

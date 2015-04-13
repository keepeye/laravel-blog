<?php
class User extends \Cartalyst\Sentry\Users\Eloquent\User {
    public static function boot()
    {
        parent::boot();

        //删除时先删除相关文档、单页
        self::deleting(function(User $user){
            Article::where('uid','=',$user->id)->delete();
            Page::where('uid','=',$user->id)->delete();
        });
    }
}
<?php
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/


App::before(function ($request) {

    //载入自定义option，合并到Config
    foreach (Option::rememberForever('options')->get() as $option) {
        Config::set($option->key, $option->value);
    }

    //注册缓存宏
    Cache::macro('want',function($key,$minutes=0,$callback){
        if (!$data = Cache::get($key)) {
            $data = call_user_func($callback);
            if ($minutes == 0) {
                Cache::forever($key,$data);
            } else {
                Cache::put($key,$data,$minutes);
            }
        }
        return $data;
    });

});


App::after(function ($request, $response) {
    $sqlLogs = DB::getQueryLog();

    foreach ($sqlLogs as $sql) {
        Log::debug($sql['query'],['time'=>$sql['time']]);
    }

    Log::info("\n");
});

App::error(function(ModelNotFoundException $e){
    return Response::make('记录不存在',404);
});

App::error(function(NotFoundHttpException $e){
    return Response::make('页面不存在',404);
});

/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. The "basic" filter easily
| integrates HTTP Basic authentication for quick, simple checking.
|
*/

Route::filter('checkLogin', function () {
    //check if login
    if (!Sentry::check()) {
        if (Request::ajax()) {
            return Response::json(['errcode' => 401, 'errmsg' => '请先登陆', 'to' => URL::route('admin.authentication.create')], 401);
        } else {
            return Redirect::guest(URL::route('admin.authentication.create'));;
        }
    }
});


/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

Route::filter('csrf', function () {
    if (Session::token() !== Input::get('_token')) {
        throw new Illuminate\Session\TokenMismatchException;
    }
});

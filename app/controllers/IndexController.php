<?php
class IndexController extends  BaseController {
    public function index()
    {
        $articles = Cache::want('index.index.articles',60,function(){
            return Article::with('category','tags')
                ->take(10)
                ->orderBy('id','desc')
                ->select(array('id','title','cid','description','litpic','created_at','updated_at'))
                ->where('cid','>','0')
                ->get();
        });

        $values = array(
            'articles' => $articles
        );

        return View::make('index.index',$values);
    }
}
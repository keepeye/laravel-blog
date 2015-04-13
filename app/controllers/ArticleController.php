<?php
class ArticleController extends  BaseController {
    
    public function show($id)
    {

        $article = Cache::want('article_'.$id,0,function() use ($id){
            return Article::with('tags')->findOrFail($id,['id','cid','description','title','content_html as content','created_at','updated_at']);
        });

        $values = array(
            'title' => $article->title.'_',
            'description' => $article->description,
            'article' => $article
        );
        return View::make('article.show',$values);
    }
}
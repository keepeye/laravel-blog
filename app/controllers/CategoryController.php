<?php
class CategoryController extends  BaseController {

    public function show($id)
    {
        $category = Cache::want('category_'.$id,0,function() use ($id) {
            return Category::findOrFail($id);
        });

        $articles = Article::with('tags')->where('cid','=',$category->id)
            ->orderBy('id','desc')
            ->paginate(15);

        $values = array(
            'title' => $category->name.'_',
            'category' => $category,
            'articles' => $articles
        );
        return View::make('category.show',$values);
    }
}
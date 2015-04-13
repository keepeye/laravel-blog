<?php
class TagController extends  BaseController {

    public function show($name)
    {
        $tag = Tag::where('name','=',$name)->firstOrFail();
        $articles = $tag->articles()->where('cid','>','0')->with('category')->orderBy('id','desc')->paginate(10);
        $values = array(
            'title' => '标签:'.$tag->name.'_',
            'tag' => &$tag,
            'articles' => &$articles
        );
        return View::make('tag.show',$values);
    }
}
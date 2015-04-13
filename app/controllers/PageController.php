<?php
class PageController extends  BaseController {
    
    public function show($id)
    {
        $page = Cache::want('page_'.$id,0,function() use ($id){
            return Page::findOrFail($id,['id','title','content_html as content','created_at','updated_at']);
        });

        $values = array(
            'title' => $page->title.'_',
            'page' => $page
        );
        return View::make('page.show',$values);
    }
}
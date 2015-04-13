<?php namespace Controllers\Admin;
use View,Input,Response,Redirect,Msgbox;

class ArticleController extends BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        $query = \Article::with('user');

        //过滤处理
        if ($cid = Input::get('cid')) {
            $query->where('cid','=',$cid);
        }

        if ($title = Input::get('title')) {
            $query->where('title','like','%'.$title.'%');
        }

        //查询最终文章列表
        $articles = $query->orderBy('id','desc')->paginate(20);
        $values = array(
            'articles' => $articles,
            'categories' => \Category::where('final','=','1')->get(['id','name'])
        );
		return View::make('admin/article/index',$values);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        $categories = \Category::selectOptions();
        $values = array(
            'categories' => $categories
        );
		return View::make('admin/article/create',$values);
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
        $data = Input::get('data');

        $article = \Article::create($data);
        if ($article->id) {
            return Redirect::route('admin.article.index');
        } else {
            return Msgbox::error($article->getLastError() ?: "创建文章失败");
        }

	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
        $article = \Article::find($id);
        if (!$article) {
            return Msgbox::error('文档不存在');
        }
        //读取分类
        $categories = \Category::selectOptions();
        //读取tags
        $tags = $article->getTags();

        $values = array(
            'article' => $article,
            'categories' => $categories,
            'tags' => $tags
        );

        return View::make('admin/article/edit',$values);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$article = \Article::find($id);
        if (!$article) {
            return Msgbox::error('文章不存在');
        }

        $article->fill(Input::get('data'));

        if ($article->save()) {
            return Redirect::route('admin.article.index');
        } else {
            return Msgbox::error($article->getLastError() ?: "更新文章失败");
        }
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{

	}


    /**
     * 批量操作
     * @return \Illuminate\Http\JsonResponse
     */
    public function batch()
    {
        $ids = Input::get('ids');
        $action = Input::get('action');
        switch ($action) {
            case "delete" :
                if (count($ids) > 0) {
                    \Article::destroy($ids);
                }
                break;
            default:

        }
        return Response::json(['status'=>1,'msg'=>'操作成功']);
    }
}

<?php namespace Controllers\Admin;
use View,Input,Response,Redirect,Msgbox,Page;

class PageController extends BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        $pages = Page::with('user')->paginate(20);
        $values = array(
            'pages' => $pages
        );
		return View::make('admin/page/index',$values);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('admin/page/create');
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
        $data = Input::get('data');

        $page = Page::create($data);
        if ($page->id) {
            return Redirect::route('admin.page.index');
        } else {
            return Msgbox::error($page->getLastError() ?: "创建单页失败");
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
        $page = Page::find($id);

        if (!$page) {
            return Msgbox::error('文档不存在');
        }

        $values = array(
            'page' => $page,
        );

        return View::make('admin/page/edit',$values);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$page = Page::find($id);
        if (!$page) {
            return Msgbox::error('文档不存在');
        }

        $page->fill(Input::get('data'));

        if ($page->save()) {
            return Redirect::route('admin.page.index');
        } else {
            return Msgbox::error($page->getLastError() ?: "更新失败");
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
                    Page::destroy($ids);
                }
                break;
            default:

        }
        return Response::json(['status'=>1,'msg'=>'操作成功']);
    }
}

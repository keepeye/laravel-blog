<?php namespace Controllers\Admin;
use View,Input,Redirect,Response,Category,Msgbox,Menu;

class CategoryController extends BaseController
{

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $categories = Category::getList();
        $binds = [
            'categories' => $categories
        ];
        return View::make('admin/category/index', $binds);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $parents = Category::selectOptions();
        return View::make('admin/category/create')->with('parents',$parents);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        $category = Category::create(Input::get('data'));
        if ($category->id) {
            return Redirect::route('admin.category.index');
        } else {
            return Msgbox::error($category->getLastError() ?: "创建分类失败");
        }

    }


    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {

    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        $category = Category::find($id);
        if (!$category) {
            return Msgbox::error('不存在');
        }
        $parents = Category::selectOptions($id);
        return View::make('admin/category/edit')
                ->with('category', $category)
                ->with('parents',$parents);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($id)
    {
        $category = Category::find($id);

        if (!$category) {
            return Msgbox::error('不存在');
        }

        $category->fill(Input::get('data'));

        if ($category->save()) {
            return Redirect::route('admin.category.edit', ['id' => $id])->with('success', '1');
        } else {
            return Msgbox::error($category->getLastError()?:'更新失败');
        }
    }


    /**
     * 删除分类及其关联文章
     * @param  int $id
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
                    Category::destroy($ids);
                }
                break;

            default:

        }
        return Response::json(['status'=>1,'msg'=>'操作成功']);
    }
}

<?php namespace Controllers\Admin;
use View,Input,Redirect,Response,Menu,Msgbox;

class MenuController extends BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        $menus = Menu::getList();
        $values = [
            'menus' => $menus
        ];
		return View::make('admin.menu.index',$values);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        $parents = Menu::selectOptions();
        return View::make('admin.menu.create')->with('parents',$parents);
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
        $menu = Menu::create(Input::get('data'));
        if ($menu->id) {
            return Redirect::route('admin.menu.index');
        } else {
            return Msgbox::error($menu->getLastError() ?: "创建菜单失败");
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
        $menu = Menu::find($id);
        if (!$menu) {
            return Msgbox::error('不存在');
        }
        $parents = Menu::selectOptions($id);

        return View::make('admin/menu/edit')
            ->with('menu', $menu)
            ->with('parents',$parents);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
        $menu = Menu::find($id);

        if (!$menu) {
            return Msgbox::error('不存在');
        }

        $menu->fill(Input::get('data'));

        if ($menu->save()) {
            return Redirect::route('admin.menu.edit', ['id' => $id])->with('success', '1');
        } else {
            return Msgbox::error($menu->getLastError()?:'更新失败');
        }
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
                    Menu::destroy($ids);
                }
                break;

            default:

        }
        return Response::json(['status'=>1,'msg'=>'操作成功']);
    }
}

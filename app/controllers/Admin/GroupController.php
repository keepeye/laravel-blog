<?php namespace Controllers\Admin;
use View,Input,Response,Msgbox,Sentry,Group,Menu,URL;
use Cartalyst\Sentry\Groups\GroupNotFoundException;

class GroupController extends BaseController {

	/**
	 * 列表
	 *
	 * @return Response
	 */
	public function index()
	{
        $groups = Group::all();
        $data = array(
            'groups' => $groups
        );
		return View::make('admin.group.index',$data);
	}


	/**
	 * 创建
	 *
	 * @return Response
	 */
	public function create()
	{
        $menus = Menu::getList();
        $values = [
            'menus' => $menus
        ];
		return View::make('admin.group.create',$values);
	}


	/**
	 * 创建新记录
	 *
	 * @return Response
	 */
	public function store()
	{
		$data = Input::get('data');

        try {
            // 创建分组
            Sentry::createGroup($data);
        } catch (Cartalyst\Sentry\Groups\NameRequiredException $e) {
            return Msgbox::error('请填写分组名');
        } catch (Cartalyst\Sentry\Groups\GroupExistsException $e) {
            return Msgbox::error('分组已存在');
        }


        return Msgbox::success('创建成功',URL::route('admin.group.index'));
	}



	/**
	 * 编辑
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
        try {
            $group = Sentry::findGroupById($id);
            $menus = Menu::getList();
            $permissions = $group->getPermissions();
            $values = array(
                'group' => $group,
                'menus' => $menus,
                'permissions' => $permissions
            );
            return View::make('admin/group/edit',$values);
        } catch (GroupNotFoundException $e) {
            return Msgbox::error('用户组不存在');
        }
	}


	/**
	 * 更新用户数据.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
        try {
            $group = Sentry::findGroupById($id);
            $group->name = Input::get('data.name');
            $group->permissions = Input::get('data.permissions');
            if ($group->save()) {
                return Msgbox::success('修改成功');
            } else {
                return Msgbox::error('修改失败');
            }
        } catch (GroupNotFoundException $e) {
            return Msgbox::error('用户组不存在');
        }

	}



    /**
     * 批量操作
     */
    public function batch()
    {
        $ids = Input::get('ids');
        $action = Input::get('action');
        switch ($action) {
            case "delete" :
                if (count($ids) > 0) {
                    Group::destroy($ids);
                }
                break;
            default:

        }
        return Response::json(['status'=>1,'msg'=>'操作成功']);
    }

}

<?php namespace Controllers\Admin;
use View,Input,Response,Msgbox,Sentry,User,Group;
use Cartalyst\Sentry\Users\LoginRequiredException,
    Cartalyst\Sentry\Users\PasswordRequiredException,
    Cartalyst\Sentry\Users\UserExistsException,
    Cartalyst\Sentry\Groups\GroupNotFoundException,
    Cartalyst\Sentry\Users\UserNotFoundException;


class UserController extends BaseController {

	/**
	 * 用户列表
	 *
	 * @return Response
	 */
	public function index()
	{
        $users = Sentry::getEmptyUser()->with('groups')->paginate(30);
        $data = array(
            'users' => $users
        );
		return View::make('admin.user.index',$data);
	}


	/**
	 * 创建用户
	 *
	 * @return Response
	 */
	public function create()
	{
        $groups = Group::all();
        if (!$groups) {
            return Msgbox::error('请先添加用户组');
        }
		return View::make('admin.user.create')->with('groups',$groups);
	}


	/**
	 * 保存新用户数据.
	 *
	 * @return Response
	 */
	public function store()
	{
		$data = Input::get('data');
        try {
            $user = Sentry::createUser($data);
            //关联用户组
            if ($groups = Input::get('groups')) {
                $user->groups()->attach($groups);
            }
        } catch (LoginRequiredException $e) {
            return Msgbox::error('login 字段是必须的');
        } catch (PasswordRequiredException $e) {
            return Msgbox::error('密码 是必须的');
        } catch (UserExistsException $e) {
            return Msgbox::error('用户名已存在');
        } catch (GroupNotFoundException $e) {
            return Msgbox::error('用户组不存在');
        }

        if (Input::get('super')) {
            $user->permissions = array(
                'superuser' => 1
            );
            $user->save();
        }

        return Msgbox::success('创建成功');
	}



	/**
	 * 编辑用户
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
        $groups = Group::all();
        if (!$groups) {
            return Msgbox::error('请先添加用户组');
        }
        try {
            $user = Sentry::findUserById($id);
            $groupIds = $user->groups()->lists('id');
            $values = array(
                'user' => $user,
                'groups' => $groups,
                'groupIds' => $groupIds
            );
            return View::make('admin/user/edit',$values);
        } catch(UserNotFoundException $e){
            return Msgbox::error('用户不存在');
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
            $user = Sentry::findUserById($id);
            if (!$user) {
                return Msgbox::error('用户不存在');
            }
            $user->email = Input::get('data.email');
            if (Input::get('data.password')) {
                $user->password = Input::get('data.password');
            }
            $user->first_name = Input::get('data.first_name');
            $user->activated = Input::get('data.activated');
            $user->save();
            //关联用户组
            $user->groups()->detach();
            if ($groups = Input::get('groups')) {
                $user->groups()->attach($groups);
            }
            return Msgbox::success('修改成功');
        } catch(UserNotFoundException $e){
            return Msgbox::error('用户不存在');
        } catch (LoginRequiredException $e) {
            return Msgbox::error('login 字段是必须的');
        } catch (PasswordRequiredException $e) {
            return Msgbox::error('密码 是必须的');
        } catch (UserExistsException $e) {
            return Msgbox::error('用户名已存在');
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
                    User::destroy($ids);
                }
                break;
            default:

        }
        return Response::json(['status'=>1,'msg'=>'操作成功']);
    }

}

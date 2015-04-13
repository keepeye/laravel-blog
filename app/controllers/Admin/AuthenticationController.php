<?php namespace Controllers\Admin;
use View,Validator,Input,Redirect,Sentry,Response;
class AuthenticationController extends \Controller {

	/**
	 * 登陆表单
	 *
	 * @return Response
	 */
	public function create()
	{
        return View::make("admin/authentication/create");
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function store()
	{
        $formdata = [
            'email'=>Input::get('email'),
            'password'=>Input::get('password'),
        ];

        $validator = Validator::make($formdata,
            [
                'email' => 'required|email',
                'password' => 'required'
            ],
            [
                'email.required' => '请输入邮箱账号',
                'email.email' => '邮箱格式不合法',
                'password.required' => '请输入密码'
            ]
        );

        if($validator->fails()){
            return Redirect::route('admin.authentication.index')->withErrors($validator);
        }


        try{
            $user = Sentry::authenticate($formdata,false);
            if($user){
                return Redirect::intended("/");
            }
        }catch (\Exception $e){
            return Redirect::route('admin.authentication.create')->withErrors(array('invalid' => '用户名或密码错误'));
        }
	}

}

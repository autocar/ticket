<?php

class AccountController extends AuthorizedController
{
	/**
	 * Let's whitelist all the methods we want to allow guests to visit!
	 *
	 * @access   protected
	 * @var      array
	 */
	protected $whitelist = array(
		'getLogin',
		'postLogin'
	);

	/**
	 * Main users page.
	 *
	 * @access   public
	 * @return   View
	 */
	public function getIndex()
	{
		// Show the page.
		//
		return View::make('account/index')->with('user', Auth::user());
	}

	/**
	 *
	 *
	 * @access   public
	 * @return   Redirect
	 */
	public function postIndex()
	{
		// Declare the rules for the form validation.
		//
		$rules = array(
			//'email'      => 'Required|Email|Unique:users,email,' . Auth::user()->email . ',email',
            'name'   => 'Required',
            'mobile' => 'Required'
		);

		// If we are updating the password.
		//
		if (Input::get('password'))
		{
			// Update the validation rules.
			//
			$rules['password']              = 'Required|Confirmed';
			$rules['password_confirmation'] = 'Required';
		}

		// Get all the inputs.
		//
		$inputs = Input::all();

		// Validate the inputs.
		//
		$validator = Validator::make($inputs, $rules);

		// Check if the form validates with success.
		//
		if ($validator->passes())
		{
			// Create the user.
			//
			$user =  Member::find(Auth::user()->id);
			//$user->email      = Input::get('email');
            $user->name        = Input::get('name');
            $user->mobile      = Input::get('mobile');

			if (Input::get('password') !== '')
			{
				$user->password = Hash::make(Input::get('password'));
			}

			$user->save();

            // 修改密码，重新登录
            if (Input::get('password') !== '')
            {
                // Log the user out.
                Auth::logout();

                // Redirect to the users page.
                return Redirect::to('account/login')->with('success', '密码修改、请重新登录！');
            }

			// Redirect to the register page.
			//
			return Redirect::to('account')->with('success', '资料更新成功!');
		}

		// Something went wrong.
		//
		return Redirect::to('account')->withInput($inputs)->withErrors($validator->getMessageBag());
	}

	/**
	 * Login form page.
	 *
	 * @access   public
	 * @return   View
	 */
	public function getLogin()
	{
		// Are we logged in?
		//
		if (Auth::check())
		{
			return Redirect::to('ticket');
		}

		// Show the page.
		//
		return View::make('account/login');
	}

	/**
	 * Login form processing.
	 *
	 * @access   public
	 * @return   Redirect
	 */
	public function postLogin()
	{
		// Declare the rules for the form validation.
		//
		$rules = array(
			'email'    => 'Required|Email',
			'password' => 'Required'
		);

		// Get all the inputs.
		//
		$email    = Input::get('email');
		$password = Input::get('password');

		// Validate the inputs.
		//
		$validator = Validator::make(Input::all(), $rules);

		// Check if the form validates with success.
		//
		if ($validator->passes())
		{
			// Try to log the user in.
			//
			if (Auth::attempt(array('email' => $email, 'password' => $password)))
			{
				// Redirect to the users page.
				//
				return Redirect::to('ticket')->with('success', '登陆成功');
			}
			else
			{
				// Redirect to the login page.
				//
				return Redirect::to('account/login')->with('error', '邮箱/密码 无效');
			}
		}

		// Something went wrong.
		//
		return Redirect::to('account/login')->withErrors($validator->getMessageBag());
	}

	/**
	 * Logout page.
	 *
	 * @access   public
	 * @return   Redirect
	 */
	public function getLogout()
	{
		// Log the user out.
		Auth::logout();

		// Redirect to the users page.
		return Redirect::to('account/login')->with('success', '退出成功');
	}
}

<?php namespace Controllers\Admin;

use Auth;
use Config;
use Input;
use Lang;
use Redirect;
use Validator;
use View;

class AccountController extends AdminController
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
			return Redirect::to('admin/login');
		}

		// Show the page.
		//
		return View::make('admin/account/login');
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
			'username' => 'Required',
			'password' => 'Required'
		);

		// Get all the inputs.
		//
		$username = Input::get('username');
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
			if (Auth::attempt(array('username' => $username, 'password' => $password)))
			{
				// Redirect to the users page.
				//
				return Redirect::to('admin/ticket')->with('success', '登陆成功');
			}
			else
			{
				// Redirect to the login page.
				//
				return Redirect::to('admin/login')->with('error', '用户名 / 密码 无效');
			}
		}

		// Something went wrong.
		//
		return Redirect::to('admin/login')->withErrors($validator->getMessageBag());
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
		return Redirect::to('admin/login')->with('success', '退出成功');
	}
}

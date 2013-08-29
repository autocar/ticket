<?php namespace Controllers\Admin;

use Auth;
use Config;
use Input;
use Lang;
use Redirect;
use Validator;
use View;
use Hash;
use Operator;
use Image;
use DateTime;

class AccountController extends AdminController {
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
        return View::make('admin/account/index')->with('user', Auth::user());
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
            'name'   => 'Required',
            'mobile' => 'Required',
            'email'  => 'Required|Email',
            'file'   => 'image',
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
            $user         = Operator::find(Auth::user()->id);
            $user->email  = Input::get('email');
            $user->name   = Input::get('name');
            $user->mobile = Input::get('mobile');

            // 图片附件
            $file = Input::file('file');

            if (!empty($file))
            {
                if ($file->getSize() > (100 * 1024))
                {
                    return Redirect::back()->with('error', '上传图片过大，请控制在100k以内！');
                }
                else
                {
                    $destinationPath = 'uploads/avatar/' . date('Y/m/d');
                    $extension       = $file->getClientOriginalExtension();
                    $filename        = str_random(8) . '.' . $extension;
                    $upload_success  = $file->move($destinationPath, $filename);

                    if ($upload_success)
                    {
                        $image              = new Image();
                        $image->url         = $destinationPath . '/' . $filename;
                        $image->create_time = new DateTime();

                        if ($image->save())
                        {
                            $user->image_id = $image->id;
                        }

                    }
                    else
                    {
                        return Redirect::back()->with('error', '上传图片失败！');
                    }
                }
            }

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
                return Redirect::to('admin/login')->with('success', '密码修改、请重新登录！');
            }

            // Redirect to the register page.
            //
            return Redirect::to('admin/account')->with('success', '资料更新成功!');
        }

        // Something went wrong.
        //
        return Redirect::to('admin/account')->withInput($inputs)->withErrors($validator->getMessageBag());
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
            return Redirect::to('admin/ticket');
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
            if (Auth::attempt(array(
                                   'username' => $username,
                                   'password' => $password
                              ))
            )
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

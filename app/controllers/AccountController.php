<?php

class AccountController extends AuthorizedController {
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
        $troubles = Trouble::all();

        // Show the page.
        //
        return View::make('account/index', array(
                                                'user'     => Auth::user(),
                                                'troubles' => $troubles,
                                           ));
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
            // 'email'      => 'Required|Email|Unique:users,email,' . Auth::user()->email . ',email',
            'name'       => 'Required',
            'mobile'     => 'Required',
            'company'    => 'Required',
            // 'trouble_id' => 'Required',
            'file'       => 'image',
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
            $user = Member::find(Auth::user()->id);
            //$user->email      = Input::get('email');
            $user->name         = Input::get('name');
            $user->mobile       = Input::get('mobile');
            $user->company      = Input::get('company');
            $user->introduction = Input::get('introduction');
            $user->trouble_id   = Input::get('trouble_id');

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
            if (Auth::attempt(array(
                                   'email'    => $email,
                                   'password' => $password
                              ))
            )
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

<?php namespace Controllers\Admin;

use Auth;
use View;
use Operator;
use Validator;
use Input;
use Hash;
use Redirect;
use Str;

class OperatorController extends AdminController {

    /**
     * getIndex
     *
     * @return View
     */
    public function getIndex()
    {
        $operators = Operator::all();

        // Show the page
        return View::make('admin/operator/index', compact('operators'));
    }

    /**
     * getCreate
     *
     * @return View
     */
    public function getCreate()
    {
        return View::make('admin/operator/create');
    }

    /**
     * postCreate
     *
     * @return mixed
     */
    public function postCreate()
    {
        $rules = array(
            'username'              => 'required|min:4|max:10|Unique:operators,username',
            'name'                  => 'required|min:2',
            'password'              => 'Required|Confirmed',
            'password_confirmation' => 'Required',
            'mobile'                => 'Required|Unique:operators,mobile',
            'email'                 => 'Required|Email|Unique:operators,email',
        );

        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails())
        {
            return Redirect::back()->withInput()->withErrors($validator);
        }

        $operator = new Operator;

        $operator->username = e(Input::get('username'));
        $operator->name     = e(Input::get('name'));
        $operator->password = Hash::make(Input::get('password'));
        $operator->mobile   = e(Input::get('mobile'));
        $operator->email    = e(Input::get('email'));
        $operator->lv       = e(Input::get('lv'));

        if ($operator->save())
        {
            return Redirect::to("admin/operator")->with('success', '用户添加成功');
        }

        return Redirect::to('admin/operator/create')->with('error', '用户添加失败');
    }

    /**
     * getEdit
     *
     * @param null $operatorId
     *
     * @return mixed
     */
    public function getEdit($operatorId = NULL)
    {
        if (is_null($operator = Operator::find($operatorId)))
        {
            return Redirect::to('admin/operator')->with('error', '用户不存在');
        }

        return View::make('admin/operator/edit', compact('operator'));
    }

    /**
     * postEdit
     *
     * @param null $operatorId
     *
     * @return mixed
     */
    public function postEdit($operatorId = NULL)
    {
        if (is_null($operator = Operator::find($operatorId)))
        {
            return Redirect::to('admin/operator')->with('error', '用户不存在');
        }

        $rules = array(
            'username'              => 'required|min:4|max:10',
            'name'                  => 'required|min:2',
            'mobile'                => 'Required',
            'email'                 => 'Required|Email',
        );

        if (Input::get('password'))
        {
            $rules['password']              = 'Required|Confirmed';
            $rules['password_confirmation'] = 'Required';
        }

        $validator = Validator::make(Input::all(), $rules);


        if ($validator->fails())
        {
            return Redirect::back()->withInput()->withErrors($validator);
        }

        $operator->username = e(Input::get('username'));
        $operator->name     = e(Input::get('name'));
        $operator->mobile   = e(Input::get('mobile'));
        $operator->email    = e(Input::get('email'));

        if (Input::get('password') !== '')
        {
            $operator->password = Hash::make(Input::get('password'));
        }

        if (Input::get('lv') !== '')
        {
            $operator->lv       = e(Input::get('lv'));
        }

        if ($operator->save())
        {
            return Redirect::to("admin/operator")->with('success', '更新成功');
        }

        return Redirect::to("admin/operator/$operatorId/edit")->with('error', '更新失败');

    }

    /**
     * getDelete
     *
     * @param null $operatorId
     *
     * @return mixed
     */
    public function getDelete($operatorId = NULL)
    {

        if (is_null($operator = Operator::find($operatorId)))
        {
            return Redirect::to('admin/operator')->with('error', '用户不存在');
        }

        $operator->delete();

        return Redirect::to('admin/operator')->with('success', '删除成功');
    }
}
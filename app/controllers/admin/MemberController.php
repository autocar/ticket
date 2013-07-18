<?php namespace Controllers\Admin;

use Auth;
use View;
use Member;
use Operator;
use Hash;
use Validator;
use Input;
use Redirect;
use Str;

class MemberController extends AdminController {

    /**
     * getIndex
     *
     * @return View
     */
    public function getIndex()
    {
        $members = Member::all();

        // Show the page
        return View::make('admin/member/index', compact('members'));
    }

    /**
     * getCreate
     *
     * @return View
     */
    public function getCreate()
    {
        $operators = Operator::where('lv', '0')->get();

        return View::make('admin/member/create', compact('operators'));
    }

    /**
     * postCreate
     *
     * @return mixed
     */
    public function postCreate()
    {
        $rules = array(
            'bn'                    => 'required|min:4|max:10|Unique:members,bn',
            'name'                  => 'required|min:2',
            'email'                 => 'Required|Email|Unique:members,email',
            'mobile'                => 'Required|Unique:operators,mobile',
            'password'              => 'Required|Confirmed',
            'password_confirmation' => 'Required',
            'start_time'            => 'date',
            'end_time'              => 'date',
            //'start_time'            => 'Required',
        );

        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails())
        {
            return Redirect::back()->withInput()->withErrors($validator);
        }

        $member = new Member;

        $member->bn          = e(Input::get('bn'));
        $member->name        = e(Input::get('name'));
        $member->email       = e(Input::get('email'));
        $member->mobile      = e(Input::get('mobile'));
        $member->product     = e(Input::get('product'));
        $member->start_time  = e(Input::get('start_time'));
        $member->end_time    = e(Input::get('end_time'));
        $member->password    = Hash::make(Input::get('password'));
        $member->operator_id = e(Input::get('operator_id'));

        if ($member->save())
        {
            return Redirect::to("admin/member")->with('success', '客户添加成功');
        }

        return Redirect::to('admin/member/create')->with('error', '客户添加失败');
    }

    /**
     * getEdit
     *
     * @param null $memberId
     *
     * @return mixed
     */
    public function getEdit($memberId = NULL)
    {
        if (is_null($member = Member::find($memberId)))
        {
            return Redirect::to('admin/member')->with('error', '客户不存在');
        }

        $operators = Operator::where('lv', '0')->get();

        return View::make('admin/member/edit', array(
                                                    'operators' => $operators,
                                                    'member'    => $member
                                               ));
    }

    /**
     * postEdit
     *
     * @param null $memberId
     *
     * @return mixed
     */
    public function postEdit($memberId = NULL)
    {
        if (is_null($member = Member::find($memberId)))
        {
            return Redirect::to('admin/member')->with('error', '客户不存在');
        }

        $rules = array(
            'bn'         => 'required|min:4|max:10',
            'name'       => 'required|min:2',
            'mobile'     => 'Required',
            'email'      => 'Required|Email',
            'start_time' => 'date',
            'end_time'   => 'date',
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

        $member->bn          = e(Input::get('bn'));
        $member->name        = e(Input::get('name'));
        $member->email       = e(Input::get('email'));
        $member->mobile      = e(Input::get('mobile'));
        $member->product     = e(Input::get('product'));
        $member->start_time  = e(Input::get('start_time'));
        $member->end_time    = e(Input::get('end_time'));
        $member->operator_id = e(Input::get('operator_id'));

        if (Input::get('password') !== '')
        {
            $member->password = Hash::make(Input::get('password'));
        }

        if ($member->save())
        {
            return Redirect::to("admin/member")->with('success', '更新成功');
        }

        return Redirect::to("admin/member/$memberId/edit")->with('error', '更新失败');

    }

    /**
     * getDelete
     *
     * @param null $memberId
     *
     * @return mixed
     */
    public function getDelete($memberId = NULL)
    {

        if (is_null($member = Member::find($memberId)))
        {
            return Redirect::to('admin/member')->with('error', '客户不存在');
        }

        $member->delete();

        return Redirect::to('admin/member')->with('success', '删除成功');
    }
}
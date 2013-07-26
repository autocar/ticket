<?php namespace Controllers\Admin;

use Auth;
use View;
use Member;
use Cgroup;
use Product;
use Hash;
use Validator;
use Input;
use Redirect;
use Str;
use Paginator;

class MemberController extends AdminController {

    /**
     * getIndex
     *
     * @return View
     */
    public function getIndex()
    {
        $members = Member::query()->orderBy('id', 'desc')->paginate();

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
        $cgroups  = Cgroup::all();
        $products = Product::all();

        return View::make('admin/member/create', compact('cgroups', 'products'));
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
            'name'                  => 'required|min:2|Unique:members,name',
            'email'                 => 'Required|Email|Unique:members,email',
            'mobile'                => 'Required|Unique:operators,mobile',
            'password'              => 'Required|Confirmed',
            'password_confirmation' => 'Required',
            'start_time'            => 'date',
            'end_time'              => 'date|different:start_time|after:' . substr(e(Input::get('start_time')), 0, 10),
            'product'               => 'Required',
            'company'               => 'Required|min:4|Unique:members,company',
        );

        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails())
        {
            return Redirect::back()->withInput()->withErrors($validator);
        }

        $member = new Member;

        $member->bn           = e(Input::get('bn'));
        $member->name         = e(Input::get('name'));
        $member->email        = e(Input::get('email'));
        $member->mobile       = e(Input::get('mobile'));
        $member->company      = e(Input::get('company'));
        $member->introduction = e(Input::get('introduction'));
        // $member->start_time   = e(Input::get('start_time'));
        // $member->end_time     = e(Input::get('end_time'));
        $member->start_time = substr(e(Input::get('start_time')), 0, 10) . ' 00:00:00';
        $member->end_time   = substr(e(Input::get('end_time')), 0, 10) . ' 00:00:00';
        $member->password   = Hash::make(Input::get('password'));
        $member->cgroup_id  = Input::get('cgroup_id');

        if ($member->save())
        {
            foreach (Input::get('product') as $val)
            {
                $member->products()->attach($val);
            }

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

        $cgroups  = Cgroup::all();
        $products = Product::all();

        $mproducts = $member->products()->lists('name', 'product_id');

        return View::make('admin/member/edit', array(
                                                    'cgroups'   => $cgroups,
                                                    'member'    => $member,
                                                    'products'  => $products,
                                                    'mproducts' => $mproducts,
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
            'end_time'   => 'date|different:start_time|after:' . substr(e(Input::get('start_time')), 0, 10),
            'product'    => 'Required',
            'company'    => 'Required|min:4',
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

        $member->bn           = e(Input::get('bn'));
        $member->name         = e(Input::get('name'));
        $member->email        = e(Input::get('email'));
        $member->mobile       = e(Input::get('mobile'));
        $member->company      = e(Input::get('company'));
        $member->introduction = e(Input::get('introduction'));
        // $member->start_time   = e(Input::get('start_time'));
        // $member->end_time     = e(Input::get('end_time'));
        $member->start_time = substr(e(Input::get('start_time')), 0, 10) . ' 00:00:00';
        $member->end_time   = substr(e(Input::get('end_time')), 0, 10) . ' 00:00:00';
        $member->cgroup_id  = Input::get('cgroup_id');

        if (Input::get('password') !== '')
        {
            $member->password = Hash::make(Input::get('password'));
        }

        $mproducts = $member->products()->lists('product_id', 'product_id');

        $productsGroups = Input::get('product', array());

        $productsToAdd    = array_diff($productsGroups, $mproducts);
        $productsToRemove = array_diff($mproducts, $productsGroups);

        if ($member->save())
        {
            foreach ($productsToAdd as $productid)
            {
                $member->products()->attach($productid);
            }

            foreach ($productsToRemove as $productid)
            {
                $member->products()->detach($productid);
            }

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
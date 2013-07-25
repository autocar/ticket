<?php namespace Controllers\Admin;

use Auth;
use View;
use Cgroup;
use Validator;
use Input;
use Redirect;
use Str;

class CustomerGroupController extends AdminController {

    /**
     * getIndex
     *
     * @return View
     */
    public function getIndex()
    {
        $cgroups = Cgroup::all();

        // Show the page
        return View::make('admin/customergroup/index', compact('cgroups'));
    }

    /**
     * getCreate
     *
     * @return View
     */
    public function getCreate()
    {
        return View::make('admin/customergroup/create');
    }

    /**
     * postCreate
     *
     * @return mixed
     */
    public function postCreate()
    {
        $rules = array(
            'name' => 'required',
        );

        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails())
        {
            // Ooops.. something went wrong
            return Redirect::back()->withInput()->withErrors($validator);
        }

        $cgroup = new Cgroup;

        $cgroup->name = e(Input::get('name'));

        if ($cgroup->save())
        {
            // Redirect to the new blog post page
            return Redirect::to("admin/customergroup")->with('success', '添加成功');
        }

        return Redirect::to('admin/customergroup/create')->with('error', '添加失败');
    }

    /**
     * getEdit
     *
     * @param null $cgroupId
     *
     * @return mixed
     */
    public function getEdit($cgroupId = NULL)
    {
        if (is_null($cgroup = Cgroup::find($cgroupId)))
        {
            return Redirect::to('admin/customergroup')->with('error', '客服组不存在');
        }

        // Show the page
        return View::make('admin/customergroup/edit', compact('cgroup'));
    }

    /**
     *
     * postEdit
     *
     * @param null $cgroupId
     *
     * @return mixed
     */
    public function postEdit($cgroupId = NULL)
    {
        if (is_null($cgroup = Cgroup::find($cgroupId)))
        {
            return Redirect::to('admin/customergroup')->with('error', '客服组不存在');
        }

        $rules = array(
            'name' => 'required',
        );

        $validator = Validator::make(Input::all(), $rules);


        if ($validator->fails())
        {
            // Ooops.. something went wrong
            return Redirect::back()->withInput()->withErrors($validator);
        }

        $cgroup->name = e(Input::get('name'));

        if ($cgroup->save())
        {
            return Redirect::to("admin/customergroup")->with('success', '更新成功');
        }

        return Redirect::to("admin/customergroup/$cgroupId/edit")->with('error', '更新失败');

    }

    /**
     * getDelete
     *
     * @param null $cgroupId
     *
     * @return mixed
     */
    public function getDelete($cgroupId = NULL){

        if (is_null($cgroup = Cgroup::find($cgroupId)))
        {
            return Redirect::to('admin/customergroup')->with('error', '客服组不存在');
        }

        $cgroup->delete();

        return Redirect::to('admin/customergroup')->with('success', '删除成功');
    }
}
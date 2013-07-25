<?php namespace Controllers\Admin;

use Auth;
use View;
use Cgroup;
use Operator;
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
     * getBound
     *
     * @param null $cgroupId
     *
     * @return mixed
     */
    public function getBound($cgroupId = NULL)
    {
        if (is_null($cgroup = Cgroup::find($cgroupId)))
        {
            return Redirect::to('admin/customergroup')->with('error', '客服组不存在');
        }
        $operators = Operator::where('lv', '0')->get();
        //$ocGroups = $cgroup->OCG()->where('operator_id','=',Auth::user()->id)->get();
        $ocGroups = $cgroup->operators()->lists('name', 'operator_id');

        return View::make('admin/customergroup/bound', compact('operators', 'cgroup', 'ocGroups'));
    }

    public function postBound($cgroupId = NULL)
    {
        if (is_null($cgroup = Cgroup::find($cgroupId)))
        {
            return Redirect::to('admin/customergroup')->with('error', '客服组不存在');
        }

        $ocGroups = $cgroup->operators()->lists('operator_id', 'operator_id');

        $operatorsGroups = Input::get('operators', array());

        $operatorToAdd    = array_diff($operatorsGroups, $ocGroups);
        $operatorToRemove = array_diff($ocGroups, $operatorsGroups);

        foreach ($operatorToAdd as $operatorid)
        {
            $operator = Operator::find($operatorid);
            $cgroup->operators()->attach($operator);
        }

        foreach ($operatorToRemove as $operatorid)
        {
            $operator = Operator::find($operatorid);
            $cgroup->operators()->detach($operator);
        }

        return Redirect::to('admin/customergroup')->with('success', '绑定成功');
    }

    /**
     * getDelete
     *
     * @param null $cgroupId
     *
     * @return mixed
     */
    public function getDelete($cgroupId = NULL)
    {

        if (is_null($cgroup = Cgroup::find($cgroupId)))
        {
            return Redirect::to('admin/customergroup')->with('error', '客服组不存在');
        }

        $cgroup->delete();

        return Redirect::to('admin/customergroup')->with('success', '删除成功');
    }
}
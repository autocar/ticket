<?php namespace Controllers\Admin;

use Auth;
use View;
use Trouble;
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
        $troubles = Trouble::all();

        // Show the page
        return View::make('admin/type/index', compact('troubles'));
    }

    /**
     * getCreate
     *
     * @return View
     */
    public function getCreate()
    {
        return View::make('admin/type/create');
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

        $trouble = new Trouble;

        $trouble->name = e(Input::get('name'));

        if ($trouble->save())
        {
            // Redirect to the new blog post page
            return Redirect::to("admin/type")->with('success', '添加成功');
        }

        return Redirect::to('admin/type/create')->with('error', '添加失败');
    }

    /**
     * getEdit
     *
     * @param null $typeId
     *
     * @return mixed
     */
    public function getEdit($typeId = NULL)
    {
        if (is_null($trouble = Trouble::find($typeId)))
        {
            return Redirect::to('admin/type')->with('error', '问题类型不存在');
        }

        // Show the page
        return View::make('admin/type/edit', compact('trouble'));
    }

    /**
     *
     * postEdit
     *
     * @param null $typeId
     *
     * @return mixed
     */
    public function postEdit($typeId = NULL)
    {
        if (is_null($trouble = Trouble::find($typeId)))
        {
            return Redirect::to('admin/type')->with('error', '问题类型不存在');
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

        $trouble->name = e(Input::get('name'));

        if ($trouble->save())
        {
            return Redirect::to("admin/type")->with('success', '更新成功');
        }

        return Redirect::to("admin/type/$typeId/edit")->with('error', '更新失败');

    }

    /**
     * getDelete
     *
     * @param null $typeId
     *
     * @return mixed
     */
    public function getDelete($typeId = NULL){

        if (is_null($trouble = Trouble::find($typeId)))
        {
            return Redirect::to('admin/type')->with('error', '问题类型不存在');
        }

        $trouble->delete();

        return Redirect::to('admin/type')->with('success', '删除成功');
    }
}
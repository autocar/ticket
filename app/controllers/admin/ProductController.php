<?php namespace Controllers\Admin;

use Auth;
use View;
use Product;
use Validator;
use Input;
use Redirect;
use Str;

class ProductController extends AdminController {

    /**
     * getIndex
     *
     * @return View
     */
    public function getIndex()
    {
        $products = Product::all();

        // Show the page
        return View::make('admin/product/index', compact('products'));
    }

    /**
     * getCreate
     *
     * @return View
     */
    public function getCreate()
    {
        return View::make('admin/product/create');
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

        $product = new Product;

        $product->name = e(Input::get('name'));

        if ($product->save())
        {
            // Redirect to the new blog post page
            return Redirect::to("admin/product")->with('success', '产品添加成功');
        }

        return Redirect::to('admin/product/create')->with('error', '产品添加失败');
    }

    /**
     * getEdit
     *
     * @param null $productId
     *
     * @return mixed
     */
    public function getEdit($productId = NULL)
    {
        if (is_null($product = Product::find($productId)))
        {
            return Redirect::to('admin/product')->with('error', '产品不存在');
        }

        // Show the page
        return View::make('admin/product/edit', compact('product'));
    }

    /**
     *
     * postEdit
     *
     * @param null $productId
     *
     * @return mixed
     */
    public function postEdit($productId = NULL)
    {
        if (is_null($product = Product::find($productId)))
        {
            return Redirect::to('admin/product')->with('error', '产品不存在');
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

        $product->name = e(Input::get('name'));

        if ($product->save())
        {
            return Redirect::to("admin/product")->with('success', '更新成功');
        }

        return Redirect::to("admin/product/$productId/edit")->with('error', '更新失败');

    }

    /**
     * getDelete
     *
     * @param null $productId
     *
     * @return mixed
     */
    public function getDelete($productId = NULL){

        if (is_null($product = Product::find($productId)))
        {
            return Redirect::to('admin/product')->with('error', '产品不存在');
        }

        $product->delete();

        return Redirect::to('admin/product')->with('success', '删除成功');
    }
}
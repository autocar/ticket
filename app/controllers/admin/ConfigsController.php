<?php namespace Controllers\Admin;

use Auth;
use Config;
use Input;
use Lang;
use Redirect;
use Validator;
use View;
use Configuration;

class ConfigurationController extends AdminController {


    /**
     * Main users page.
     *
     * @access   public
     * @return   View
     */
    public function getIndex()
    {
        $views          = array();
        $Configurations = Configuration::all();

        foreach ($Configurations as $val)
        {
            $views[$val['key']] = $val['value'];
        }

        return View::make('admin/configuration/index', $views);
    }

    /**
     *
     *
     * @access   public
     * @return   Redirect
     */
    public function postIndex()
    {
        $rules = array(
            'auto_close_time' => 'Required|numeric'
        );

        $validator = Validator::make(Input::all(), $rules);

        if ($validator->passes())
        {
            Configuration::where('key', 'auto_close')->update(array('value' => Input::get('auto_close')));

            Configuration::where('key', 'auto_close_time')->update(array('value' => Input::get('auto_close_time')));

            return Redirect::to('admin/configuration')->with('success', '更新成功!');
        }

        return Redirect::to('admin/configuration')->withInput(Input::all())->withErrors($validator->getMessageBag());
    }
}

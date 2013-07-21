<?php namespace Controllers\Admin;

use BaseController;
use Config;

class AdminController extends BaseController {

    protected $whitelist = array();

    /**
     * Initializer.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        // 配置登陆
        Config::set('auth.driver', 'database');
        Config::set('auth.model', 'Operator');
        Config::set('auth.table', 'operators');
        Config::set('auth.reminder', array());

        // Apply the admin auth filter
        $this->beforeFilter('adminauth', array('except' => $this->whitelist));
    }
}

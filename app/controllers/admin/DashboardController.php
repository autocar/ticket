<?php namespace Controllers\Admin;

use Auth;
use View;
use Redirect;

class DashboardController extends AdminController {

	/**
	 * Show the administration dashboard page.
	 *
	 * @return View
	 */
	public function getIndex()
	{
        return Redirect::to('admin/login');
		// Show the page
		//return View::make('admin/dashboard');
	}

}

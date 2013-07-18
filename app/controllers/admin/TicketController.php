<?php namespace Controllers\Admin;

use Auth;
use View;
use Job;


class TicketController extends AdminController {

    /**
     * Show the administration dashboard page.
     *
     * @return View
     */
    public function getIndex()
    {
        // 客服
        if(Auth::user()->lv == 0){
            $jobs = Job::where('operator_id', '=', Auth::user()->id)->orderBy('id', 'desc')->paginate();
        } else {
            $jobs = Job::query()->orderBy('id', 'desc')->paginate();
        }

        // Show the page.
        //
        return View::make('admin/ticket/index', compact('jobs'));
    }


}
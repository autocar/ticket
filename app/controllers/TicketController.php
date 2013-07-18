<?php

class TicketController extends AuthorizedController {

    public function getIndex()
    {
        // Show the page.
        //
        return View::make('home')->with('user', Auth::user());
    }

    public function getCreate()
    {
        // Show the page.
        //
        return View::make('home')->with('user', Auth::user());
    }

}
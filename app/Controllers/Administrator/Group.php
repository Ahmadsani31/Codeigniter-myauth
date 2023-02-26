<?php

namespace App\Controllers\Administrator;

use App\Controllers\BaseController;

class Group extends BaseController
{
    public function index()
    {
        return view('v_group');
    }
}

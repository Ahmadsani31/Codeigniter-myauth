<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Dashboard extends BaseController
{
    public function index()
    {
        $arrD = [
            'Title' => 'Dashboard'
        ];
        return view('v_dashboard', $arrD);
    }
}

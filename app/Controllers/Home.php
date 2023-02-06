<?php

namespace App\Controllers;

use App\Models\UserModel;

class Home extends BaseController
{
    public function __construct()
    {
        $this->user = new UserModel();
    }
    public function index()
    {
        $arrData = [
            'Users' => $this->user->findAll()
        ];
        return view('dashboard', $arrData);
    }
}

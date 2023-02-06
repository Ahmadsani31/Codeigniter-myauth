<?php

namespace App\Controllers;

use App\Models\UserModel;
use Myth\Auth\Models\GroupModel;
use Myth\Auth\Models\PermissionModel;

class Home extends BaseController
{
    public function __construct()
    {
        $this->user = new UserModel();
        $this->group = new GroupModel();
        $this->permissions = new PermissionModel();
    }
    public function index()
    {

        $arrData = [
            'Users' => $this->user->findAll(),
            'Group' => $this->group
        ];
        return view('dashboard', $arrData);
    }
}

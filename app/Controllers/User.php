<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use Myth\Auth\Models\GroupModel;

class User extends BaseController
{
    public function __construct()
    {
        $this->users = new UserModel();
        $this->group = new GroupModel();
    }
    public function index()
    {
        $arrD = [
            'Title' => 'User'
        ];
        return view('administrator/v_user', $arrD);
    }

    public function edit(int $id)
    {
        $data = [
            'Users' => $this->users->find($id),
            'Group' => $this->group->findAll(),
            'groupUser' => $this->group->getGroupsForUser($id)[0]['group_id']
        ];
        return view('v_user', $data);
    }
}

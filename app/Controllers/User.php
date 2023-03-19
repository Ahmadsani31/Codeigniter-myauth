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
        return view('v_user', $arrD);
    }

    public function group()
    {
        $arrD = [
            'Title' => 'Group'
        ];
        return view('v_group', $arrD);
    }

    public function permission()
    {
        $arrD = [
            'Title' => 'Permission'
        ];
        return view('v_permission', $arrD);
    }



    function simpanDanUpdate()
    {
        $post = $this->request->getPost();
        // print_r($post);
        $data = [
            'nama' => $post['Nama'],
            // 'email' => $post['Email'],
            // 'username' => $post['Username'],
        ];
        $this->group->removeUserFromAllGroups($post['UserID']);
        $this->group->addUserToGroup($post['UserID'], $post['GroupID']);

        if ($post['UserID'] == 0) {
            if ($param = $this->users->insert($data)) {
                // return $this->respondCreated();
                return $this->response->setJSON(['param' => $param, 'pesan' => 'Berhasil Simpan']);
            }
            return $this->response->setJSON(['param' => $param, 'pesan' => $this->users->errors()]);
            // return $this->fail($this->model_undangan->errors());
        } else {
            if ($param = $this->users->update($post['UserID'], $data)) {
                return $this->response->setJSON(['param' => $param, 'pesan' => 'Berhasil Simpan']);
            }
            return $this->response->setJSON(['param' => $param, 'pesan' =>  $this->users->errors()]);
        }
    }

    public function simpanDanUpdateGroup()
    {
        $post = $this->request->getPost();

        $data = [
            'name' => $post['Nama'],
            'description' => $post['description'],
        ];

        if ($post['GroupID'] == 0) {

            if ($param = $this->group->insert($data)) {
                // return $this->respondCreated();
                foreach ($post['PermissionID'] as $persNew) {
                    $this->group->addPermissionToGroup($persNew, $this->group->getInsertId());
                }

                return $this->response->setJSON(['param' => $param, 'pesan' => 'Berhasil Simpan']);
            }
            return $this->response->setJSON(['param' => $param, 'pesan' => $this->group->errors()]);
            // return $this->fail($this->model_undangan->errors());
        } else {
            //get all permissiion for group
            $permissOld = $this->group->getPermissionsForGroup($post['GroupID']);
            foreach ($permissOld as $permOld) {
                // delete all permission from group
                $this->group->removePermissionFromGroup($permOld['id'], $post['GroupID']);
            }
            //update new permission to group

            if ($param = $this->group->update($post['GroupID'], $data)) {
                foreach ($post['PermissionID'] as $persNew) {
                    $this->group->addPermissionToGroup($persNew, $post['GroupID']);
                }

                return $this->response->setJSON(['param' => $param, 'pesan' => 'Berhasil Simpan']);
            }
            return $this->response->setJSON(['param' => $param, 'pesan' =>  $this->group->errors()]);
        }
    }
}

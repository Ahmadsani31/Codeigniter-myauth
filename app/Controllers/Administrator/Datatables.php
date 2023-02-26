<?php

namespace App\Controllers\Administrator;

use App\Controllers\BaseController;
use App\Models\UserModel;
use \Hermawan\DataTables\DataTable;
use Myth\Auth\Models\GroupModel;
use Myth\Auth\Models\PermissionModel;
use PhpParser\Node\Stmt\Echo_;

class Datatables extends BaseController
{
    public function __construct()
    {
        $this->user = new UserModel();
        $this->group = new GroupModel();
        $this->permissions = new PermissionModel();
    }

    public function index()
    {
        $tb =  $this->request->getVar('datatable');

        switch ($tb) {
            case 'group':
                $table = $tb;
                $db = db_connect()->table('auth_groups')->get();
                break;
            case 'permission':
                $table = $tb;
                $db = db_connect()->table('auth_permissions')->get();
                break;
        }

        if ($db->getNumRows() > 0) {
            switch ($table) {
                case 'group':
                    foreach ($db->getResultArray() as $info) {

                        $permission = $this->group->getPermissionsForGroup($info['id']);
                        foreach ($permission as $permis) {
                            $per[$info['id']][] = '<span class="badge badge bg-success">' . $permis['name'] . '</span>';
                        }
                        $data['data'][] = [
                            "id"        => $info['id'],
                            "name"        => $info['name'],
                            "description"        => $info['description'],
                            "permission"        => implode(' ', $per[$info['id']]),
                        ];
                    }
                    break;
                case 'permission':
                    foreach ($db->getResultArray() as $info) {
                        $data['data'][] = [
                            "id"        => $info['id'],
                            "name"        => $info['name'],
                            "description"        => $info['description'],
                        ];
                    }
                    break;
            }
            echo json_encode($data);
        } else {
            echo '{"data":""}';
        }
    }

    public function serverSide()
    {
        $table = $this->request->getVar('table');
        if ($table) {
            switch ($table) {
                case 'user':
                    $builder = db_connect()->table('users')->select('id,email, username, active')->where('deleted_at', null);

                    return DataTable::of($builder)
                        ->addNumbering('nomor')
                        ->add('group', function ($row) {
                            $groups = $this->group->getGroupsForUser($row->id);
                            return '<span class="badge text-bg-primary">' . $groups[0]['name'] . '</span>';
                        })
                        ->add('permission', function ($row) {
                            $groups = $this->group->getGroupsForUser($row->id);
                            $permission = $this->group->getPermissionsForGroup($groups[0]['group_id']);
                            foreach ($permission as $permis) {
                                $per[$row->id][] = '<span class="badge text-bg-info">' . $permis['name'] . '</span>';
                            }
                            return implode(' ', $per[$row->id]);
                        })
                        ->add('button', function ($row) {
                            $btn = '<button class="btn btn-sm btn-success btn-sm modal-open-cre" userid="' . $row->id . '" id="user" Judul="Edit User"><i class="ri-edit-box-line"></i></button>&nbsp;';
                            $btn .= '<button title="Hapus Data" class="btn btn-sm btn-danger btn-sm modal-hapus-cre" id="' . $row->id . '" table="users"><i class="ri-delete-bin-5-line"></i></button>';
                            return $btn;
                        })
                        ->toJson(true);
                    break;
            }
        }
    }
}

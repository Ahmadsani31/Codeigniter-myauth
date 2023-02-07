<?php

namespace App\Controllers\Administrator;

use App\Controllers\BaseController;
use App\Models\UserModel;
use \Hermawan\DataTables\DataTable;
use Myth\Auth\Models\GroupModel;
use Myth\Auth\Models\PermissionModel;

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
        //
    }

    public function serverSide()
    {
        $table = $this->request->getVar('table');
        if ($table) {
            switch ($table) {
                case 'user':
                    $builder = db_connect()->table('users')->select('id,email, username, active');

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
                        ->toJson(true);
                    break;

                default:
                    # code...
                    break;
            }
        }
    }
}

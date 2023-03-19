<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;

class Delete extends BaseController
{
    use ResponseTrait;
    public function index()
    {
        $ID =  $this->request->getPost('id');
        $Table =  $this->request->getPost('table');
        switch ($Table) {
            case 'users':
                if ($found = $this->MUser->delete($ID)) {
                    return $this->respondDeleted($found);
                }
                return $this->fail('Data Gagal Dihapus');
                break;
            case 'auth_groups':
                $permissOld = $this->group->getPermissionsForGroup($ID);
                foreach ($permissOld as $permOld) {
                    $this->group->removePermissionFromGroup($permOld['id'], $ID);
                }
                if ($found = $this->group->delete($ID)) {
                    return $this->respondDeleted($found);
                }
                return $this->fail('Data Gagal Dihapus');
                break;
            default:
                return $this->fail('Data Gagal Dihapus');
                break;
        }
    }
}

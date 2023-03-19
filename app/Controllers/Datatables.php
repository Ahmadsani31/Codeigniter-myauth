<?php

namespace App\Controllers;

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
            case 'acara':
                $table = $tb;
                $db = $this->MAcara->getData();
                break;
            case 'acara_sub':
                $table = $tb;
                $AcaraID = $this->request->getPost('AcaraID');
                $db = $this->MAcaraSub->getData($AcaraID);
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
                case 'acara':
                    foreach ($db->getResultArray() as $info) {
                        $data['data'][] = [
                            "AcaraID"        => $info['AcaraID'],
                            "Nama"        => $info['Nama'],
                            "Tempat"        => $info['Tempat'],
                            "Slug"        => $info['Slug'],
                            "Keterangan"        => $info['Keterangan'],
                            "Tanggal" => TanggalIndo($info['TglMulai']) . ' - ' . TanggalIndo($info['TglAkhir'])
                        ];
                    }
                    break;
                case 'acara_sub':
                    foreach ($db->getResultArray() as $info) {
                        $sql = db_connect('db_undangan')->table('undangan')->where('UndanganID', $info['UndanganID'])->get()->getRowArray();


                        $gambar = '<img src="' . base_url() . '/assets/img/not-found.png" width="100px" alt="">';
                        if (!empty($info['FileGambar'])) {
                            $gambar = '<img src="' . base_url() . '/assets/files/images/' . $info['FileGambar'] . '" width="100px" alt="">';
                        }

                        $data['data'][] = [
                            "AcaraSubID"        => $info['AcaraSubID'],
                            "AcaraID"        => $info['AcaraID'],
                            "Nama"        => $sql['Nama'],
                            "Prioritas"        => '<span class="badge text-bg-info">' . $info['Prioritas'] . '</span>',
                            "Keterangan"        => $info['Keterangan'],
                            "FileGambar"        => $gambar,
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
                case 'undangan':
                    $builder = db_connect('db_undangan')->table('undangan')->select('UndanganID,WilayahID,Nama,Alamat,KodePos,Kontak,Latitude,Longitude')->where('Deleted_AT', null);
                    return DataTable::of($builder)
                        ->addNumbering('nomor')
                        ->add('kordinat', function ($row) {
                            $kordinat = '<span class="badge text-bg-info">' . $row->Latitude . '</span><br>';
                            $kordinat .= '<span class="badge text-bg-info">' . $row->Longitude . '</span>';
                            return $kordinat;
                        })
                        ->add('nmUndangan', function ($row) {
                            $btn = '<button class="btn btn-sm btn-primary btn-sm modal-open-cre mr-1 mb-1" undanganid="' . $row->UndanganID . '" id="undangan-nama" Judul="Set nama untuk label Undangan"><i class="ri-price-tag-fill"></i></button>';
                            return $btn;
                        })
                        ->add('button', function ($row) {
                            $btn = '<button class="btn btn-sm btn-success btn-sm modal-open-cre mr-1 mb-1" undanganid="' . $row->UndanganID . '" id="undangan" Judul="Edit Data Undangan"><i class="ri-edit-box-line"></i></button>';
                            $btn .= '<button title="Hapus Data" class="btn btn-sm btn-danger btn-sm modal-hapus-cre ml-1 mb-1" id="' . $row->UndanganID . '" table="undangan"><i class="ri-delete-bin-5-line"></i></button>';
                            return $btn;
                        })
                        ->toJson(true);
                    break;
            }
        }
    }
}

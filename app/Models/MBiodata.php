<?php

namespace App\Models;

use CodeIgniter\Model;

class MBiodata extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'biodatas';
    protected $primaryKey       = 'BiodataID';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['UserID', 'TentangSaya', 'NamaPangilan', 'NoHP', 'ProvinsiID', 'KabupatenID', 'KecamatanID', 'Alamat', 'Avatar', 'Created_AT', 'Updated_AT', 'Deleted_AT'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'Created_AT';
    protected $updatedField  = 'Updated_AT';
    protected $deletedField  = 'Deleted_AT';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = ['beforeInsert'];
    protected $afterInsert    = [];
    protected $beforeUpdate   = ['beforeUpdate'];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];


    protected function beforeInsert(array $data)
    {
        $data['data']['UCreate'] = session()->get('s_Nama');
        return $data;
    }

    protected function beforeUpdate(array $data)
    {
        $data['data']['UEdited'] = session()->get('s_Nama');
        return $data;
    }

    // protected function afterDelete(array $data)
    // {
    //     $builder = db_connect()->table($this->table);
    //     $dataUpdate = [
    //         'NA' => 'Y',
    //         'UDelete'  => session()->get('s_Nama'),
    //     ];
    //     $builder->where($this->primaryKey, $data['id'][0]);
    //     $builder->update($dataUpdate);
    // }
}

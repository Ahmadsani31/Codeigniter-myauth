<?php

namespace App\Models;

use CodeIgniter\Model;

class MUndangan extends Model
{
    protected $DBGroup          = 'db_undangan';
    protected $table            = 'undangan';
    protected $primaryKey       = 'UndanganID';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = ['UndanganID', 'WilayahID', 'Nama', 'WA', 'Alamat', 'KodePos', 'Kontak',  'Latitude', 'Longitude', 'NamaUndangan', 'AlamatUndangan', 'DiUndangan', 'Created_AT', 'UCreate', 'Updated_AT', 'UEdited', 'Deleted_AT'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'Created_AT';
    protected $updatedField  = 'Updated_AT';
    protected $deletedField  = 'Deleted_AT';

    // Validation
    protected $validationRules = [
        'Nama'       =>        [
            'rules' => 'required|min_length[3]|max_length[255]',
            'errors' => [
                'required' => '{field} Harus diisi',
                'min_length' => '{field} minimal 10 huruf',
            ]
        ],
        'KodePos'      =>  [
            'rules' => 'required',
            'errors' => [
                'required' => '{field} Harus diisi',
            ]
        ],
        'Kontak'      => [
            'rules' => 'required',
            'errors' => [
                'required' => '{field} Harus diisi',
            ]
        ],
        'Alamat' => [
            'rules' =>  'required|min_length[5]',
            'errors' => [
                'required' => '{field} Harus diisi',
                'min_length' => '{field} minimal 10 huruf',
            ]
        ],
        'Latitude'      => [
            'rules' => 'required',
            'errors' => [
                'required' => '{field} Harus diisi',
            ]
        ],
        'Longitude'      => [
            'rules' => 'required',
            'errors' => [
                'required' => '{field} Harus diisi',
            ]
        ], 'WilayahID'      => [
            'rules' => 'required',
            'errors' => [
                'required' => '{field} Harus diisi',
            ]
        ], 'WA'      => [
            'rules' => 'required',
            'errors' => [
                'required' => '{field} Harus diisi',
            ]
        ],
    ];

    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = ['beforeInsert'];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = ['afterDelete'];

    public function getData()
    {
        $builder = $this->table($this->table);
        $query   = $builder->get();  // Produces: SELECT * FROM mytable

        return $query;
    }

    public function getWhere($UndanganID)
    {
        $builder = $this->table($this->table);
        $query = $builder->getWhere(['UndanganID' => $UndanganID]);
        $query   = $builder->get();  // Produces: SELECT * FROM mytable

        return $query;
    }
    ///
    protected function beforeInsert(array $data)
    {
        $data['data']['UCreate'] = session()->get('Nama');
        return $data;
    }
    protected function afterDelete(array $data)
    {
        // $builder = $this->table($this->table)->update($data['id'][0], [
        //     'Active' => 'N',
        //     'UEdited' => session()->get('Nama'),
        // ]);
        db_connect('db_undangan')->query('UPDATE acara SET Active="N", UEdited="' . session()->get('Nama') . '" WHERE AcaraID="' . $data['id'][0] . '"');
    }
}

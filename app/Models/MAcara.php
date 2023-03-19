<?php

namespace App\Models;

use CodeIgniter\Model;

class MAcara extends Model
{
    protected $DBGroup          = 'db_undangan';
    protected $table            = 'acara';
    protected $primaryKey       = 'AcaraID';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = ['AcaraID', 'Nama', 'Slug', 'Tempat', 'TglMulai', 'TglAkhir', 'Keterangan', 'Created_AT', 'UCreate', 'Updated_AT', 'UEdited', 'Deleted_AT'];

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
                'min_length' => '{field} minimal 3 huruf',
            ]
        ]
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
        $builder = $this->table($this->table)->where(['Deleted_AT' => null, 'Active' => 'Y']);
        $query   = $builder->get();  // Produces: SELECT * FROM mytable

        return $query;
    }

    public function getSlug($Slug)
    {
        $builder = $this->table($this->table);
        $builder->where('Slug', $Slug);
        $builder->limit(1);
        $query   = $builder->get();  // Produces: SELECT * FROM mytable

        return $query;
    }

    public function UpdateStatus($Slug)
    {
        $builder = $this->table($this->table);
        $builder->where('Slug', $Slug);
        $builder->limit(1);
        $query   = $builder->get();  // Produces: SELECT * FROM mytable

        return $query;
    }

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
        db_connect('db_undangan')->query('DELETE FROM acara_sub WHERE AcaraID="' . $data['id'][0] . '"');
    }
}

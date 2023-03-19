<?php

namespace App\Models;

use CodeIgniter\Model;

class MAcaraSub extends Model
{
    protected $DBGroup          = 'db_undangan';
    protected $table            = 'acara_sub';
    protected $primaryKey       = 'AcaraSubID';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = ['AcaraSubID', 'AcaraID', 'UndanganID', 'Keterangan', 'FileGambar', 'Prioritas', 'Created_AT', 'Updated_AT', 'Deleted_AT'];

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
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function getData($AcaraID)
    {
        $builder = $this->table($this->table)->where(['AcaraID' => $AcaraID, 'Deleted_AT' => null])->orderBy('Prioritas', 'ASC');
        $query   = $builder->get();  // Produces: SELECT * FROM mytable

        return $query;
    }
}

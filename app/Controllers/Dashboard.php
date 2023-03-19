<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Dashboard extends BaseController
{
    public function index()
    {

        $Udg =  $this->MUndangan->where('Deleted_AT', null)->findAll();
        foreach ($Udg as $va) {
            $totSemuaUndangan[] = $va;
            if ($va['Latitude'] != null && $va['Longitude'] != null) {
                $totAdaLocation[] = $va;
            }
        }
        $Udg =  $this->MUndangan->where('Deleted_AT', null)->findAll();
        $Acr =  $this->MAcara->where('Deleted_AT', null)->findAll();

        $arrD = [
            'Title' => 'Dashboard',
            'TotalUndangan' => count($totSemuaUndangan),
            'TotalUndanganLocation' => count($totAdaLocation),
            'TotalAcara' => count($Acr)
        ];
        return view('v_dashboard', $arrD);
    }

    function getLocation()
    {
        $query = db_connect('db_undangan')->query('SELECT * FROM undangan WHERE Latitude IS NOT NULL AND Longitude IS NOT NULL');
        $location = [];
        foreach ($query->getResultArray() as $value) {
            $location[] = [$value['Nama'], $value['Latitude'], $value['Longitude'], 5];
        }
        echo json_encode($location);
    }
}

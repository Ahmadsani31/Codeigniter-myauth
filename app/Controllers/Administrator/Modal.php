<?php

namespace App\Controllers\Administrator;

use App\Controllers\BaseController;

class Modal extends BaseController
{
    function __construct()
    {
    }
    public function index()
    {
        $data = [
            'group' => $this->group,
            'MUser' => $this->MUser,
        ];
        $modal =   $this->request->uri->getSegment(2);
        return view('administrator/modal/' . $modal, $data);
    }
}

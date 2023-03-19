<?php

namespace App\Controllers;

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
        return view('modal/' . $modal, $data);
    }
}

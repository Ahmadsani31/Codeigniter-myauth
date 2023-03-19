<?php

namespace App\Libraries;

class Pdf
{
    function LOADFpdfFancyrow()
    {
        // require_once(APPPATH . 'ThirdParty/fpdf/html_table.php');
        // require_once(APPPATH . 'ThirdParty/fpdf/fpdf.php');
        require_once(APPPATH . 'ThirdParty/fpdf/fancyrow.php');
    }
}

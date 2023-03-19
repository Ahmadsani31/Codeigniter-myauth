<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\Pdf;
use CodeIgniter\HTTP\RequestTrait;
use FPDF;
use PDF as PDFTable;
use PDF_FancyRow;
use PDF_HTML;

class Acara extends BaseController
{
    use RequestTrait;
    public function index()
    {
        $arrD = [
            'Title' => 'Acara'
        ];
        return view('v_acara', $arrD);
    }

    function view($slug)
    {
        $sql = $this->MAcara->getSlug($slug)->getRowArray();
        $this->data['Nama'] =  $sql['Nama'];
        $this->data['AcaraID'] =  $sql['AcaraID'];
        $this->data['Title'] =  'Detail Acara';
        return view('v_acara-detail', $this->data);
    }

    public function simpan()
    {
        $post = $this->request->getPost();

        $data = [
            "Nama"          => $post['Nama'],
            "Tempat"        => $post['Tempat'],
            "Slug"          => strtolower(url_title($post['Nama'])),
            "Keterangan"    => $post['Keterangan'],
            "TglMulai"      => $post['TglMulai'],
            "TglAkhir"      => $post['TglAkhir'],
        ];
        $param = 0;
        $pesan = '';

        if ($post['AcaraID'] == 0) {
            if ($param = $this->MAcara->insert($data)) {
                // return $this->respondCreated();
                return $this->response->setJSON(['param' => $param, 'pesan' => 'Berhasil Simpan']);
            }
            return $this->response->setJSON(['param' => $param, 'pesan' => $this->MAcara->errors()]);
            // return $this->fail($this->model_undangan->errors());
        } else {
            if ($param = $this->MAcara->update($post['AcaraID'], $data)) {
                return $this->response->setJSON(['param' => $param, 'pesan' => 'Berhasil Simpan']);
            }
            return $this->response->setJSON(['param' => $param, 'pesan' => $this->MAcara->errors()]);
        }
    }

    public function simpanSub()
    {
        $param = 0;
        $pesan = '';

        $AcaraSubID = $this->request->getPost('AcaraSubID');
        $AcaraID = $this->request->getPost('AcaraID');
        $UndanganID = $this->request->getPost('UndanganID');
        $AllUndangan = $this->request->getPost('AllUndangan');
        $Keterangan = $this->request->getPost('Keterangan');
        $FileGambar = $this->request->getFile('FileGambar');

        if (!empty($FileGambar)) {
            $isValidFile = $this->validate([
                'FileGambar'       =>        [
                    'label' => 'Gambar',
                    'rules' => 'uploaded[FileGambar]|is_image[FileGambar]|mime_in[FileGambar,image/jpg,image/jpeg,image/gif,image/png,image/webp]|max_size[FileGambar,1024]',
                    'errors' => [
                        'mime_in' => '{field} type not support',
                        'max_size' => '{field} size melebihi kapasitas',
                    ]
                ]
            ]);

            if (!$isValidFile) {;
                return $this->response->setJSON(['param' => $param, 'pesan' => $this->validator->getErrors()]);
            }
            $filepath = 'assets/files/images/';
            createDir($filepath);

            if ($FileGambar->isValid() && !$FileGambar->hasMoved()) {
                $newName = $FileGambar->getRandomName();
                $FileGambar->move($filepath, $newName);
            }
        }

        if (is_array($UndanganID) || $AllUndangan == 'on') {
            if ($AllUndangan == 'on') {
                $sql =   $this->MUndangan->getData();
                foreach ($sql->getResultArray() as $key => $value) {
                    $data = [
                        "AcaraID" => $AcaraID,
                        "UndanganID" => $value['UndanganID'],
                        "Keterangan" => $Keterangan,
                    ];
                    $param = $this->MAcaraSub->insert($data);
                }
            } else {
                foreach ($UndanganID as $ID) {
                    $data = [
                        "AcaraID" => $AcaraID,
                        "UndanganID" => $ID,
                        "Keterangan" => $Keterangan,
                    ];
                    $param = $this->MAcaraSub->insert($data);
                }
            }


            if ($param > 0) {
                return $this->response->setJSON(['param' => $param, 'pesan' => 'Berhasil Simpan']);
            } else {
                return $this->response->setJSON(['param' => $param, 'pesan' => $this->MAcaraSub->errors()]);
            }
        } else {
            $d =  $this->MAcaraSub->find($AcaraSubID);
            if (file_exists($filepath . $d['FileGambar']) && $d['FileGambar']) {
                unlink($filepath . $d['FileGambar']);
            }

            $data = [
                "AcaraID" => $AcaraID,
                "UndanganID" => $UndanganID,
                "Keterangan" => $Keterangan,
                "FileGambar" => $newName,
            ];

            if ($param = $this->MAcaraSub->update($AcaraSubID, $data)) {
                return $this->response->setJSON(['param' => $param, 'pesan' => 'Berhasil Simpan']);
            }
            return $this->response->setJSON(['param' => $param, 'pesan' => $this->MAcaraSub->errors()]);
        }
    }

    public function  setPrioritasUndangan()
    {
        $param = 0;
        $post = $this->request->getPost();
        $sql = $this->MAcaraSub->find($post['acaraSubID']);
        if ($sql['Prioritas'] == 'N') {
            $text = 'Undangan diset menjadi PRIORITAS';
            $prioritas = 'Y';
        } else {
            $text = 'Undangan diunset dari PRIORITAS';
            $prioritas = 'N';
        }
        $data = [
            'Prioritas' => $prioritas
        ];

        if ($param = $this->MAcaraSub->update($post['acaraSubID'], $data)) {
            return $this->response->setJSON(['param' => $param, 'pesan' => $text]);
        }
        return $this->response->setJSON(['param' => $param, 'pesan' => $this->MAcaraSub->errors()]);
    }

    function cetakNamaUndangan()
    {

        $sql = db_connect('db_undangan')->table('undangan')->limit(10)->get();
        foreach ($sql->getResultArray() as $key) {
            $dataUnd[] = [
                $key['Nama'],
                'di',
                $key['Alamat'],

            ];
        }

        // echo '<pre>';
        // print_r($dataUnd);
        // echo '</pre>';

        $data = [
            ['asdsadasd', 'di', 'asdasdas',],
            ['sdfsd sdf', 'di', 'sdf sdfsdf',],
            ['sdfsdfs', 'di', 'sdfsdfsd',],
            ['asdssdfsdfadasd', 'di', 'asdas',],
            ['sdfsd', 'di', 'asdasd',],
            ['sfsd', 'di', 'gf',],
            ['dfghdfg', 'di', 'sdf',],
            ['fghfghfg', 'di', 'asdfsdfg',],
        ];



        $Table = '<table border="1">';
        $Table .= '<tr>';
        $i = 1;
        foreach ($data as $value) {
            if (is_int($i / 4)) {

                $Table .= '<td align="center"  height="34" width="67"><div></div>' . $value[0] . '<br>' . $value[1] . '<br>' . $value[2] . '</td></tr>';
            } else {

                $Table .= '<td height="34" width="67" align="center"><div></div>' . $value[0] . '<br>' . $value[1] . '<br>' . $value[2] . '</td>';
            }
            $i++;
        }


        $Table .= '    </table>';
        // echo $Table;
        // exit();


        $this->response->setHeader('Content-Type', 'application/pdf');

        $pdf = Pdf::LOADFpdfFancyrow();

        $pdf = new PDF_FancyRow();
        $pdf->AddPage();
        $pdf->SetFont('Arial', '', 12);
        $pdf->Write(12, 'Please fill in your name, company and email below:');
        $pdf->Ln(20);
        $widths = array(5, 40, 5, 40, 5, 40);
        $border = array('', 'LBR', '', 'LBR', '', 'LBR');
        $caption = array('', 'Name', '', 'Company', '', 'Email');
        $align = array('', 'C', '', 'C', '', 'C');
        $style = array('', 'I', '', 'I', '', 'I');
        $empty = array('', '', '', '', '', '');
        $pdf->SetWidths($widths);
        $pdf->FancyRow($empty, $border);
        $pdf->FancyRow($caption, $empty, $align, $style);
        $pdf->Output();
    }

    function cetakUndangan()
    {
        $arrD = [
            'Title' => 'Acara'
        ];
        return view('v_acara_cetak', $arrD);
    }

    function cetakUndanganPost()
    {
        $file = $this->request->getFile('FileExcel');
        $ext = $file->getClientExtension(); // Mengetahui Nama File
        if ($ext == 'xls') {
            $render = new \PhpOffice\PhpSpreadsheet\Reader\xls();
        } elseif ($ext == 'csv') {
            $render = new \PhpOffice\PhpSpreadsheet\Reader\csv();
        } else {
            $render = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        }

        $spreadsheet = $render->load($file);

        $data = $spreadsheet->getActiveSheet()->toArray();

        foreach ($data as $key => $row) {
            if ($key != 0) {

                $cekUd = db_connect('db_undangan')->table('undangan')->getWhere(['Nama' => $row[1]])->getResult();
                if (count($cekUd) > 0) {
                    session()->setFlashdata('errors', ['Gagal simpan, Data Duplicate']);
                } else {
                    $data = [
                        'Nama' => $row[1],
                        'Alamat' => $row[2],
                        'Kontak' => $row[6],
                        'WA' => $row[7],
                    ];
                    // $db->table('undangan')->insert($save);
                    if ($this->model_undangan->insert($data)) {
                        session()->setFlashdata('success', 'Berhasil import excel');
                    }
                    session()->setFlashdata('errors', $this->model_undangan->errors());
                }
            }
        }
        return redirect()->to(base_url('undangan'));
    }

    public function getEventFullcalender()
    {
        $acara = $this->MAcara->where('Deleted_AT', null)->findAll();

        foreach ($acara as $key => $value) {
            $data['data'][$key]['id'] = $value['AcaraID'];
            $data['data'][$key]['title'] = $value['Nama'];
            $data['data'][$key]['start'] = $value['TglMulai'];
            $data['data'][$key]['end'] = $value['TglAkhir'];
            $data['data'][$key]['backgroundColor'] = "#00a65a";
        }

        return $this->response->setJSON($data);
    }
}

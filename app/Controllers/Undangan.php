<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\RequestTrait;
use TCPDF;

class Undangan extends BaseController
{
    use RequestTrait;
    public function index()
    {
        $arrD = [
            'Title' => 'Undangan'
        ];
        return view('v_undangan', $arrD);
    }

    public function simpan()
    {
        $post = $this->request->getPost();

        $data = [
            "Nama"      => $post['Nama'],
            "Alamat"    => $post['Alamat'],
            "KodePos"   => $post['KodePos'],
            "Kontak"    => $post['Kontak'],
            "Latitude"  => $post['Latitude'],
            "Longitude" => $post['Longitude'],
            "WilayahID" => $post['WilayahID'],
            "WA"        => $post['WA'],
        ];
        $param = 0;
        $pesan = '';

        if ($post['UndanganID'] == 0) {
            if ($param = $this->MUndangan->insert($data)) {
                // return $this->respondCreated();
                return $this->response->setJSON(['param' => $param, 'pesan' => 'Berhasil Simpan']);
            }
            return $this->response->setJSON(['param' => $param, 'pesan' => $this->MUndangan->errors()]);
            // return $this->fail($this->model_undangan->errors());
        } else {
            if ($param = $this->MUndangan->update($post['UndanganID'], $data)) {
                return $this->response->setJSON(['param' => $param, 'pesan' => 'Berhasil Simpan']);
            }
            return $this->response->setJSON(['param' => $param, 'pesan' => $this->MUndangan->errors()]);
        }
    }

    public function setLabelUndangan()
    {
        $post = $this->request->getPost();

        $data = [
            "NamaUndangan"      => $post['NamaUndangan'],
            "AlamatUndangan"    => $post['AlamatUndangan'],
            "DiUndangan"   => $post['DiUndangan'],
        ];
        $param = 0;
        $pesan = '';

        if ($param = $this->MUndangan->update($post['UndanganID'], $data)) {
            return $this->response->setJSON(['param' => $param, 'pesan' => 'Berhasil Simpan']);
        }
        return $this->response->setJSON(['param' => $param, 'pesan' => $this->MUndangan->errors()]);
    }

    function import_excel()
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
        // return redirect()->to('/undangan');
    }

    function cetakTCPDF($AcaraID)
    {

        $this->response->setHeader('Content-Type', 'application/pdf');

        $sql = db_connect('db_undangan')->query('SELECT * FROM acara_sub as a join undangan as b on b.UndanganID=a.UndanganID WHERE a.AcaraID="' . $AcaraID . '" AND b.NamaUndangan IS NOT NULL AND b.AlamatUndangan IS NOT NULL ORDER BY b.Nama');
        foreach ($sql->getResultArray() as $key) {
            $dataUnd[] = [
                substr($key['NamaUndangan'], 0, 50),
                substr($key['DiUndangan'], 0, 10),
                substr($key['AlamatUndangan'], 0, 100),

            ];
        }

        // echo count($dataUnd) . '<br>';
        // echo (count($dataUnd) % 3);
        if ((count($dataUnd) % 3) == 1) {
            array_push($dataUnd, ['', '', ''], ['', '', '']);
        } elseif ((count($dataUnd) % 3) == 2) {
            array_push($dataUnd, ['', '', '']);
        }




        $pdf = new TCPDF('L', 'mm', array('205', '165'), true, 'UTF-8', false);

        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        //$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetMargins(1.5, 1, 1);
        // $pdf->Ln(40);
        // ---------------------------------------------------------
        // $pdf->SetAutoPageBreak(TRUE, 6);
        // set font
        $pdf->SetFont('dejavusans', '', 10);

        // add a page
        $pdf->AddPage();


        // create some HTML content


        // echo '<pre>';
        // print_r($dataUnd);
        // echo '</pre>';
        // exit();

        $Table = '<table border="0" cellspacing="7" cellpadding="5">';
        $kolom = 3;
        $no = 1;
        foreach ($dataUnd as  $value) {

            if (($no) % $kolom == 1) {
                $Table .= '<tr>';
            }
            $Table .= '<td align="center" height="32mm" width="64mm"><br><br>' . $value[0] . '<br>' . $value[1] . '<br>' . $value[2] . '</td>';
            if (($no) % $kolom == 0) {
                $Table .= '</tr>';
            }

            $no++;
        }
        $Table .= ' </table>';
        // echo $Table;
        // exit();
        // $Table = '<table border="1"><tr><th align="center" class="b">Pimpinan Bank Nagari Cabang Utama <br> di <br>Jl. Pemuda No.21, Olo, Kec. Padang Barat, Kota Padang, Sumatera Barat 25117</th><th align="center" class="b">Pimpinan Bank Nagari Cabang Pembantu UNP <br> di <br>Gedung Business Center Kampus UNP, Jl. Prof. Hamka, Padang Utara, Kota Padang, Sumatera Barat 25173</th><th align="center" class="a">Pimpinan Bank Nagari Syariah <br> di <br>Jl. Blk. Olo, Kp. Jao, Kec. Padang Barat, Kota Padang, Sumatera Barat</th></tr><th align="center" class="b">Pimpinan Bank Nagari Siteba  <br> di <br>Jl. Raya Siteba</th><th align="center" class="b">Camat Koto Tangah <br> di <br>Jl. Adinegoro No.17, Lubuk Buaya, Kec. Koto Tangah, Kota Padang, Sumatera Barat 25586</th><th align="center" class="a">Ketua RT 04/ RW. 05 Air Pacah <br> di <br>Aie Pacah, Kec. Koto Tangah, Kota Padang, Sumatera Barat 25586</th></tr><th align="center" class="b">Ka. Polsek Koto Tangah <br> di <br>Jembatan Timbang Lubuk Buaya, Jalan Adinegoro, Lubuk Buaya, Padang, Kota Padang, Sumatera Barat 25172</th><th align="center" class="b">Direktur PT. Intra Tiara Persada <br> di <br>Jl. Raya Siteba, Surau Gadang, Kec. Nanggalo, Kota Padang, Sumatera Barat 25173</th><th align="center" class="a">Direktur PT. Andalan Tiara Persada <br> di <br>Jl. Raya Siteba, Surau Gadang, Kec. Nanggalo, Kota Padang, Sumatera Barat 25173</th></tr> </tr> </table>';


        // output the HTML content
        $pdf->writeHTML($Table, true, false, true, false, '');

        // reset pointer to the last page
        $pdf->lastPage();

        // - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
        // Print a table


        //Close and output PDF document
        $pdf->Output('example_006.pdf', 'I');
    }
}

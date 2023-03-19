<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Profil extends BaseController
{
    public function index()
    {
        $Biodata = [
            'BiodataID' => 0,
            'NoHP' => '',
            'TentangSaya' => '',
            'ProvinsiID' => '',
            'KabupatenID' => '',
            'KecamatanID' => '',
            'Alamat' => '',
            'NamaPangilan' => '',
            'Avatar' => base_url('assets/img/avatars/profile-image.png'),
        ];
        $User = $this->MUser->find(session()->get('s_UserID'));
        $Bio = db_connect()->table('biodatas')->where('UserID', session()->get('s_UserID'))->get();
        if ($Bio->getNumRows() > 0) {
            $qBio = $Bio->getRow();
            $Biodata = [
                'BiodataID' => $qBio->BiodataID,
                'NoHP' => $qBio->NoHP,
                'TentangSaya' => $qBio->TentangSaya,
                'ProvinsiID' => $qBio->ProvinsiID,
                'KabupatenID' => $qBio->KabupatenID,
                'KecamatanID' => $qBio->KecamatanID,
                'Alamat' => $qBio->Alamat,
                'NamaPangilan' => $qBio->NamaPangilan,
                'Avatar' => base_url('assets/files/profil/') . $qBio->Avatar,
            ];
        }
        $arrD = [
            'Title' => 'Profil User',
            'User' => $User,
            'Biodata' => $Biodata,
        ];
        return view('v_profil', $arrD);
    }

    public function upload()
    {
        $post = $this->request->getPost();

        $user = $this->MBiodata->where('BiodataID', $post['biodataID'])->first();

        if ($user != null) {
            if (file_exists('assets/files/profil/' . $user['Avatar']) && $user['Avatar']) {
                unlink('assets/files/profil/' . $user['Avatar']);
            }
        }

        $fileImageArray = explode(";", $post['fileImage']);
        $fileImageBase64 = explode(",", $fileImageArray[1]);
        $uplaod =  $this->fileBase64->du_uploads('assets/files/profil/', $fileImageBase64[1], $post['typeFile']);


        if ($uplaod['status'] == true) {
            $dataInput = [
                'Avatar' => $uplaod['file_name']
            ];
            if ($post['biodataID'] == 0) {
                if ($param = $this->MBiodata->insert($dataInput)) {
                    return $this->response->setJSON(['param' => $param, 'pesan' => 'Berhasil Simpan']);
                }
                return $this->response->setJSON(['param' => $param, 'pesan' => $this->MBiodata->errors()]);
            } else {
                if ($param = $this->MBiodata->update($post['biodataID'], $dataInput)) {
                    return $this->response->setJSON(['param' => $param, 'pesan' => 'Berhasil Simpan']);
                }
                return $this->response->setJSON(['param' => $param, 'pesan' => $this->MBiodata->errors()]);
            }
        } else {
            return $this->response->setJSON(['param' => 0, 'pesan' => 'Foto profil gagal diuplaod']);
        }
        // print_r($uplaod);
    }

    public function simpanBiodata()
    {
        $param = 0;
        $post = $this->request->getPost();

        $dataInput = [
            'UserID' => session()->get('s_UserID'),
            'NoHP' => $post['NoHP'],
            'TentangSaya' => $post['TentangSaya'],
            'ProvinsiID' => $post['ProvinsiID'],
            'KabupatenID' => $post['KabupatenID'],
            'KecamatanID' => $post['KecamatanID'],
            'Alamat' => $post['Alamat'],
            'NamaPangilan' => $post['NamaPangilan'],
        ];

        if ($post['BiodataID'] == 0) {
            if ($param = $this->MBiodata->insert($dataInput)) {
                return redirect()->back()->with('success', 'Profil berhasil disimpan');
                // return $this->response->setJSON(['param' => $param, 'pesan' => 'Berhasil Simpan']);
            }
            return $this->response->setJSON(['param' => $param, 'pesan' => $this->MBiodata->errors()]);
        } else {
            if ($param = $this->MBiodata->update($post['BiodataID'], $dataInput)) {
                return redirect()->back()->with('success', 'Profil berhasil diupdate');
                // return $this->response->setJSON(['param' => $param, 'pesan' => 'Berhasil Simpan']);
            }
            return $this->response->setJSON(['param' => $param, 'pesan' => $this->MBiodata->errors()]);
        }
    }

    public function simpanPassword()
    {
    }
}

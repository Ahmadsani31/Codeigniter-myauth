<?php
function Option($Table, $Primary, $Selected, $Nama, $where = null)
{

    $data = "";

    switch ($Table) {
        case 'group':
            $query = db_connect()->query("SELECT * from $Table where $where order by id ASC");
            break;

        default:
            $query = db_connect()->query("SELECT * from $Table");
            break;
    }

    foreach ($query->getResultArray() as $fetch) {
        if ($Selected == $fetch[$Primary]) {
            $sel = "selected";
        } else {
            $sel = "";
        }

        $data .= '<option value="' . $fetch[$Primary] . '" ' . $sel . '>' . $fetch[$Nama] . '</option>';
    }

    return $data;
}

function OptionDaerah($Table, $Primary, $Selected)
{

    $data = "";
    $obj = [];
    switch ($Table) {
        case 'provinsi':
            $json = file_get_contents('https://ibnux.github.io/data-indonesia/provinsi.json', true);
            $obj = json_decode($json);
            break;
        case 'kabupaten':
            if ($Primary != null) {
                $json = file_get_contents('https://ibnux.github.io/data-indonesia/kabupaten/' . $Primary . '.json', true);
                $obj = json_decode($json);
                return $obj;
            }

            break;
        case 'kecamatan':
            if ($Primary != null) {
                $json = file_get_contents('https://ibnux.github.io/data-indonesia/kecamatan/' . $Primary . '.json', true);
                $obj = json_decode($json);
                return $obj;
            }
            break;
    }

    foreach ($obj as $fetch) {
        if ($Selected == $fetch->id) {
            $sel = "selected";
        } else {
            $sel = "";
        }

        $data .= '<option value="' . $fetch->id . '" ' . $sel . '>' . $fetch->nama . '</option>';
    }

    return $data;
}

function createDir($path)
{
    if (!file_exists($path)) {
        $old_mask = umask(0);
        mkdir($path, 0777, true);
        umask($old_mask);
    }
}

function TanggalIndo($Date)
{
    if ($Date != '') {
        $Tanggal = substr($Date, 0, 10);
        $Jam     = substr($Date, 11, 8);

        $bulan = array(
            1 => 'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        );

        $pecahkan = explode('-', $Tanggal);

        if ($Jam != "") {
            return $pecahkan[2] . ' ' . $bulan[(int) $pecahkan[1]] . ' ' . $pecahkan[0] . ' Jam ' . $Jam;
        } else {
            return @$pecahkan[2] . ' ' . @$bulan[(int) @$pecahkan[1]] . ' ' . @$pecahkan[0];
        }
    }
}

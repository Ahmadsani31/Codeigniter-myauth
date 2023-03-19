<?php
function OptCreate($Key, $Name, $Selected)
{

    $data = '';

    $Jumlah = count($Key);

    if ($Jumlah > 0) {

        for ($i = 0; $i < $Jumlah; $i++) {

            $selected = $Key[$i] == $Selected ? "selected" : "";

            $data .= '<option value ="' . $Key[$i] . '" ' . $selected . '>' . $Name[$i] . '</option>';
        }
    } else {

        $data .= '<option =""></option>';
    }

    return $data;
}


function options($from = '', $primary = '', $selected = '', $where = '', $database = 'default')
{
    $options = '';
    $s       = '';
    if ($from != '') {
        $db =  db_connect($database)->table($from);
        $db->select('*');
        if ($where != '') {
            $db->where($where);
        }
        $sql = $db->get();
        $j   = $sql->getNumRows();
        if ($j > 0) {
            switch ($from) {
                case 'undangan':
                    foreach ($sql->getResultArray() as $key) {
                        $s = '';
                        if ($key[$primary] == $selected) {
                            $s = 'selected';
                        }
                        $options .= '<option value="' . $key[$primary] . '" ' . $s . '>' . $key['Nama'] . '</options>';
                    }
                    break;
            }
        }
    }
    return $options;
}

function OptionMultiple($Table, $Primary, $Selected, $Nama, $where = null)
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
    // $x = explode(",", $Selected);

    foreach ($query->getResultArray() as $fetch) {

        if (in_array($fetch[$Primary], $Selected)) {
            $sel = "selected";
        } else {
            $sel = "";
        }

        $data .= '<option value="' . $fetch[$Primary] . '" ' . $sel . '>' . $fetch[$Nama] . '</option>';
    }

    return $data;
}

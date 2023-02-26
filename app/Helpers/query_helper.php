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


function textHalo()
{
    echo 'hai';
}

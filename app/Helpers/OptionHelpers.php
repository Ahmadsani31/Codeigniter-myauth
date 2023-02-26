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

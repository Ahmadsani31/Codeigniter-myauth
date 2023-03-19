<?= $this->extend('layout/_app') ?>

<?= $this->section('content-body') ?>
<div class="container-fluid p-0">

    <h1 class="h3 mb-3">Halaman <?= $Title; ?></h1>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-actions float-end">
                        <div class="dropdown position-relative">
                            <button class="btn btn-sm btn-primary modal-open-cre" id="acara" acaraid="" style="margin-right:20px;"><i class="ri-add-box-fill"></i> Tambah Data</button>
                        </div>
                    </div>
                    <h5 class="card-title mb-0">Data User</h5>
                </div>
                <?php

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
                echo '<pre>';
                print_r($data);
                echo '</pre>';



                foreach ($data as $value) {
                    print_r($value);
                }
                ?>

                <table border="1">
                    <?php
                    $kolom = 4;
                    $i = 1;
                    foreach ($data as $value) {
                        if (is_int($i / 4)) {

                            echo '<td style="height:34mm; width:67mm" align="center"><div></div>' . $value[0] . '<br>' . $value[1] . '<br>' . $value[2] . '</td></tr><tr>';
                        } else {

                            echo '<td style="height:34mm; width:67mm" align="center"><div></div>' . $value[0] . '<br>' . $value[1] . '<br>' . $value[2] . '</td>';
                        }
                        $i++;
                    }
                    ?>
                </table>
                <table border="1">
                    <tr>
                        <td height="34" width="67" align="center">
                            <div></div>asdsadasd<br>di<br>asdasdas
                        </td>
                        <td height="34" width="67" align="center">
                            <div></div>sdfsd sdf<br>di<br>sdf sdfsdf
                        </td>
                        <td height="34" width="67" align="center">
                            <div></div>sdfsdfs<br>di<br>sdfsdfsd
                        </td>
                        <td align="center" height="34" width="67">
                            <div></div>asdssdfsdfadasd<br>di<br>asdas
                        </td>
                    </tr>
                    <tr>
                        <td height="34" width="67" align="center">
                            <div></div>sdfsd<br>di<br>asdasd
                        </td>
                        <td height="34" width="67" align="center">
                            <div></div>sfsd<br>di<br>gf
                        </td>
                        <td height="34" width="67" align="center">
                            <div></div>dfghdfg<br>di<br>sdf
                        </td>
                        <td align="center" height="34" width="67">
                            <div></div>fghfghfg<br>di<br>asdfsdfg
                        </td>
                    </tr>
                </table>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="DTable" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Tempat</th>
                                    <th>Tanggal</th>
                                    <th>Keterangan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>
<?= $this->endSection() ?>
<?= $this->section('content-js') ?>

<?= $this->endSection() ?>
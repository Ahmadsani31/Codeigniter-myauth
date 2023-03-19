<?php
$Nama = '';
$WilayahID = '';
$WA = '';
$Alamat = '';
$KodePos = '';
$Kontak = '';
$Latitude = '';
$Longitude = '';
$UndanganID =  $_POST['undanganid'];
if (!empty($UndanganID)) {
    $qeu = db_connect('db_undangan')->query('SELECT * FROM undangan WHERE UndanganID="' . $UndanganID . '"')->getRow();
    $Nama = $qeu->Nama;
    $Alamat = $qeu->Alamat;

    $NamaUndangan = $qeu->NamaUndangan ? $qeu->NamaUndangan : $qeu->Nama;
    $AlamatUndangan = $qeu->AlamatUndangan ? $qeu->AlamatUndangan : $qeu->Alamat;
    $DiUndangan = $qeu->DiUndangan ? $qeu->DiUndangan : "Di";
}
?>

<form action="<?= route_to('save.namaUndangan'); ?>" method="post" id="form-acara">
    <?= csrf_field() ?>
    <div class="modal-body">
        <ul>
            <li><?= $Nama; ?></li>
            <li><?= $Alamat; ?></li>
        </ul>
        <div class="form-group mb-3">
            <input type="text" name="NamaUndangan" class="form-control" value="<?= $NamaUndangan; ?>" placeholder="Nama undangan">
        </div>
        <div class="form-group mb-3">
            <input type="text" name="DiUndangan" class="form-control" value="<?= $DiUndangan; ?>" placeholder="di">
        </div>
        <div class="form-group mb-3">
            <input type="text" name="AlamatUndangan" class="form-control" value="<?= $AlamatUndangan; ?>" placeholder="Alamat Undangan">
        </div>
    </div>
    <input type="hidden" name="UndanganID" value="<?= $UndanganID; ?>">
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" id="simpanData" class="btn btn-primary">Simpan Data</button>
    </div>
</form>
<script>
    $(document).ready(function() {
        $('#form-acara').submit(function(e) {
            e.preventDefault();
            var form = this;
            $.ajax({
                url: $(form).attr('action'),
                method: $(form).attr('method'),
                enctype: 'multipart/form-data',
                data: new FormData(form),
                processData: false,
                contentType: false,
                cache: false,
                success: function(data, textStatus) {
                    DTable.ajax.reload(null, false);
                    if (data.param > 0) {
                        $("#myModals").modal("hide");
                        Swal.fire({
                            icon: 'success',
                            title: textStatus,
                            text: data.pesan,
                            showConfirmButton: false,
                            timer: 1500
                        })
                    } else {
                        var pesan = '';
                        Object.keys(data.pesan).forEach(function(key) {
                            pesan += data.pesan[key] + ", ";
                        });
                        Swal.fire({
                            icon: 'error',
                            title: 'Kesalahan !',
                            text: pesan,
                        })
                    }
                    // console.log(data);
                    // console.log(textStatus);
                },
                error: function(jqXhr, textStatus, errorMessage) {
                    // console.log(textStatus)
                    // console.log(errorMessage)
                    // console.log(jqXhr.responseJSON.message)
                    Swal.fire({
                        icon: 'error',
                        title: jqXhr.statusText,
                        text: jqXhr.responseJSON.message,
                    })
                }
            })
        });
    });
</script>
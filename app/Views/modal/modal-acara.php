<?php
$Nama = '';
$Keterangan = '';
$Tempat = '';
$TglMulai = '';
$TglAkhir = '';

$AcaraID =  $_POST['acaraid'];
if (!empty($AcaraID)) {
    $qeu = db_connect('db_undangan')->query('SELECT * FROM acara WHERE AcaraID="' . $AcaraID . '"')->getRow();
    $Nama = $qeu->Nama;
    $Keterangan = $qeu->Keterangan;
    $Tempat = $qeu->Tempat;
    $TglMulai = $qeu->TglMulai;
    $TglAkhir = $qeu->TglAkhir;
}
?>

<form action="<?= route_to('save.acara'); ?>" method="post" id="form-acara">
    <?= csrf_field() ?>
    <div class="modal-body">
        <div class="form-group mb-3">
            <label class="text-black">Nama</label>
            <input type="text" name="Nama" class="form-control" value="<?= $Nama; ?>" placeholder="Nama">
        </div>
        <div class="form-group mb-3">
            <label class="text-black">Tempat</label>
            <input type="text" name="Tempat" class="form-control" value="<?= $Tempat; ?>" placeholder="Nama">
        </div>
        <div class="row">
            <div class="form-group col-md-6 mb-3">
                <label class="text-black">Mulai Acara</label>
                <input type="date" name="TglMulai" class="form-control" value="<?= $TglMulai; ?>" placeholder="Nama">
            </div>
            <div class="form-group col-md-6 mb-3">
                <label for="">&nbsp;</label>
                <input type="date" name="TglAkhir" class="form-control" value="<?= $TglAkhir; ?>" placeholder="Nama">
            </div>
        </div>
        <div class="form-group mb-3">
            <label class="text-black">Keterangan</label>
            <textarea class="form-control" name="Keterangan" rows="4"><?= $Keterangan; ?></textarea>
        </div>
    </div>
    <input type="hidden" name="AcaraID" value="<?= $AcaraID; ?>">
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
                }
            })
        });
    });
</script>
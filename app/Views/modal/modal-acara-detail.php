<style>
    .form-check .form-check-input {
        float: left;
        margin-left: -1.2em;
    }
</style>
<?php
$UndanganID = '';
$Keterangan = '';

$AcaraSubID =  $_POST['acarasubid'];
$AcaraID =  $_POST['acaraid'];
if (!empty($AcaraSubID)) {
    $qeu = db_connect('db_undangan')->query('SELECT * FROM acara_sub WHERE AcaraID="' . $AcaraID . '" AND AcaraSubID="' . $AcaraSubID . '"')->getRow();
    $UndanganID = $qeu->UndanganID;
    $Keterangan = $qeu->Keterangan;
}
?>

<form action="<?= route_to('save.acara_sub'); ?>" method="post" id="form-acara" enctype="multipart/form-data">
    <?= csrf_field() ?>
    <div class="modal-body">
        <div class="form-check mb-3">
            <input class="form-check-input" name="AllUndangan" type="checkbox" id="invalidCheck">
            <label class="form-check-label text-black" for="invalidCheck">
                Ceklis untuk pilih Semua undangan
            </label>
        </div>
        <div class="form-group mb-3">
            <label class="text-black form-label">Undangan</label>
            <select class="form-control CSS-select2" name="UndanganID[]" id="UndanganID" multiple>
                <?php echo options('undangan', 'UndanganID', $UndanganID, '', 'db_undangan') ?>
            </select>
        </div>
        <div class="form-group mb-3">
            <label class="text-black">Keterangan</label>
            <textarea name="Keterangan" id="Keterangan" class="form-control" cols="30" rows="4"><?= $Keterangan; ?></textarea>
        </div>
    </div>
    <input type="hidden" name="AcaraID" value="<?= $AcaraID; ?>">
    <input type="hidden" name="AcaraSubID" value="<?= $AcaraSubID; ?>">
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" id="simpanData" class="btn btn-primary">Simpan Data</button>
    </div>
</form>
<script>
    $(document).ready(function() {
        $(".CSS-select2").select2({
            tags: "true",
            placeholder: "Select an option",
            allowClear: true
        });

        checkBox = document.getElementById('invalidCheck').addEventListener('click', event => {
            if (event.target.checked) {
                document.getElementById("UndanganID").disabled = true;
            } else {
                document.getElementById("UndanganID").disabled = false;
            }
        });

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
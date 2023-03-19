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
    <div class="modal-body pb-0">
        <h1 style="padding-left: 10px;"><?= $Nama; ?></h1>
        <table class="table text-black mb-0" style="font-size: 16px;">

            <tr>
                <td width="5"><i class="ri-arrow-right-circle-fill"></i></td>
                <td><?= TanggalIndo($TglMulai); ?></td>
                <td>Sampai dengan</td>
                <td><?= TanggalIndo($TglAkhir); ?></td>
            </tr>

            <tr class="mt-0">
                <td><i class="ri-arrow-right-circle-fill"></i></td>
                <td colspan="3"><?= $Keterangan; ?></td>
            </tr>
            </tbody>
        </table>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
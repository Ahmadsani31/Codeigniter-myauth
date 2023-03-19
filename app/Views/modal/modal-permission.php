<?php

$Nama = '';
$description = '';
$PermissionID =  $_POST['permissionid'];
if (!empty($PermissionID)) {
    $qeu = db_connect()->query('SELECT * FROM auth_permissions WHERE id="' . $PermissionID . '"')->getRow();
    $Nama = $qeu->name;
    $description = $qeu->description;


    $permission = $group->getPermissionsForGroup($qeu->id);
    foreach ($permission as $permis) {
        $permis_on[] = $permis['id'];
    }
}
?>

<form action="<?= base_url('admin/permission'); ?>" method="post" id="form-simpan">
    <?= csrf_field() ?>
    <div class="modal-body">
        <div class="form-group mb-2">
            <label class="text-black">Nama</label>
            <input type="text" name="Nama" class="form-control" value="<?= $Nama; ?>" placeholder="nama">
        </div>
        <div class="form-group mb-2">
            <label class="text-black">Keterangan</label>
            <textarea name="description" class="form-control" id="" cols="30" rows="3"><?= $description; ?></textarea>
        </div>

    </div>
    <input type="hidden" name="PermissionID" value="<?= $PermissionID; ?>">
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" id="simpanData" class="btn btn-primary">Simpan Data</button>
    </div>
</form>
<script>
    $(document).ready(function() {
        $('#form-simpan').submit(function(e) {
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
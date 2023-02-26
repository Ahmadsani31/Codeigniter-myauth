<?php

$Nama = '';
$description = '';
$permis_on = [];
$GroupID =  $_POST['groupid'];
if (!empty($GroupID)) {
    $qeu = db_connect()->query('SELECT * FROM auth_groups WHERE id="' . $GroupID . '"')->getRow();
    $Nama = $qeu->name;
    $description = $qeu->description;


    $permission = $group->getPermissionsForGroup($qeu->id);
    foreach ($permission as $permis) {
        $permis_on[] = $permis['id'];
    }
}
?>

<form action="<?= base_url('admin/group'); ?>" method="post" id="form-simpan">
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

        <div class="form-group mb-2">
            <label class="text-black">Permission</label>
            <select name="PermissionID[]" id="" class="form-control select2" multiple="multiple">
                <?php
                echo OptionMultiple('auth_permissions', 'id',  $permis_on, 'name');
                ?>
            </select>
        </div>
    </div>
    <input type="hidden" name="GroupID" value="<?= $GroupID; ?>">
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" id="simpanData" class="btn btn-primary">Simpan Data</button>
    </div>
</form>
<script>
    $('.select2').select2({
        dropdownParent: $('#myModals')
    });
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
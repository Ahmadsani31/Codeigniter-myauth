<?php
$Nama = '';
$Email = '';
$Username = '';
$GroupID = '';
$Password = '';
$UserID =  $_POST['userid'];
if (!empty($UserID)) {
    $qeu = db_connect()->query('SELECT * FROM users WHERE id="' . $UserID . '"')->getRow();

    $Nama = $qeu->nama;
    $Email = $qeu->email;
    $Username = $qeu->username;
    $Password = $qeu->password_hash;

    $groups = $group->getGroupsForUser($qeu->id);
    $GroupID = $groups[0]['group_id'];
}
?>

<form action="<?= base_url('admin/user'); ?>" method="post" id="form-simpan">
    <?= csrf_field() ?>
    <div class="modal-body">
        <div class="form-group mb-3">
            <label class="text-black">Nama</label>
            <input type="text" name="nama" class="form-control" value="<?= $Nama; ?>" placeholder="nama">
        </div>
        <div class="form-group mb-3">
            <label class="text-black">Email</label>
            <input type="text" name="email" class="form-control" value="<?= $Email; ?>" placeholder="email">
        </div>
        <div class="form-group mb-3">
            <label class="text-black">Username</label>
            <input type="text" name="username" class="form-control" value="<?= $Username; ?>" placeholder="username">
        </div>
        <div class="row">
            <div class="form-group col-md-6 mb-3">
                <label class="text-black">Password</label>
                <input type="password" name="password" class="form-control" value="<?= $Password; ?>" placeholder="username">
            </div>
            <div class="form-group col-md-6 mb-3">
                <label class="text-black">Password Konfirmasi</label>
                <input type="password" name="pass_confirm" class="form-control" value="<?= $Password; ?>" placeholder="username">
            </div>
        </div>

        <div class="form-group mb-3">
            <label class="text-black">Group</label>
            <select name="GroupID" id="" class="form-control">
                <option value="">[pilih]</option>
                <?php
                echo Option('auth_groups', 'id',  $GroupID, 'name');
                ?>
            </select>
        </div>
    </div>
    <input type="hidden" name="UserID" value="<?= $UserID; ?>">
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
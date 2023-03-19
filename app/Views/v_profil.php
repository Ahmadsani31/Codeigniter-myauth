<?= $this->extend('layout/_app') ?>
<?= $this->section('content-css') ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.css" integrity="sha512-zxBiDORGDEAYDdKLuYU9X/JaJo/DPzE42UubfBw9yg8Qvb2YRRIQ8v4KsGHOx2H1/+sdSXyXxLXv5r7tHc9ygg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>
    #upload-demo {
        width: auto;
        height: auto;
    }
</style>
<?= $this->endSection() ?>
<?= $this->section('content-body') ?>
<div class="container-fluid p-0">

    <h1 class="h3 mb-3">Biodata / Profil</h1>
    <div class="alert alert-warning" role="alert">
        Segera isi dan lengkapi biodata kamu biar kamu semakin dikenal oleh developer
    </div>
    <div class="row">
        <div class="col-md-3 col-xl-2">

            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Profil Settings</h5>
                </div>

                <div class="list-group list-group-flush" role="tablist">
                    <a class="list-group-item list-group-item-action active" data-bs-toggle="list" href="#account" role="tab" aria-selected="true">
                        Account
                    </a>
                    <a class="list-group-item list-group-item-action" data-bs-toggle="list" href="#password" role="tab" aria-selected="false" tabindex="-1">
                        Password
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-9 col-xl-10">
            <div class="tab-content">
                <div class="tab-pane fade show active" id="account" role="tabpanel">
                    <form action="<?= route_to('profil/simpan-biodata'); ?>" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="BiodataID" id="BiodataID" value="<?= $Biodata['BiodataID']; ?>">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Public info</h5>
                            </div>
                            <div class="card-body">

                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="mb-3">
                                            <label class="form-label" for="inputUsername">Username</label>
                                            <input type="text" class="form-control" id="inputUsername" value="<?= $User->username; ?>" placeholder="Username" readonly>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="inputUsername">Tentang Saya</label>
                                            <textarea rows="2" class="form-control" name="TentangSaya" placeholder="Tell something about yourself"><?= $Biodata['TentangSaya']; ?></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-4">


                                        <div class="text-center">
                                            <img alt="Charles Hall" id="item-img-output" src="<?= $Biodata['Avatar']; ?>" class="rounded-circle img-responsive mt-2" width="128" height="128">
                                            <div class="mt-2">
                                                <input class="form-control btn btn-primary item-img file" type="file" name="file_photo" style="width: 60%;">
                                                <input type="hidden" id="typeFile">
                                            </div>
                                            <small>gunakan foto terbaik untuk profil yang berformat images (jpg,jpeg,png) </small>
                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">

                                <h5 class="card-title mb-0">Private info</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="mb-3 col-md-8">
                                        <label class="form-label" for="inputFirstName">Nama lengkap</label>
                                        <input type="text" class="form-control" name="Nama" value="<?= $User->nama; ?>" placeholder="First name">
                                    </div>
                                    <div class="mb-3 col-md-4">
                                        <label class="form-label" for="inputLastName">Pangilan</label>
                                        <input type="text" class="form-control" name="NamaPangilan" value="<?= $Biodata['NamaPangilan']; ?>" placeholder="Last name">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="inputEmail4">Email</label>
                                    <input type="email" class="form-control" name="Email" value="<?= $User->email; ?>" placeholder="Email">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="inputEmail4">No Handphone</label>
                                    <input type="number" class="form-control" name="NoHP" placeholder="No Handphone" value="<?= $Biodata['NoHP']; ?>">
                                </div>


                                <div class="row">
                                    <div class="mb-3 col-md-4">
                                        <label class="form-label" for="inputCity">Provinsi </label>
                                        <select id="select2-provinsi" name="ProvinsiID" class="form-control">
                                            <option selected="">Choose...</option>
                                            <?= OptionDaerah('provinsi', '', $Biodata['ProvinsiID']); ?>
                                        </select>
                                    </div>
                                    <div class="mb-3 col-md-4">
                                        <label class="form-label" for="inputState">Kabupaten / Kota</label>
                                        <select id="select2-kabupaten" name="KabupatenID" class="form-control">
                                            <option selected="">Choose...</option>
                                            <?= OptionDaerah('kabupaten', $Biodata['ProvinsiID'], $Biodata['KabupatenID']); ?>
                                        </select>
                                    </div>
                                    <div class="mb-3 col-md-4">
                                        <label class="form-label" for="inputZip">Kecamatan</label>
                                        <select id="select2-kecamatan" name="KecamatanID" class="form-control">
                                            <option selected="">Choose...</option>
                                            <?= OptionDaerah('kecamatan', $Biodata['KabupatenID'], $Biodata['KecamatanID']); ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="inputAddress">Alamat</label>
                                    <textarea name="Alamat" id="" class="form-control" cols="30" rows="5"><?= $Biodata['Alamat']; ?></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                        </div>
                    </form>

                </div>
                <div class="tab-pane fade" id="password" role="tabpanel">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Password</h5>

                            <form>
                                <div class="mb-3">
                                    <label class="form-label" for="inputPasswordCurrent">Current password</label>
                                    <input type="password" class="form-control" id="inputPasswordCurrent" value="<?= $User->password; ?>">
                                    <small><a href="#">Forgot your password?</a></small>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="inputPasswordNew">New password</label>
                                    <input type="password" class="form-control" id="inputPasswordNew">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="inputPasswordNew2">Verify password</label>
                                    <input type="password" class="form-control" id="inputPasswordNew2">
                                </div>
                                <button type="submit" class="btn btn-primary">Save changes</button>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<div class="modal fade" id="cropImagePop" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Upload Profil</h4>
                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal" aria-label="Close"><i class="ri-close-fill"></i>
                </button>
            </div>
            <div class="modal-body">
                <div id="upload-demo" class="center-block"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" id="cropImageBtn" class="btn btn-primary">Crop</button>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
<?= $this->section('content-js') ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.js" integrity="sha512-Gs+PsXsGkmr+15rqObPJbenQ2wB3qYvTHuJO6YJzPe/dTLvhy0fmae2BcnaozxDo5iaF8emzmCZWbQ1XXiX2Ig==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    var $uploadCrop,
        tempFilename,
        rawImg,
        imageId;

    function readFile(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('.upload-demo').addClass('ready');
                $('#cropImagePop').modal('show');
                rawImg = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        } else {
            swal("Sorry - you're browser doesn't support the FileReader API");
        }
    }

    $uploadCrop = $('#upload-demo').croppie({
        viewport: {
            width: 200,
            height: 200,
        },
        boundary: {
            width: 300,
            height: 300
        },
        enforceBoundary: true,
        enableExif: true
    });
    $('#cropImagePop').on('shown.bs.modal', function() {
        // alert('Shown pop');
        $uploadCrop.croppie('bind', {
            url: rawImg
        }).then(function() {
            console.log('jQuery bind complete');
        });
    });

    $('.item-img').on('change', function() {
        imageId = $(this).data('id');
        tempFilename = $(this).val();
        var file = event.target.files[0];
        console.log(file);
        $('#typeFile').val(file.type);
        $('#cancelCropBtn').data('id', imageId);
        readFile(this);
    });
    $('#cropImageBtn').on('click', function(ev) {
        $uploadCrop.croppie('result', {
            type: 'base64',
            format: 'png',
            size: {
                width: 200,
                height: 200
            }
        }).then(function(resp) {

            $.ajax({
                url: "<?= base_url('profil/upload'); ?>",
                method: 'POST',
                data: {
                    typeFile: $('#typeFile').val(),
                    biodataID: $('#BiodataID').val(),
                    fileImage: resp,
                },
                success: function(data, textStatus) {
                    if (data.status == false) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Perhatian!',
                            text: data.message,
                        })
                        return false;
                    }
                    if (data.param == true) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: data.pesan,
                        })
                    }
                    $('#item-img-output').attr('src', resp);
                    $('#cropImagePop').modal('hide');
                },
                error: function(jqXhr, textStatus, errorMessage) {
                    Swal.fire({
                        icon: 'error',
                        title: jqXhr.statusText,
                        text: jqXhr.responseJSON.message,
                    })
                }
            })


        });
    });

    var urlProvinsi = "https://ibnux.github.io/data-indonesia/provinsi.json";
    var urlKabupaten = "https://ibnux.github.io/data-indonesia/kabupaten/";
    var urlKecamatan = "https://ibnux.github.io/data-indonesia/kecamatan/";
    var urlKelurahan = "https://ibnux.github.io/data-indonesia/kelurahan/";

    function clearOptions(id) {
        console.log("on clearOptions :" + id);

        //$('#' + id).val(null);
        $('#' + id).empty().trigger('change');
    }

    console.log('Load Provinsi...');
    $.getJSON(urlProvinsi, function(res) {

        res = $.map(res, function(obj) {
            obj.text = obj.nama
            return obj;
        });

        data = [{
            id: "",
            nama: "- Pilih Provinsi -",
            text: "- Pilih Provinsi -"
        }].concat(res);

        //implemen data ke select provinsi
        $("#select2-provinsi").select2({
            dropdownAutoWidth: true,
            width: '100%',
            data: data
        })
    });

    var selectProv = $('#select2-provinsi');
    $(selectProv).change(function() {
        var value = $(selectProv).val();
        clearOptions('select2-kabupaten');

        if (value) {
            console.log("on change selectProv");

            var text = $('#select2-provinsi :selected').text();
            console.log("value = " + value + " / " + "text = " + text);

            console.log('Load Kabupaten di ' + text + '...')
            $.getJSON(urlKabupaten + value + ".json", function(res) {

                res = $.map(res, function(obj) {
                    obj.text = obj.nama
                    return obj;
                });

                data = [{
                    id: "",
                    nama: "- Pilih Kabupaten -",
                    text: "- Pilih Kabupaten -"
                }].concat(res);

                //implemen data ke select provinsi
                $("#select2-kabupaten").select2({
                    dropdownAutoWidth: true,
                    width: '100%',
                    data: data
                })
            })
        }
    });

    var selectKab = $('#select2-kabupaten');
    $(selectKab).change(function() {
        var value = $(selectKab).val();
        clearOptions('select2-kecamatan');

        if (value) {
            console.log("on change selectKab");

            var text = $('#select2-kabupaten :selected').text();
            console.log("value = " + value + " / " + "text = " + text);

            console.log('Load Kecamatan di ' + text + '...')
            $.getJSON(urlKecamatan + value + ".json", function(res) {

                res = $.map(res, function(obj) {
                    obj.text = obj.nama
                    return obj;
                });

                data = [{
                    id: "",
                    nama: "- Pilih Kecamatan -",
                    text: "- Pilih Kecamatan -"
                }].concat(res);

                //implemen data ke select provinsi
                $("#select2-kecamatan").select2({
                    dropdownAutoWidth: true,
                    width: '100%',
                    data: data
                })
            })
        }
    });

    // End upload preview image
</script>
<?= $this->endSection() ?>
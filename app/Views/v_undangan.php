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
                            <button class="btn btn-sm btn-primary modal-open-cre" id="undangan" undanganid="" style="margin-right:20px;"><i class="ri-add-box-fill"></i> Tambah Data</button>
                        </div>
                    </div>
                    <h5 class="card-title mb-0">Data User</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="DTable" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Alamat</th>
                                    <th>Kode Pos</th>
                                    <th>Kontak</th>
                                    <th>Latitude</th>
                                    <th>Set Nama</th>
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
<script>
    var DTable;
    var DTable = $('#DTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '<?= base_url('datatable/server-side'); ?>',
            method: 'POST',
            data: function(d) {
                d.table = 'undangan';
            },
        },
        order: [],
        columnDefs: [{
            className: "text-center",
            targets: ['_all'],
        }, {
            searchable: false,
            orderable: false,
            targets: 0,
        }],
        columns: [{
            data: "nomor",
        }, {
            data: "Nama",
        }, {
            data: "Alamat",
        }, {
            data: "KodePos",
        }, {
            data: "Kontak",
        }, {
            data: "kordinat",
        }, {
            searchable: false,
            orderable: false,
            data: "nmUndangan",
        }, {
            searchable: false,
            orderable: false,
            data: "button",
        }],
    });
</script>
<?= $this->endSection() ?>
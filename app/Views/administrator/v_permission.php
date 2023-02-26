<?= $this->extend('administrator/layout/_app') ?>

<?= $this->section('content-body') ?>
<div class="container-fluid p-0">

    <h1 class="h3 mb-3"><?= $Title; ?></h1>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-actions float-end">
                        <div class="dropdown position-relative">
                            <button class="btn btn-sm btn-primary modal-open-cre" permissionid="0" id="permission">Tambah Data</button>
                        </div>
                    </div>
                    <h5 class="card-title mb-0">Data Permission
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="DTable" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
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
<script>
    var DTable;
    var DTable = $("#DTable").DataTable({
        ajax: {
            url: "<?= base_url(); ?>/datatable",
            type: "POST",
            data: function(d) {
                d.datatable = 'permission';
            },
        },
        columnDefs: [{
            className: "align-middle text-center",
            targets: ['_all'],
        }, {
            searchable: false,
            orderable: false,
            targets: 0,
        }, {
            targets: -1,
            data: "aksi",
            searchable: false,
            orderable: false,
            render: function(data) {
                btn = '<button class="btn btn-sm btn-primary btn-sm modal-open-cre mr-1 mb-1" permissionid="' + data.id + '" id="permission" Judul="Proses Presensi Dosen" data-bs-toggle="tooltip" data-bs-placement="top" title="Halaman Acara"> <i class="ri-edit-box-fill"></i></button>&nbsp;';
                btn += '<button class="btn btn-sm btn-danger btn-sm mr-1 mb-1 modal-hapus-cre" id="' + data.id + '" table="permission"><i class="ri-delete-bin-2-fill"></i></button>&nbsp;';
                return btn;
            },
        }],
        columns: [{
            data: null,
        }, {
            data: "name",
        }, {
            data: "description",
        }, {
            data: null,
        }],
    });
    //nomor otomatis colomn 0

    DTable.on("order.dt search.dt", function() {
        DTable.column(0, {
            search: "applied",
            order: "applied",
        }).nodes().each(function(cell, i) {
            cell.innerHTML = i + 1 + ".";
        });
    }).draw();
</script>
<?= $this->endSection() ?>
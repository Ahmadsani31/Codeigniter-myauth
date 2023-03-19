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
                            <button class="btn btn-sm btn-primary modal-open-cre" id="acara" acaraid="" style="margin-right:20px;"><i class="ri-add-box-fill"></i> Tambah Data</button>
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
                                    <th>Tempat</th>
                                    <th>Tanggal</th>
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
<script type="text/javascript">
    var DTable;
    var DTable = $("#DTable").DataTable({
        ajax: {
            url: "<?= base_url(); ?>/datatable",
            type: "POST",
            data: function(d) {
                d.datatable = 'acara';
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
                btn = '<a href="<?= base_url(); ?>acara/tampil/' + data.Slug + '" class="btn btn-sm btn-success mr-1 mb-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Halaman Acara"><i class="ri-file-list-3-line"></i></a>&nbsp;';
                btn += '<button class="btn btn-sm btn-primary btn-sm modal-open-cre mr-1 mb-1" acaraid="' + data.AcaraID + '" id="acara" Judul="Proses Presensi Dosen" data-bs-toggle="tooltip" data-bs-placement="top" title="Halaman Acara"> <i class="ri-edit-box-fill"></i></button>&nbsp;';
                btn += '<button class="btn btn-sm btn-danger btn-sm mr-1 mb-1 modal-hapus-cre" id="' + data.AcaraID + '" table="acara"><i class="ri-delete-bin-2-fill"></i></button>&nbsp;';
                return btn;
            },
        }],
        columns: [{
            data: null,
        }, {
            data: "Nama",
        }, {
            data: "Tempat",
        }, {
            data: "Tanggal",
        }, {
            data: "Keterangan",
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
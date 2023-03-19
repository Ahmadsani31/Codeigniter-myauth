<?= $this->extend('layout/_app') ?>
<?= $this->section('content-css') ?>
<style>
    tr.odd .datatable-color {
        background-color: #FDCF60;
        color: #000;
    }

    tr.even .datatable-color {
        background-color: #FDCF60;
        color: #000;
    }
</style>
<?= $this->endSection() ?>
<?= $this->section('content-body') ?>
<div class="container-fluid p-0">

    <h1 class="h3 mb-3">Halaman <?= $Title; ?></h1>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-actions float-end">
                        <div class="dropdown position-relative">
                            <button class="btn btn-sm btn-primary modal-open-cre" id="acara-detail" acarasubid="" acaraid="<?= $AcaraID; ?>" style="margin-right:20px;"><i class="ri-add-box-fill"></i> Tambah Data</button>
                            <a href="<?= base_url('undangan/cetak/' . $AcaraID); ?>" target="_blank" class="btn btn-sm btn-info"><i class="ri-printer-line"></i> Cetak Nama</a>
                        </div>
                    </div>
                    <a href="<?= base_url('acara'); ?>" class="btn btn-sm btn-warning"><i class="ri-arrow-left-line"></i> Kembali</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="DTable" class="table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Gambar</th>
                                    <th>Prioritas</th>
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
                d.datatable = 'acara_sub';
                d.AcaraID = '<?= $AcaraID; ?>';
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
                btn = '<button class="btn btn-sm btn-success btn-sm mr-1 mb-1"  onclick="prioritas(' + data.AcaraSubID + ')"><i class="ri-check-double-line"></i></button>&nbsp;';
                btn += '<button class="btn btn-sm btn-primary btn-sm modal-open-cre mr-1 mb-1" acaraid="' + data.AcaraID + '" acarasubid="' + data.AcaraSubID + '" id="acara-detail-update" Judul="Proses Presensi Dosen"> <i class="ri-edit-box-fill"></i></button>&nbsp;';
                btn += '<button class="btn btn-sm btn-danger btn-sm mr-1 mb-1 modal-hapus-cre" id="' + data.AcaraSubID + '" table="acara_sub"><i class="ri-delete-bin-2-fill"></i></button>&nbsp;';
                return btn;
            },
        }],
        columns: [{
            data: null,
        }, {
            data: "Nama",
        }, {
            data: "FileGambar",
        }, {
            data: "Prioritas",
        }, {
            data: "Keterangan",
        }, {
            data: null,
        }],
        fnRowCallback: function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
            if (aData.Prioritas == "Y") {
                $('td', nRow).addClass('datatable-color');
            }
        }
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

    function prioritas(params) {

        page = "<?= route_to('save.prioritas'); ?>";
        $.ajax({
            url: page,
            data: {
                acaraSubID: params,
            },
            method: 'POST',
        }).done((data, textStatus) => {
            DTable.ajax.reload();

            toastr.success(data.pesan, "Perhatian!", {
                positionClass: "toast-top-right",
                timeOut: 5e3,
                closeButton: !0,
                debug: !1,
                newestOnTop: !0,
                progressBar: !0,
                preventDuplicates: !0,
                onclick: null,
                showDuration: "300",
                hideDuration: "1000",
                extendedTimeOut: "1000",
                showEasing: "swing",
                hideEasing: "linear",
                showMethod: "fadeIn",
                hideMethod: "fadeOut",
                tapToDismiss: !1
            })
        }).fail((error) => {
            Swal.fire({
                icon: 'error',
                title: error.responseJSON.messages.error,
            })
        })
    }
</script>
<?= $this->endSection() ?>
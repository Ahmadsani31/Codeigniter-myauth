<?= $this->extend('administrator/layout/_app') ?>

<?= $this->section('content-body') ?>
<div class="container-fluid p-0">

    <h1 class="h3 mb-3"><?= $Title; ?></h1>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Empty card</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="DTable" class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Username</th>
                                    <th scope="col">Group</th>
                                    <th scope="col">Permission</th>
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
    $(document).ready(function() {
        $('#DTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '<?= base_url('datatable'); ?>',
                method: 'POST',
                data: function(d) {
                    d.table = 'user';
                },
            },
            columnDefs: [{
                className: "text-center",
                targets: ['_all'],
            }, {
                searchable: false,
                orderable: false,
                targets: 0,
            }],
            columns: [{
                data: 'id',
            }, {
                data: "email",
            }, {
                data: "username",
            }, {
                data: "group",
            }, {
                data: "permission",
            }, ],
        });
    });
</script>
<?= $this->endSection() ?>
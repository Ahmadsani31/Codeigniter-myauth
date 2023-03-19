<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Responsive Admin &amp; Dashboard Template based on Bootstrap 5">
    <meta name="author" content="AdminKit">
    <meta name="keywords" content="adminkit, bootstrap, bootstrap 5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="shortcut icon" href="<?= base_url('assets'); ?>/img/icons/icon-48x48.png" />

    <link rel="canonical" href="https://demo-basic.adminkit.io/" />

    <title>Admin - Bootstrap</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <link href="<?= base_url('assets'); ?>/css/app.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.2/css/jquery.dataTables.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
    <style>
        .sidebar [aria-expanded=true]:after,
        .sidebar [data-bs-toggle=collapse]:not(.collapsed):after {
            top: 1.4rem;
            transform: rotate(-135deg);
        }

        .sidebar [data-bs-toggle=collapse]:after {
            border: solid;
            border-width: 0 0.075rem 0.075rem 0;
            content: " ";
            display: inline-block;
            padding: 2px;
            position: absolute;
            right: 1.5rem;
            top: 1.2rem;
            transform: rotate(45deg);
            transition: all .2s ease-out;
        }

        .sidebar-dropdown .sidebar-item .sidebar-link:hover:hover:before {
            transform: translateX(4px);
        }

        .sidebar-dropdown .sidebar-link:before {
            content: "→";
            display: inline-block;
            left: -14px;
            position: relative;
            transform: translateX(0);
            transition: all .1s ease;
        }

        .sidebar-dropdown .sidebar-link {
            background: transparent;
            border-left: 0;
            color: #adb5bd;
            font-size: 90%;
            font-weight: 400;
            padding: 0.625rem 1.5rem 0.625rem 3.25rem;
        }
    </style>
    <?= $this->renderSection('content-css') ?>
</head>

<body>
    <div class="wrapper">
        <?= $this->include('layout/_sidebar') ?>


        <div class="main">
            <?= $this->include('layout/_navbar') ?>

            <input type="hidden" id="base_url" value="<?= base_url(); ?>">
            <main class="content">
                <?= $this->renderSection('content-body'); ?>

            </main>

            <?= $this->include('layout/_footer') ?>
        </div>
    </div>
    <?= $this->include('layout/_modal') ?>

    <script src="<?= base_url('assets'); ?>/js/app.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js" integrity="sha512-STof4xm1wgkfm7heWqFJVn58Hm3EtS31XFaagaa8VMReCXAkQnJZ+jEy8PCC/iT18dFy95WcExNHFTqLyp72eQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script> -->
    <script src="//cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script src="<?= base_url('assets'); ?>/js/xtends.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <?php if (session()->has('error')) : ?>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Kesalahan...',
                text: `<?= session('error') ?>`,
            })
        </script>
    <?php endif ?>
    <?php if (session()->has('success')) : ?>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: `<?= session('error') ?>`,
            })
        </script>
    <?php endif ?>
    <?= $this->renderSection('content-js'); ?>
    <script>
    </script>
</body>

</html>
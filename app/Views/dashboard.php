<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.108.0">
    <title>Navbar Template · Bootstrap v5.3</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/5.3/examples/navbars-offcanvas/">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />



    <link href="<?= base_url(); ?>/assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }

        .b-example-divider {
            height: 3rem;
            background-color: rgba(0, 0, 0, .1);
            border: solid rgba(0, 0, 0, .15);
            border-width: 1px 0;
            box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
        }

        .b-example-vr {
            flex-shrink: 0;
            width: 1.5rem;
            height: 100vh;
        }

        .bi {
            vertical-align: -.125em;
            fill: currentColor;
        }

        .nav-scroller {
            position: relative;
            z-index: 2;
            height: 2.75rem;
            overflow-y: hidden;
        }

        .nav-scroller .nav {
            display: flex;
            flex-wrap: nowrap;
            padding-bottom: 1rem;
            margin-top: -1px;
            overflow-x: auto;
            text-align: center;
            white-space: nowrap;
            -webkit-overflow-scrolling: touch;
        }
    </style>


    <!-- Custom styles for this template -->
    <link href="<?= base_url(); ?>/assets/css/navbars-offcanvas.css" rel="stylesheet">
</head>

<body>

    <main>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark" aria-label="Offcanvas navbar large">
            <div class="container-fluid">
                <a class="navbar-brand" href="#"><?= session()->get('s_Nama'); ?></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar2" aria-controls="offcanvasNavbar2">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="offcanvas offcanvas-end text-bg-dark" tabindex="-1" id="offcanvasNavbar2" aria-labelledby="offcanvasNavbar2Label">
                    <div class="offcanvas-header">
                        <h5 class="offcanvas-title" id="offcanvasNavbar2Label">Offcanvas</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body">
                        <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="#">Home</a>
                            </li>
                            <?php if (in_groups('administrator')) {
                                echo '      <li class="nav-item">
                                <a class="nav-link" href="#">Group</a>
                            </li>';
                            } ?>

                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Dropdown
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#">Action</a></li>
                                    <li><a class="dropdown-item" href="#">Another action</a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item" href="<?= base_url('logout'); ?>">Log Out</a></li>
                                </ul>
                            </li>
                        </ul>
                        <form class="d-flex mt-3 mt-lg-0" role="search">
                            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                            <button class="btn btn-outline-success" type="submit">Search</button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>

        <div class="container my-5">
            <div class="bg-light p-5 rounded">
                <div class="col-sm-8 py-5 mx-auto">
                    <h1 class="display-5 fw-normal">WELCOME <?= session()->get('s_Nama'); ?></h1>
                    <p class="fs-5">This example shows how responsive offcanvas menus work within the navbar. For positioning of navbars, checkout the <a href="../examples/navbar-static/">top</a> and <a href="../examples/navbar-fixed/">fixed top</a> examples.</p>
                    <p>From the top down, you'll see a dark navbar, light navbar and a responsive navbar—each with offcanvases built in. Resize your browser window to the large breakpoint to see the toggle for the offcanvas.</p>
                    <p>
                        <a class="btn btn-primary" href="../components/navbar/#offcanvas" role="button">Learn more about offcanvas navbars &raquo;</a>
                    </p>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h4>User</h4>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Email</th>
                                <th scope="col">Nama</th>
                                <th scope="col">Group</th>
                                <th scope="col">Permission</th>
                                <th scope="col">Status</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            $delete = '';
                            foreach ($Users as $val) {
                                $groups = $Group->getGroupsForUser($val->id);
                                $permission = $Group->getPermissionsForGroup($groups[0]['group_id']);
                                foreach ($permission as $permis) {
                                    $per[$val->id][] = '<span class="badge text-bg-info">' . $permis['name'] . '</span>';
                                }
                                // implode(',', $per);
                                // echo '<pre>';
                                // print_r($per[$val->id]);
                                // echo '</pre>';
                                // echo $groups->name;
                                if (has_permission('delete-module')) {
                                    $delete = '<a href="" class="btn btn-sm btn-danger ml-1"><i class="fa fa-trash"></i></a>';
                                }
                                echo '<tr>
                                    <th scope="row">' . $no++ . '</th>
                                    <td>' . $val->email . '</td>
                                    <td>' . $val->username . '</td>
                                    <td><span class="badge text-bg-primary">' . $groups[0]['name'] . '</span></td>
                                    <td>' . implode(' ', $per[$val->id]) . '</td>
                                    <td>' . ($val->active == 1 ? 'Aktif' : 'Non Aktif') . '</td>
                                    <td>
                                    <a href="' . base_url('user/' . $val->id . '/edit') . '" class="btn btn-sm btn-primary mr-1"><i class="fa fa-edit"></i></a>
                                    ' . $delete . '
                                    </td>
                                </tr>';
                            }
                            ?>

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h4>Group</h4>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Nama</th>
                                <th scope="col">Keterangan</th>
                                <th scope="col">Permission</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            $delete = '';
                            foreach ($Group->findAll() as $gs) {
                                $permission = $Group->getPermissionsForGroup($gs->id);
                                foreach ($permission as $permiss) {
                                    $perm[$gs->id][] = '<span class="badge text-bg-info">' . $permiss['name'] . '</span>';
                                }
                                // echo '<pre>';
                                // print_r($perm[$gs->id]);
                                // echo '</pre>';
                                echo '<tr>
                                    <th scope="row">' . $no++ . '</th>
                                    <td>' . $gs->name . '</td>
                                    <td>' . $gs->description . '</td>
                                    <td>' . implode(' ', $perm[$gs->id]) . '</td>
                                    <td>
                                    <a href="" class="btn btn-sm btn-primary mr-1"><i class="fa fa-edit"></i></a>
                                    <a href="" class="btn btn-sm btn-danger ml-1"><i class="fa fa-trash"></i></a>
                                    </td>
                                </tr>';
                            }
                            ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>


    <script src="<?= base_url(); ?>/assets/bootstrap/js/bootstrap.bundle.min.js"></script>


</body>

</html>
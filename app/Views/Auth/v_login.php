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

    <link rel="canonical" href="https://demo-basic.adminkit.io/pages-sign-in.html" />

    <title>Login | AdminKit</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <link href="<?= base_url('assets'); ?>/css/app.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
</head>

<body>
    <main class="d-flex w-100">
        <div class="container d-flex flex-column">
            <div class="row vh-100">
                <div class="col-sm-10 col-md-8 col-lg-6 mx-auto d-table h-100">
                    <div class="d-table-cell align-middle">



                        <div class="card">
                            <div class="text-center mt-4">
                                <h1 class="h2"><?= lang('Auth.loginTitle') ?></h1>
                            </div>
                            <div class="card-body">
                                <?= view('App\Views\Auth\_message_block') ?>

                                <div class="m-sm-4">
                                    <form action="<?= url_to('login') ?>" method="post">
                                        <?= csrf_field() ?>
                                        <div class="mb-3">
                                            <?php if ($config->validFields === ['email']) : ?>
                                                <label for="login"><?= lang('Auth.email') ?></label>
                                                <input type="email" class="form-control form-control-lg <?php if (session('errors.login')) : ?>is-invalid<?php endif ?>" name="login" placeholder="<?= lang('Auth.email') ?>">
                                                <div class="invalid-feedback">
                                                    <?= session('errors.login') ?>
                                                </div>
                                            <?php else : ?>
                                                <label for="login"><?= lang('Auth.emailOrUsername') ?></label>
                                                <input type="text" class="form-control form-control-lg <?php if (session('errors.login')) : ?>is-invalid<?php endif ?>" name="login" placeholder="<?= lang('Auth.emailOrUsername') ?>">
                                                <div class="invalid-feedback">
                                                    <?= session('errors.login') ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="mb-3">
                                            <div class="form-group">
                                                <label for="password"><?= lang('Auth.password') ?></label>
                                                <input type="password" name="password" class="form-control form-control-lg <?php if (session('errors.password')) : ?>is-invalid<?php endif ?>" placeholder="<?= lang('Auth.password') ?>">
                                                <div class="invalid-feedback">
                                                    <?= session('errors.password') ?>
                                                </div>
                                            </div>
                                            <small>
                                                <?php if ($config->activeResetter) : ?>
                                                    <p><a href="<?= url_to('forgot') ?>"><?= lang('Auth.forgotYourPassword') ?></a></p>
                                                <?php endif; ?>
                                            </small>
                                        </div>
                                        <div>
                                            <?php if ($config->allowRemembering) : ?>
                                                <label class="form-check">
                                                    <input type="checkbox" name="remember" class="form-check-input" <?php if (old('remember')) : ?> checked <?php endif ?>>
                                                    <span class="form-check-label">
                                                        <?= lang('Auth.rememberMe') ?>
                                                    </span>
                                                </label>
                                            <?php endif; ?>

                                        </div>
                                        <div class="text-center mt-3">
                                            <button type="submit" class="btn btn-primary btn-block"><?= lang('Auth.loginAction') ?></button>
                                        </div>
                                    </form>
                                    <?php if ($config->allowRegistration) : ?>
                                        <p><a href="<?= url_to('register') ?>"><?= lang('Auth.needAnAccount') ?></a></p>
                                    <?php endif; ?>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url('assets'); ?>/js/app.js"></script>

</body>

</html>
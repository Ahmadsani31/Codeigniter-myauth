<nav id="sidebar" class="sidebar js-sidebar">
    <div class="sidebar-content js-simplebar">
        <a class="sidebar-brand" href="index.html">
            <span class="align-middle"><?= $Title; ?></span>
        </a>

        <ul class="sidebar-nav">
            <li class="sidebar-header">
                Pages
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link" href="<?= base_url('dashboard'); ?>">
                    <i class="ri-dashboard-line"></i> <span class="align-middle">Dashboard</span>
                </a>
            </li>
            <?php
            $sqlUs =  db_connect()->table('biodatas')->where('UserID', session()->get('s_UserID'))->get();
            $wrr = '';
            if ($sqlUs->getNumRows() == 0) {
                $wrr = '<span class="sidebar-badge badge bg-warning"><i class="ri-error-warning-line text-black" style="margin-right: 0px;"></i></span>';
            }
            ?>
            <li class="sidebar-item">
                <a class="sidebar-link" href="<?= base_url('profil'); ?>">
                    <i class="ri-profile-line"></i> <span class="align-middle">Profil</span><?= $wrr; ?>
                </a>
            </li>
            <?php
            if (in_groups('administrator')) {
            ?>
                <li class="sidebar-header">
                    Administrator
                </li>
                <li class="sidebar-item">
                    <a data-bs-target="#pages" data-bs-toggle="collapse" class="sidebar-link collapsed">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-layout align-middle">
                            <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                            <line x1="3" y1="9" x2="21" y2="9"></line>
                            <line x1="9" y1="21" x2="9" y2="9"></line>
                        </svg> <span class="align-middle">Tools</span>
                    </a>
                    <ul id="pages" class="sidebar-dropdown list-unstyled collapse " data-bs-parent="#sidebar">
                        <li class="sidebar-item"><a class="sidebar-link" href="<?= base_url('user'); ?>">User</a></li>
                        <li class="sidebar-item"><a class="sidebar-link" href="<?= base_url('user/group'); ?>">Groups</a></li>
                        <li class="sidebar-item"><a class="sidebar-link" href="<?= base_url('user/permission'); ?>">Permissions</a></li>
                    </ul>
                </li>
            <?php
            }
            ?>
            <li class="sidebar-header">
                Apps
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link" href="<?= base_url('undangan'); ?>">
                    <i class="ri-calendar-event-fill"></i> <span class="align-middle">Undangan</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link" href="<?= base_url('acara'); ?>">
                    <i class="ri-hotel-line"></i> <span class="align-middle">Acara</span>
                </a>
            </li>
            <?php
            if (in_groups('administrator')) {
            ?>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="<?= base_url('acara/cetak-undangan'); ?>">
                        <i class="align-middle" data-feather="check-square"></i> <span class="align-middle">Cetak Undangan</span>
                    </a>
                </li>
            <?php
            }
            ?>
        </ul>

    </div>
</nav>
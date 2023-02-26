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
                <a class="sidebar-link" href="<?= base_url('admin-dashboard'); ?>">
                    <i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Dashboard</span>
                </a>
            </li>

            <li class="sidebar-header">
                Administrator
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link" href="<?= base_url('admin/user'); ?>">
                    <i class="align-middle" data-feather="user"></i> <span class="align-middle">User</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link" href="<?= base_url('admin/group'); ?>">
                    <i class="align-middle" data-feather="check-square"></i> <span class="align-middle">Group</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link" href="<?= base_url('admin/permission'); ?>">
                    <i class="align-middle" data-feather="check-square"></i> <span class="align-middle">Permission</span>
                </a>
            </li>
        </ul>

    </div>
</nav>
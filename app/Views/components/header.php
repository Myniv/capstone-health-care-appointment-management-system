<header class="navbar bg-base-100 shadow-md">
    <div class="flex-1">
        <a href="/" class="btn btn-ghost normal-case text-xl">HealthCare</a>
    </div>
    <div class="flex-none">
        <ul class="menu menu-horizontal px-1">
            <li><a href="#">Dashboard</a></li>
            <li><a href="<?= base_url('admin/users'); ?>">User</a></li>
            <li><a href="<?= base_url('admin/doctor-category'); ?>">Doctor Category</a></li>
            <li><a href="<?= base_url('doctor/absent'); ?>">Doctor Absent</a></li>
        </ul>
    </div>
</header>
<?php

use Config\Roles; ?>
<header class="navbar bg-base-100 shadow-md">
    <div class="flex-1">
        <a href="/" class="btn btn-ghost normal-case text-xl">HealthCare</a>
    </div>
    <div class="flex-none">
        <ul class="menu menu-horizontal px-1 gap-2">
            <?php if (logged_in()): ?>
                <li><a href="<?= base_url('admin/dashboard'); ?>" class="btn btn-white text-black mr-2">Dashboard</a></li>
                <?php if (in_groups(Roles::ADMIN)): ?>
                <?php endif; ?>
                <?php if (in_groups(Roles::DOCTOR)): ?>
                <?php endif; ?>
                <?php if (in_groups(Roles::PATIENT)): ?>
                <?php endif; ?>
                <li><a href="<?= base_url('logout'); ?>" class="btn btn-error text-white">Logout</a></li>
            <?php else: ?>
                <li><a href="<?= base_url('login'); ?>" class="btn btn-primary text-white">Login</a></li>
                <li><a href="<?= base_url('register'); ?>" class="btn btn-white text-black mr-2">Register</a></li>
            <?php endif; ?>
        </ul>
    </div>
</header>
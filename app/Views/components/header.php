<?php

use Config\Roles; ?>
<header class="navbar bg-base-100 shadow-md">
    <div class="flex-1">
        <a href="/" class="btn btn-ghost normal-case text-xl">HealthCare</a>
    </div>
    <div class="flex-none">
        <ul class="menu menu-horizontal px-1 gap-2">
            <?php if (logged_in()): ?>
                <?php if (in_groups(Roles::ADMIN)): ?>
                    <li>
                        <a href="<?= base_url('admin/dashboard'); ?>" class="">Dashboard</a>
                    </li>
                <?php endif; ?>
                <?php if (in_groups(Roles::DOCTOR)): ?>
                    <li>
                        <a href="<?= base_url('doctor/dashboard'); ?>" class="">Dashboard</a>
                    </li>
                <?php endif; ?>
                <?php if (in_groups(Roles::PATIENT)): ?>
                    <li>
                        <a href="<?= base_url('dashboard'); ?>" class="">Dashboard</a>
                    </li>
                    <li>
                        <a href="<?= base_url('appointment'); ?>" class="">Appointment</a>
                    </li>
                <?php endif; ?>
                <li><a href="<?= base_url('logout'); ?>" class="btn btn-error text-white">Logout</a></li>
            <?php else: ?>
                <li><a href="<?= base_url('login'); ?>" class="btn btn-primary text-white">Login</a></li>
                <li><a href="<?= base_url('register'); ?>" class="btn btn-white text-black mr-2">Register</a></li>
            <?php endif; ?>
        </ul>
    </div>
</header>
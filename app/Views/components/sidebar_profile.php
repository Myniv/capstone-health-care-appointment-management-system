<?php

use Config\Roles; ?>

<aside class="flex-grow lg:flex-grow-0 p-6 rounded-lg flex flex-col justify-between bg-base-100 shadow-md">
    <div class="flex gap-2 items-center justify-center">
        <div class="avatar">
            <div class="w-20 rounded-full">
                <img
                    src="<?= base_url('profile-picture?path=' . $user->profile_picture); ?>"
                    alt="Profile Picture <?= $user->first_name . ' ' . $user->last_name; ?>">
            </div>
        </div>
        <div>
            <h3 class="font-semibold">
                <?= $user->first_name . ' ' . $user->last_name; ?>
            </h3>
            <h5 class="text-sm text-gray-700"><?= user()->username; ?></h5>
        </div>
    </div>

    <div class="divider"></div>

    <ul class="menu border rounded-box w-full">
        <li><a href="detail">Profile</a></li>
        <?php if (in_groups(Roles::PATIENT)): ?>
            <li><a href="history">Medical History</a></li>
        <?php endif; ?>
    </ul>

    <a href="<?= base_url('logout'); ?>" class="btn btn-error text-base-100 w-full mt-auto">Logout</a>
</aside>
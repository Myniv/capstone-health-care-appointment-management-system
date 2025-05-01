<?php

use App\Models\DoctorModel;
use App\Models\PatientModel;
use Config\Roles;

$patientModel = new PatientModel();
$doctorModel = new DoctorModel();

$profilePicture = "";

if (in_groups(Roles::PATIENT)) {
    $profilePicture = $patientModel->where('user_id', user_id())->first()->profile_picture;
}

if (in_groups(Roles::DOCTOR)) {
    $profilePicture = $doctorModel->where('user_id', user_id())->first()->profile_picture;
} ?>

<header class="navbar bg-base-100 shadow-sm">
    <div class="md:hidden flex-none">
        <button class="btn btn-square btn-ghost">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block h-5 w-5 stroke-current">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </button>
    </div>
    <div class="flex-1">
        <a href="/" class="btn btn-ghost normal-case font-black text-3xl text-primary">HealthCare</a>
    </div>
    <div class="flex-none flex px-4">
        <ul class="menu menu-horizontal gap-4">
            <?php if (logged_in()): ?>
                <?php if (in_groups(Roles::ADMIN)): ?>
                    <li>
                        <a href="<?= base_url('admin/dashboard'); ?>" class="btn btn-ghost">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                <path fill-rule="evenodd" d="M3 6a3 3 0 0 1 3-3h2.25a3 3 0 0 1 3 3v2.25a3 3 0 0 1-3 3H6a3 3 0 0 1-3-3V6Zm9.75 0a3 3 0 0 1 3-3H18a3 3 0 0 1 3 3v2.25a3 3 0 0 1-3 3h-2.25a3 3 0 0 1-3-3V6ZM3 15.75a3 3 0 0 1 3-3h2.25a3 3 0 0 1 3 3V18a3 3 0 0 1-3 3H6a3 3 0 0 1-3-3v-2.25Zm9.75 0a3 3 0 0 1 3-3H18a3 3 0 0 1 3 3V18a3 3 0 0 1-3 3h-2.25a3 3 0 0 1-3-3v-2.25Z" clip-rule="evenodd" />
                            </svg>
                            <span>Dashboard</span>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if (in_groups(Roles::DOCTOR)): ?>
                    <li>
                        <a href="<?= base_url('doctor/dashboard'); ?>" class="btn btn-ghost btn-circle">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z" />
                            </svg>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if (in_groups(Roles::PATIENT)): ?>
                    <li>
                        <div class="btn btn-ghost btn-circle">
                            <a href="<?= base_url('dashboard'); ?>" class="tooltip tooltip-bottom" data-tip="Dashboard">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z" />
                                </svg>
                            </a>
                        </div>
                    </li>
                    <li>
                        <div class="btn btn-ghost btn-circle">
                            <a href="<?= base_url('appointment'); ?>" class="tooltip tooltip-bottom" data-tip="Appointment List">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.042 21.672 13.684 16.6m0 0-2.51 2.225.569-9.47 5.227 7.917-3.286-.672ZM12 2.25V4.5m5.834.166-1.591 1.591M20.25 10.5H18M7.757 14.743l-1.59 1.59M6 10.5H3.75m4.007-4.243-1.59-1.59" />
                                </svg>
                            </a>
                        </div>
                    </li>
                <?php endif; ?>

                <?php if (!empty($profilePicture)): ?>
                    <div class="dropdown dropdown-end">
                        <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar">
                            <div class="size-10 rounded-full">
                                <img
                                    alt="Profile Picture User"
                                    src="<?= base_url('profile-picture?path=' . $profilePicture); ?>" />
                            </div>
                        </div>
                        <ul tabindex="0" class="menu menu-sm dropdown-content bg-base-100 rounded-box z-1 mt-3 w-52 p-2 shadow-lg">
                            <li>
                                <a href="<?= base_url('profile/detail'); ?>">Profile</a>
                            </li>
                            <?php if (in_groups(Roles::PATIENT)): ?>
                                <li>
                                    <a href="<?= base_url('profile/history'); ?>">History</a>
                                </li>
                            <?php endif; ?>
                            <li class="mt-2">
                                <a href="<?= base_url('logout'); ?>" class="btn btn-sm btn-error text-white">Logout</a>
                            </li>
                        </ul>
                    </div>
                <?php endif; ?>
            <?php else: ?>
                <li><a href="<?= base_url('login'); ?>" class="btn btn-primary text-white">Login</a></li>
                <li><a href="<?= base_url('register'); ?>" class="btn btn-white text-black mr-2">Register</a></li>
            <?php endif; ?>
        </ul>
    </div>
</header>
<?php

use Config\Roles; ?>
<aside class="menu">
    <ul class="menu menu-compact lg:menu-normal">
        <li class="menu-title">
            <span>Navigation</span>
        </li>
        <?php if (in_groups(Roles::ADMIN)): ?>
            <li>
                <a href="/admin/dashboard" class="active:bg-primary active:text-white ">
                    <div class="flex gap-4 items-center">
                        <i class="fa-solid fa-table-columns"></i>
                        <span>Dashboard</span>
                    </div>
                </a>
            </li>
            <li>
                <a href="/admin/users" class="active:bg-primary active:text-white">
                    <div class="flex gap-4 items-center">
                        <i class="fa-solid fa-users"></i>
                        <span>Users</span>
                    </div>
                </a>
            </li>

            <li>
                <a href="/admin/setting" class="active:bg-primary active:text-white">
                    <div class="flex gap-4 items-center">
                        <i class="fa-solid fa-gear"></i>
                        Settings
                    </div>
                </a>
            </li>




            <?php
            $uri = uri_string();
            $isResourcesActive = str_contains($uri, 'admin/doctor');
            ?>
            <li class="hoverable">
                <details class="group" <?= $isResourcesActive ? 'open' : '' ?>>
                    <summary
                        class="flex items-center cursor-pointer px-3 py-2 rounded-lg <?= $isResourcesActive ? 'bg-base-300 text-black' : 'hover:bg-base-200' ?>">
                        <div class="flex gap-4 items-center">
                            <i class="fa-solid fa-list"></i>
                            Doctor
                        </div>
                    </summary>
                    <ul class="pl-6">
                        <li>
                            <a href="/admin/doctor-category" class="active:bg-primary active:text-white">
                                <div class="flex gap-4 items-center">
                                    <i class="fa-solid fa-user-doctor"></i>
                                    <span>Category</span>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="/admin/doctor-schedule" class="active:bg-primary active:text-white">
                                <div class="flex gap-4 items-center">
                                    <i class="fa-solid fa-calendar-days"></i>
                                    <span>Schedule</span>
                                </div>

                            </a>
                        </li>

                    </ul>
                </details>
            </li>


            <?php
            $uri = uri_string();
            $isResourcesActive = str_contains($uri, 'admin/equipment') || str_contains($uri, 'admin/inventory') || str_contains($uri, 'admin/room');
            ?>
            <li class="hoverable">
                <details class="group" <?= $isResourcesActive ? 'open' : '' ?>>
                    <summary
                        class="flex items-center cursor-pointer px-3 py-2 rounded-lg <?= $isResourcesActive ? 'bg-base-300 text-black' : 'hover:bg-base-200' ?>">
                        <div class="flex gap-4 items-center">
                            <i class="fa-solid fa-list"></i>
                            Resources
                        </div>
                    </summary>
                    <ul class="pl-6">
                        <li>
                            <a href="/admin/equipment"
                                class="<?= current_url() === base_url('/admin/equipment') ? 'bg-base-300 text-black' : 'hover:bg-base-200' ?>">
                                <div class="flex gap-4 items-center">
                                    <i class="fa-solid fa-toolbox"></i>
                                    <span>Equipments</span>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="/admin/inventory"
                                class="<?= current_url() === base_url('/admin/inventory') ? 'bg-base-300 text-black' : 'hover:bg-base-200' ?>">
                                <div class="flex gap-4 items-center">
                                    <i class="fa-solid fa-warehouse"></i>
                                    <span>Inventories</span>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="/admin/room"
                                class="<?= current_url() === base_url('/admin/room') ? 'bg-base-300 text-black' : 'hover:bg-base-200' ?>">

                                <div class="flex gap-4 items-center">
                                    <i class="fa-solid fa-door-open"></i>
                                    <span>Rooms</span>
                                </div>


                            </a>
                        </li>
                    </ul>
                </details>
            </li>


            <?php
            $uri = uri_string();
            $isReportsActive = str_contains($uri, 'report/user') || str_contains($uri, 'report/resources') || str_contains($uri, 'report/appointment');
            ?>
            <li class="hoverable">
                <details class="group" <?= $isReportsActive ? 'open' : '' ?>>
                    <summary
                        class="flex items-center cursor-pointer px-3 py-2 rounded-lg <?= $isReportsActive ? 'bg-base-300 text-black' : 'hover:bg-base-200' ?>">
                        <div class="flex gap-4 items-center">
                            <i class="fa-solid fa-list"></i>
                            Reports
                        </div>
                    </summary>
                    <ul class="pl-6">
                        <li>
                            <a href="/report/user"
                                class="<?= current_url() === base_url('/report/user') ? 'bg-base-300 text-black' : 'hover:bg-base-200' ?>">
                                <div class="flex gap-4 items-center">
                                    <i class="fa-solid fa-file"></i>
                                    <span>User</span>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="/report/resources"
                                class="<?= current_url() === base_url('/admin/inventory') ? 'bg-base-300 text-black' : 'hover:bg-base-200' ?>">


                                <div class="flex gap-4 items-center">
                                    <i class="fa-solid fa-file"></i>
                                    <span>Resources</span>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="/report/appointment"
                                class="<?= current_url() === base_url('/report/appointment') ? 'bg-base-300 text-black' : 'hover:bg-base-200' ?>">

                                <div class="flex gap-4 items-center">
                                    <i class="fa-solid fa-file"></i>
                                    <span>Appointment</span>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="/report/history"
                                class="<?= current_url() === base_url('/report/history') ? 'bg-base-300 text-black' : 'hover:bg-base-200' ?>">History</a>
                        </li>
                    </ul>
                </details>
            </li>
        <?php endif; ?>

        <?php if (in_groups(Roles::DOCTOR)): ?>
            <li>
                <a href="/doctor/dashboard" class="active:bg-primary active:text-white">
                    <div class="flex gap-4 items-center">
                        <i class="fa-solid fa-table-columns"></i>
                        <span>Dashboard</span>
                    </div>
                </a>
            </li>
            <li>
                <a href="/doctor/absent" class="active:bg-primary active:text-white">
                    <div class="flex gap-4 items-center">
                        <i class="fa-solid fa-table-columns"></i>
                        <span>Absent</span>
                    </div>
                </a>
            </li>
            <?php
            $uri = uri_string();
            $isReportsActive = str_contains($uri, 'report/user') || str_contains($uri, 'report/resources') || str_contains($uri, 'report/appointment');
            ?>
            <li class="hoverable">
                <details class="group" <?= $isReportsActive ? 'open' : '' ?>>
                    <summary
                        class="flex items-center cursor-pointer px-4 py-2 rounded-lg <?= $isReportsActive ? 'bg-base-300 text-black' : 'hover:bg-base-200' ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5h6M9 12h6m-6 7h6" />
                        </svg>
                        Reports
                    </summary>
                    <ul class="pl-6">
                        <li>
                            <a href="/report/appointment"
                                class="<?= current_url() === base_url('/report/appointment') ? 'bg-base-300 text-black' : 'hover:bg-base-200' ?>">Appointment</a>
                        </li>
                        <li>
                            <a href="/report/history"
                                class="<?= current_url() === base_url('/report/history') ? 'bg-base-300 text-black' : 'hover:bg-base-200' ?>">History</a>
                        </li>
                    </ul>
                </details>
            </li>
        <?php endif; ?>
    </ul>
</aside>
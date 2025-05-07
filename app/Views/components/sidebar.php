<?php

use Config\Roles; ?>

<div class="flex flex-col h-full">
    <ul class="menu mt-6 p-4 w-full">
        <?php if (in_groups(Roles::ADMIN)): ?>
            <li class="user-management">
                <a href="/admin/users" class="active:bg-primary active:text-white">
                    <div class="flex gap-4 items-center">
                        <i class="fa-solid fa-users"></i>
                        <span>Users</span>
                    </div>
                </a>
            </li>
            <li class="override-appointment">
                <a href="/admin/appointment" class="active:bg-primary active:text-white">
                    <div class="flex gap-2 items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                            <path fill-rule="evenodd" d="M12 1.5a.75.75 0 0 1 .75.75V4.5a.75.75 0 0 1-1.5 0V2.25A.75.75 0 0 1 12 1.5ZM5.636 4.136a.75.75 0 0 1 1.06 0l1.592 1.591a.75.75 0 0 1-1.061 1.06l-1.591-1.59a.75.75 0 0 1 0-1.061Zm12.728 0a.75.75 0 0 1 0 1.06l-1.591 1.592a.75.75 0 0 1-1.06-1.061l1.59-1.591a.75.75 0 0 1 1.061 0Zm-6.816 4.496a.75.75 0 0 1 .82.311l5.228 7.917a.75.75 0 0 1-.777 1.148l-2.097-.43 1.045 3.9a.75.75 0 0 1-1.45.388l-1.044-3.899-1.601 1.42a.75.75 0 0 1-1.247-.606l.569-9.47a.75.75 0 0 1 .554-.68ZM3 10.5a.75.75 0 0 1 .75-.75H6a.75.75 0 0 1 0 1.5H3.75A.75.75 0 0 1 3 10.5Zm14.25 0a.75.75 0 0 1 .75-.75h2.25a.75.75 0 0 1 0 1.5H18a.75.75 0 0 1-.75-.75Zm-8.962 3.712a.75.75 0 0 1 0 1.061l-1.591 1.591a.75.75 0 1 1-1.061-1.06l1.591-1.592a.75.75 0 0 1 1.06 0Z" clip-rule="evenodd" />
                        </svg>
                        <span>Appointment</span>
                    </div>
                </a>
            </li>
            <li class="system-settings">
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
            <li class="hoverable doctor-management">
                <details class="group" <?= $isResourcesActive ? 'open' : '' ?>>
                    <summary
                        class="flex justify-between cursor-pointer px-3 py-2 rounded-lg <?= $isResourcesActive ? 'bg-base-300 text-black' : 'hover:bg-base-200' ?>">
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
            <li class="hoverable facility-management">
                <details class="group" <?= $isResourcesActive ? 'open' : '' ?>>
                    <summary
                        class="flex justify-between cursor-pointer px-3 py-2 rounded-lg <?= $isResourcesActive ? 'bg-base-300 text-black' : 'hover:bg-base-200' ?>">
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
                            <a
                                href="/admin/room"
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
            $isReportsActive = str_contains($uri, 'report/user') || str_contains($uri, 'report/resources') || str_contains($uri, 'report/history') || str_contains($uri, 'report/appointment');
            ?>
            <li class="hoverable operational-reports">
                <details class="group" <?= $isReportsActive ? 'open' : '' ?>>
                    <summary
                        class="flex justify-between cursor-pointer px-3 py-2 rounded-lg <?= $isReportsActive ? 'bg-base-300 text-black' : 'hover:bg-base-200' ?>">
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
                                class="<?= current_url() === base_url('/report/history') ? 'bg-base-300 text-black' : 'hover:bg-base-200' ?>">
                                <div class="flex gap-4 items-center">
                                    <i class="fa-solid fa-file"></i>
                                    <span>History</span>
                                </div>
                            </a>
                        </li>
                    </ul>
                </details>
            </li>
        <?php endif; ?>

        <?php if (in_groups(Roles::DOCTOR)): ?>
            <li>
                <a href="/doctor/dashboard" class="active:bg-primary active:text-white">
                    <div class="flex gap-4 items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z" />
                        </svg>
                        <span>Dashboard</span>
                    </div>
                </a>
            </li>
            <li class="appointment-list">
                <a href="/doctor/appointment" class="active:bg-primary active:text-white">
                    <div class="flex gap-4 items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.042 21.672 13.684 16.6m0 0-2.51 2.225.569-9.47 5.227 7.917-3.286-.672ZM12 2.25V4.5m5.834.166-1.591 1.591M20.25 10.5H18M7.757 14.743l-1.59 1.59M6 10.5H3.75m4.007-4.243-1.59-1.59" />
                        </svg>
                        <span>Appointment</span>
                    </div>
                </a>
            </li>
            <li class="doctor-absent">
                <a href="/doctor/absent" class="active:bg-primary active:text-white">
                    <div class="flex gap-4 items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z" />
                        </svg>
                        <span>Absent</span>
                    </div>
                </a>
            </li>

            <?php
            $uri = uri_string();
            $isReportsActive = str_contains($uri, 'report/user') || str_contains($uri, 'report/history') || str_contains($uri, 'report/appointment');
            ?>
            <li class="hoverable operational-reports">
                <details class="group" <?= $isReportsActive ? 'open' : '' ?>>
                    <summary
                        class="flex justify-between cursor-pointer px-3 py-2 rounded-lg <?= $isReportsActive ? 'bg-base-300 text-black' : 'hover:bg-base-200' ?>">
                        <div class="flex gap-6">
                            <i class="fa-solid fa-list"></i>
                            <span>Reports</span>
                        </div>
                    </summary>
                    <ul>
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
                                class="<?= current_url() === base_url('/report/history') ? 'bg-base-300 text-black' : 'hover:bg-base-200' ?>">
                                <div class="flex gap-4 items-center">
                                    <i class="fa-solid fa-file"></i>
                                    <span>History</span>
                                </div>
                            </a>
                        </li>
                    </ul>
                </details>
            </li>
        <?php endif; ?>
    </ul>
    <a href="<?= base_url('logout'); ?>" class="btn btn-error text-base-100 w-full mt-auto">Logout</a>
</div>
<?php

use Config\Roles; ?>
<aside class="menu">
    <ul class="menu menu-compact lg:menu-normal">
        <li class="menu-title">
            <span>Navigation</span>
        </li>
        <?php if (in_groups(Roles::ADMIN)): ?>
            <li>
                <a href="/admin/dashboard" class="active:bg-primary active:text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 10h11M9 21V3m0 0L3 10m6-7l6 7" />
                    </svg>
                    Dashboard
                </a>
            </li>
            <li>
                <a href="/admin/users" class="active:bg-primary active:text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 4h10M5 11h14M5 15h14M5 19h14" />
                    </svg>
                    Users
                </a>
            </li>
            <li>
                <a href="/admin/doctor-category" class="active:bg-primary active:text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5.121 17.804A4 4 0 0112 15m0 0a4 4 0 016.879 2.804M12 15v6m-7 0h14" />
                    </svg>
                    Doctor Category
                </a>
            </li>
            <li>
                <a href="/admin/doctor-schedule" class="active:bg-primary active:text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4m0 4h.01M4.93 4.93l2.83 2.83m8.48 8.48l2.83 2.83M12 2a10 10 0 100 20 10 10 0 000-20z" />
                    </svg>
                    Doctor Schedule
                </a>
            </li>
            <li>
                <a href="/admin/setting" class="active:bg-primary active:text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4m0 4h.01M4.93 4.93l2.83 2.83m8.48 8.48l2.83 2.83M12 2a10 10 0 100 20 10 10 0 000-20z" />
                    </svg>
                    Settings
                </a>
            </li>
            <?php
            $uri = uri_string();
            $isResourcesActive = str_contains($uri, 'admin/equipment') || str_contains($uri, 'admin/inventory') || str_contains($uri, 'admin/room');
            ?>
            <li class="hoverable">
                <details class="group" <?= $isResourcesActive ? 'open' : '' ?>>
                    <summary
                        class="flex items-center cursor-pointer px-4 py-2 rounded-lg <?= $isResourcesActive ? 'bg-base-300 text-black' : 'hover:bg-base-200' ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5h6M9 12h6m-6 7h6" />
                        </svg>
                        Resources
                    </summary>
                    <ul class="pl-6">
                        <li>
                            <a href="/admin/equipment"
                                class="<?= current_url() === base_url('/admin/equipment') ? 'bg-base-300 text-black' : 'hover:bg-base-200' ?>">Equipments</a>
                        </li>
                        <li>
                            <a href="/admin/inventory"
                                class="<?= current_url() === base_url('/admin/inventory') ? 'bg-base-300 text-black' : 'hover:bg-base-200' ?>">Inventories</a>
                        </li>
                        <li>
                            <a href="/admin/room"
                                class="<?= current_url() === base_url('/admin/room') ? 'bg-base-300 text-black' : 'hover:bg-base-200' ?>">Rooms</a>
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
                            <a href="/report/user"
                                class="<?= current_url() === base_url('/admin/equipment') ? 'bg-base-300 text-black' : 'hover:bg-base-200' ?>">User</a>
                        </li>
                        <li>
                            <a href="/report/resources"
                                class="<?= current_url() === base_url('/admin/inventory') ? 'bg-base-300 text-black' : 'hover:bg-base-200' ?>">Resources</a>
                        </li>
                        <li>
                            <a href="/report/appointment"
                                class="<?= current_url() === base_url('/admin/room') ? 'bg-base-300 text-black' : 'hover:bg-base-200' ?>">Appointment</a>
                        </li>
                    </ul>
                </details>
            </li>
        <?php endif; ?>

        <?php if (in_groups(Roles::DOCTOR)): ?>
            <li>
                <a href="/doctor/dashboard" class="active:bg-primary active:text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 10h11M9 21V3m0 0L3 10m6-7l6 7" />
                    </svg>
                    Dashboard
                </a>
            </li>
            <li>
                <a href="/doctor/absent" class="active:bg-primary active:text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5.121 17.804A4 4 0 0112 15m0 0a4 4 0 016.879 2.804M12 15v6m-7 0h14" />
                    </svg>
                    Absent
                </a>
            </li>
        <?php endif; ?>
    </ul>
</aside>
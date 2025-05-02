<?= $this->extend('layouts/admin_layout') ?>
<?= $this->section('content') ?>
<?php use Config\Roles; ?>

<!-- Back button with DaisyUI styling -->
<?php if (in_groups(Roles::ADMIN)): ?>
    <div class="mb-4">
        <?= view_cell('BackButtonCell', ['backLink' => 'admin/room']) ?>
    </div>
<?php else: ?>
    <div class="mb-4">
        <?= view_cell('BackButtonCell', ['backLink' => null]) ?>
    </div>
<?php endif; ?>

<!-- Page Title -->
<div class="text-2xl font-bold mb-6">Room Details</div>

<!-- Room Info Card -->
<div class="card bg-base-100 shadow-xl mb-8">
    <div class="card-body">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="card-title text-xl text-primary"><?= esc($room->name) ?></h2>
                <div class="grid grid-cols-2 gap-2 mt-2">
                    <div class="flex items-center">
                        <div class="badge badge-outline mr-2">Status</div>
                        <?php if ($room->status == 'Available'): ?>
                            <span class="badge badge-success"><?= esc($room->status) ?></span>
                        <?php elseif ($room->status == 'Occupied'): ?>
                            <span class="badge badge-warning"><?= esc($room->status) ?></span>
                        <?php else: ?>
                            <span class="badge badge-ghost"><?= esc($room->status) ?></span>
                        <?php endif; ?>
                    </div>
                    <div class="flex items-center">
                        <div class="badge badge-outline mr-2">Function</div>
                        <span class="badge badge-primary badge-outline"><?= esc($room->function) ?></span>
                    </div>
                </div>
            </div>
            <?php if (in_groups(Roles::ADMIN)): ?>
                <div class="card-actions">
                    <a href="<?= site_url('admin/room/update/' . $room->id) ?>" class="btn btn-primary btn-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Edit Room
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Inventories Card -->
<div class="card bg-base-100 shadow-xl mb-8">
    <div class="card-body">
        <div class="flex justify-between items-center mb-4">
            <h2 class="card-title text-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                Inventories
            </h2>
            <?php if (in_groups(Roles::ADMIN)): ?>
                <a href="<?= site_url('admin/room/create-inventory/' . $room->id) ?>"
                    class="btn btn-outline btn-primary btn-sm ml-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    Edit Inventories
                </a>
            <?php endif; ?>
        </div>

        <?php if (!empty($inventories)): ?>
            <div class="overflow-x-auto">
                <table class="table table-zebra w-full">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Function</th>
                            <th>Serial Number</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($inventories as $inv): ?>
                            <tr class="hover">
                                <td class="font-medium"><?= esc($inv->inventory_name) ?></td>
                                <td><?= esc($inv->inventory_function) ?></td>
                                <td><code class="bg-base-200 px-2 py-1 rounded"><?= esc($inv->inventory_serial_number) ?></code>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="alert alert-info">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    class="stroke-current shrink-0 w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span>No inventories assigned to this room.</span>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Equipments Card -->
<div class="card bg-base-100 shadow-xl mb-8">
    <div class="card-body">
        <div class="flex justify-between items-center mb-4">
            <h2 class="card-title text-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z" />
                </svg>
                Equipments
            </h2>
            <?php if (in_groups(Roles::ADMIN)): ?>
                <a href="<?= site_url('admin/room/create-equipment/' . $room->id) ?>"
                    class="btn btn-outline btn-primary btn-sm ml-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    Edit Equipments
                </a>
            <?php endif; ?>
        </div>

        <?php if (!empty($equipments)): ?>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <?php foreach ($equipments as $eq): ?>
                    <div class="border border-base-300 rounded-lg p-4 flex items-center">
                        <div class="avatar placeholder mr-4">
                            <div class="bg-neutral-focus text-neutral-content rounded-full w-12">
                                <span class="text-lg"><?= substr($eq->name, 0, 1) ?></span>
                            </div>
                        </div>
                        <div>
                            <h3 class="font-bold"><?= esc($eq->name) ?></h3>
                            <div class="flex gap-2 mt-1">
                                <div class="badge badge-neutral">Qty: <?= esc($eq->quantity) ?></div>
                                <div class="badge badge-ghost"><?= esc($eq->equipment_function) ?></div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="alert alert-info">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    class="stroke-current shrink-0 w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span>No equipment assigned to this room.</span>
            </div>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>
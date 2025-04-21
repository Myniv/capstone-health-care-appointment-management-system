<?= $this->extend('layouts/admin_layout') ?>
<?= $this->section('content') ?>

<h2>Room Details</h2>

<!-- Room Info -->
<div class="card mb-4">
    <div class="card-body d-flex justify-content-between align-items-center">
        <div>
            <h5 class="card-title">Room: <?= esc($room->name) ?></h5>
            <p><strong>Status:</strong> <?= esc($room->status) ?></p>
            <p><strong>Function:</strong> <?= esc($room->function) ?></p>
            <a href="<?= site_url('room/edit/' . $room->id) ?>" class="btn btn-primary btn-sm mt-2">Edit Room</a>
        </div>
    </div>
</div>

<!-- Inventories -->
<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5>Inventories</h5>
        <a href="<?= site_url('room/edit-inventories/' . $room->id) ?>" class="btn btn-sm btn-outline-primary">Edit
            Inventories</a>
    </div>
    <div class="card-body">
        <?php if (!empty($inventories)): ?>
            <ul class="list-group">
                <?php foreach ($inventories as $inv): ?>
                    <li class="list-group-item">
                        <strong><?= esc($inv->inventory_name) ?></strong><br>
                        Function: <?= esc($inv->inventory_function) ?><br>
                        Serial Number: <?= esc($inv->inventory_serial_number) ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>No inventories assigned to this room.</p>
        <?php endif; ?>
    </div>
</div>

<!-- Equipments -->
<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5>Equipments</h5>
        <a href="<?= site_url('room/edit-equipments/' . $room->id) ?>" class="btn btn-sm btn-outline-primary">Edit
            Equipments</a>
    </div>
    <div class="card-body">
        <?php if (!empty($equipments)): ?>
            <ul class="list-group">
                <?php foreach ($equipments as $eq): ?>
                    <li class="list-group-item">
                        <strong><?= esc($eq->equipment_name) ?></strong> (Quantity: <?= esc($eq->quantity) ?>)<br>
                        Function: <?= esc($eq->equipment_function) ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>No equipment assigned to this room.</p>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>
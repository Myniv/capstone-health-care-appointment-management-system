<?= $this->extend('layouts/admin_layout'); ?>

<?= $this->section('content'); ?>
<div class="container mx-auto mt-4 px-4">
    <h2 class="text-2xl font-bold mb-4">
        <?= $title; ?>
    </h2>

    <div class="grid grid-cols-3 grid-rows-1 gap-4">
        <div class="stats border">
            <div class="stat">
                <div class="stat-title">Total Users</div>
                <div class="stat-value"><?= $users; ?></div>
                <div class="stat-desc"></div>
            </div>
        </div>
        <div class="stats border">
            <div class="stat">
                <div class="stat-title">Total Doctors</div>
                <div class="stat-value"><?= $doctors; ?></div>
                <div class="stat-desc"></div>
            </div>
        </div>
        <div class="stats border">
            <div class="stat">
                <div class="stat-title">Total Patients</div>
                <div class="stat-value"><?= $patients; ?></div>
                <div class="stat-desc"></div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>
<?= $this->extend('layouts/admin_layout'); ?>

<?= $this->section('content'); ?>
<div class="grid grid-cols-3 md:grid-rows-[auto_1fr] gap-4 h-full">
    <div class="stats shadow-md bg-base-100">
        <div class="stat">
            <div class="stat-title">Total Users</div>
            <div class="stat-value"><?= $users; ?></div>
            <div class="stat-desc"></div>
        </div>
    </div>
    <div class="stats shadow-md bg-base-100">
        <div class="stat">
            <div class="stat-title">Total Doctors</div>
            <div class="stat-value"><?= $doctors; ?></div>
            <div class="stat-desc"></div>
        </div>
    </div>
    <div class="stats shadow-md bg-base-100">
        <div class="stat">
            <div class="stat-title">Total Patients</div>
            <div class="stat-value"><?= $patients; ?></div>
            <div class="stat-desc"></div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>
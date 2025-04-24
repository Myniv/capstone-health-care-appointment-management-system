<?= $this->extend('layouts/admin_layout'); ?>

<?= $this->section('content'); ?>
<div class="container mx-auto mt-4 px-4">
    <div class="grid md:grid-cols-3 gap-4">
        <?php if (!empty(user())): ?>
            <div class="card col-span-2">
                <div class="card-body">
                    <span class="card-title text-3xl font-bold">
                        Hello, <span class="text-primary"><?= user()->username; ?></span> 👋🏼
                    </span>
                </div>
            </div>
        <?php endif; ?>

        <div class="stats border bg-secondary-content">
            <div class="stat">
                <div class="stat-title">Today Appointment</div>
                <div class="stat-value text-secondary"><?= count($appointments); ?></div>
            </div>
        </div>

        <div class="card border col-span-2">
            <div class="card-body">
                <div class="flex justify-between">
                    <h3 class="card-title">Upcoming Appointment</h3>
                    <a class="btn btn-sm btn-primary" href="#">View All</a>
                </div>
                <?php if (!empty($appointments)): ?>
                    <ul class="list rounded-box border">
                        <?php foreach ($appointments as $appointment): ?>
                            <li class="list-row">
                                <div>
                                    <img class="size-10 rounded-full" src="<?= base_url('profile-picture?path=' . $appointment->patientProfilePicture); ?>" alt="Profile Picture <?= $appointment->patientFirstName . ' ' . $appointment->patientLastName; ?>" />
                                </div>
                                <div>
                                    <div><?= $appointment->patientFirstName . ' ' . $appointment->patientLastName; ?></div>
                                    <p>
                                        <?= date('g:i A', strtotime($appointment->startTime)) ?> -
                                        <?= date('g:i A', strtotime($appointment->endTime)) ?>
                                    </p>
                                    <p><?= date('F j, Y', strtotime($appointment->date)) ?></p>
                                    <div class="badge badge-soft badge-warning text-xs mt-2"><?= ucwords($appointment->status); ?></div>
                                </div>
                                <button class="btn btn-ghost">
                                    Manage
                                </button>
                            </li>
                        <?php endforeach; ?>
                    </ul>

                <?php else: ?>
                    <p>There is no data appointment.</p>
                <?php endif; ?>
            </div>
        </div>

        <div class="card bg-primary-content">
            <div class="card-body">
                <div class="card-title">test</div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>
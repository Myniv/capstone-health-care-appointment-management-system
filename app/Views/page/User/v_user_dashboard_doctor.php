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
                                <div class="flex flex-col items-center">
                                    <div class="badge badge-soft badge-warning text-xs mt-2">
                                        <?= ucwords($appointment->status); ?>
                                    </div>
                                    <p class="text-primary font-semibold">
                                        <?= date('g:i A', strtotime($appointment->startTime)) ?> -
                                        <?= date('g:i A', strtotime($appointment->endTime)) ?>
                                    </p>
                                </div>
                                <div>
                                    <h3 class="font-semibold">
                                        <?= $appointment->patientFirstName . ' ' . $appointment->patientLastName; ?>
                                    </h3>
                                    <p class="text-gray-700"><?= date('F j, Y', strtotime($appointment->date)) ?></p>
                                    <span class="text-gray-700">Reason:
                                        <span class="text-gray-500">
                                            <?= $appointment->reason; ?>
                                        </span>
                                    </span>
                                </div>
                                <a class="btn btn-ghost" href="#modal-form-history" data-id="<?= $appointment->id; ?>">
                                    Manage
                                </a>
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
                <div class="card-title">Schedule</div>
                <?php if (!empty($appointments)): ?>
                    <ul class="list rounded-box border">
                        <?php $count = 1 ?>
                        <?php foreach ($appointments as $appointment): ?>
                            <li class="list-row bg-base-100">
                                <div class="text-lg font-thin opacity-30 tabular-nums"><?= $count++; ?>.</div>
                                <div class="list-col-grow">
                                    <h3 class="font-semibold">
                                        <?= $appointment->roomName; ?>
                                    </h3>
                                    <p class="text-primary font-semibold">
                                        <?= date('g:i A', strtotime($appointment->startTime)) ?> -
                                        <?= date('g:i A', strtotime($appointment->endTime)) ?>
                                    </p>

                                    <p class="text-gray-700"><?= date('F j, Y', strtotime($appointment->date)) ?></p>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>

                <?php else: ?>
                    <p>There is no schedule.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    
</div>
<?= $this->endSection(); ?>

<?= $this->extend('layouts/public_layout'); ?>

<?= $this->section('content'); ?>
<div class="container mx-auto mt-4 px-4">
    <div class="grid md:grid-cols-4 gap-4">
        <?php if (!empty(user())): ?>
            <div class="card bg-primary-content">
                <div class="card-body">
                    <div class="card-title">
                        Hello, <?= user()->username; ?> 👋🏼
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <div class="col-span-3"></div>

        <div class="card border bg-base-100 col-span-3">
            <div class="card-body">
                <h3 class="card-title">Upcoming Appointment</h3>
                <?php if (!empty($appointment)): ?>
                    <ul class="list rounded-box border">
                            <li class="list-row">
                                <div><img class="size-10 rounded-full" src="<?= base_url('profile-picture?path=' . $appointment->profilePicture); ?>" alt="Profile Picture <?= $appointment->doctorFirstName . ' ' . $appointment->doctorLastName; ?>" /></div>
                                <div>
                                    <div><?= $appointment->doctorFirstName . ' ' . $appointment->doctorLastName; ?></div>
                                    <p><?= date('g:i A', strtotime($appointment->startTime)) ?> -
                                        <?= date('g:i A', strtotime($appointment->endTime)) ?></p>
                                    <p><?= date('F j, Y', strtotime($appointment->date)) ?></p>

                                </div>
                                <button class="btn btn-ghost">
                                    Detail
                                </button>
                            </li>
                    </ul>

                <?php else: ?>
                    <p>There is no data appointment.</p>
                <?php endif; ?>
            </div>
        </div>

        <div class="card border">
            <div class="card-body bg-base-100">
                <h3 class="card-title">Medical History</h3>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>
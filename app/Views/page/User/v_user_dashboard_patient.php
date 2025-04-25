<?= $this->extend('layouts/public_layout'); ?>

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

        <div class="card border">
            <div class="card-body">
                <a href="appointment/create" class="btn btn-soft btn-success">+ Create Appointment</a>
            </div>
        </div>

        <div class="card border md:col-span-2">
            <div class="card-body">
                <div class="flex justify-between">
                    <h3 class="card-title">Upcoming Appointment</h3>
                    <a class="btn btn-sm btn-primary" href="appointment">View All</a>
                </div>
                <?php if (!empty($appointment)): ?>
                    <div class="p-4 border rounded-lg">
                        <div class="grid grid-cols-[auto,1fr]">
                            <img class="size-10 rounded-full mr-4" src="<?= base_url('profile-picture?path=' . $appointment->doctorProfilePicture); ?>" alt="Profile Picture <?= $appointment->doctorFirstName . ' ' . $appointment->doctorLastName; ?>" />
                            <h3 class="text-lg font-semibold"><?= $appointment->doctorFirstName . ' ' . $appointment->doctorLastName; ?></h3>
                            <p class="col-start-2"><?= ucwords($appointment->doctorCategoryName); ?></p>
                            <p class="col-start-2">
                                <?= date('g:i A', strtotime($appointment->startTime)) ?> -
                                <?= date('g:i A', strtotime($appointment->endTime)) ?>
                            </p>
                            <p class="col-start-2"><?= date('F j, Y', strtotime($appointment->date)) ?></p>
                        </div>
                        <div class="card-actions justify-end">
                            <button class="btn btn-soft">
                                Detail
                            </button>
                        </div>
                    </div>

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
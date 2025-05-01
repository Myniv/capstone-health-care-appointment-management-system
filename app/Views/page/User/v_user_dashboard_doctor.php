<?= $this->extend('layouts/admin_layout'); ?>

<?= $this->section('content'); ?>
<div class="grid grid-cols-1 md:grid-cols-3 md:grid-rows-[auto_1fr] gap-4 h-full">
    <div class="card md:col-span-2">
        <div class="card-body">
            <?php if (!empty(user())): ?>
                <span class="card-title text-3xl font-bold">
                    Hello, <span class="text-primary"><?= user()->username; ?></span> 👋🏼
                </span>
            <?php endif; ?>
        </div>
    </div>

    <div class="stats bg-base-100 shadow-md">
        <div class="stat">
            <div class="stat-title">Today Appointment</div>
            <div class="stat-value text-secondary"><?= count($appointments); ?></div>
        </div>
    </div>

    <div class="card md:col-span-2 bg-base-100 shadow-md h-full">
        <div class="card-body">
            <div class="flex justify-between">
                <h3 class="card-title">Upcoming Appointment</h3>
                <a class="btn btn-sm btn-primary" href="<?= base_url('doctor/appointment'); ?>">View All</a>
            </div>
            <?php if (!empty($appointments)): ?>
                <ul class="list rounded-box border">
                    <?php foreach ($appointments as $appointment): ?>
                        <li class="list-row">
                            <div class="flex flex-col items-center gap-2">
                                <?= view_cell('\App\Cells\StatusCell::getStatus', ['status' => $appointment->status]) ?>
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
                            <a class="btn btn-ghost btn-sm" href="#modal-form-history" data-id="<?= $appointment->id; ?>">
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

    <div class="card bg-base-100 shadow-md h-full">
        <div class="card-body">
            <div class="card-title">Doctor Schedule</div>
            <?php if (!empty($appointments)): ?>
                <ul class="list rounded-box border">
                    <?php $count = 1 ?>
                    <?php foreach ($appointments as $appointment): ?>
                        <li class="list-row bg-base-100 mb-2">
                            <div class="text-lg font-thin opacity-30 tabular-nums"><?= $count++; ?>.</div>
                            <div class="list-col-grow">
                                <h3 class="font-semibold text-lg">
                                    <?= $appointment->roomName; ?>
                                </h3>
                                <span class="flex gap-2 items-center">
                                    <i class="fa-solid fa-clock"></i>
                                    <span><?= date('g:i A', strtotime($appointment->startTime)) ?> -
                                        <?= date('g:i A', strtotime($appointment->endTime)) ?></span>
                                </span>

                                <span class="flex gap-2 items-center">
                                    <i class="fa-solid fa-calendar"></i>
                                    <?= date('F j, Y', strtotime($appointment->date)) ?></span>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>

            <?php else: ?>
                <p>There is no schedule.</p>
            <?php endif; ?>
        </div>
    </div>

    <div class="modal" role="dialog" id="modal-form-history">
        <div class="modal-box md:max-w-5xl">
            <form
                action="<?= base_url('doctor/history/create') ?>"
                method="post" enctype="multipart/form-data" id="formData" novalidate>
                <?= csrf_field() ?>

                <?php if (isset($history)): ?>
                    <input type="hidden" name="_method" value="PUT">
                <?php endif; ?>

                <input type="hidden" name="appointment_id" id="appointmentId">

                <!-- Notes -->
                <div class="mb-2">
                    <label for="notes" class="label">
                        <span class="label-text">Notes</span>
                    </label>
                    <textarea
                        name="notes"
                        class="textarea textarea-bordered w-full"
                        rows="2"><?= old('notes') ?></textarea>
                    <div class="text-error text-sm"><?= session('errors.notes') ?? '' ?></div>
                </div>

                <!-- Prescriptions -->
                <div class="mb-2">
                    <label for="prescriptions" class="label">
                        <span class="label-text">Prescriptions</span>
                    </label>
                    <textarea
                        name="prescriptions"
                        class="textarea textarea-bordered w-full"
                        rows="2"><?= old('prescriptions') ?></textarea>
                    <div class="text-error text-sm"><?= session('errors.prescriptions') ?? '' ?></div>
                </div>

                <!-- Input Documents -->
                <div class="mb-2">
                    <label for="documents" class="label">
                        <span class="label-text">Medical Documents</span>
                    </label>
                    <input
                        type="file"
                        name="documents"
                        class="file-input file-input-bordered w-full">
                    <div class="text-error text-sm mt-1"><?= session('errors.documents') ?></div>
                </div>

                <div class="modal-action">
                    <a href="#" class="btn">Cancel</a>
                    <button type="submit" class="btn btn-primary">
                        Save & Mark as Done
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>

<?= $this->section('scripts'); ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const buttons = document.querySelectorAll('[href="#modal-form-history"]');
        const appointmentIdInput = document.getElementById('appointmentId');

        buttons.forEach(button => {
            button.addEventListener('click', function() {
                // Ambil appointment ID dari atribut data-id
                const appointmentId = button.getAttribute('data-id');

                // Isi input hidden dengan appointment ID
                appointmentIdInput.value = appointmentId;
            });
        });
    });
</script>
<?= $this->endSection(); ?>
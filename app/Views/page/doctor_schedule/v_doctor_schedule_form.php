<?= $this->extend('layouts/admin_layout'); ?>

<?= $this->section('content'); ?>
<div class="container mx-auto mt-4">
    <h2 class="text-2xl font-bold mb-4"><?= isset($schedule) ? 'Edit Doctor Schedule' : 'Add Doctor Schedule'; ?></h2>
    
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-error mb-4">
            <?= esc(session()->getFlashdata('error')) ?>
        </div>
    <?php endif; ?>

    <form
        action="<?= isset($schedule) ? base_url('admin/doctor-schedule/update/' . $schedule->id) : base_url('admin/doctor-schedule/create') ?>"
        method="post" id="formData" novalidate>
        <?= csrf_field() ?>
        <?php if (isset($schedule)): ?>
            <input type="hidden" name="_method" value="PUT">
        <?php endif; ?>

        <!-- Room and Doctor -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
                <label for="room_id" class="label">
                    <span class="label-text">Room</span>
                </label>
                <select name="room_id"
                    class="select select-bordered w-full <?= session('errors.room_id') ? 'select-error' : '' ?>"
                    required>
                    <option value="">Select Room</option>
                    <?php foreach ($rooms as $room): ?>
                        <option value="<?= $room['id'] ?>" <?= old('room_id', $schedule->room_id ?? '') == $room['id'] ? 'selected' : '' ?>>
                            <?= esc($room['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <div class="text-error text-sm"><?= session('errors.room_id') ?? '' ?></div>
            </div>

            <div>
                <label for="doctor_id" class="label">
                    <span class="label-text">Doctor</span>
                </label>
                <select name="doctor_id"
                    class="select select-bordered w-full <?= session('errors.doctor_id') ? 'select-error' : '' ?>"
                    required>
                    <option value="">Select Doctor</option>
                    <?php foreach ($doctors as $doctor): ?>
                        <option value="<?= $doctor->id ?>" <?= old('doctor_id', $schedule->doctor_id ?? '') == $doctor->id ? 'selected' : '' ?>>
                            <?= esc($doctor->first_name . ' ' . $doctor->last_name) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <div class="text-error text-sm"><?= session('errors.doctor_id') ?? '' ?></div>
            </div>
        </div>

        <!-- Start and End Time -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
                <label for="start_time" class="label">
                    <span class="label-text">Start Time</span>
                </label>
                <input type="time" name="start_time"
                    class="input input-bordered w-full <?= session('errors.start_time') ? 'input-error' : '' ?>"
                    value="<?= old('start_time', isset($schedule) ? date('H:i', strtotime($schedule->start_time)) : '') ?>"
                    required>
                <div class="text-error text-sm"><?= session('errors.start_time') ?? '' ?></div>
            </div>

            <div>
                <label for="end_time" class="label">
                    <span class="label-text">End Time</span>
                </label>
                <input type="time" name="end_time"
                    class="input input-bordered w-full <?= session('errors.end_time') ? 'input-error' : '' ?>"
                    value="<?= old('end_time', isset($schedule) ? date('H:i', strtotime($schedule->end_time)) : '') ?>"
                    required>
                <div class="text-error text-sm"><?= session('errors.end_time') ?? '' ?></div>
            </div>
        </div>


        <!-- Max Patient -->
        <div class="mb-4">
            <label for="max_patient" class="label">
                <span class="label-text">Maximum Number of Patients</span>
            </label>
            <input type="number" name="max_patient" min="1"
                class="input input-bordered w-full <?= session('errors.max_patient') ? 'input-error' : '' ?>"
                value="<?= old('max_patient', $schedule->max_patient ?? '') ?>" required>
            <div class="text-error text-sm"><?= session('errors.max_patient') ?? '' ?></div>
        </div>

        <!-- Status -->
        <div class="mb-4">
            <label for="status" class="label">
                <span class="label-text">Status</span>
            </label>
            <select name="status"
                class="select select-bordered w-full <?= session('errors.status') ? 'select-error' : '' ?>" required>
                <option value="">Select Status</option>
                <option value="active" <?= old('status', $schedule->status ?? '') == 'active' ? 'selected' : '' ?>>Active
                </option>
                <option value="inactive" <?= old('status', $schedule->status ?? '') == 'inactive' ? 'selected' : '' ?>>
                    Inactive</option>
            </select>
            <div class="text-error text-sm"><?= session('errors.status') ?? '' ?></div>
        </div>

        <!-- Submit Button -->
        <div class="text-end">
            <button type="submit" class="btn btn-primary"><?= isset($schedule) ? 'Update' : 'Save' ?> Schedule</button>
        </div>
    </form>
</div>
<?= $this->endSection(); ?>
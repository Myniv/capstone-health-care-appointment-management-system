<?= $this->extend('layouts/admin_layout'); ?>

<?= $this->section('content'); ?>
<div class="mb-4">
    <?= view_cell('BackButtonCell', ['backLink' => null]) ?>
</div>

<h2 class="text-2xl font-bold mb-4"><?= isset($schedule) ? 'Edit Doctor Schedule' : 'Add Doctor Schedule'; ?></h2>

<div class="bg-base-100 p-6 rounded-md shadow-md">
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-error alert-soft mb-4">
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
                <select name="room_id" id="room_id"
                    class="select select-bordered w-full <?= session('errors.room_id') ? 'select-error' : '' ?>"
                    required>
                    <option value="">Select Room</option>
                    <?php foreach ($rooms as $room): ?>
                        <option value="<?= $room->id ?>" <?= old('room_id', $schedule->room_id ?? '') == $room->id ? 'selected' : '' ?>>
                            <?= esc($room->name) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <div class="text-error text-sm"><?= session('errors.room_id') ?? '' ?></div>
            </div>
            <div>
                <label for="doctor_id" class="label">
                    <span class="label-text">Doctor</span>
                </label>
                <select name="doctor_id" id="doctor_id"
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

        <!-- Room Schedule Table -->
        <div class="mb-4 mt-2">
            <div class="card bg-base-100 shadow">
                <div class="card-body p-4">
                    <h3 class="text-lg font-semibold mb-2">Current Room Schedule</h3>
                    <div id="room-schedule-container">
                        <p class="text-sm text-gray-500">Select a room to view its schedule</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Start and End Time -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
                <label for="start_time" class="label">
                    <span class="label-text">Start Time</span>
                </label>
                <input type="time" name="start_time" id="start_time"
                    class="input input-bordered w-full <?= session('errors.start_time') ? 'input-error' : '' ?>"
                    value="<?= old('start_time', isset($schedule) ? date('H:i', strtotime($schedule->start_time)) : '') ?>"
                    required>
                <div class="text-error text-sm"><?= session('errors.start_time') ?? '' ?></div>
            </div>
            <div>
                <label for="end_time" class="label">
                    <span class="label-text">End Time</span>
                </label>
                <input type="time" name="end_time" id="end_time"
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
            <input type="number" name="max_patient" id="max_patient" min="1"
                class="input input-bordered w-full <?= session('errors.max_patient') ? 'input-error' : '' ?>"
                value="<?= old('max_patient', $schedule->max_patient ?? '') ?>" required>
            <div class="text-error text-sm"><?= session('errors.max_patient') ?? '' ?></div>
        </div>
        <!-- Status -->
        <div class="mb-4">
            <label for="status" class="label">
                <span class="label-text">Status</span>
            </label>
            <select name="status" id="status"
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
<!-- Room Schedule Validation Script -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const roomSelect = document.querySelector('select[name="room_id"]');
        const startTimeInput = document.querySelector('input[name="start_time"]');
        const endTimeInput = document.querySelector('input[name="end_time"]');
        const scheduleId = "<?= $schedule->id ?? '' ?>"; // For edit mode
        const roomScheduleContainer = document.getElementById('room-schedule-container');

        // Store existing schedules
        let existingSchedules = [];

        // Check for conflicts when room, start or end time changes
        roomSelect.addEventListener('change', function() {
            fetchRoomSchedule(roomSelect.value);
            checkForConflicts();
        });
        startTimeInput.addEventListener('change', checkForConflicts);
        endTimeInput.addEventListener('change', checkForConflicts);

        // Check conflicts on page load if values are already set (edit mode)
        if (roomSelect.value) {
            setTimeout(function() {
                fetchRoomSchedule(roomSelect.value);
                checkForConflicts();
            }, 500); // Small delay to ensure DOM is ready
        }

        function fetchRoomSchedule(roomId) {
            if (!roomId) {
                roomScheduleContainer.innerHTML = '<p class="text-sm text-gray-500">Select a room to view its schedule</p>';
                return;
            }

            // Show loading indicator
            roomScheduleContainer.innerHTML = '<p class="text-sm">Loading schedules...</p>';

            fetch(`<?= base_url('admin/doctor-schedule/get-room-schedules') ?>/${roomId}`, {
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('input[name="<?= csrf_token() ?>"]').value
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.schedules && data.schedules.length > 0) {
                        // Create table to display schedules
                        let tableHtml = `
                        <div class="overflow-x-auto">
                            <table class="table table-zebra w-full text-sm">
                                <thead>
                                    <tr>
                                        <th>Doctor</th>
                                        <th>Start Time</th>
                                        <th>End Time</th>
                                        <th>Max Patients</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                    `;

                        data.schedules.forEach(schedule => {
                            // Highlight the current schedule if in edit mode
                            const isCurrentSchedule = schedule.id == scheduleId;
                            const rowClass = isCurrentSchedule ? 'bg-primary bg-opacity-10' : '';

                            tableHtml += `
                            <tr class="${rowClass}">
                                <td>${schedule.doctor_name}</td>
                                <td>${schedule.start_time}</td>
                                <td>${schedule.end_time}</td>
                                <td>${schedule.max_patient}</td>
                                <td>
                                    <span class="badge badge-${schedule.status === 'active' ? 'success' : 'error'}">
                                        ${schedule.status}
                                    </span>
                                </td>
                            </tr>
                        `;
                        });

                        tableHtml += `
                                </tbody>
                            </table>
                        </div>
                    `;

                        roomScheduleContainer.innerHTML = tableHtml;
                    } else {
                        roomScheduleContainer.innerHTML = '<p class="text-sm text-gray-500">No schedules found for this room</p>';
                    }

                    // Store the schedules for conflict checking
                    existingSchedules = data.schedules || [];
                })
                .catch(error => {
                    console.error('Error fetching room schedules:', error);
                    roomScheduleContainer.innerHTML = '<p class="text-sm text-error">Failed to load room schedules</p>';
                });
        }

        function checkForConflicts() {
            const roomId = roomSelect.value;
            const startTime = startTimeInput.value;
            const endTime = endTimeInput.value;

            // Clear previous error messages
            document.querySelectorAll('.time-conflict-error').forEach(el => el.remove());

            // Reset input styles
            startTimeInput.classList.remove('input-error');
            endTimeInput.classList.remove('input-error');

            // Don't proceed if any value is missing
            if (!roomId || !startTime || !endTime) return;

            fetch(`<?= base_url('admin/doctor-schedule/check-availability') ?>`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('input[name="<?= csrf_token() ?>"]').value
                    },
                    body: JSON.stringify({
                        room_id: roomId,
                        start_time: startTime,
                        end_time: endTime,
                        schedule_id: scheduleId // Used for edit mode to exclude current schedule
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.conflict) {
                        // Show error message
                        showConflictError(data.message);
                        // Style inputs as error
                        startTimeInput.classList.add('input-error');
                        endTimeInput.classList.add('input-error');
                    }
                })
                .catch(error => {
                    console.error('Error checking schedule availability:', error);
                });
        }

        function showConflictError(message) {
            // Add error message under time inputs
            const errorDiv = document.createElement('div');
            errorDiv.classList.add('text-error', 'text-sm', 'mt-2', 'time-conflict-error');
            errorDiv.textContent = message || 'Room is already booked during this time.';

            // Insert after the end time input container
            endTimeInput.parentElement.appendChild(errorDiv);
        }

        // Form validation before submit
        document.getElementById('formData').addEventListener('submit', function(e) {
            const roomId = roomSelect.value;
            const startTime = startTimeInput.value;
            const endTime = endTimeInput.value;

            // Basic validation
            if (startTime >= endTime) {
                e.preventDefault();
                showConflictError('End time must be after start time.');
                startTimeInput.classList.add('input-error');
                endTimeInput.classList.add('input-error');
                return;
            }

            // Check if there's an active conflict error
            if (document.querySelector('.time-conflict-error')) {
                e.preventDefault();
            }
        });
    });
</script>
<?= $this->endSection(); ?>
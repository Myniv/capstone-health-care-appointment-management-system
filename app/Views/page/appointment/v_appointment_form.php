<?= $this->extend('layouts/admin_layout'); ?>

<?= $this->section('content'); ?>
<div class="container mx-auto mt-4">
  <!-- <h2 class="text-2xl font-bold mb-4"></h2> -->
  <h2 class="text-2xl font-bold mb-4">Create Appointment</h2>

  <p class="text-gray-500/75 font-semibold mb-2">Doctor Information</p>
  <div class="card card-border bg-base-100 mb-4">
    <div class="card-body">
      <div class="flex">
        <img src="/images/placeholder.jpg" width="100" alt="">
        <div class="">
          <h2 class="card-title"><?= $doctor->first_name ?> <?= $doctor->last_name ?></h2>
          <p class="text-gray-500/75"><?= $doctor->education ?></p>
          <p class="text-gray-500/75"><?= $doctor->degree ?></p>
        </div>
      </div>
    </div>
  </div>

  <form
    action="<?= base_url('appointment/create/submit') ?>"
    method="post"
    enctype="multipart/form-data"
    id="appointmentForm"
    novalidate>
    <?= csrf_field() ?>

    <input type="hidden" name="_method" value="POST">
    <input type="hidden" name="id" value="<?= $doctor->id; ?>">
    <input type="hidden" name="schedule" id="scheduleInput" value="<?= old('schedule', $schedule ?? '') ?>">
    <input type="hidden" name="date" id="dateInput" value="<?= old('date', $date ?? '') ?>">

    <p class="text-gray-500/75 font-semibold mb-2">Doctor Practice Schedule</p>
    <div class="grid gap-2">
      <div class="grid gap-2 w-1/3">
        <label for="dateDisplay" class="label">
          <span class="label-text">Date</span>
        </label>
        <input
          type="date"
          id="dateDisplay"
          class="input input-bordered w-full"
          value="<?= old('date', $date ?? '') ?>"
          onchange="document.getElementById('dateInput').value = this.value"
          required />
      </div>

      <div class="grid gap-2">
        <label class="label">
          <span class="label-text">Time</span>
        </label>
        <div class="flex gap-2 flex-wrap w-1/2">
          <?php if ($doctor_schedule): ?>
            <?php foreach ($doctor_schedule as $row): ?>
              <?php $isSelected = old('schedule', $schedule ?? '') == $row->id; ?>
              <button
                type="button"
                class="btn <?= $isSelected ? 'btn-primary text-white' : 'btn-outline' ?> time-btn"
                data-id="<?= $row->id ?>"
                onclick="selectSchedule(this)">
                <?= date('g:i A', strtotime($row->start_time)) ?> -
                <?= date('g:i A', strtotime($row->end_time)) ?>
              </button>
            <?php endforeach; ?>
          <?php endif; ?>
        </div>
      </div>

      <div class="grid gap-2">
        <label for="description" class="label">
          <span class="label-text">Needs</span>
        </label>
        <textarea
          class="textarea w-1/2 <?= session('errors.reason') ? 'input-error' : '' ?>"
          name="reason"
          placeholder="headache, etc"
          required><?= old('reason', $reason ?? '') ?></textarea>
        <div class="text-error text-sm"><?= session('errors.reason') ?? '' ?></div>
      </div>
    </div>

    <!-- Submit Button -->
    <div class="text-end mt-4">
      <button type="submit" class="btn btn-primary">Create</button>
      <a href="/appointment/create" class="btn btn-secondary">Cancel</a>
    </div>
  </form>
</div>

<script>
  function selectSchedule(button) {
    const date = document.getElementById('dateDisplay').value;
    if (!date) {
      alert('Please select a date first.');
      return;
    }

    // Update hidden inputs
    const scheduleId = button.getAttribute('data-id');
    document.getElementById('scheduleInput').value = scheduleId;
    document.getElementById('dateInput').value = date;

    // Visually update buttons
    const allButtons = document.querySelectorAll('.time-btn');
    allButtons.forEach(btn => {
      btn.classList.remove('btn-primary', 'text-white');
      btn.classList.add('btn-outline');
    });

    button.classList.remove('btn-outline');
    button.classList.add('btn-primary', 'text-white');
  }
</script>
<?= $this->endSection(); ?>
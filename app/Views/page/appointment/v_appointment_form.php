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

  <!-- BIG FORM -->
  <form
    action="<?= base_url('appointment/create/confirmation') ?>"
    method="get" enctype="multipart/form-data" id="formData" name="formData" novalidate>
    <input type="hidden" name="schedule" id="scheduleInput" value="">
    <input type="hidden" name="id" value="<?= $doctor->id; ?>">
    <input type="hidden" name="date" id="dateInput" value="<?= old('date', $date ?? '') ?>">

    <p class="text-gray-500/75 font-semibold mb-2">Doctor Practice Schedule</p>
    <div class="flex gap-4 w-full items-start">
      <div class="grid gap-2 w-1/3">
        <label for="name" class="label">
          <span class="label-text">Date</span>
        </label>
        <input
          type="date"
          id="dateDisplay"
          class="input input-bordered w-full"
          value="<?= old('date', $date ?? '') ?>"
          onchange="document.getElementById('dateInput').value = this.value" />
      </div>


      <div class="grid gap-2">
        <label for="name" class="label">
          <span class="label-text">Time</span>
        </label>
        <div class="flex gap-2 flex-wrap w-1/2  ">
          <?php if ($doctor_schedule) { ?>
            <?php foreach ($doctor_schedule as $row): ?>

              <!-- DATE TIME FORM -->

              <button type="submit" class="btn btn-primary" onclick="selectSchedule('<?= $row->id ?>')">
                <p> <?= date('g:i A', strtotime($row->start_time)) ?> -
                  <?= date('g:i A', strtotime($row->end_time)) ?></p>
              </button>


            <?php endforeach; ?>

          <?php }; ?>

        </div>

      </div>
    </div>


    <!-- Submit Button -->
    <div class="text-end">
      <!-- <button type="submit" class="btn btn-primary">Create</button> -->
      <a href="/appointment/create" class="btn btn-secondary">Cancel</a>
    </div>
</div>

<script>
  function selectSchedule(scheduleId) {
    const date = document.getElementById('dateDisplay').value;

    if (!date) {
      alert('Please select a date first.');
      return;
    }

    document.getElementById('scheduleInput').value = scheduleId;
    document.getElementById('dateInput').value = date;
    document.getElementById('dateForm').submit();
  }
</script>
<?= $this->endSection(); ?>
<?php

use Config\Roles; ?>

<?php if (in_groups(Roles::PATIENT)): ?>
  <?= $this->extend('layouts/public_layout'); ?>
<?php else: ?>
  <?= $this->extend('layouts/admin_layout'); ?>
<?php endif; ?>

<?= $this->section('content'); ?>
<!-- <h2 class="text-2xl font-bold mb-4"></h2> -->
<div class="mb-4">
  <?= view_cell('BackButtonCell', ['backLink' => null]) ?>
</div>
<h2 class="text-2xl font-bold mb-4"><?= $type == 'reschedule' ? 'Reschedule' : 'Create' ?> Appointment</h2>

<?php if (session('errors')): ?>
  <div class="alert alert-error mb-4">
    <ul>
      <?php foreach (session('errors') as $error): ?>
        <li><?= $error ?></li>
      <?php endforeach ?>
    </ul>
  </div>

<?php endif ?>

<div class="grid grid-cols-2 gap-4 w-full">
  <div class="">
    <div class="card card-border bg-base-100 mb-4">
      <div class="card-body">
        <p class="text-gray-500/75 font-semibold mb-2">Doctor Information</p>
        <div class="flex gap-4">
          <div class="avatar">
            <div class="w-24 rounded-full">
              <img src="<?= base_url('profile-picture?path=' . $doctor->profile_picture); ?>"
                alt="Profile Picture <?= $doctor->first_name . ' ' . $doctor->last_name; ?>">
            </div>
          </div>
          <div class="">
            <h2 class="card-title"><?= $doctor->first_name ?> <?= $doctor->last_name ?></h2>
            <p class="text-gray-500/75"><?= ucfirst($doctor->categoryName) ?></p>
            <p class="text-gray-500/75">HealthCare Hospital</p>
          </div>
        </div>
        <hr class="my-2">
        <div class="">
          <h3 class="text-sm font-bold mb-2">Education</h3>
          <ul class="flex flex-col space-y-4">
            <?php foreach ($education as $row): ?>
              <li class="flex items-center space-x-4">
                <div class="timeline-start self-center flex items-center justify-center">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5">
                    <path fill-rule="evenodd"
                      d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                      clip-rule="evenodd" />
                  </svg>
                </div>
                <div class="timeline-middle text-left">
                  <p class=" font-bold"><?= $row->study_program ?></p>
                  <div class="flex">
                    <p class="text-sm"><?= $row->year ?> &#x2022; <?= $row->university ?>,<?= $row->city ?></p>
                  </div>
                </div>
              </li>
            <?php endforeach; ?>
          </ul>

        </div>
      </div>
    </div>
  </div>
  <form
    action="<?= $type == 'create' ? base_url('appointment/create/form') : base_url(in_groups(Roles::ADMIN) ? 'admin/appointment/reschedule/form' : 'appointment/reschedule/form') ?>"
    method="get" enctype="multipart/form-data" id="appointmentForm" novalidate>

    <input type="hidden" name="id" value="<?= $doctor->id; ?>">
    <input type="hidden" name="schedule" id="scheduleInput" value="<?= old('schedule', $schedule ?? '') ?>">
    <input type="hidden" name="date" id="dateInput" value="<?= old('date', $date ?? '') ?>">

    <div class="card card-border bg-base-100 mb-4">
      <div class="card-body">
        <p class="text-gray-500/75 font-semibold mb-2">Doctor Practice Schedule</p>
        <div class="grid gap-2">
          <div class="grid gap-2">
            <label for="dateDisplay" class="label">
              <span class="label-text">Date</span>
            </label>
            <input type="text" id="dateDisplay" name="dateDisplay" class="input input-bordered w-full" autocomplete="off"
              value="<?= old('date', $date ?? '') ?>" min="<?= date('Y-m-d') ?>" onchange="this.form.submit()" />
          </div>

          <div class="grid gap-2">
            <label class="label">
              <span class="label-text">Available Time</span>
            </label>
            <div class="flex gap-2 flex-wrap w-1/2">

              <?php if ($doctor_schedule): ?>
                <?php foreach ($doctor_schedule as $row): ?>
                  <?php $isSelected = old('schedule', $schedule ?? '') == $row->id; ?>
                  <?php $isFull = $row->full == 1; ?>
                  <button type="button" class="btn <?= $isSelected ? 'btn-primary text-white' : 'btn-outline' ?> time-btn"
                    data-id="<?= $row->id ?>" <?= $isFull ? 'disabled' : '' ?> onclick="selectSchedule(this)">
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
            <textarea class="textarea w-full <?= session('errors.reason') ? 'input-error' : '' ?>" name="reason"
              placeholder="headache, etc" required><?= old('reason', $reason ?? '') ?></textarea>
            <div class="text-error text-sm"><?= session('errors.reason') ?? '' ?></div>
          </div>

          <?php if ($type == 'create'): ?>
            <div class="w-full">
              <label for="documents" class="label">
                <span class="label-text">Documents</span>
              </label>
              <input type="file" name="documents" accept="application/pdf"
                class="file-input file-input-bordered w-full <?= session('errors.documents') ? 'file-input-error' : '' ?>">
              <div class="text-error text-sm mt-1"><?= session('errors.documents') ?></div>
            </div>
          <?php endif; ?>
        </div>


        <!-- Submit Button -->
        <div class="text-end mt-4">
          <button type="submit"
            formaction="<?= $type == 'create' ?
                          base_url('appointment/create/submit') :
                          base_url(in_groups(Roles::ADMIN) ? 'admin/appointment/reschedule/submit' : 'appointment/reschedule/submit') ?>"
            formmethod="post" class="btn btn-primary">
            <?= $type == 'create' ? 'Create' : 'Reschedule' ?>
          </button>
          <a href="<?= in_groups(Roles::ADMIN) ? '/admin/appointment/detail/' . $appointmentId : base_url('find-doctor') ?>"
            class="btn btn-secondary">Cancel</a>
          <input type="hidden" name="appointmentId" value="<?= $type == 'create' ? '' : $appointmentId ?>" />
        </div>
      </div>
    </div>
  </form>
</div>

<?= $this->endSection(); ?>

<?= $this->section('scripts'); ?>
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
    //document.getElementById('dateInput').value = date;

    // Visually update buttons
    const allButtons = document.querySelectorAll('.time-btn');
    allButtons.forEach(btn => {
      btn.classList.remove('btn-primary', 'text-white');
      btn.classList.add('btn-outline');
    });

    button.classList.remove('btn-outline');
    button.classList.add('btn-primary', 'text-white');
  }

  $(function() {
    $("#dateDisplay").datepicker({
      dateFormat: "DD, dd MM yy", // Display format: Monday, 2025-05-05
      minDate: 0,
      altField: "#dateInput", // Where the ISO value goes
      altFormat: "yy-mm-dd", // What the server receives
      onSelect: function(dateText, inst) {
        const dateObj = $(this).datepicker("getDate");
        const isoDate = $.datepicker.formatDate("yy-mm-dd", dateObj);

        // Set hidden input value for form submission
        $("#dateInput").val(isoDate);

        // Optional: auto-submit form if you want
        // $("#appointmentForm").submit();
      }

    });

    // Set display if value already exists (e.g., on form reload)
    const existingDate = $("#dateInput").val();
    if (existingDate) {
      const dateObj = $.datepicker.parseDate("yy-mm-dd", existingDate);
      const displayText = $.datepicker.formatDate("DD, dd MM yy", dateObj);
      $("#dateDisplay").val(displayText);
    }
  });
</script>
<?= $this->endSection(); ?>
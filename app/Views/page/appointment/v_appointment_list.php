<?php

use Config\Roles; ?>

<?php if (in_groups(Roles::PATIENT)): ?>
  <?= $this->extend('layouts/public_layout'); ?>
<?php else: ?>
  <?= $this->extend('layouts/admin_layout'); ?>
<?php endif; ?>

<?= $this->section('content'); ?>
<h2 class="text-2xl font-bold mb-4">Appointment List</h2>
<?php if (session('success')): ?>
  <div class="alert alert-success alert-soft mb-4">
    <?= session('success') ?>
  </div>
<?php endif ?>
<div class="bg-base-100 p-6 rounded-md shadow-md">
  <?php if (in_groups(Roles::PATIENT)): ?>
    <!-- Add Button -->
    <div class="flex gap-4 mb-4">
      <a href="/find-doctor" class="btn btn-outline btn-success">Create Appointment</a>
    </div>
  <?php endif; ?>

  <!-- Search and Filters -->
  <form action="<?= $baseUrl ?>" method="get" class="flex flex-wrap items-center gap-4 mb-4">
    <div class="flex flex-grow items-center gap-2">
      <input type="text" class="input input-bordered w-full md:w-auto flex-grow" name="search"
        value="<?= $params->search ?>" placeholder="Search...">
      <input type="date" name="date" class="input input-bordered <?= session('errors.date') ? 'input-error' : '' ?>"
        value="<?= $params->date ?>" placeholder="Select Date" />
      <button type="submit" class="btn btn-primary ml-2">Search</button>
    </div>

    <div class="form-control w-full md:w-1/4">
      <select name="perPage" class="select select-bordered" onchange="this.form.submit()">
        <option value="2" <?= ($params->perPage == 2) ? 'selected' : '' ?>>2 per Page</option>
        <option value="5" <?= ($params->perPage == 5) ? 'selected' : '' ?>>5 per Page</option>
        <option value="10" <?= ($params->perPage == 10) ? 'selected' : '' ?>>10 per Page</option>
        <option value="25" <?= ($params->perPage == 25) ? 'selected' : '' ?>>25 per Page</option>
      </select>
    </div>


    <div class="form-control w-full md:w-auto">
      <a href="<?= $params->getResetUrl($baseUrl) ?>" class="btn btn-primary">Reset</a>
    </div>

    <input type="hidden" name="sort" value="<?= $params->sort ?>">
    <input type="hidden" name="order" value="<?= $params->order; ?>">
  </form>

  <!-- Table -->
  <?php if (in_groups(Roles::ADMIN)): ?>
    <div class="overflow-x-auto">
      <table class="table table-zebra w-full">
        <thead>
          <tr>
            <th>
              <a href="<?= $params->getSortUrl('id', $baseUrl) ?>" class="link link-hover">
                ID <?= $params->isSortedBy('id') ? ($params->getSortDirection() == 'asc' ? '↑' : '↓') : '↕' ?>
              </a>
            </th>
            <th>Doctor</th>
            <th>Patient</th>
            <th>Room</th>
            <th>Date</th>
            <th>Time</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($appointment)): ?>
            <?php foreach ($appointment as $row): ?>
              <tr>
                <td><?= $row->id ?></td>
                <td><?= $row->doctorFirstName ?> <?= $row->doctorLastName ?></td>
                <td><?= $row->patientFirstName ?> <?= $row->patientLastName ?></td>
                <td><?= date('F j, Y', strtotime($row->date)) ?></td>
                <td><?= $row->roomName ?></td>
                <td><?= date('g:i A', strtotime($row->startTime)) ?> -
                  <?= date('g:i A', strtotime($row->endTime)) ?>
                </td>
                <td>
                  <?= view_cell('\App\Cells\StatusCell::getStatus', ['status' => $row->status]) ?>
                  <?= view_cell('\App\Cells\StatusRescheduleCell::getStatusReschedule', ['is_reschedule' => $row->is_reschedule]) ?>
                </td>
                <td>
                  <a href="appointment/detail/<?= $row->id ?>" class="btn btn-soft btn-sm">Details</a>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  <?php else: ?>
    <div class="grid grid-cols-3 gap-4">
      <?php foreach ($appointment as $row): ?>
        <div class="card border bg-base-100 w-full">
          <div class="card-body">
            <div class="flex gap-4 items-center">
              <div class="avatar">
                <div class="w-24 rounded-full">
                  <?php if (in_groups(Roles::PATIENT)): ?>
                    <img src="<?= base_url('profile-picture?path=' . $row->doctorProfilePicture); ?>"
                      alt="Profile Picture <?= $row->doctorFirstName . ' ' . $row->doctorLastName; ?>">
                  <?php elseif (in_groups(Roles::DOCTOR)): ?>
                    <img src="<?= base_url('profile-picture?path=' . $row->patientProfilePicture); ?>"
                      alt="Profile Picture <?= $row->patientFirstName . ' ' . $row->patientLastName; ?>">
                  <?php endif; ?>
                </div>
              </div>
              <div class="grid gap-2">
                <h2 class="card-title">
                  <?php if (in_groups(Roles::PATIENT)): ?>
                    <p><?= $row->doctorFirstName ?>       <?= $row->doctorLastName ?></p>
                  <?php else: ?>
                    <p><?= $row->patientFirstName ?>       <?= $row->patientLastName ?></p>
                  <?php endif; ?>
                </h2>
                <p class="flex gap-2 items-center"><i class="fa-solid fa-calendar"></i>
                  <span><?= date('F j, Y', strtotime($row->date)) ?></span>
                </p>
                <p class="flex gap-2 items-center">
                  <i class="fa-solid fa-clock"></i>
                  <span><?= date('g:i A', strtotime($row->startTime)) ?> -
                    <?= date('g:i A', strtotime($row->endTime)) ?></span>
                </p>

                <span class="flex gap-2">
                  <?= view_cell('\App\Cells\StatusCell::getStatus', ['status' => $row->status]) ?>
                  <?= view_cell('\App\Cells\StatusRescheduleCell::getStatusReschedule', ['is_reschedule' => $row->is_reschedule]) ?>
                </span>
              </div>
            </div>

            <div class="card-actions justify-end">
              <?php if (in_groups(Roles::DOCTOR)): ?>
                <?php if ($row->status == 'booking'): ?>
                  <a href="#modal-form-history" data-id="<?= $row->id; ?>" class="btn btn-primary btn-sm">
                    Manage
                  </a>
                <?php endif; ?>
              <?php endif; ?>
              <a href="/appointment/detail/<?= $row->id ?>" class="btn btn-soft btn-sm">
                Details
              </a>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>

  <?php endif; ?>

  <!-- Pagination -->
  <div class="mt-8 text-center">
    <?= $pager->links('appointment', 'custom_pager') ?>
    <div class="mt-2">
      <small>Show <?= count($appointment) ?> of <?= $total ?> total data (Page <?= $params->page ?>)</small>
    </div>
  </div>


  <!-- Modal Form History -->
  <div class="modal" role="dialog" id="modal-form-history">
    <div class="modal-box md:max-w-5xl">
      <form action="<?= base_url('doctor/history/create') ?>" method="post" enctype="multipart/form-data" id="formData"
        novalidate>
        <?= csrf_field() ?>

        <input type="hidden" name="appointment_id" id="appointmentId">

        <!-- Notes -->
        <div class="mb-2">
          <label for="notes" class="label">
            <span class="label-text">Notes</span>
          </label>
          <textarea name="notes" class="textarea textarea-bordered w-full" rows="2"><?= old('notes') ?></textarea>
          <div class="text-error text-sm"><?= session('errors.notes') ?? '' ?></div>
        </div>

        <!-- Prescriptions -->
        <div class="mb-2">
          <label for="prescriptions" class="label">
            <span class="label-text">Prescriptions</span>
          </label>
          <textarea name="prescriptions" class="textarea textarea-bordered w-full"
            rows="2"><?= old('prescriptions') ?></textarea>
          <div class="text-error text-sm"><?= session('errors.prescriptions') ?? '' ?></div>
        </div>

        <!-- Input Documents -->
        <div class="mb-2">
          <label for="documents" class="label">
            <span class="label-text">Medical Documents</span>
          </label>
          <input type="file" name="documents" class="file-input file-input-bordered w-full">
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
  document.addEventListener('DOMContentLoaded', function () {
    const buttons = document.querySelectorAll('[href="#modal-form-history"]');
    const appointmentIdInput = document.getElementById('appointmentId');

    buttons.forEach(button => {
      button.addEventListener('click', function () {
        // Ambil appointment ID dari atribut data-id
        const appointmentId = button.getAttribute('data-id');

        // Isi input hidden dengan appointment ID
        appointmentIdInput.value = appointmentId;
      });
    });
  });
</script>
<?= $this->endSection(); ?>
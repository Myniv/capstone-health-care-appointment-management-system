<?= $this->extend('layouts/admin_layout'); ?>

<?= $this->section('content'); ?>
<div class="container mx-auto mt-4">
  <h2 class="text-2xl font-bold mb-4">Appointment List</h2>

  <!-- Add Button -->
  <div class="flex gap-4 mb-4">
    <a href="/appointment/create" class="btn btn-outline btn-success">Create Appointment</a>
  </div>

  <!-- Search and Filters -->
  <form action="<?= $baseUrl ?>" method="get" class="flex flex-wrap items-center gap-4 mb-4">
    <div class="flex flex-grow items-center gap-2">
      <input type="text" class="input input-bordered w-full md:w-auto flex-grow" name="search" value="<?= $params->search ?>"
        placeholder="Search...">
      <input type="date"
        name="date"
        class="input input-bordered <?= session('errors.date') ? 'input-error' : '' ?>"
        value="<?= $params->date ?>"
        placeholder="Select Date" />
      <button type="submit" class="btn btn-primary ml-2">Search</button>
    </div>

    <div class="form-control w-full md:w-1/4">
      <select name="perPage" class="select select-bordered" onchange="this.form.submit()">
        <option value="3" <?= ($params->perPage == 3) ? 'selected' : '' ?>>3 per Page</option>
        <option value="6" <?= ($params->perPage == 6) ? 'selected' : '' ?>>6 per Page</option>
        <option value="12" <?= ($params->perPage == 12) ? 'selected' : '' ?>>12 per Page</option>
        <option value="24" <?= ($params->perPage == 24) ? 'selected' : '' ?>>24 per Page</option>
      </select>
    </div>


    <div class="form-control w-full md:w-auto">
      <a href="<?= $params->getResetUrl($baseUrl) ?>" class="btn btn-primary">Reset</a>
    </div>

    <input type="hidden" name="sort" value="<?= $params->sort; ?>">
    <input type="hidden" name="order" value="<?= $params->order; ?>">
  </form>

  <!-- Table -->
  <?php

  use Config\Roles;

  if (in_groups(Roles::ADMIN)):
  ?>
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
            <th>Time</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($appointment)): ?>
            <?php foreach ($appointment as $row): ?>
              <tr>
                <td><?= $row->id ?></td>
                <td><?= $row->doctorFirstName ?> <?= $row->doctorLastName ?></td>
                <td><?= $row->patientFirstName ?> <?= $row->patientLastName ?></td>
                <td><?= $row->roomName ?></td>
                <td><?= date('g:i A', strtotime($row->startTime)) ?> -
                  <?= date('g:i A', strtotime($row->endTime)) ?></td>
                <td>
                  <?= view_cell('\App\Cells\StatusCell::getStatus', ['status' => $row->status]) ?>
                </td>
                <td>
                  <a href="/appointment/detail/<?= $row->id ?>" class="btn btn-primary btn-sm">Details</a>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  <?php else: ?>
    <div class="grid grid-cols-3 gap-4">
      <?php if (!empty($appointment)): ?>
        <?php foreach ($appointment as $row): ?>
          <div class="card border bg-base-100 w-full">
            <div class="card-body">
              <h2 class="card-title">
                <?php if (in_groups(Roles::PATIENT)): ?>
                  <p><?= $row->doctorFirstName ?> <?= $row->doctorLastName ?></p>
                <?php elseif (in_groups(Roles::DOCTOR)): ?>
                  <p><?= $row->patientFirstName ?> <?= $row->patientLastName ?></p>
                <?php endif; ?>
              </h2>
              <p><?= date('g:i A', strtotime($row->startTime)) ?> -
                <?= date('g:i A', strtotime($row->endTime)) ?></p>
              <p><?= date('F j, Y', strtotime($row->date)) ?></p>
              <?= view_cell('\App\Cells\StatusCell::getStatus', ['status' => $row->status]) ?>

              <div class="card-actions justify-end">
                <?php if (in_groups(Roles::PATIENT)): ?>
                  <a href="/appointment/detail/<?= $row->id ?>" class="btn btn-primary btn-sm">
                    Details
                  </a>
                <?php elseif (in_groups(Roles::DOCTOR)): ?>
                  <a href="#modal-form-history" data-id="<?= $row->id; ?>" class="btn btn-primary btn-sm">
                    Manage
                  </a>
                <?php endif; ?>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>

    <div class="modal" role="dialog" id="modal-form-history">
      <div class="modal-box md:max-w-5xl">
        <form
          action="<?= base_url('doctor/history/create') ?>"
          method="post" enctype="multipart/form-data" id="formData" novalidate>
          <?= csrf_field() ?>

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
  <?php endif; ?>

  <!-- Pagination -->
  <div class="mt-8 text-center">
    <?= $pager->links('appointment', 'custom_pager') ?>
    <div class="mt-2">
      <small>Show <?= count($appointment) ?> of <?= $total ?> total data (Page <?= $params->page ?>)</small>
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
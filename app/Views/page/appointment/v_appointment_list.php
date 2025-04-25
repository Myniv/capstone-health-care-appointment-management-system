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

  if (!in_groups(Roles::PATIENT)):
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
            <th>
              Doctor
            </th>
            <th>
              Patient
            </th>
            <th>
              Room
            </th>
            <th>
              Time
            </th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($appointment as $row): ?>
            <tr>
              <td><?= $row->id ?></td>
              <td><?= $row->doctorFirstName ?> <?= $row->doctorLastName ?></td>
              <td><?= $row->patientFirstName ?> <?= $row->patientLastName ?></td>
              <td><?= $row->roomName ?></td>
              <td><?= date('g:i A', strtotime($row->startTime)) ?> -
                <?= date('g:i A', strtotime($row->endTime)) ?></td>
              <td>
                <form action="<?= $baseUrl ?>/detail" method="post" novalidate>
                  <?= csrf_field() ?>
                  <input type="text" hidden name="appointmentId" value="<?= $row->id ?>">
                  <button type="submit" class="btn btn-primary btn-sm">Details</button>
                </form>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php else: ?>
    <div class="grid grid-cols-3 gap-4">
      <?php foreach ($appointment as $row): ?>
        <div class="card card-border bg-base-100 w-full">
          <div class="card-body">
            <h2 class="card-title">
              <p><?= $row->doctorFirstName ?> <?= $row->doctorLastName ?></p>
            </h2>
            <p><?= date('g:i A', strtotime($row->startTime)) ?> -
              <?= date('g:i A', strtotime($row->endTime)) ?></p>
            <p><?= date('F j, Y', strtotime($row->date)) ?></p>
            <div class="badge badge-warning"><?= $row->status; ?></div>

            <div class="card-actions justify-end">
              <form action="<?= $baseUrl ?>/detail" method="post" novalidate>
                <?= csrf_field() ?>
                <input type="text" hidden name="appointmentId" value="<?= $row->id ?>">
                <button type="submit" class="btn btn-primary">Details</button>
              </form>
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
</div>
<?= $this->endSection(); ?>
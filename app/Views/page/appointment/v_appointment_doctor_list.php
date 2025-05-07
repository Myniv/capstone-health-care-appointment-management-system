<?php

use Config\Roles; ?>

<?php if (in_groups(Roles::PATIENT)): ?>
  <?= $this->extend('layouts/public_layout'); ?>
<?php else: ?>
  <?= $this->extend('layouts/admin_layout'); ?>
<?php endif; ?>

<?= $this->section('content'); ?>
<!-- <h2 class="text-2xl font-bold mb-4"></h2> -->
<h2 class="text-2xl font-bold mb-4"><?= 'Find Doctor'; ?></h2>

<div class="bg-base-100 p-6 rounded-md shadow-md">
  <!-- Search and Filters -->
  <form action="<?= $baseUrl ?>" method="get" class="flex flex-wrap items-center gap-4 mb-4">
    <div class="flex flex-grow items-center gap-2 search-doctor">
      <input type="text" class="input input-bordered w-full md:w-auto flex-grow" name="search" value="<?= $params->search ?>"
        placeholder="Search...">
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

    <input type="hidden" name="sort" value="<?= $params->sort; ?>">
    <input type="hidden" name="order" value="<?= $params->order; ?>">
  </form>

  <p class="text-gray-500/75 font-semibold mb-4">Doctor List</p>

  <div class="grid grid-cols-1 md:grid-cols-3 gap-4 select-doctor">
    <?php foreach ($doctors as $row): ?>
      <div class="card border bg-base-100 w-full">
        <div class="card-body">
          <div class="flex flex-col md:flex-row gap-4 items-center">
            <!-- Avatar -->
            <div class="avatar flex-shrink-0">
              <div class="w-16 h-16 lg:w-20 lg:h-20 rounded-full overflow-hidden">
                <img src="<?= base_url('profile-picture?path=' . $row->profile_picture); ?>"
                  alt="Profile Picture <?= $row->first_name . ' ' . $row->last_name; ?>"
                  class="object-cover w-full h-full">
              </div>
            </div>

            <!-- Doctor Info -->
            <div class="text-center md:text-left flex-grow">
              <h2 class="card-title lg:text-xl"><?= $row->first_name ?> <?= $row->last_name ?></h2>
              <p class="text-gray-500/75"><?= ucfirst($row->categoryName) ?></p>
              <p class="text-gray-500/75">HealthCare Hospital</p>
            </div>
          </div>

          <!-- Appointment Button -->
          <form action="/appointment/create/form">
            <div class="card-actions justify-end mt-4">
              <button type="submit" class="btn btn-primary w-full md:w-auto create-appointment">Create Appointment</button>
            </div>
            <input type="text" name="id" hidden value="<?= $row->id ?>">
          </form>
        </div>
      </div>
    <?php endforeach; ?>
  </div>

  <!-- Pagination -->
  <div class="mt-8 text-center">
    <?= $pager->links('doctors', 'custom_pager') ?>
    <div class="mt-2">
      <small>Show <?= count($doctors) ?> of <?= $total ?> total data (Page <?= $params->page ?>)</small>
    </div>
  </div>
</div>
<?= $this->endSection(); ?>

<?= $this->section('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/driver.js@latest/dist/driver.js.iife.js"></script>

<?php if (in_groups(Roles::PATIENT)): ?>
  <script>
    const isOnboardingDoctorList = sessionStorage.getItem('isOnboardingDoctorList');

    if (!isOnboardingDoctorList) {
      const driver = window.driver.js.driver;

      const driverObj = driver({
        showProgress: true,
        steps: [{
          element: ".search-doctor",
          popover: {
            title: 'Search Doctor',
            description: "Memilih dokter spesifik berdasarkan pencarian nama dokter."
          }
        }, {
          element: ".select-doctor",
          popover: {
            title: 'Select Doctor',
            description: "Memilih dokter berdasarkan spesialisasi atau kategori dokter yang dibutuhkan."
          }
        }, {
          element: ".create-appointment",
          popover: {
            title: "Create Appointment",
            description: "Tombol masuk ke halamana form appointment."
          }
        }]
      });

      driverObj.drive();

      sessionStorage.setItem('isOnboardingDoctorList', 'true');
    }
  </script>
<?php endif; ?>
<?= $this->endSection(); ?>
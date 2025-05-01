<?= $this->extend('layouts/admin_layout'); ?>

<?= $this->section('content'); ?>
<div class="container mt-4">
  <div class="flex gap-4 items-center mb-4">
    <h2 class="text-2xl font-bold">Appointment Details</h2>
    <?= view_cell('\App\Cells\StatusCell::getStatus', ['status' => $appointment->status]) ?>
  </div>
  <?php

  use CodeIgniter\I18n\Time;
  use Config\Roles;

  if (session('message')): ?>
    <div class="alert alert-error alert-soft mb-4">
      <?= session('message') ?>
    </div>
  <?php endif ?>
  <?php if (session('success')): ?>
    <div class="alert alert-success alert-soft mb-4">
      <?= session('success') ?>
    </div>
  <?php endif ?>

  <div class="card card-border bg-base-100 my-4 text-xl">
    <div class="card-body">
      <div class="grid grid-cols-3 gap-4">
        <div class="col-span-2">
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
          <hr class="my-4">
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
          <hr class="my-4">
        </div>

        <?php if ($appointment->status != 'cancel' && in_groups(Roles::PATIENT)): ?>


          <div class="col-span-1">
            <div class="card card-border alert alert-warning alert-soft w-full h-full">
              <div class="card-body items-center text-center">
                <h2 class="card-title font-bold">Notice</h2>
                You can CANCEL or RESCHEDULE your appointment up to <span class="font-bold text-xl text-red-700">3 days
                  before</span> the scheduled date.
                <br>
                Cancellations are not allowed within 3 days of the appointment.

                <?php
                $targetDate = date('Y-m-d', strtotime("-3 days"));
                $today = Time::parse('today');
                $diff = $today->difference($appointment->date)->getDays();
                if ($diff > 3):
                ?>
                  <div class="card-actions justify-end">
                    <form action="/appointment/cancel" method="post" novalidate id="cancelForm" name="cancelForm">
                      <?= csrf_field() ?>
                      <input type="hidden" name="_method" value="POST">
                      <input type="text" name="appointmentId" hidden value="<?= $appointment->id ?>">
                      <button form="cancelForm" type="submit" class="btn btn-error btn-sm"
                        onclick="return confirm('Are you sure want to cancel appointment?');">
                        Cancel Appointment
                      </button>
                    </form>

                    <form action="/appointment/reschedule/form" method="get">
                      <div class="card-actions justify-end">
                        <button type="submit" class="btn btn-info btn-sm ">Reschedule</button>
                      </div>
                      <input type="text" name="id" hidden value="<?= $appointment->doctorId ?>">
                      <input type="text" name="appointmentId" hidden value="<?= $appointment->id ?>">
                    </form>

                  </div>
                <?php endif; ?>

              </div>
            </div>
          </div>
        <?php endif; ?>
      </div>

      <?php if (!in_groups(Roles::ADMIN)): ?>
        <div role="alert" class="alert alert-info alert-soft">
          <span>Please reach 10-15 minutes before the appointment starts.</span>
        </div>
      <?php endif; ?>

      <p class="font-bold">Details</p>
      <span class="flex gap-2 items-center">
        <i class="fa-solid fa-calendar"></i>
        <?= date('F j, Y', strtotime($appointment->date)) ?></span>
      <span class="flex gap-2 items-center">
        <i class="fa-solid fa-clock"></i>
        <span><?= date('g:i A', strtotime($appointment->start_time)) ?> -
          <?= date('g:i A', strtotime($appointment->end_time)) ?></span>
      </span>
      <span class="flex gap-2 items-center">
        <i class="fa-solid fa-door-open"></i>
        <span>
          <?= $appointment->roomName ?>
        </span>
      </span>

      <span class="flex gap-2 items-center">
        <i class="fa-solid fa-location-dot text-lg"></i>
        <span>
          Rumah Sakit HealthCare
          Jl. Melati Raya No. 27
          Kelurahan Sukamaju, Kecamatan Serpong
          Tangerang Selatan, Banten 15310
        </span>
      </span>

      <span class="flex gap-2 items-center">
        <i class="fa-solid fa-phone"></i>
        <span>
          Telepon: (021) 555-7283</span>
      </span>

      <?php if (!empty($appointment->documents)): ?>
        <a href="<?= site_url('documents/' . $appointment->documents . '/' . $appointment->patientUserId) ?>"
          target="_blank" class="btn btn-outline btn-info w-fit">
          <i class="fa-solid fa-file"></i>
          Preview Document
        </a>
      <?php endif ?>
    </div>

  </div>
  <div class="flex justify-end">
    <?php if (in_groups(Roles::PATIENT)): ?>
      <a href="/appointment" class="btn btn-primary">Back</a>
    <?php elseif (in_groups(Roles::ADMIN)): ?>
      <a href="<?= base_url('admin/appointment'); ?>" class="btn btn-primary">Back</a>
    <?php endif; ?>
  </div>
</div>
<?= $this->endSection(); ?>
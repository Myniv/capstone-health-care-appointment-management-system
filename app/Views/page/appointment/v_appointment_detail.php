<?= $this->extend('layouts/admin_layout'); ?>

<?= $this->section('content'); ?>
<div class="container mx-auto mt-4">
  <h2 class="text-2xl font-bold mb-4">Appointment Details</h2>


  <div class="card card-border bg-base-100 my-4">
    <div class="card-body">
      <div class="flex">
        <img src="/images/placeholder.jpg" width="100" alt="">
        <div class="">
          <h2 class="card-title"><?= $appointment->first_name ?> <?= $appointment->last_name ?></h2>
          <p class="text-gray-500/75">EDUCATION</p>
          <p class="text-gray-500/75">DEGREE</p>
        </div>
      </div>
      <p class="font-bold">Date, Time & Room</p>
      <span><?= date('F j, Y', strtotime($appointment->date)) ?></span>
      <span>
        <?= date('g:i A', strtotime($appointment->start_time)) ?> -
        <?= date('g:i A', strtotime($appointment->end_time)) ?>
      </span>
      <span><?= $appointment->roomName ?></span>
      <div role="alert" class="alert alert-info alert-soft">
        <span>Please reach 10 minutes before the appointment starts.</span>
      </div>
      <p class="font-bold">Address</p>
      <span>Rumah Sakit Permata Harapan
        Jl. Melati Raya No. 27
        Kelurahan Sukamaju, Kecamatan Serpong
        Tangerang Selatan, Banten 15310 </span>
      <span>Telepon: (021) 555-7283</span>
    </div>

  </div>
  <div class="flex justify-end">
    <a href="/appointment" class="btn btn-primary">Back</a>
  </div>
</div>
<?= $this->endSection(); ?>
<?= $this->extend('layouts/admin_layout'); ?>

<?= $this->section('content'); ?>
<div class="container mx-auto mt-4">
  <!-- <h2 class="text-2xl font-bold mb-4"></h2> -->
  <h2 class="text-2xl font-bold mb-4"><?= 'Create Appointment'; ?></h2>


  <p class="text-gray-500/75 font-semibold mb-4">Doctor List</p>
  <?php foreach ($doctors as $row): ?>
    <div class="card card-border bg-base-100">
      <div class="card-body">
        <div class="flex">
          <img src="/images/placeholder.jpg" width="100" alt="">
          <div class="">
            <h2 class="card-title"><?= $row->first_name ?> <?= $row->last_name ?></h2>
            <p class="text-gray-500/75"><?= $row->education ?></p>
            <p class="text-gray-500/75"><?= $row->degree ?></p>
          </div>
        </div>
        <form action="/appointment/create/form">
          <div class="card-actions justify-end">
            <button type="submit" class="btn btn-primary w-full">Choose</button>
          </div>
          <input type="text" name="id" hidden value="<?= $row->id ?>">
        </form>
      </div>
    </div>

  <?php endforeach; ?>


</div>
<?= $this->endSection(); ?>
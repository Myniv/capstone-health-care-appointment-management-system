<?= $this->extend('layouts/admin_layout'); ?>

<?= $this->section('content'); ?>
<div class="container mx-auto mt-4">
  <!-- <h2 class="text-2xl font-bold mb-4"></h2> -->
  <h2 class="text-2xl font-bold mb-4"><?= 'Create Appointment'; ?></h2>

  <?php foreach ($doctors as $row): ?>

    <div class="card card-border bg-base-100 w-96">
      <div class="card-body">
        <h2 class="card-title"><?= $row->first_name ?> <?= $row->last_name ?></h2>
        <div class="card-actions justify-end">
          <a href="/appointment/create/<?= $row->id ?>" class="btn btn-primary">Choose</a>
        </div>
      </div>
    </div>

  <?php endforeach; ?>


</div>
<?= $this->endSection(); ?>
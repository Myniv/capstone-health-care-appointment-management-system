<?= $this->extend('layouts/admin_layout'); ?>

<?= $this->section('content'); ?>
<div class="container mx-auto mt-4">
  <!-- <h2 class="text-2xl font-bold mb-4"></h2> -->
  <h2 class="text-2xl font-bold mb-4">Create Appointment</h2>

  <form
    action="<?= base_url('doctor/absent/create') ?>"
    method="post" enctype="multipart/form-data" id="formData" novalidate>
    <?= csrf_field() ?>
    <input type="hidden" name="_method" value="POST">

    <!-- Name and Description -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">

    </div>

    <!-- Submit Button -->
    <div class="text-end">
      <button type="submit" class="btn btn-primary">Create</button>
      <a href="/appointment/create" class="btn btn-secondary">Cancel</a>
    </div>
  </form>
</div>
<?= $this->endSection(); ?>
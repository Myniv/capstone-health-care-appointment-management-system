<?= $this->extend('layouts/admin_layout'); ?>

<?= $this->section('content'); ?>
<div class="container mx-auto mt-4">
  <!-- <h2 class="text-2xl font-bold mb-4"></h2> -->
  <h2 class="text-2xl font-bold mb-4"><?= 'Add Absent'; ?></h2>

  <?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-error mb-4">
      <?= esc(session()->getFlashdata('error')) ?>
    </div>
  <?php endif; ?>

  <form
    action="<?= base_url('doctor/absent/create') ?>"
    method="post" enctype="multipart/form-data" id="formData" novalidate>
    <?= csrf_field() ?>
    <input type="hidden" name="_method" value="POST">

    <!-- Name and Description -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
      <div>
        <label for="name" class="label">
          <span class="label-text">Date</span>
        </label>
        <input type="date"
          name="date"
          class="input input-bordered w-full <?= session('errors.date') ? 'input-error' : '' ?>"
          required
          value="<?= old('date', $doctor_absent->date ?? '') ?>" />
      </div>

      <div>
        <label for="description" class="label">
          <span class="label-text">Reason</span>
        </label>
        <input type="text" name="reason"
          class="input input-bordered w-full <?= session('errors.reason') ? 'input-error' : '' ?>"
          value="<?= old('reason', $doctor_absent->reason ?? '') ?>" required />
        <div class="text-error text-sm"><?= session('errors.reason') ?? '' ?></div>
      </div>
    </div>

    <!-- Submit Button -->
    <div class="text-end">
      <button type="submit" class="btn btn-primary"><?= 'Request' ?> Absent</button>
      <a href="/doctor/absent" class="btn btn-secondary">Cancel</a>
    </div>
  </form>
</div>
<?= $this->endSection(); ?>
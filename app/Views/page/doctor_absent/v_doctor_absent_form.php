<?= $this->extend('layouts/admin_layout'); ?>

<?= $this->section('content'); ?>
<div class="mb-4">
  <?= view_cell('BackButtonCell', ['backLink' => null]) ?>
</div>
<h2 class="text-2xl font-bold mb-4"><?= 'Add Absent'; ?></h2>

<?php if (session()->getFlashdata('error')): ?>
  <div class="alert alert-error mb-4">
    <?= esc(session()->getFlashdata('error')) ?>
  </div>
<?php endif; ?>

<div class="bg-base-100 p-6 rounded-md shadow-md">
  <form action="<?= base_url('doctor/absent/create') ?>" method="post" enctype="multipart/form-data" id="formData"
    novalidate>
    <?= csrf_field() ?>
    <input type="hidden" name="_method" value="POST">

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
      <!-- Date -->
      <div class="mb-3">
        <label for="date" class="label">
          <span class="label-text">Date</span>
        </label>
        <input type="date" name="date" id="date"
          class="input input-bordered w-full <?= session('errors.date') ? 'input-error' : '' ?>"
          value="<?= old('date', $doctor_absent->date ?? '') ?>" data-pristine-required
          data-pristine-required-message="The date field is required.">
        <div class="text-error text-sm"><?= session('errors.date') ?? '' ?></div>
      </div>

      <!-- Reason -->
      <div class="mb-3">
        <label for="reason" class="label">
          <span class="label-text">Reason</span>
        </label>
        <input type="text" name="reason" id="reason"
          class="input input-bordered w-full <?= session('errors.reason') ? 'input-error' : '' ?>"
          value="<?= old('reason', $doctor_absent->reason ?? '') ?>" data-pristine-required
          data-pristine-required-message="The reason field is required." data-pristine-maxlength="255"
          data-pristine-maxlength-message="Reason must not exceed 255 characters.">
        <div class="text-error text-sm"><?= session('errors.reason') ?? '' ?></div>
      </div>
    </div>

    <!-- Submit Button -->
    <div class="text-end">
      <button type="submit" class="btn btn-primary">Request Absent</button>
      <a href="/doctor/absent" class="btn btn-secondary">Cancel</a>
    </div>
  </form>
</div>
<?= $this->endSection(); ?>

<?= $this->section('scripts') ?>
<script>
  window.onload = function() {
    const form = document.getElementById("formData");

    const pristine = new Pristine(form, {
      classTo: 'mb-3',
      errorClass: 'input-error',
      successClass: 'input-success',
      errorTextParent: 'mb-3',
      errorTextTag: 'div',
      errorTextClass: 'text-error text-sm'
    });

    form.addEventListener('submit', function(e) {
      const valid = pristine.validate();
      if (!valid) {
        e.preventDefault();
      }
    });
  };
</script>
<?= $this->endSection(); ?>
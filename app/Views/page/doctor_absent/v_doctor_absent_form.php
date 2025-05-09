<?= $this->extend('layouts/admin_layout'); ?>

<?= $this->section('content'); ?>
<div class="mb-4">
  <?= view_cell('BackButtonCell', ['backLink' => null]) ?>
</div>
<h2 class="text-2xl font-bold mb-4"><?= 'Add Absent'; ?></h2>

<div class="bg-base-100 p-6 rounded-md shadow-md">
  <?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-error alert-soft mb-4">
      <?= esc(session()->getFlashdata('error')) ?>
    </div>
  <?php endif; ?>
  <div class="alert alert-info alert-soft mb-4">
    <i class="fa-solid fa-exclamation"></i>You can add an absence with the minimum is 1 week from today.
  </div>
  <form action="<?= base_url('doctor/absent/create') ?>" method="post" enctype="multipart/form-data" id="formData"
    novalidate>
    <?= csrf_field() ?>
    <input type="hidden" name="_method" value="POST">
    <input type="text" name="date" id="date"
      class="hidden"
      value="<?= old('date', $doctor_absent->date ?? '') ?>"
      data-pristine-required
      data-pristine-required-message="The date field is required.">

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
      <!-- Date -->
      <div class="mb-3">
        <label for="date" class="label">
          <span class="label-text">Date</span>
        </label>
        <!-- <input type="date" name="date" id="date"
          class="input input-bordered w-full <?= session('errors.date') ? 'input-error' : '' ?>"
          min="<?= date('Y-m-d') ?>"
          value="<?= old('date', $doctor_absent->date ?? '') ?>"
          autocomplete="off" data-pristine-required
          data-pristine-required-message="The date field is required."> -->

        <input type="text" id="dateDisplay" class="input input-bordered w-full"
          autocomplete="off" readonly>
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
      <button type="submit" class="btn btn-primary">Add Absent</button>
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

    // Load existing value into display
    const realDate = document.getElementById("date");
    const dateDisplay = document.getElementById("dateDisplay");

    if (realDate.value) {
      try {
        const parsed = $.datepicker.parseDate("yy-mm-dd", realDate.value);
        const pretty = $.datepicker.formatDate("DD, dd MM yy", parsed);
        dateDisplay.value = pretty;
      } catch (e) {
        console.warn("Invalid initial date format:", e);
      }
    }

    // jQuery UI Datepicker
    $("#dateDisplay").datepicker({
      dateFormat: "DD, dd MM yy", // What user sees
      minDate: 7,
      altField: "#date", // Hidden ISO field to submit
      altFormat: "yy-mm-dd", // What gets submitted
      onSelect: function(dateText, inst) {
        const dateObj = $(this).datepicker("getDate");
        const isoDate = $.datepicker.formatDate("yy-mm-dd", dateObj);
        $("#date").val(isoDate);
      }
    });
  };
</script>
<?= $this->endSection(); ?>
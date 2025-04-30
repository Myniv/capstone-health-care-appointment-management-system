<?= $this->extend('layouts/admin_layout'); ?>
<?= $this->section('content'); ?>

<div class="container mx-auto mt-4">
  <div class="mb-4">
    <?= view_cell('BackButtonCell', ['backLink' => null]) ?>
  </div>
  <h2 class="text-2xl font-bold mb-4"><?= isset($education) ? 'Edit' : 'Add'; ?> Education</h2>

  <?php if (session('errors')): ?>
    <div class="alert alert-error mb-4">
      <ul>
        <?php foreach (session('errors') as $error): ?>
          <li><?= $error ?></li>
        <?php endforeach ?>
      </ul>
    </div>
  <?php endif ?>

  <form
    action="<?= isset($education) ? base_url('doctor/education/update/' . $education->id) : base_url('doctor/education/create') ?>"
    method="post" enctype="multipart/form-data" id="formData" novalidate>
    <?= csrf_field() ?>
    <?php if (isset($education)): ?>
      <input type="hidden" name="_method" value="PUT">
      <input type="hidden" name="education_id" value="<?= $education->id ?>">
    <?php endif; ?>
    <input type="hidden" name="doctor_id" value="<?= $doctor_id ?>" data-pristine-required
      data-pristine-required-message="Doctor ID is required.">

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">

      <div class="mb-3">
        <label class="label"><span class="label-text">Degree</span></label>
        <select name="degree"
          class="select select-bordered w-full <?= session('errors.degree') ? 'select-error' : '' ?>"
          data-pristine-required data-pristine-required-message="Degree must be filled.">
          <option value="">Select Degree</option>
          <option value="Bachelor" <?= old('degree', $education->degree ?? '') == 'Bachelor' ? 'selected' : '' ?>>Bachelor
          </option>
          <option value="Master" <?= old('degree', $education->degree ?? '') == 'Master' ? 'selected' : '' ?>>Master
          </option>
          <option value="Doctor" <?= old('degree', $education->degree ?? '') == 'Doctor' ? 'selected' : '' ?>>Doctor
          </option>
        </select>
        <div class="text-error text-sm"><?= session('errors.degree') ?? '' ?></div>
      </div>

      <div class="mb-3">
        <label for="study_program" class="label"><span class="label-text">Major</span></label>
        <input type="text" name="study_program"
          class="input input-bordered w-full <?= session('errors.study_program') ? 'input-error' : '' ?>"
          value="<?= old('study_program', $education->study_program ?? '') ?>" data-pristine-required
          data-pristine-required-message="Major must be filled.">
        <div class="text-error text-sm"><?= session('errors.study_program') ?? '' ?></div>
      </div>

      <div class="mb-3">
        <label for="university" class="label"><span class="label-text">University</span></label>
        <input type="text" name="university"
          class="input input-bordered w-full <?= session('errors.university') ? 'input-error' : '' ?>"
          value="<?= old('university', $education->university ?? '') ?>" data-pristine-required
          data-pristine-required-message="University must be filled.">
        <div class="text-error text-sm"><?= session('errors.university') ?? '' ?></div>
      </div>

      <div class="mb-3">
        <label for="city" class="label"><span class="label-text">City</span></label>
        <input type="text" name="city"
          class="input input-bordered w-full <?= session('errors.city') ? 'input-error' : '' ?>"
          value="<?= old('city', $education->city ?? '') ?>" data-pristine-required
          data-pristine-required-message="City must be filled.">
        <div class="text-error text-sm"><?= session('errors.city') ?? '' ?></div>
      </div>

      <div class="mb-3">
        <label for="year" class="label"><span class="label-text">Year</span></label>
        <input type="text" name="year" placeholder="<?= date("Y"); ?>"
          class="input input-bordered w-full <?= session('errors.year') ? 'input-error' : '' ?>"
          value="<?= old('year', $education->year ?? '') ?>" data-pristine-required
          data-pristine-required-message="Year must be filled." data-pristine-type="number"
          data-pristine-type-message="Year cant be string." data-pristine-maxlength="4"
          data-pristine-maxlength-message="Year must be 4 character." data-pristine-minlength="4"
          data-pristine-minlength-message="Year must be 4 character.">
        <div class="text-error text-sm"><?= session('errors.year') ?? '' ?></div>
      </div>
    </div>

    <div class="text-end">
      <button type="submit" class="btn btn-primary"><?= isset($education) ? 'Update' : 'Save' ?> Education</button>
    </div>
  </form>
</div>

<?= $this->endSection(); ?>

<?= $this->section('scripts') ?>
<script>
  window.onload = function () {
    let form = document.getElementById("formData");

    let pristine = new Pristine(form, {
      classTo: 'mb-3',
      errorClass: 'input-error',
      successClass: 'input-success',
      errorTextParent: 'mb-3',
      errorTextTag: 'div',
      errorTextClass: 'text-error text-sm'
    });

    form.addEventListener('submit', function (e) {
      let valid = pristine.validate();
      if (!valid) {
        e.preventDefault();
      }
    });
  };
</script>
<?= $this->endSection(); ?>
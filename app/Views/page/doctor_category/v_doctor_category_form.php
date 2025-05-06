<?= $this->extend('layouts/admin_layout'); ?>

<?= $this->section('content'); ?>
<div class="mb-4">
    <?= view_cell('BackButtonCell', ['backLink' => null]) ?>
</div>

<h2 class="text-2xl font-bold mb-4">
    <?= isset($doctor_category) ? 'Edit Category' : 'Add Category'; ?>
</h2>

<div class="bg-base-100 p-6 rounded-md shadow-md">
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-error alert-soft mb-3">
            <?= esc(session()->getFlashdata('error')) ?>
        </div>
    <?php endif; ?>

    <form
        action="<?= isset($doctor_category) ? base_url('admin/doctor-category/update/' . $doctor_category->id) : base_url('admin/doctor-category/create') ?>"
        method="post" enctype="multipart/form-data" id="formData" novalidate>
        <?= csrf_field() ?>
        <?php if (isset($doctor_category)): ?>
            <input type="hidden" name="_method" value="PUT">
        <?php endif; ?>

        <!-- Name & Description -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <!-- Name -->
            <div class="mb-3">
                <label for="name" class="label">
                    <span class="label-text">Name</span>
                </label>
                <input type="text" name="name" id="name"
                    class="input input-bordered w-full <?= session('errors.name') ? 'input-error' : '' ?>"
                    value="<?= old('name', $doctor_category->name ?? '') ?>" data-pristine-required
                    data-pristine-required-message="Category name is required." data-pristine-maxlength="255"
                    data-pristine-maxlength-message="Category name must not exceed 255 characters.">
                <div class="text-error text-sm"><?= session('errors.name') ?? '' ?></div>
            </div>

            <!-- Description -->
            <div class="mb-3">
                <label for="description" class="label">
                    <span class="label-text">Description</span>
                </label>
                <input type="text" name="description" id="description"
                    class="input input-bordered w-full <?= session('errors.description') ? 'input-error' : '' ?>"
                    value="<?= old('description', $doctor_category->description ?? '') ?>" data-pristine-required
                    data-pristine-required-message="Category description is required." data-pristine-maxlength="255"
                    data-pristine-maxlength-message="Category description must not exceed 255 characters.">
                <div class="text-error text-sm"><?= session('errors.description') ?? '' ?></div>
            </div>
        </div>

        <!-- Submit -->
        <div class="text-end">
            <button type="submit" class="btn btn-primary">
                <?= isset($doctor_category) ? 'Update' : 'Save' ?> Category
            </button>
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
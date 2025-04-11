<?= $this->extend('layouts/admin_layout'); ?>

<?= $this->section('content'); ?>
<div class="container mx-auto mt-4">
    <h2 class="text-2xl font-bold mb-4"><?= isset($doctor_category) ? 'Edit Category' : 'Add Category'; ?></h2>

    <form
        action="<?= isset($doctor_category) ? base_url('admin/doctor-category/update/' . $doctor_category->id) : base_url('admin/doctor-category/create') ?>"
        method="post" enctype="multipart/form-data" id="formData" novalidate>
        <?= csrf_field() ?>
        <?php if (isset($doctor_category)): ?>
            <input type="hidden" name="_method" value="PUT">
        <?php endif; ?>

        <!-- Name and Description -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
                <label for="name" class="label">
                    <span class="label-text">Name</span>
                </label>
                <input type="text" name="name"
                    class="input input-bordered w-full <?= session('errors.name') ? 'input-error' : '' ?>"
                    value="<?= old('name', $doctor_category->name ?? '') ?>" required>
                <div class="text-error text-sm"><?= session('errors.name') ?? '' ?></div>
            </div>

            <div>
                <label for="description" class="label">
                    <span class="label-text">Description</span>
                </label>
                <input type="text" name="description"
                    class="input input-bordered w-full <?= session('errors.description') ? 'input-error' : '' ?>"
                    value="<?= old('description', $doctor_category->description ?? '') ?>" required>
                <div class="text-error text-sm"><?= session('errors.description') ?? '' ?></div>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="text-end">
            <button type="submit" class="btn btn-primary"><?= isset($doctor_category) ? 'Update' : 'Save' ?> Category</button>
        </div>
    </form>
</div>
<?= $this->endSection(); ?>
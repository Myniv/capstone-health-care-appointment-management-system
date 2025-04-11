<div class="container mt-4 mb-4">
    <div class="card">
        <div class="card-header bg-dark text-white">
            <h4 class="mb-3"><?= isset($doctor_category) ? 'Edit Category' : 'Add Category'; ?></h4>
        </div>
        <div class="card-body">
            <form
                action="<?= isset($doctor_category) ? base_url('admin/doctor-category/update/' . $doctor_category->id) : base_url('admin/doctor-category/create') ?>"
                method="post" enctype="multipart/form-data" id="formData" novalidate>
                <?= csrf_field() ?>
                <?php if (isset($doctor_category)): ?>
                    <input type="hidden" name="_method" value="PUT">
                <?php endif; ?>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" name="name"
                            class="form-control <?= session('errors.name') ? 'is-invalid' : '' ?>"
                            value="<?= old('name', $doctor_category->name ?? '') ?>" required>
                        <div class="text-danger"><?= session('errors.name') ?? '' ?></div>
                    </div>

                    <div class="col-md-6">
                        <label for="description" class="form-label">Description</label>
                        <input type="text" name="description"
                            class="form-control <?= session('errors.description') ? 'is-invalid' : '' ?>"
                            value="<?= old('description', $doctor_category->description ?? '') ?>" required>
                        <div class="text-danger"><?= session('errors.description') ?? '' ?></div>
                    </div>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-primary"><?= isset($doctor_category) ? 'Update' : 'Save' ?>
                        Category</button>
                </div>
            </form>
        </div>
    </div>
</div>
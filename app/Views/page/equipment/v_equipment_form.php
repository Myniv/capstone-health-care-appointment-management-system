<?= $this->extend('layouts/admin_layout'); ?>

<?= $this->section('content'); ?>
<div class="container mx-auto mt-4">
    <h2 class="text-2xl font-bold mb-4"><?= isset($equipment) ? 'Edit Equipment' : 'Add Equipment'; ?></h2>

    <form
        action="<?= isset($equipment) ? base_url('admin/equipment/update/' . $equipment->id) : base_url('admin/equipment/create') ?>"
        method="post" enctype="multipart/form-data" id="formData" novalidate>
        <?= csrf_field() ?>
        <?php if (isset($equipment)): ?>
            <input type="hidden" name="_method" value="PUT">
        <?php endif; ?>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">

            <!-- Name -->
            <div>
                <label for="name" class="label">
                    <span class="label-text">Name</span>
                </label>
                <input type="text" name="name"
                    class="input input-bordered w-full <?= session('errors.name') ? 'input-error' : '' ?>"
                    value="<?= old('name', $equipment->name ?? '') ?>" maxlength="100" required />
                <div class="text-error text-sm"><?= session('errors.name') ?? '' ?></div>
            </div>

            <!-- Function -->
            <div>
                <label for="function" class="label">
                    <span class="label-text">Function</span>
                </label>
                <input type="text" name="function"
                    class="input input-bordered w-full <?= session('errors.function') ? 'input-error' : '' ?>"
                    value="<?= old('function', $equipment->function ?? '') ?>" maxlength="100" required />
                <div class="text-error text-sm"><?= session('errors.function') ?? '' ?></div>
            </div>

            <!-- Stock -->
            <div>
                <label for="stock" class="label">
                    <span class="label-text">Stock</span>
                </label>
                <input type="number" name="stock"
                    class="input input-bordered w-full <?= session('errors.stock') ? 'input-error' : '' ?>"
                    value="<?= old('stock', $equipment->stock ?? '') ?>" maxlength="11" min="0" required />
                <div class="text-error text-sm"><?= session('errors.stock') ?? '' ?></div>
            </div>

            <!-- Status -->
            <div>
                <label for="status" class="label">
                    <span class="label-text">Status</span>
                </label>
                <select name="status"
                    class="select select-bordered w-full <?= session('errors.status') ? 'select-error' : '' ?>"
                    required>
                    <option value="" disabled <?= old('status', $equipment->status ?? '') == '' ? 'selected' : '' ?>>--
                        Select Status --</option>
                    <option value="Maintenance" <?= old('status', $equipment->status ?? '') == 'Maintenance' ? 'selected' : '' ?>>Maintenance</option>
                    <option value="Available" <?= old('status', $equipment->status ?? '') == 'Available' ? 'selected' : '' ?>>Available</option>
                    <option value="Out of Stock" <?= old('status', $equipment->status ?? '') == 'Out of Stock' ? 'selected' : '' ?>>Out of Stock</option>
                </select>
                <div class="text-error text-sm"><?= session('errors.status') ?? '' ?></div>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="text-end">
            <button type="submit" class="btn btn-primary">
                <?= isset($equipment) ? 'Update' : 'Add' ?> Equipment
            </button>
        </div>
    </form>
</div>
<?= $this->endSection(); ?>
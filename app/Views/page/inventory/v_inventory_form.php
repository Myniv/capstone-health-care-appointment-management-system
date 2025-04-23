<?= $this->extend('layouts/admin_layout'); ?>

<?= $this->section('content'); ?>
<div class="container mx-auto mt-4">
    <h2 class="text-2xl font-bold mb-4"><?= isset($inventory) ? 'Edit Inventory' : 'Add Inventory'; ?></h2>

    <form
        action="<?= isset($inventory) ? base_url('admin/inventory/update/' . $inventory->id) : base_url('admin/inventory/create') ?>"
        method="post" enctype="multipart/form-data" id="formData" novalidate>
        <?= csrf_field() ?>
        <?php if (isset($inventory)): ?>
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
                    value="<?= old('name', $inventory->name ?? '') ?>" maxlength="100" required />
                <div class="text-error text-sm"><?= session('errors.name') ?? '' ?></div>
            </div>
            
            <div>
                <label for="status" class="label">
                    <span class="label-text">Status</span>
                </label>
                <select class="select select-bordered w-full <?= session('errors.status') ? 'select-error' : '' ?>"
                    name="status" required>
                    <option value="">Select Status</option>
                    <option value="Available" <?= old('status', $inventory->status ?? '') === 'Available' ? 'selected' : '' ?>>Available</option>
                    <option value="In Use" <?= old('status', $inventory->status ?? '') === 'In Use' ? 'selected' : '' ?>>In
                        Use</option>
                    <option value="Maintenance" <?= old('status', $inventory->status ?? '') === 'Maintenance' ? 'selected' : '' ?>>Maintenance</option>
                </select>
                <div class="text-error text-sm"><?= session('errors.status') ?? '' ?></div>
            </div>
        </div>

        <!-- Function -->
        <div>
            <label for="function" class="label">
                <span class="label-text">Function</span>
            </label>
            <input type="text" name="function"
                class="input input-bordered w-full <?= session('errors.function') ? 'input-error' : '' ?>"
                value="<?= old('function', $inventory->function ?? '') ?>" maxlength="100" required />
            <div class="text-error text-sm"><?= session('errors.function') ?? '' ?></div>
        </div>

        <!-- Submit Button -->
        <div class="text-end mt-4">
            <button type="submit" class="btn btn-primary">
                <?= isset($inventory) ? 'Update' : 'Add' ?> Inventory
            </button>
        </div>
    </form>
</div>
<?= $this->endSection(); ?>
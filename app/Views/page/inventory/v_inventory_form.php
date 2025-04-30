<?= $this->extend('layouts/admin_layout'); ?>

<?= $this->section('content'); ?>
<div class="container mx-auto mt-4">
<div class="mb-4">
        <?= view_cell('BackButtonCell', ['backLink' => null]) ?>
    </div>
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
            <div class="mb-4">
                <label for="name" class="label">
                    <span class="label-text">Name</span>
                </label>
                <input type="text" name="name" id="name" class="input input-bordered w-full" maxlength="100"
                    value="<?= old('name', $inventory->name ?? '') ?>" required
                    data-pristine-required-message="The name field is required."
                    data-pristine-maxlength-message="The name must not exceed 100 characters." />
            </div>

            <!-- Status -->
            <div class="mb-4">
                <label for="status" class="label">
                    <span class="label-text">Status</span>
                </label>
                <select name="status" id="status" class="select select-bordered w-full" required
                    data-pristine-required-message="The status field is required."
                    data-pristine-in-list="Available,In Use,Maintenance"
                    data-pristine-in-list-message='The status must be either "Available", "Maintenance" or "In Use".'>
                    <option value="">Select Status</option>
                    <option value="Available" <?= old('status', $inventory->status ?? '') === 'Available' ? 'selected' : '' ?>>Available</option>
                    <option value="In Use" <?= old('status', $inventory->status ?? '') === 'In Use' ? 'selected' : '' ?>>In
                        Use</option>
                    <option value="Maintenance" <?= old('status', $inventory->status ?? '') === 'Maintenance' ? 'selected' : '' ?>>Maintenance</option>
                </select>
            </div>
        </div>

        <!-- Function -->
        <div class="mb-4">
            <label for="function" class="label">
                <span class="label-text">Function</span>
            </label>
            <input type="text" name="function" id="function" class="input input-bordered w-full" maxlength="100"
                value="<?= old('function', $inventory->function ?? '') ?>" required
                data-pristine-required-message="The function field is required."
                data-pristine-maxlength-message="The function must not exceed 100 characters." />
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

<?= $this->section('scripts') ?>
<!-- PristineJS -->
<script>
    // Custom validator for in_list rule
    Pristine.addValidator("in-list", function (value, list) {
        const allowed = list.split(',').map(item => item.trim());
        return allowed.includes(value);
    });

    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('formData');
        const pristine = new Pristine(form, {
            classTo: 'mb-4',
            errorClass: 'input-error',
            successClass: 'input-success',
            errorTextParent: 'mb-4',
            errorTextTag: 'div',
            errorTextClass: 'text-error text-sm'
        });

        form.addEventListener('submit', function (e) {
            if (!pristine.validate()) {
                e.preventDefault();
            }
        });
    });
</script>
<?= $this->endSection(); ?>
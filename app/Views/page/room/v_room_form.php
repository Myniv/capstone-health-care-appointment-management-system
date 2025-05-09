<?= $this->extend('layouts/admin_layout'); ?>

<?= $this->section('content'); ?>
<div class="mb-4">
    <?= view_cell('BackButtonCell', ['backLink' => null]) ?>
</div>

<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-error mb-3">
        <?= esc(session()->getFlashdata('error')) ?>
    </div>
<?php endif; ?>


<div class="bg-base-100 p-6 rounded-md shadow-md">
    <h2 class="text-2xl font-bold mb-4"><?= isset($room) ? 'Edit Room' : 'Add Room'; ?></h2>

    <form action="<?= isset($room) ? base_url('admin/room/update/' . $room->id) : base_url('admin/room/create') ?>"
        method="post" enctype="multipart/form-data" id="formData" novalidate>
        <?= csrf_field() ?>
        <?php if (isset($room)): ?>
            <input type="hidden" name="_method" value="PUT">
        <?php endif; ?>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <!-- Name -->
            <div class="mb-3">
                <label for="name" class="label">
                    <span class="label-text">Name</span>
                </label>
                <input type="text" name="name"
                    class="input input-bordered w-full <?= session('errors.name') ? 'input-error' : '' ?>"
                    value="<?= old('name', $room->name ?? '') ?>" maxlength="100" required data-pristine-required
                    data-pristine-required-message="The name field is required." data-pristine-maxlength="100"
                    data-pristine-maxlength-message="The name must not exceed 100 characters." />
                <div class="text-error text-sm"><?= session('errors.name') ?? '' ?></div>
            </div>

            <!-- Function -->
            <div class="mb-3">
                <label for="function" class="label">
                    <span class="label-text">Function</span>
                </label>
                <input type="text" name="function"
                    class="input input-bordered w-full <?= session('errors.function') ? 'input-error' : '' ?>"
                    value="<?= old('function', $room->function ?? '') ?>" maxlength="100" required
                    data-pristine-required data-pristine-required-message="The function field is required."
                    data-pristine-maxlength="100"
                    data-pristine-maxlength-message="The function must not exceed 100 characters." />
                <div class="text-error text-sm"><?= session('errors.function') ?? '' ?></div>
            </div>
        </div>

        <!-- Status -->
        <div class="mb-3">
            <label for="status" class="label">
                <span class="label-text">Status</span>
            </label>
            <select name="status"
                class="select select-bordered w-full <?= session('errors.status') ? 'input-error' : '' ?>" required
                data-pristine-required data-pristine-required-message="The status field is required."
                data-pristine-maxlength="20"
                data-pristine-maxlength-message="The status must not exceed 20 characters.">
                <option value="">Select Status</option>
                <option value="Active" <?= old('status', $room->status ?? '') === 'Active' ? 'selected' : '' ?>>Active
                </option>
                <option value="Inactive" <?= old('status', $room->status ?? '') === 'Inactive' ? 'selected' : '' ?>>
                    Inactive</option>
            </select>
            <div class="text-error text-sm"><?= session('errors.status') ?? '' ?></div>
        </div>

        <!-- Submit Button -->
        <div class="text-end mt-4">
            <button type="submit" class="btn btn-primary">
                <?= isset($room) ? 'Update' : 'Add' ?> Room
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
            if (!pristine.validate()) {
                e.preventDefault();
            }
        });
    };
</script>
<?= $this->endSection(); ?>
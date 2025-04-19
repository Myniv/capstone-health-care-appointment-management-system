<?= $this->extend('layouts/admin_layout'); ?>

<?= $this->section('content'); ?>
<div class="container mx-auto mt-4">
    <h2 class="text-2xl font-bold mb-4"><?= isset($room) ? 'Edit Room' : 'Add Room'; ?></h2>

    <form action="<?= isset($room) ? base_url('admin/room/update/' . $room->id) : base_url('admin/room/create') ?>"
        method="post" enctype="multipart/form-data" id="formData" novalidate>
        <?= csrf_field() ?>
        <?php if (isset($room)): ?>
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
                    value="<?= old('name', $room->name ?? '') ?>" maxlength="100" required />
                <div class="text-error text-sm"><?= session('errors.name') ?? '' ?></div>
            </div>

            <!-- Function -->
            <div>
                <label for="function" class="label">
                    <span class="label-text">Function</span>
                </label>
                <input type="text" name="function"
                    class="input input-bordered w-full <?= session('errors.function') ? 'input-error' : '' ?>"
                    value="<?= old('function', $room->function ?? '') ?>" maxlength="100" required />
                <div class="text-error text-sm"><?= session('errors.function') ?? '' ?></div>
            </div>

            <!-- Status -->
            <div>
                <label for="status" class="label">
                    <span class="label-text">Status</span>
                </label>
                <select name="status"
                    class="select select-bordered w-full <?= session('errors.status') ? 'select-error' : '' ?>"
                    required>
                    <option value="" disabled <?= old('status', $room->status ?? '') == '' ? 'selected' : '' ?>>--
                        Select Status --</option>
                    <option value="Active" <?= old('status', $room->status ?? '') == 'Active' ? 'selected' : '' ?>>
                        Active</option>
                    <option value="Inactive" <?= old('status', $room->status ?? '') == 'Inactive' ? 'selected' : '' ?>>
                        Inactive</option>
                </select>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="text-end">
            <button type="submit" class="btn btn-primary">
                <?= isset($room) ? 'Update' : 'Add' ?> Room
            </button>
        </div>
    </form>
</div>
<?= $this->endSection(); ?>
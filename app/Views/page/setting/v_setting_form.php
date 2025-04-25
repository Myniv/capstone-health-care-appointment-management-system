<?= $this->extend('layouts/admin_layout'); ?>

<?= $this->section('content'); ?>
<div class="container mx-auto mt-4">
    <h2 class="text-2xl font-bold mb-4"><?= isset($setting) ? 'Edit Setting' : 'Add Setting'; ?></h2>

    <form
        action="<?= isset($setting) ? base_url('admin/setting/update/' . $setting->id) : base_url('admin/setting/create') ?>"
        method="post" enctype="multipart/form-data" id="formData" novalidate>
        <?= csrf_field() ?>
        <?php if (isset($setting)): ?>
            <input type="hidden" name="_method" value="PUT">
        <?php endif; ?>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">

            <!-- Name -->
            <div>
                <label for="key" class="label">
                    <span class="label-text">Key</span>
                </label>
                <input type="text" name="key"
                    class="input input-bordered w-full <?= session('errors.key') ? 'input-error' : '' ?>"
                    value="<?= old('key', $setting->key ?? '') ?>" maxlength="100" required />
                <div class="text-error text-sm"><?= session('errors.key') ?? '' ?></div>
            </div>
            <div>
                <label for="value" class="label">
                    <span class="label-text">Value</span>
                </label>
                <input type="text" name="value"
                    class="input input-bordered w-full <?= session('errors.value') ? 'input-error' : '' ?>"
                    value="<?= old('value', $setting->value ?? '') ?>" maxlength="100" required />
                <div class="text-error text-sm"><?= session('errors.value') ?? '' ?></div>
            </div>

            <!-- Function -->

        </div>
        <div>
            <label for="description" class="label">
                <span class="label-text">Description</span>
            </label>
            <input type="text" name="description"
                class="input input-bordered w-full <?= session('errors.description') ? 'input-error' : '' ?>"
                value="<?= old('description', $setting->description ?? '') ?>" maxlength="100" required />
            <div class="text-error text-sm"><?= session('errors.description') ?? '' ?></div>
        </div>

        <!-- Submit Button -->
        <div class="text-end">
            <button type="submit" class="btn btn-primary">
                <?= isset($setting) ? 'Update' : 'Add' ?> Setting
            </button>
        </div>
    </form>
</div>
<?= $this->endSection(); ?>
<?= $this->extend('layouts/admin_layout'); ?>

<?= $this->section('content'); ?>
<div class="container mx-auto mt-4">
    <div class="mb-4">
        <?= view_cell('BackButtonCell', ['backLink' => null]) ?>
    </div>
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
            <div class="mb-3">
                <label for="key" class="label">
                    <span class="label-text">Key</span>
                </label>
                <input type="text" name="key"
                    class="input input-bordered w-full <?= session('errors.key') ? 'input-error' : '' ?>"
                    value="<?= old('key', $setting->key ?? '') ?>" maxlength="100" required
                    data-pristine-required-message="The key field is required." />
                <div class="text-error text-sm"><?= session('errors.key') ?? '' ?></div>
            </div>
            <div class="mb-3">
                <label for="value" class="label">
                    <span class="label-text">Value</span>
                </label>
                <input type="text" name="value"
                    class="input input-bordered w-full <?= session('errors.value') ? 'input-error' : '' ?>"
                    value="<?= old('value', $setting->value ?? '') ?>" maxlength="100" required
                    data-pristine-required-message="The value field is required." />

                <div class="text-error text-sm"><?= session('errors.value') ?? '' ?></div>
            </div>

            <!-- Function -->

        </div>
        <div class="mb-3">
            <label for="description" class="label">
                <span class="label-text">Description</span>
            </label>
            <input type="text" name="description"
                class="input input-bordered w-full <?= session('errors.description') ? 'input-error' : '' ?>"
                value="<?= old('description', $setting->description ?? '') ?>" required
                data-pristine-required-message="The description field is required." data-pristine-maxlength="100"
                data-pristine-maxlength-message="Description must not exceed 255 characters." />

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
<?= $this->section('scripts'); ?>
<!-- Include Pristine JS -->
<script src="<?= base_url('public/assets/js/pristine/pristine.min.js') ?>"></script>

<script>
    window.onload = function () {
        const form = document.getElementById("formData");

        const pristine = new Pristine(form, {
            classTo: 'mb-3',
            errorClass: 'input-error',
            successClass: 'input-success',
            errorTextParent: 'mb-3',
            errorTextTag: 'div',
            errorTextClass: 'text-error text-sm'
        });

        form.addEventListener('submit', function (e) {
            if (!pristine.validate()) {
                e.preventDefault();
            }
        });
    };
</script>
<?= $this->endSection(); ?>
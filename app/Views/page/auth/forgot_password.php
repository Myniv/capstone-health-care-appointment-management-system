<?= $this->extend('layouts/auth_layout') ?>

<?= $this->section('content') ?>

<div class="w-full max-w-md bg-base-100 p-6 rounded-lg shadow-md">
    <h2 class="text-2xl font-bold text-center mb-4"><?= lang('Auth.forgotPassword') ?></h2>

    <?= view('Myth\Auth\Views\_message_block') ?>

    <p><?= lang('Auth.enterEmailForInstructions') ?></p>

    <form action="<?= url_to('forgot') ?>" method="post">
        <?= csrf_field() ?>

        <!-- Email Field -->
        <div class="mb-4">
            <label for="email" class="label">
                <span class="label-text"><?= lang('Auth.emailAddress') ?></span>
            </label>
            <input type="email" name="email" placeholder="<?= lang('Auth.emailAddress') ?>"
                class="input input-bordered w-full <?= session('errors.email') ? 'input-error' : '' ?>"
                value="<?= old('email') ?>">
            <div class="text-error text-sm mt-1"><?= session('errors.email') ?></div>
        </div>

        <!-- Submit Button -->
        <div class="mb-4">
            <button type="submit" class="btn btn-primary w-full"><?= lang('Auth.sendInstructions') ?></button>
        </div>
    </form>
</div>

<?= $this->endSection() ?>
<?= $this->extend('layouts/auth_layout') ?>

<?= $this->section('content') ?>

<div class="w-full max-w-md bg-base-100 p-6 rounded-lg shadow-md">
    <h2 class="text-2xl font-bold text-center mb-4"><?= lang('Auth.resetYourPassword') ?></h2>

    <?= view('Myth\Auth\Views\_message_block') ?>

    <p class="mb-4"><?= lang('Auth.enterCodeEmailPassword') ?></p>

    <form action="<?= url_to('reset-password') ?>" method="post">
        <?= csrf_field() ?>

        <!-- Token Field -->
        <div class="mb-4">
            <label for="token" class="label">
                <span class="label-text"><?= lang('Auth.token') ?></span>
            </label>
            <input type="text" name="token" placeholder="<?= lang('Auth.token') ?>"
                class="input input-bordered w-full <?= session('errors.token') ? 'input-error' : '' ?>"
                value="<?= old('token', $token ?? '') ?>">
            <div class="text-error text-sm mt-1"><?= session('errors.token') ?></div>
        </div>

        <!-- Email Field -->
        <div class="mb-4">
            <label for="email" class="label">
                <span class="label-text"><?= lang('Auth.email') ?></span>
            </label>
            <input type="email" name="email" placeholder="<?= lang('Auth.email') ?>"
                class="input input-bordered w-full <?= session('errors.email') ? 'input-error' : '' ?>"
                value="<?= old('email') ?>">
            <div class="text-error text-sm mt-1"><?= session('errors.email') ?></div>
        </div>

        <!-- New Password Field -->
        <div class="mb-4">
            <label for="password" class="label">
                <span class="label-text"><?= lang('Auth.newPassword') ?></span>
            </label>
            <input type="password" name="password" placeholder="<?= lang('Auth.newPassword') ?>"
                class="input input-bordered w-full <?= session('errors.password') ? 'input-error' : '' ?>">
            <div class="text-error text-sm mt-1"><?= session('errors.password') ?></div>
        </div>

        <!-- Confirm New Password Field -->
        <div class="mb-4">
            <label for="pass_confirm" class="label">
                <span class="label-text"><?= lang('Auth.newPasswordRepeat') ?></span>
            </label>
            <input type="password" name="pass_confirm" placeholder="<?= lang('Auth.newPasswordRepeat') ?>"
                class="input input-bordered w-full <?= session('errors.pass_confirm') ? 'input-error' : '' ?>">
            <div class="text-error text-sm mt-1"><?= session('errors.pass_confirm') ?></div>
        </div>

        <!-- Submit Button -->
        <div class="mb-4">
            <button type="submit" class="btn btn-primary w-full"><?= lang('Auth.loginAction') ?></button>
        </div>
    </form>
</div>

<?= $this->endSection() ?>
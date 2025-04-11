<?= $this->extend('layouts/auth_layout') ?>

<?= $this->section('content') ?>

<div class="w-full max-w-md bg-base-100 p-6 rounded-lg shadow-md">
    <h2 class="text-2xl font-bold text-center mb-4"><?= lang('Auth.register') ?></h2>

    <form action="<?= url_to('register') ?>" method="post">
        <?= csrf_field() ?>

        <!-- Email Field -->
        <div class="mb-4">
            <label for="email" class="label">
                <span class="label-text"><?= lang('Auth.email') ?></span>
            </label>
            <input type="email" name="email" placeholder="<?= lang('Auth.email') ?>"
                class="input input-bordered w-full <?= session('errors.email') ? 'input-error' : '' ?>" value="<?= old('email') ?>">
            <small class="text-sm text-gray-500"><?= lang('Auth.weNeverShare') ?></small>
            <div class="text-error text-sm mt-1"><?= session('errors.email') ?></div>
        </div>

        <!-- Username Field -->
        <div class="mb-4">
            <label for="username" class="label">
                <span class="label-text"><?= lang('Auth.username') ?></span>
            </label>
            <input type="text" name="username" placeholder="<?= lang('Auth.username') ?>"
                class="input input-bordered w-full <?= session('errors.username') ? 'input-error' : '' ?>" value="<?= old('username') ?>">
            <div class="text-error text-sm mt-1"><?= session('errors.username') ?></div>
        </div>

        <!-- Password Field -->
        <div class="mb-4">
            <label for="password" class="label">
                <span class="label-text"><?= lang('Auth.password') ?></span>
            </label>
            <input type="password" name="password" placeholder="<?= lang('Auth.password') ?>"
                class="input input-bordered w-full <?= session('errors.password') ? 'input-error' : '' ?>" autocomplete="off">
            <div class="text-error text-sm mt-1"><?= session('errors.password') ?></div>
        </div>

        <!-- Confirm Password Field -->
        <div class="mb-4">
            <label for="pass_confirm" class="label">
                <span class="label-text"><?= lang('Auth.repeatPassword') ?></span>
            </label>
            <input type="password" name="pass_confirm" placeholder="<?= lang('Auth.repeatPassword') ?>"
                class="input input-bordered w-full <?= session('errors.pass_confirm') ? 'input-error' : '' ?>" autocomplete="off">
            <div class="text-error text-sm mt-1"><?= session('errors.pass_confirm') ?></div>
        </div>

        <!-- Submit Button -->
        <div class="mb-4">
            <button type="submit" class="btn btn-primary w-full"><?= lang('Auth.register') ?></button>
        </div>
    </form>

    <hr class="my-4">

    <!-- Links -->
    <div class="text-center">
        <p><?= lang('Auth.alreadyRegistered') ?> <a href="<?= url_to('login') ?>" class="link link-primary"><?= lang('Auth.signIn') ?></a></p>
    </div>
</div>

<?= $this->endSection() ?>
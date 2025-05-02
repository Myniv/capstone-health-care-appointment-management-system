<?= $this->extend('layouts/auth_layout') ?>

<?= $this->section('content') ?>

<div class="w-full max-w-md bg-base-100 p-6 rounded-lg shadow-md">
    <h2 class="text-2xl font-bold text-center mb-4"><?= lang('Auth.loginTitle') ?></h2>

    <?= view('Myth\Auth\Views\_message_block') ?>

    <form action="<?= url_to('login') ?>" method="post" id="formData">
        <?= csrf_field() ?>

        <!-- Login Field -->
        <?php if ($config->validFields === ['email']): ?>
            <div class="mb-3">
                <label for="login" class="label">
                    <span class="label-text"><?= lang('Auth.email') ?></span>
                </label>
                <input type="email" name="login" placeholder="<?= lang('Auth.email') ?>"
                    class="input input-bordered w-full <?= session('errors.login') ? 'input-error' : '' ?>" required
                    data-pristine-required-message="The email field is required.">
                <div class="text-error text-sm mt-1"><?= session('errors.login') ?></div>
            </div>
        <?php else: ?>
            <div class="mb-3">
                <label for="login" class="label">
                    <span class="label-text"><?= lang('Auth.emailOrUsername') ?></span>
                </label>
                <input type="text" name="login" placeholder="<?= lang('Auth.emailOrUsername') ?>"
                    class="input input-bordered w-full <?= session('errors.login') ? 'input-error' : '' ?>" required
                    data-pristine-required-message="The email or username field is required.">
                <div class="text-error text-sm mt-1"><?= session('errors.login') ?></div>
            </div>
        <?php endif; ?>

        <!-- Password Field -->
        <div class="mb-3">
            <label for="password" class="label">
                <span class="label-text"><?= lang('Auth.password') ?></span>
            </label>
            <input type="password" name="password" placeholder="<?= lang('Auth.password') ?>"
                class="input input-bordered w-full <?= session('errors.password') ? 'input-error' : '' ?>" required
                data-pristine-required-message="The password field is required.">
            <div class="text-error text-sm mt-1"><?= session('errors.password') ?></div>
        </div>

        <!-- Remember Me -->
        <?php if ($config->allowRemembering): ?>
            <div class="mb-4">
                <label class="cursor-pointer flex items-center">
                    <input type="checkbox" name="remember" class="checkbox checkbox-primary mr-2" <?php if (old('remember')): ?> checked <?php endif ?>>
                    <span class="label-text"><?= lang('Auth.rememberMe') ?></span>
                </label>
            </div>
        <?php endif; ?>

        <!-- Submit Button -->
        <div class="mb-4">
            <button type="submit" class="btn btn-primary w-full"><?= lang('Auth.loginAction') ?></button>
        </div>
    </form>

    <hr class="my-4">

    <!-- Links -->
    <div class="text-center">
        <?php if ($config->allowRegistration): ?>
            <p><a href="<?= url_to('register') ?>" class="link link-primary"><?= lang('Auth.needAnAccount') ?></a></p>
        <?php endif; ?>
        <?php if ($config->activeResetter): ?>
            <p><a href="<?= url_to('forgot') ?>" class="link link-primary"><?= lang('Auth.forgotYourPassword') ?></a></p>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
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
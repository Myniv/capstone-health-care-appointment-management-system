<?= $this->extend('layouts/auth_layout') ?>

<?= $this->section('content') ?>

<div class="w-full max-w-md bg-base-100 p-6 rounded-lg shadow-md">
    <h2 class="text-2xl font-bold text-center mb-4"><?= lang('Auth.register') ?></h2>

    <!-- Notice enctype for file upload -->
    <form action="<?= url_to('register') ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>

        <!-- Email Field -->
        <div class="mb-4">
            <label for="email" class="label">
                <span class="label-text"><?= lang('Auth.email') ?></span>
            </label>
            <input type="email" name="email" placeholder="<?= lang('Auth.email') ?>"
                class="input input-bordered w-full <?= session('errors.email') ? 'input-error' : '' ?>"
                value="<?= old('email') ?>">
            <small class="text-sm text-gray-500"><?= lang('Auth.weNeverShare') ?></small>
            <div class="text-error text-sm mt-1"><?= session('errors.email') ?></div>
        </div>

        <!-- Username Field -->
        <div class="mb-4">
            <label for="username" class="label">
                <span class="label-text"><?= lang('Auth.username') ?></span>
            </label>
            <input type="text" name="username" placeholder="<?= lang('Auth.username') ?>"
                class="input input-bordered w-full <?= session('errors.username') ? 'input-error' : '' ?>"
                value="<?= old('username') ?>">
            <div class="text-error text-sm mt-1"><?= session('errors.username') ?></div>
        </div>

        <!-- First Name and Last Name -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
                <label for="first_name" class="label">
                    <span class="label-text">First Name</span>
                </label>
                <input type="text" name="first_name"
                    class="input input-bordered w-full <?= session('errors.first_name') ? 'input-error' : '' ?>"
                    value="<?= old('first_name', $user->first_name ?? '') ?>" required>
                <div class="text-error text-sm"><?= session('errors.first_name') ?? '' ?></div>
            </div>

            <div>
                <label for="last_name" class="label">
                    <span class="label-text">Last Name</span>
                </label>
                <input type="text" name="last_name"
                    class="input input-bordered w-full <?= session('errors.last_name') ? 'input-error' : '' ?>"
                    value="<?= old('last_name', $user->last_name ?? '') ?>" required>
                <div class="text-error text-sm"><?= session('errors.last_name') ?? '' ?></div>
            </div>
        </div>

        <!-- Phone -->
        <div class="mb-4">
            <label for="phone" class="label">
                <span class="label-text">Phone</span>
            </label>
            <input type="tel" name="phone"
                class="input input-bordered w-full <?= session('errors.phone') ? 'input-error' : '' ?>"
                value="<?= old('phone', $user->phone ?? '') ?>">
            <div class="text-error text-sm"><?= session('errors.phone') ?? '' ?></div>
        </div>

        <!-- Address -->
        <div class="mb-4">
            <label for="address" class="label">
                <span class="label-text">Address</span>
            </label>
            <textarea name="address"
                class="textarea textarea-bordered w-full <?= session('errors.address') ? 'textarea-error' : '' ?>"
                rows="2"><?= old('address', $user->address ?? '') ?></textarea>
            <div class="text-error text-sm"><?= session('errors.address') ?? '' ?></div>
        </div>

        <!-- Sex and Date of Birth -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
                <label for="sex" class="label">
                    <span class="label-text">Sex</span>
                </label>
                <select name="sex"
                    class="select select-bordered w-full <?= session('errors.sex') ? 'select-error' : '' ?>" required>
                    <option value="">Select Gender</option>
                    <option value="male" <?= old('sex', $user->sex ?? '') == 'male' ? 'selected' : '' ?>>Male</option>
                    <option value="female" <?= old('sex', $user->sex ?? '') == 'female' ? 'selected' : '' ?>>Female
                    </option>
                </select>
                <div class="text-error text-sm"><?= session('errors.sex') ?? '' ?></div>
            </div>

            <div>
                <label for="dob" class="label">
                    <span class="label-text">Date of Birth</span>
                </label>
                <input type="date" name="dob"
                    class="input input-bordered w-full <?= session('errors.dob') ? 'input-error' : '' ?>"
                    value="<?= old('dob', $user->dob ?? '') ?>" required>
                <div class="text-error text-sm"><?= session('errors.dob') ?? '' ?></div>
            </div>
        </div>

        <!-- Password Field -->
        <div class="mb-4">
            <label for="password" class="label">
                <span class="label-text"><?= lang('Auth.password') ?></span>
            </label>
            <input type="password" name="password" placeholder="<?= lang('Auth.password') ?>"
                class="input input-bordered w-full <?= session('errors.password') ? 'input-error' : '' ?>"
                autocomplete="off">
            <div class="text-error text-sm mt-1"><?= session('errors.password') ?></div>
        </div>

        <!-- Confirm Password Field -->
        <div class="mb-4">
            <label for="pass_confirm" class="label">
                <span class="label-text"><?= lang('Auth.repeatPassword') ?></span>
            </label>
            <input type="password" name="pass_confirm" placeholder="<?= lang('Auth.repeatPassword') ?>"
                class="input input-bordered w-full <?= session('errors.pass_confirm') ? 'input-error' : '' ?>"
                autocomplete="off">
            <div class="text-error text-sm mt-1"><?= session('errors.pass_confirm') ?></div>
        </div>

        <!-- Profile Picture Upload Field -->
        <div class="mb-4">
            <label for="profile_picture" class="label">
                <span class="label-text">Profile Picture (optional)</span>
            </label>
            <!-- Using DaisyUI file input -->
            <input type="file" name="profile_picture"
                class="file-input file-input-bordered w-full <?= session('errors.profile_picture') ? 'file-input-error' : '' ?>">
            <div class="text-error text-sm mt-1"><?= session('errors.profile_picture') ?></div>
        </div>

        <!-- Submit Button -->
        <div class="mb-4">
            <button type="submit" class="btn btn-primary w-full"><?= lang('Auth.register') ?></button>
        </div>
    </form>

    <hr class="my-4">

    <!-- Links -->
    <div class="text-center">
        <p><?= lang('Auth.alreadyRegistered') ?> <a href="<?= url_to('login') ?>"
                class="link link-primary"><?= lang('Auth.signIn') ?></a></p>
    </div>
</div>

<?= $this->endSection() ?>
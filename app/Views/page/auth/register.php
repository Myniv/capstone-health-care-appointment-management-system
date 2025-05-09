<?= $this->extend('layouts/auth_layout') ?>

<?= $this->section('content') ?>

<div class="w-full max-w-md bg-base-100 p-6 rounded-lg shadow-md">
    <div class="mb-4">
        <?= view_cell('BackButtonCell', ['backLink' => null]) ?>
    </div>
    <h2 class="text-2xl font-bold text-center mb-4"><?= lang('Auth.register') ?></h2>

    <!-- Notice enctype for file upload -->
    <form action="<?= url_to('register') ?>" method="post" enctype="multipart/form-data" id="formData">
        <?= csrf_field() ?>

        <!-- Email Field -->
        <div class="mb-3">
            <label for="email" class="label">
                <span class="label-text"><?= lang('Auth.email') ?></span>
            </label>
            <input type="email" name="email" placeholder="<?= lang('Auth.email') ?>"
                class="input input-bordered w-full <?= session('errors.email') ? 'input-error' : '' ?>"
                value="<?= old('email') ?>" required data-pristine-required-message="The email field is required.">
            <small class="text-sm text-gray-500"><?= lang('Auth.weNeverShare') ?></small>
            <div class="text-error text-sm mt-1"><?= session('errors.email') ?></div>
        </div>

        <!-- Username Field -->
        <div class="mb-3">
            <label for="username" class="label">
                <span class="label-text"><?= lang('Auth.username') ?></span>
            </label>
            <input type="text" name="username" placeholder="<?= lang('Auth.username') ?>"
                class="input input-bordered w-full <?= session('errors.username') ? 'input-error' : '' ?>"
                value="<?= old('username') ?>" required
                data-pristine-required-message="The username field is required.">
            <div class="text-error text-sm mt-1"><?= session('errors.username') ?></div>
        </div>

        <!-- First Name and Last Name -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="mb-3">
                <label for="first_name" class="label">
                    <span class="label-text">First Name</span>
                </label>
                <input type="text" name="first_name"
                    class="input input-bordered w-full <?= session('errors.first_name') ? 'input-error' : '' ?>"
                    value="<?= old('first_name', $user->first_name ?? '') ?>" required
                    data-pristine-required-message="The first name field is required." data-pristine-minlength="2"
                    data-pristine-minlength-message="The first name must be at least 2 characters."
                    data-pristine-maxlength="100"
                    data-pristine-maxlength-message="The first name must not exceed 100 characters.">
                <div class="text-error text-sm"><?= session('errors.first_name') ?? '' ?></div>
            </div>

            <div class="mb-3">
                <label for="last_name" class="label">
                    <span class="label-text">Last Name</span>
                </label>
                <input type="text" name="last_name"
                    class="input input-bordered w-full <?= session('errors.last_name') ? 'input-error' : '' ?>"
                    value="<?= old('last_name', $user->last_name ?? '') ?>" required
                    data-pristine-required-message="The last name field is required." data-pristine-minlength="2"
                    data-pristine-minlength-message="The last name must be at least 2 characters."
                    data-pristine-maxlength="100"
                    data-pristine-maxlength-message="The last name must not exceed 100 characters.">
                <div class="text-error text-sm"><?= session('errors.last_name') ?? '' ?></div>
            </div>
        </div>

        <!-- Phone -->
        <div class="mb-3">
            <label for="phone" class="label">
                <span class="label-text">Phone</span>
            </label>
            <input type="tel" name="phone"
                class="input input-bordered w-full <?= session('errors.phone') ? 'input-error' : '' ?>"
                value="<?= old('phone', $user->phone ?? '') ?>" required pattern="^\d+$"
                data-pristine-required-message="The phone field is required."
                data-pristine-pattern-message="The phone field must contain only numbers.">
            <div class="text-error text-sm"><?= session('errors.phone') ?? '' ?></div>
        </div>

        <!-- Address -->
        <div class="mb-3">
            <label for="address" class="label">
                <span class="label-text">Address</span>
            </label>
            <textarea name="address"
                class="textarea textarea-bordered w-full <?= session('errors.address') ? 'textarea-error' : '' ?>"
                rows="2" required data-pristine-required-message="The address field is required."
                data-pristine-minlength="2" data-pristine-minlength-message="The address minimal 2 characters."
                data-pristine-maxlength="500"
                data-pristine-maxlength-message="The address must not exceed 500 characters."><?= old('address', $user->address ?? '') ?></textarea>
            <div class="text-error text-sm"><?= session('errors.address') ?? '' ?></div>
        </div>

        <!-- Sex and Date of Birth -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="mb-3">
                <label for="sex" class="label">
                    <span class="label-text">Sex</span>
                </label>
                <select name="sex"
                    class="select select-bordered w-full <?= session('errors.sex') ? 'select-error' : '' ?>" required
                    data-pristine-required-message="The sex field is required.">
                    <option value="">Select Gender</option>
                    <option value="male" <?= old('sex', $user->sex ?? '') == 'male' ? 'selected' : '' ?>>Male</option>
                    <option value="female" <?= old('sex', $user->sex ?? '') == 'female' ? 'selected' : '' ?>>Female
                    </option>
                </select>
                <div class="text-error text-sm"><?= session('errors.sex') ?? '' ?></div>
            </div>

            <div class="mb-3">
                <label for="dob" class="label">
                    <span class="label-text">Date of Birth</span>
                </label>
                <input type="date" name="dob"
                    class="input input-bordered w-full <?= session('errors.dob') ? 'input-error' : '' ?>"
                    value="<?= old('dob', $user->dob ?? '') ?>" required
                    data-pristine-required-message="The date field is required.">
                <div class="text-error text-sm"><?= session('errors.dob') ?? '' ?></div>
            </div>
        </div>

        <div class="mb-3">
            <label for="patient_type" class="label">
                <span class="label-text">Patient Type</span>
            </label>
            <select name="patient_type"
                class="select select-bordered w-full <?= session('errors.patient_type') ? 'select-error' : '' ?>"
                required data-pristine-required-message="The patient type field is required.">
                <option value="">Select Patient Type</option>
                <option value="BPJS" <?= old('patient_type', $user->patient_type ?? '') == 'BPJS' ? 'selected' : '' ?>>
                    BPJS</option>
                <option value="non-BPJS(Swasta)" <?= old('patient_type', $user->patient_type ?? '') == 'non-BPJS(Swasta)' ? 'selected' : '' ?>>
                    Non-BPJS(Swasta)</option>
                <option value="Regular" <?= old('patient_type', $user->patient_type ?? '') == 'Regular' ? 'selected' : '' ?>>
                    Regular</option>
            </select>
            <div class="text-error text-sm"><?= session('errors.patient_type') ?? '' ?></div>
        </div>

        <!-- Password Field -->
        <div class="mb-3">
            <label for="password" class="label">
                <span class="label-text"><?= lang('Auth.password') ?></span>
            </label>
            <input type="password" name="password" id="password" placeholder="<?= lang('Auth.password') ?>"
                class="input input-bordered w-full <?= session('errors.password') ? 'input-error' : '' ?>"
                autocomplete="off" required data-pristine-required-message="The password field is required."
                data-pristine-minlength="8" data-pristine-minlength-message="Password minimal 8 characters.">
            <div class="text-error text-sm mt-1"><?= session('errors.password') ?></div>
        </div>

        <!-- Confirm Password Field -->
        <div class="mb-3">
            <label for="pass_confirm" class="label">
                <span class="label-text"><?= lang('Auth.repeatPassword') ?></span>
            </label>
            <input type="password" name="pass_confirm" id="pass_confirm"
                placeholder="<?= lang('Auth.repeatPassword') ?>"
                class="input input-bordered w-full <?= session('errors.pass_confirm') ? 'input-error' : '' ?>"
                autocomplete="off" required data-pristine-required-message="The confirm password field is required."
                data-pristine-minlength="8" data-pristine-minlength-message="Password minimal 8 characters."
                data-pristine-equals="#password" data-pristine-equals-message="Passwords do not match.">
            <div class="text-error text-sm mt-1"><?= session('errors.pass_confirm') ?></div>
        </div>


        <!-- Profile Picture Upload Field -->
        <div class="mb-3">
            <label for="profile_picture" class="label">
                <span class="label-text">Profile Picture (optional)</span>
            </label>
            <input type="file" name="profile_picture"
                class="file-input file-input-bordered w-full <?= session('errors.profile_picture') ? 'file-input-error' : '' ?>">
            <div class="text-error text-sm mt-1"><?= session('errors.profile_picture') ?></div>
        </div>

        <!-- Submit Button -->
        <div class="mb-3">
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
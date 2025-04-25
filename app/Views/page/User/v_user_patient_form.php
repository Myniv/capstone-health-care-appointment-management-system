<?= $this->extend('layouts/admin_layout'); ?>

<?= $this->section('content'); ?>
<div class="container mx-auto mt-4">
    <h2 class="text-2xl font-bold mb-4"><?= isset($user) ? 'Edit Patient' : 'Add Patient'; ?></h2>

    <form
        action="<?= isset($user) ? base_url('admin/users/patient/update/' . $user->user_id) : base_url('admin/users/patient/create') ?>"
        method="post" enctype="multipart/form-data" id="formData" novalidate>
        <?= csrf_field() ?>
        <?php if (isset($user)): ?>
            <input type="hidden" name="_method" value="PUT">
        <?php endif; ?>

        <!-- Username and Email -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
                <label for="username" class="label">
                    <span class="label-text">Username</span>
                </label>
                <input type="text" name="username"
                    class="input input-bordered w-full <?= session('errors.username') ? 'input-error' : '' ?>"
                    value="<?= old('username', $user->username ?? '') ?>" required>
                <div class="text-error text-sm"><?= session('errors.username') ?? '' ?></div>
            </div>

            <div>
                <label for="email" class="label">
                    <span class="label-text">Email</span>
                </label>
                <input type="email" name="email"
                    class="input input-bordered w-full <?= session('errors.email') ? 'input-error' : '' ?>"
                    value="<?= old('email', $user->email ?? '') ?>" required>
                <div class="text-error text-sm"><?= session('errors.email') ?? '' ?></div>
            </div>
        </div>

        <!-- Password -->
        <div class="mb-4">
            <label for="password" class="label">
                <span class="label-text">Password
                    <?= isset($user) ? '<small>(Leave blank if unchanged)</small>' : '' ?></span>
            </label>
            <input type="password" name="password"
                class="input input-bordered w-full <?= session('errors.password') ? 'input-error' : '' ?>"
                <?= isset($user) ? '' : 'required' ?>>
            <div class="text-error text-sm"><?= session('errors.password') ?? '' ?></div>
        </div>

        <!-- Confirm Password -->
        <?php if (!isset($user)): ?>
            <div class="mb-4">
                <label for="pass_confirm" class="label">
                    <span class="label-text">Confirm Password</span>
                </label>
                <input type="password" name="pass_confirm"
                    class="input input-bordered w-full <?= session('errors.pass_confirm') ? 'input-error' : '' ?>" required>
                <div class="text-error text-sm"><?= session('errors.pass_confirm') ?? '' ?></div>
            </div>
        <?php endif; ?>

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

        <div class="mb-4">
            <label for="patient_type" class="label">
                <span class="label-text">Patient Type</span>
            </label>
            <select name="patient_type"
                class="select select-bordered w-full <?= session('errors.patient_type') ? 'select-error' : '' ?>"
                required>
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

        <!-- Profile Picture Upload Field -->
        <div class="mb-4">
            <label for="profile_picture" class="label">
                <span class="label-text">Profile Picture (optional)</span>
            </label>
            <input type="file" name="profile_picture"
                class="file-input file-input-bordered w-full <?= session('errors.profile_picture') ? 'file-input-error' : '' ?>">
            <div class="text-error text-sm mt-1"><?= session('errors.profile_picture') ?></div>
        </div>

        <!-- Submit Button -->
        <div class="text-end">
            <button type="submit" class="btn btn-primary"><?= isset($user) ? 'Update' : 'Save' ?> Patient</button>
        </div>
    </form>
</div>
<?= $this->endSection(); ?>
<?= $this->extend('layouts/admin_layout'); ?>

<?= $this->section('content'); ?>
<div class="container mx-auto mt-4">
    <h2 class="text-2xl font-bold mb-4"><?= isset($user) ? 'Edit Doctor' : 'Add Doctor'; ?></h2>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-error mb-4">
            <?= esc(session()->getFlashdata('error')) ?>
        </div>
    <?php endif; ?>

    <form
        action="<?= isset($user) ? base_url('admin/users/doctor/update/' . $user->user_id) : base_url('admin/users/doctor/create') ?>"
        method="post" enctype="multipart/form-data" id="formData" novalidate>
        <?= csrf_field() ?>
        <?php if (isset($user)): ?>
            <input type="hidden" name="_method" value="PUT">
        <?php endif; ?>

        <p class="text-lg font-bold my-2">Account Information</p>

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
                class="input input-bordered w-full <?= session('errors.password') ? 'input-error' : '' ?>">
            <div class="text-error text-sm"><?= session('errors.password') ?? '' ?></div>
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


        <!-- Doctor Category -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div class="">
                <label for="doctor_category_id" class="label">
                    <span class="label-text">Doctor Category</span>
                </label>
                <select name="doctor_category_id"
                    class="select select-bordered w-full <?= session('errors.doctor_category_id') ? 'select-error' : '' ?>"
                    required>
                    <option value="">Select Category</option>
                    <?php foreach ($doctor_category as $category): ?>
                        <option value="<?= $category->id ?>" <?= old('doctor_category_id', $user->doctor_category_id ?? '') == $category->id ? 'selected' : '' ?>>
                            <?= esc($category->name) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <div class="text-error text-sm"><?= session('errors.doctor_category_id') ?? '' ?></div>
            </div>
            <div class="">
                <label for="profile_picture" class="label">
                    <span class="label-text">Profile Picture</span>
                </label>
                <input type="file" name="profile_picture"
                    class="file-input file-input-bordered w-full <?= session('errors.profile_picture') ? 'file-input-error' : '' ?>">
                <div class="text-error text-sm mt-1"><?= session('errors.profile_picture') ?></div>
            </div>
        </div>


        <!-- Profile Picture Upload Field -->


        <p class="text-lg font-bold my-2">Education Information</p>

        <!-- degree and education -->
        <div id="education-container">
            <div class="education-group grid grid-cols-1 gap-4 mb-4">
                <div class="card card-border bg-base-100 w-full">
                    <div class="card-body">
                        <h2 class="card-title">Education 1</h2>
                        <div class="education-group grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="label"><span class="label-text">Degree</span></label>
                                <select name="education[0][degree]"
                                    class="select select-bordered w-full <?= session('errors.degree') ? 'select-error' : '' ?>"
                                    required>
                                    <option value="">Select Degree</option>
                                    <option value="Bachelor" <?= old('degree', $user->degree ?? '') == 'Bachelor' ? 'selected' : '' ?>>
                                        Bachelor</option>
                                    <option value="Master" <?= old('degree', $user->degree ?? '') == 'Master' ? 'selected' : '' ?>>
                                        Master</option>
                                    <option value="Doctor" <?= old('degree', $user->degree ?? '') == 'Doctor' ? 'selected' : '' ?>>
                                        Doctor</option>
                                </select>
                                <div class="text-error text-sm"><?= session('errors.degree') ?? '' ?></div>
                            </div>
                            <div>
                                <label class="label"><span class="label-text">Major</span></label>
                                <input type="text" name="education[0][study_program]" class="input input-bordered w-full" required>
                            </div>
                            <div>
                                <label class="label"><span class="label-text">City</span></label>
                                <input type="text" name="education[0][city]" class="input input-bordered w-full" required>
                            </div>
                            <div>
                                <label class="label"><span class="label-text">University</span></label>
                                <input type="text" name="education[0][university]" class="input input-bordered w-full" required>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>

        <!-- Add Button -->
        <button type="button" id="add-education" class="btn btn-secondary btn-sm mb-4">+ Add More Education</button>

        <!-- Submit Button -->
        <div class="text-end">
            <button type="submit" class="btn btn-primary"><?= isset($user) ? 'Update' : 'Save' ?> Doctor</button>
        </div>
    </form>
</div>

<script>
    let eduIndex = 1;

    document.getElementById('add-education').addEventListener('click', () => {
        const container = document.getElementById('education-container');

        const group = document.createElement('div');
        group.className = 'education-group grid grid-cols-1 gap-4 mb-4';
        group.setAttribute('data-index', eduIndex);

        group.innerHTML = `
        <div class="card card-border bg-base-100 w-full">
            <div class="card-body relative">
                <h2 class="card-title">Education ${eduIndex + 1}</h2>
                <button type="button" class="btn btn-error btn-xs absolute top-2 right-2 remove-education">Remove</button>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="label"><span class="label-text">Degree</span></label>
                        <select name="education[${eduIndex}][degree]" class="select select-bordered w-full" required>
                            <option value="">Select Degree</option>
                            <option value="Bachelor">Bachelor</option>
                            <option value="Master">Master</option>
                            <option value="Doctor">Doctor</option>
                        </select>
                    </div>
                    <div>
                        <label class="label"><span class="label-text">Major</span></label>
                        <input type="text" name="education[${eduIndex}][study_program]" class="input input-bordered w-full" required>
                    </div>
                    <div>
                        <label class="label"><span class="label-text">City</span></label>
                        <input type="text" name="education[${eduIndex}][city]" class="input input-bordered w-full" required>
                    </div>
                    <div>
                        <label class="label"><span class="label-text">University</span></label>
                        <input type="text" name="education[${eduIndex}][university]" class="input input-bordered w-full" required>
                    </div>
                </div>
            </div>
        </div>
    `;

        container.appendChild(group);
        eduIndex++;
    });

    document.getElementById('education-container').addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-education')) {
            const group = e.target.closest('.education-group');
            group.remove();
            eduIndex--;
        }
    });
</script>
<?= $this->endSection(); ?>
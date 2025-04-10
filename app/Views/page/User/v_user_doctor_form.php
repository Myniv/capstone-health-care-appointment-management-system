<div class="container mt-4 mb-4">
    <div class="card">
        <div class="card-header bg-dark text-white">
            <h4 class="mb-3"><?= isset($user) ? 'Edit Patient' : 'Add Patient'; ?></h4>
        </div>
        <div class="card-body">
            <form action="<?= base_url('admin/users/doctor/create') ?>" method="post" enctype="multipart/form-data"
                id="formData" novalidate>
                <?= csrf_field() ?>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" name="username"
                            class="form-control <?= session('errors.username') ? 'is-invalid' : '' ?>"
                            value="<?= old('username') ?>" required>
                        <div class="text-danger"><?= session('errors.username') ?? '' ?></div>
                    </div>

                    <div class="col-md-6">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email"
                            class="form-control <?= session('errors.email') ? 'is-invalid' : '' ?>"
                            value="<?= old('email') ?>" required>
                        <div class="text-danger"><?= session('errors.email') ?? '' ?></div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password"
                        class="form-control <?= session('errors.password') ? 'is-invalid' : '' ?>" required>
                    <div class="text-danger"><?= session('errors.password') ?? '' ?></div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="first_name" class="form-label">First Name</label>
                        <input type="text" name="first_name"
                            class="form-control <?= session('errors.first_name') ? 'is-invalid' : '' ?>"
                            value="<?= old('first_name') ?>" required>
                        <div class="text-danger"><?= session('errors.first_name') ?? '' ?></div>
                    </div>

                    <div class="col-md-6">
                        <label for="last_name" class="form-label">Last Name</label>
                        <input type="text" name="last_name"
                            class="form-control <?= session('errors.last_name') ? 'is-invalid' : '' ?>"
                            value="<?= old('last_name') ?>" required>
                        <div class="text-danger"><?= session('errors.last_name') ?? '' ?></div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="phone" class="form-label">Phone</label>
                    <input type="tel" name="phone"
                        class="form-control <?= session('errors.phone') ? 'is-invalid' : '' ?>"
                        value="<?= old('phone') ?>">
                    <div class="text-danger"><?= session('errors.phone') ?? '' ?></div>
                </div>

                <div class="mb-3">
                    <label for="address" class="form-label">Address</label>
                    <textarea name="address" class="form-control <?= session('errors.address') ? 'is-invalid' : '' ?>"
                        rows="2"><?= old('address') ?></textarea>
                    <div class="text-danger"><?= session('errors.address') ?? '' ?></div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="sex" class="form-label">Sex</label>
                        <select name="sex" class="form-select <?= session('errors.sex') ? 'is-invalid' : '' ?>"
                            required>
                            <option value="">Select Gender</option>
                            <option value="male" <?= old('sex') == 'male' ? 'selected' : '' ?>>Male</option>
                            <option value="female" <?= old('sex') == 'female' ? 'selected' : '' ?>>Female</option>
                        </select>
                        <div class="text-danger"><?= session('errors.sex') ?? '' ?></div>
                    </div>

                    <div class="col-md-6">
                        <label for="dob" class="form-label">Date of Birth</label>
                        <input type="date" name="dob"
                            class="form-control <?= session('errors.dob') ? 'is-invalid' : '' ?>"
                            value="<?= old('dob') ?>" required>
                        <div class="text-danger"><?= session('errors.dob') ?? '' ?></div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="doctor_category_id" class="form-label">Doctor Category</label>
                    <select name="doctor_category_id"
                        class="form-select <?= session('errors.doctor_category_id') ? 'is-invalid' : '' ?>"
                        data-pristine-required data-pristine-required-message="The Doctor Category field is required.">
                        <option value="">Select Category</option>
                        <?php foreach ($doctor_category as $category): ?>
                            <?php
                            $selected = old('doctor_category_id') !== null
                                ? old('doctor_category_id') == $category->id
                                : (isset($user) && $user->doctor_category_id == $category->id);
                            ?>
                            <option value="<?= $category->id ?>" <?= $selected ? 'selected' : '' ?>>
                                <?= esc($category->name) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <div class="text-danger"><?= session('errors.doctor_category_id') ?? '' ?></div>
                </div>


                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Save Doctor</button>
                </div>
            </form>
        </div>
    </div>
</div>
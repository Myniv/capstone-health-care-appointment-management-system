<?= $this->extend('layouts/admin_layout'); ?>

<?= $this->section('content'); ?>
<div class="container mx-auto mt-4 px-4">
    <h2 class="text-2xl font-bold mb-4">
        <?= $title . ' ' . ucfirst($user->role); ?>
    </h2>

    <div class="flex flex-col">
        <div class="flex gap-6">
            <div class="avatar">
                <div class="w-24 rounded-full">
                    <img src="<?= base_url('profile-picture?path=' . $user->profile_picture); ?>" alt="Profile Picture <?= $user->first_name . ' ' . $user->last_name; ?>">
                </div>
            </div>
            <div class="flex flex-col">
                <p class="text-xl font-semibold">
                    <?php if ($user->role == 'patient'): ?>
                        <?= $user->first_name . ' ' . $user->last_name ?>
                    <?php elseif ($user->role == 'doctor'): ?>
                        <?= $user->first_name . ' ' . $user->last_name ?>
                    <?php endif; ?>
                </p>
                <?php if ($user->role == 'doctor'): ?>
                    <p class="text-gray-500 font-semibold">
                        <?= ucfirst($user->doctor_category); ?>
                    </p>
                <?php endif; ?>
            </div>
        </div>

        <div class="divider"></div>

        <div class="grid gap-4 md:grid-cols-2 md:gap-0">
            <div>
                <h3 class="text-lg font-bold mb-2">Account</h3>
                <div>
                    <span class="font-semibold">Username: </span>
                    <span class="text-gray-700"><?= $user->username; ?></span>
                </div>
                <div>
                    <span class="font-semibold">Email: </span>
                    <span class="text-gray-700"><?= $user->email; ?></span>
                </div>
                <div>
                    <span class="font-semibold">Phone: </span>
                    <span class="text-gray-700"><?= $user->phone; ?></span>
                </div>
            </div>


            <div>
                <h3 class="text-lg font-bold mb-2">Information</h3>
                <div>
                    <span class="font-semibold">Address: </span>
                    <span class="text-gray-700"><?= $user->address; ?></span>
                </div>
                <div>
                    <span class="font-semibold">DoB: </span>
                    <span class="text-gray-700"><?= $user->dob; ?></span>
                </div>
                <div>
                    <span class="font-semibold">Sex: </span>
                    <span class="text-gray-700"><?= $user->sex; ?></span>
                </div>
            </div>
        </div>

        <?php if ($user->role == 'doctor'): ?>
            <div class="divider"></div>

            <div>
                <h3 class="text-lg font-bold mb-2">Education</h3>
                <ul class="timeline">
                    <li>
                        <div class="timeline-start timeline-box"><?= $user->education; ?></div>
                        <div class="timeline-middle">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 20 20"
                                fill="currentColor"
                                class="h-5 w-5">
                                <path
                                    fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <hr />
                    </li>
                </ul>
            </div>
        <?php endif; ?>

    </div>
</div>
<?= $this->endSection(); ?>
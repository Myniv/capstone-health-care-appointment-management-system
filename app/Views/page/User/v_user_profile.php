<?= $this->extend('layouts/admin_layout'); ?>

<?= $this->section('content'); ?>
<div class="container mx-auto mt-4 px-4">

    <h2 class="text-2xl font-bold mb-4">
        <?= $title . ' ' . ucfirst($user->role); ?>
    </h2>

    <?php if (session()->getFlashdata('success')): ?>

        <div class="alert alert-success mb-4">
            <?= session()->getFlashdata('success'); ?>
        </div>
    <?php endif; ?>


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


        <div class="divider"></div>
        <?php if ($user->role == 'doctor'): ?>
            <form action="/doctor/education/create" method="get">
                <input type="text" hidden name="d_id" value="<?= $user->doctor_id ?>">
                <button type="submit" class="btn btn-secondary btn-sm mb-4 w-fit">+ Add Education</button>
            </form>

            <div class="">
                <h3 class="text-lg font-bold mb-2">Education</h3>
                <ul class="flex flex-col space-y-4">
                    <?php foreach ($educations as $row): ?>
                        <li class="flex items-center space-x-4">
                            <div class="timeline-start self-center flex items-center justify-center">
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
                            <div class="timeline-middle text-left">
                                <p class="text-lg font-bold"><?= $row->study_program ?></p>
                                <div class="flex">
                                    <p class="text-sm"><?= $row->year ?> &#x2022; <?= $row->university ?>,<?= $row->city ?></p>
                                </div>
                                <?php if ($user->role == 'doctor'): ?>
                                    <div class="flex gap-4">
                                        <a class="text-sm link link-primary mt-0.5" href="/doctor/education/update/<?= $user->doctor_id ?>">Edit</a>

                                        <form action="/doctor/education/delete/<?= $row->id ?>/<?= $user->user_id ?>" method="post" class="inline">
                                            <?= csrf_field() ?>
                                            <input type="hidden" name="_method" value="DELETE">
                                            <button type="submit" class="text-sm btn-link text-red-700"
                                                onclick="return confirm('Are you sure want to delete this education?');">
                                                Delete
                                            </button>
                                        </form>
                                    </div>

                                <?php endif; ?>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>

            </div>
        <?php endif; ?>

    </div>
</div>
<?= $this->endSection(); ?>
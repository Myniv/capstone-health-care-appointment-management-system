<?= $this->extend('layouts/admin_layout'); ?>

<?= $this->section('content'); ?>
<div class="container mx-auto mt-4">
    <h2 class="text-2xl font-bold mb-4"><?= $title; ?></h2>

    <div class="flex flex-col gap-2">
        <div class="flex gap-6">
            <div class="avatar">
                <div class="w-24 rounded-full">
                    <img src="<?= base_url('profile-picture?path=' . $user->profile_picture); ?>" alt="Profile Picture <?= $user->first_name . ' ' . $user->last_name; ?>">
                </div>
            </div>
            <p><?= $user->first_name . ' ' . $user->last_name ?></p>
        </div>
        <p><?= $user->username; ?></p>
        <p><?= $user->email; ?></p>
    </div>
</div>
<?= $this->endSection(); ?>
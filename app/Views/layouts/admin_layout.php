<?php use Config\Roles; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->renderSection('title'); ?> Page</title>

    <!-- Tailwind CSS & DaisyUI CDN-->
    <!-- <script src="https://cdn.tailwindcss.com"></script> -->
    <!-- <link href="https://cdn.jsdelivr.net/npm/daisyui@latest/dist/full.css" rel="stylesheet" /> -->

    <!-- Tailwind CSS & DaisyUI -->
    <link rel="stylesheet" href="<?= base_url('assets/css/tailwind.css') ?>">

    <!-- Pristine.js -->
    <script src="<?= base_url('assets/js/pristine/dist/pristine.js') ?>" type="text/javascript"></script>
</head>

<body class="flex flex-col min-h-screen bg-base-200" data-theme="light">
    <!-- Header -->
    <header class="mb-4">
        <?= $this->include('components/header'); ?>
    </header>

    <!-- Main Content -->
    <main class="container mx-auto px-4 flex flex-grow gap-4">
        <?php if (logged_in()): ?>
            <?php if (in_groups(Roles::ADMIN) || in_groups(Roles::DOCTOR)): ?>
                <!-- Sidebar -->
                <aside class="hidden lg:block bg-base-100 p-4 rounded-lg shadow-md">
                    <?= $this->include('components/sidebar'); ?>
                </aside>
            <?php endif; ?>
        <?php endif; ?>

        <!-- Page Content -->
        <section class="w-full bg-base-100 p-4 rounded-lg shadow-md">
            <?= $this->renderSection('content'); ?>
        </section>
    </main>

    <!-- Footer -->
    <footer class="text-base-content mt-4">
        <?= $this->include('components/footer'); ?>
    </footer>

    <!-- Additional Scripts -->
    <?= $this->renderSection('scripts'); ?>
</body>

</html>
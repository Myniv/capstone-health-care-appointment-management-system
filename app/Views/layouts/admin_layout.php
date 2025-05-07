<?php

use Config\Roles; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->renderSection('title'); ?> Page</title>

    <!-- Tailwind CSS & DaisyUI -->
    <link rel="stylesheet" href="<?= base_url('assets/css/tailwind.css') ?>">

    <!-- Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Tailwind CSS & DaisyUI CDN-->
    <!-- <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@latest/dist/full.css" rel="stylesheet" /> -->

    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
        integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Pristine.js -->
    <script src="<?= base_url('assets/js/pristine/dist/pristine.js') ?>" type="text/javascript"></script>

    <!-- ChartJS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- jQuery UI CSS -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- jQuery UI -->
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>

    <!-- driverjs CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/driver.js@latest/dist/driver.css" />
</head>

<body class="flex flex-col min-h-screen bg-base-100" data-theme="light">
    <!-- Header -->
    <header class="mb-4">
        <?= $this->include('components/header'); ?>
    </header>

    <!-- Main Content -->
    <main class="container mx-auto px-4 flex flex-grow gap-6 h-full">
        <?php if (in_groups(Roles::ADMIN) || in_groups(Roles::DOCTOR)): ?>
            <!-- Sidebar -->
            <aside
                class="bg-base-100 md:w-1/5 md:block md:relative md:translate-x-0 w-1/2 fixed inset-y-0 left-0 z-50 transform -translate-x-full transition-transform duration-200 ease-in-out">
                <?= $this->include('components/sidebar'); ?>
            </aside>
        <?php endif; ?>

        <!-- overlay -->
        <div class="fixed inset-0 bg-black bg-opacity-50 z-30 hidden md:hidden" id="sidebar-overlay"></div>

        <!-- Page Content -->
        <section class="w-full bg-base-200 p-4 rounded-lg">
            <?= $this->renderSection('content'); ?>
        </section>
    </main>

    <!-- Footer -->
    <footer class="mt-4">
        <?= $this->include('components/footer'); ?>
    </footer>

    <!-- Additional Scripts -->
    <?= $this->renderSection('scripts'); ?>
    <script>
        const aside = document.querySelector('aside')
        const menuToggle = document.getElementById('sidebar-toggle')
        const overlay = document.getElementById('sidebar-overlay')

        console.log(overlay)

        menuToggle.addEventListener('click', () => {
            aside.classList.toggle('-translate-x-full'); // Tampilkan/hilangkan sidebar
            overlay.classList.toggle('hidden'); // Tampilkan/hilangkan overlay
        });

        overlay.addEventListener('click', () => {
            aside.classList.add('-translate-x-full'); // Sembunyikan sidebar
            overlay.classList.add('hidden'); // Sembunyikan overlay
        });
    </script>
</body>

</html>
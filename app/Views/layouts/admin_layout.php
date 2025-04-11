<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->renderSection('title'); ?> Page</title>

    <!-- Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- DaisyUI CSS via CDN -->
    <link href="https://cdn.jsdelivr.net/npm/daisyui@latest/dist/full.css" rel="stylesheet" />

    <!-- Pristine.js -->
    <script src="<?= base_url('assets/js/pristine.js') ?>"></script>
</head>

<body class="flex flex-col min-h-screen bg-base-200" data-theme="light">
    <!-- Header -->
    <header class="mb-4">
        <?= $this->include('components/header'); ?>
    </header>

    <!-- Main Content -->
    <main class="container mx-auto px-4 flex flex-grow gap-4">
        <!-- Sidebar -->
        <aside class="w-1/4 hidden lg:block">
            <?= $this->include('components/sidebar'); ?>
        </aside>

        <!-- Page Content -->
        <section class="w-full bg-base-100 p-4 rounded-lg shadow-md lg:w-3/4">
            <?= $this->renderSection('content'); ?>
        </section>
    </main>

    <!-- Footer -->
    <footer class="bg-base-300 text-base-content mt-4">
        <?= $this->include('components/footer'); ?>
    </footer>

    <!-- Additional Scripts -->
    <?= $this->renderSection('scripts'); ?>
</body>

</html>
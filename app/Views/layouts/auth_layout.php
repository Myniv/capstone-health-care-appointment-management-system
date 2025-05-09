<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->renderSection('title'); ?></title>

    <!-- Tailwind CSS & DaisyUI -->
    <link rel="stylesheet" href="<?= base_url('assets/css/tailwind.css') ?>">

    <!-- Tailwind CSS & DaisyUI CDN-->
    <!-- <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@latest/dist/full.css" rel="stylesheet" /> -->

    <!-- Pristine.js -->
    <script src="<?= base_url('assets/js/pristine/dist/pristine.js') ?>" type="text/javascript"></script>
</head>

<body class="bg-base-200 min-h-screen flex flex-col" data-theme="light">
    <header class="mb-4">
        <?= $this->include('components/header'); ?>
    </header>

    <main class="flex-grow flex items-center justify-center">
        <?= $this->renderSection('content'); ?>
    </main>

    <footer class="text-base-content mt-4">
        <?= $this->include('components/footer'); ?>
    </footer>

    <?= $this->renderSection('scripts'); ?>
</body>

</html>
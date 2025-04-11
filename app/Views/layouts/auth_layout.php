<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->renderSection('title'); ?></title>

    <!-- Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- DaisyUI CSS via CDN -->
    <link href="https://cdn.jsdelivr.net/npm/daisyui@latest/dist/full.css" rel="stylesheet" />

    <!-- Pristine.js -->
    <script src="<?= base_url('assets/js/pristine.js') ?>"></script>
</head>

<body class="bg-base-200" data-theme="light">
    <main class="flex items-center justify-center min-h-screen">
        <?= $this->renderSection('content'); ?>
    </main>

    <?= $this->renderSection('scripts'); ?>
</body>

</html>
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

    <!-- DaisyUI CSS via CDN -->
    <link href="https://cdn.jsdelivr.net/npm/daisyui@latest/dist/full.css" rel="stylesheet" />

    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
        integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Pristine.js -->
    <script src="<?= base_url('assets/js/pristine/dist/pristine.js') ?>" type="text/javascript"></script>

    <!-- jQuery UI CSS -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- jQuery UI -->
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
</head>

<body class="flex flex-col min-h-screen bg-base-200" data-theme="light">
    <!-- Header -->
    <header class="mb-4">
        <?= $this->include('components/header'); ?>
    </header>

    <!-- Main Content -->
    <main class="container mx-auto px-4 flex flex-grow gap-4">
        <!-- Page Content -->
        <section class="w-full bg-base-200 p-4">
            <?= $this->renderSection('content'); ?>
        </section>
    </main>

    <!-- Footer -->
    <footer class="mt-4">
        <?= $this->include('components/footer'); ?>
    </footer>

    <!-- Additional Scripts -->
    <?= $this->renderSection('scripts'); ?>
</body>

</html>
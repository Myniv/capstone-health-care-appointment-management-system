<?= $this->extend('layouts/auth_layout') ?>

<?= $this->section('content') ?>
<div class="">
    <div class="text-center text-white p-10 bg-opacity-80 bg-gray-800 rounded-lg shadow-lg max-w-md mx-auto">
        <h1 class="text-5xl font-bold mb-6">403 Unauthorized</h1>
        <p class="mb-6">You do not have permission to view this page. Please contact the administrator.</p>
        <a href="/" class="btn btn-primary">Go to Home</a>
    </div>
</div>

<?= $this->endSection() ?>
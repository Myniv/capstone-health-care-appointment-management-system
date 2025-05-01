<?= $this->extend('layouts/admin_layout'); ?>

<?= $this->section('content'); ?>
<h2 class="text-2xl font-bold mb-4">Report Resources</h2>

<div class="bg-base-100 p-6 rounded-md shadow-md">
    <a href="<?= base_url('report/resources/excel') ?>" class="btn btn-success whitespace-nowrap mt-4 px-4" target="_blank">
        <i class="bi bi-file-earmark-pdf-fill me-1"></i> Export Excel
    </a>
</div>
<?= $this->endSection(); ?>
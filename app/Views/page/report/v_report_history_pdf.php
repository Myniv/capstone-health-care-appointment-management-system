<?= $this->extend('layouts/admin_layout');

use Config\Roles; ?>

<?= $this->section('content'); ?>
<div class="container mx-auto mt-4">
    <h2 class="text-2xl font-bold mb-4">Report History</h2>

    <form action="<?= $baseUrl ?>" method="get" class="">
        <?php if (in_groups(Roles::ADMIN)): ?>
            <div class="flex flex-wrap items-center gap-4 w-full">
                <div class="form-control w-full md:w-1/3">
                    <label for="doctor" class="label">
                        <span class="label-text">Filter by Doctor</span>
                    </label>
                    <div class="flex items-center gap-2">
                        <select class="select select-bordered flex-1" name="doctor" id="doctor" required
                            onchange="this.form.submit()">
                            <option value="">All Doctor</option>
                            <?php foreach ($doctors as $doctor): ?>
                                <option value="<?= $doctor->id ?>" <?= $params->doctor == $doctor->id ? 'selected' : '' ?>>
                                    <?= $doctor->first_name . ' ' . $doctor->last_name ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <a href="<?= $params->getResetUrl($baseUrl) ?>" class="btn btn-primary whitespace-nowrap">Reset</a>
                    </div>
                </div>

                <a href="<?= base_url('report/history/pdf') . '?' . http_build_query([
                                'doctor' => $params->doctor,
                            ]) ?>" class="btn btn-success whitespace-nowrap mt-4 px-4" target="_blank">
                    <i class="bi bi-file-earmark-pdf-fill me-1"></i> Export PDF
                </a>
            </div>
        <?php endif; ?>
        <?php if (in_groups(Roles::DOCTOR)): ?>
            <div class="flex flex-wrap items-center gap-4 w-full">
                <a href="<?= base_url('report/history/pdf') ?>" class="btn btn-success whitespace-nowrap mt-4 px-4"
                    target="_blank">
                    <i class="bi bi-file-earmark-pdf-fill me-1"></i> Export PDF
                </a>
            </div>
        <?php endif; ?>

        <input type="hidden" name="sort" value="<?= $params->sort; ?>">
        <input type="hidden" name="order" value="<?= $params->order; ?>">
    </form>

    <div class="col-auto mt-4">
        <h4>Preview :</h4>
    </div>

    <div class="overflow-x-auto">
        <table class="table table-zebra w-full">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Doctor</th>
                    <th>Patient</th>
                    <th>Notes</th>
                    <th>Prescription</th>
                    <th>Documents</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; ?>
                <?php foreach ($histories as $history): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= esc($history->doctorFirstName . ' ' . $history->doctorLastName ?? '-') ?></td>
                        <td><?= esc($history->patientFirstName . ' ' . $history->patientLastName ?? '-') ?></td>
                        <td><?= esc($history->notes ?? '-') ?></td>
                        <td><?= esc($history->prescriptions ?? '-') ?></td>
                        <td><?= esc($history->documents ?? '-') ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="mt-8 text-center">
        <?= $pager->links('histories', 'custom_pager') ?>
        <div class="mt-2">
            <small>Show <?= count($histories) ?> of <?= $total ?> total data (Page <?= $params->page ?>)</small>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>
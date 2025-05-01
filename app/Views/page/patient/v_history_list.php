<?= $this->extend('layouts/public_layout'); ?>

<?= $this->section('content'); ?>
<div class="flex flex-wrap gap-4 h-full">
    <?= $this->include('components/sidebar_profile'); ?>

    <section class="flex-grow p-6 rounded-lg flex flex-col bg-base-100 shadow-md">
        <h1 class="font-bold text-2xl mb-4">Medical History</h1>
        <form action="<?= $baseUrl ?>" method="get" class="flex flex-wrap items-center gap-4 mb-4">
            <div class="flex flex-grow items-center gap-2">
                <input
                    type="text"
                    class="input input-bordered w-full md:w-auto flex-grow"
                    name="search"
                    value="<?= $params->search ?>"
                    placeholder="Search...">
                <input
                    type="date"
                    name="date"
                    class="input input-bordered <?= session('errors.date') ? 'input-error' : '' ?>"
                    value="<?= $params->date ?>"
                    placeholder="Select Date" />
                <button type="submit" class="btn btn-primary ml-2">Search</button>
            </div>

            <div class="w-full md:w-auto">
                <a href="<?= $params->getResetUrl($baseUrl) ?>" class="btn btn-primary">Reset</a>
            </div>
        </form>

        <?php if (!empty($histories)): ?>
            <?php foreach ($histories as $history): ?>
                <ul class="menu border shadow-sm rounded-box bg-base-100 w-full mb-2">
                    <li class="flex flex-wrap justify-between">
                        <button
                            id="btn-modal-medical-history"
                            class="pointer w-full"
                            data-id="<?= htmlspecialchars($history->historyId); ?>"
                            data-reason="<?= htmlspecialchars($history->reason); ?>"
                            data-notes="<?= htmlspecialchars($history->notes); ?>"
                            data-prescriptions="<?= htmlspecialchars($history->prescriptions); ?>"
                            data-firstName="<?= htmlspecialchars($history->doctorFirstName); ?>"
                            data-lastName="<?= htmlspecialchars($history->doctorLastName); ?>"
                            data-date="<?= htmlspecialchars($history->date); ?>"
                            data-status="<?= htmlspecialchars($history->status); ?>"
                            data-documents="<?= htmlspecialchars($history->documents); ?>">
                            <?= strlen($history->notes) >= 40 ? substr($history->notes, 0, 40) . '...' : $history->notes; ?>

                            <p class="text-gray-700 md:justify-self-end"><?= date('F j, Y', strtotime($history->date)) ?></p>
                        </button>
                    </li>
                </ul>
            <?php endforeach; ?>
        <?php else: ?>
            <p>There is no data history.</p>
        <?php endif; ?>

        <div class="text-center mt-auto">
            <?= $pager->links('histories', 'custom_pager') ?>
            <div class="mt-2">
                <small>
                    Show <?= count($histories) ?> of <?= $total ?> total data (Page <?= $params->page ?>)
                </small>
            </div>
        </div>
    </section>
</div>

<dialog class="modal" id="modal-medical-history">
    <div class="modal-box md:max-w-xl">
        <form method="dialog">
            <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
        </form>
        <div class="card">
            <div class="card-body grid gap-2 p-4 rounded-md">
                <div>
                    <h3 class="font-semibold">Treatment</h3>
                    <div>
                        <span>Complaint: </span>
                        <span class="text-gray-700 modal-reason"></span>
                    </div>
                    <div>
                        <span>Notes: </span>
                        <span class="text-gray-700 modal-notes"></span>
                    </div>
                    <div>
                        <span>Prescriptions: </span>
                        <span class="text-gray-700 modal-prescriptions"></span>
                    </div>
                </div>
                <div>
                    <h3 class="font-semibold">Appointment</h3>
                    <div>
                        <span>Doctor: </span>
                        <span class="text-gray-700 modal-doctor-name"></span>
                    </div>
                    <div>
                        <span>Date: </span>
                        <span class="text-gray-700 modal-date"></span>
                    </div>
                </div>
                <div>
                    <h3 class="font-semibold">Status</h3>
                    <div class="badge badge-soft badge-success mt-2 modal-status"></div>
                </div>
            </div>
            <div class="card-actions flex justify-end mt-4">
                <a href="" target="_blank" class="btn btn-primary modal-id">
                    Preview Document
                </a>
            </div>
        </div>
    </div>
</dialog>
<?= $this->endSection(); ?>

<?= $this->section('scripts'); ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const links = document.querySelectorAll('#btn-modal-medical-history');
        const modal = document.getElementById('modal-medical-history');

        links.forEach(link => {
            link.addEventListener('click', function() {
                const id = link.getAttribute('data-id');
                const reason = link.getAttribute('data-reason');
                const notes = link.getAttribute('data-notes');
                const prescriptions = link.getAttribute('data-prescriptions');
                const firstName = link.getAttribute('data-firstName');
                const lastName = link.getAttribute('data-lastName');
                const date = link.getAttribute('data-date');
                const status = link.getAttribute('data-status');
                const documents = link.getAttribute('data-documents');

                // formatting date
                const formattedDate = new Intl.DateTimeFormat('id-ID', {
                    weekday: 'long',
                    day: 'numeric',
                    month: 'long',
                    year: 'numeric'
                }).format(new Date(date));

                // formatting status
                const formattedStatus = `${status.charAt(0).toUpperCase()}${status.slice(1)}`;

                // assign data
                modal.querySelector('.modal-reason').textContent = reason;
                modal.querySelector('.modal-notes').textContent = notes;
                modal.querySelector('.modal-prescriptions').textContent = prescriptions;
                modal.querySelector('.modal-doctor-name').textContent = `${firstName} ${lastName}`;
                modal.querySelector('.modal-date').textContent = formattedDate;
                modal.querySelector('.modal-status').textContent = formattedStatus;
                modal.querySelector('.modal-id').href = `history/document/${id}`;

                // show modal
                modal.showModal();
            });
        });
    });
</script>
<?= $this->endSection(); ?>
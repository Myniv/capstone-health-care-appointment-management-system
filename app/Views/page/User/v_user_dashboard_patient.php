<?= $this->extend('layouts/public_layout'); ?>

<?= $this->section('content'); ?>
<div class="container mx-auto mt-4 px-4">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="card md:col-span-2">
            <div class="card-body">
                <?php if (!empty(user())): ?>
                    <span class="card-title text-3xl font-bold">
                        Hello, <span class="text-primary"><?= user()->username; ?></span> 👋🏼
                    </span>
                <?php endif; ?>
            </div>
        </div>

        <div class="card border">
            <div class="card-body">
                <a href="appointment/create" class="btn btn-soft btn-success">+ Create Appointment</a>
            </div>
        </div>

        <div class="card border md:col-span-2">
            <div class="card-body">
                <div class="flex justify-between">
                    <h3 class="card-title">Upcoming Appointment</h3>
                    <a class="btn btn-sm btn-primary" href="appointment">View All</a>
                </div>
                <?php if (!empty($appointments)): ?>
                    <?php foreach ($appointments as $appointment): ?>
                        <div class="p-4 border rounded-lg flex flex-wrap justify-between">
                            <div class="grid grid-cols-[auto,1fr]">
                                <div class="avatar">
                                    <div class="w-24 rounded-full mr-4">
                                        <img class=""
                                            src="<?= base_url('profile-picture?path=' . $appointment->doctorProfilePicture); ?>"
                                            alt="Profile Picture <?= $appointment->doctorFirstName . ' ' . $appointment->doctorLastName; ?>" />
                                    </div>
                                </div>

                                <div>
                                    <h3 class="text-lg font-semibold">
                                        <?= $appointment->doctorFirstName . ' ' . $appointment->doctorLastName; ?></h3>
                                    <p class="col-start-2"><?= ucwords($appointment->doctorCategoryName); ?></p>
                                    <p class="col-start-2">
                                        <?= date('g:i A', strtotime($appointment->startTime)) ?> -
                                        <?= date('g:i A', strtotime($appointment->endTime)) ?>
                                    </p>
                                    <p class="col-start-2"><?= date('F j, Y', strtotime($appointment->date)) ?></p>
                                </div>
                            </div>
                            <div class="card-actions self-center">
                                <a class="btn btn-soft btn-sm" href="/appointment/detail/<?= $appointment->id ?>">
                                    Details
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>

                <?php else: ?>
                    <p>There is no data appointment.</p>
                <?php endif; ?>
            </div>
        </div>

        <div class="card border bg-primary-content">
            <div class="card-body">
                <h3 class="card-title">Medical History</h3>
                <?php if (!empty($histories)): ?>
                    <?php foreach ($histories as $history): ?>
                        <ul class="menu border rounded-box bg-base-100 w-full">
                            <li class="flex flex-wrap justify-between">
                                <button
                                    id="btn-modal-medical-history"
                                    class="pointer w-full"
                                    data-id="<?= htmlspecialchars($history->historyId); ?>"
                                    data-reason="<?= htmlspecialchars($history->reason); ?>"
                                    data-notes="<?= htmlspecialchars($history->notes); ?>"
                                    data-prescriptions="<?= htmlspecialchars($history->prescriptions); ?>"
                                    data-firstName="<?= htmlspecialchars($history->firstName); ?>"
                                    data-lastName="<?= htmlspecialchars($history->lastName); ?>"
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
                    <p>There is no history.</p>
                <?php endif; ?>
            </div>
        </div>
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
</div>
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
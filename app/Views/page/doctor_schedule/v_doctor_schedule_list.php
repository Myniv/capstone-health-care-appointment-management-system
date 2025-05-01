<?= $this->extend('layouts/admin_layout'); ?>

<?= $this->section('content'); ?>
<h2 class="text-2xl font-bold mb-4">Doctor Schedule List</h2>

<div class="bg-base-100 p-6 rounded-md shadow-md">
    <!-- Add Button -->
    <div class="flex gap-4 mb-4">
        <a href="/admin/doctor-schedule/create" class="btn btn-outline btn-success">Add Doctor Schedule</a>
    </div>

    <!-- Search and Filters -->
    <form action="<?= $baseUrl ?>" method="get" class="flex flex-wrap items-center gap-4 mb-4">
        <div class="flex flex-grow items-center">
            <input type="text" class="input input-bordered w-full md:w-auto flex-grow" name="search"
                value="<?= $params->search ?>" placeholder="Search...">
            <button type="submit" class="btn btn-primary ml-2">Search</button>
        </div>

        <div class="form-control w-full md:w-2/6">
            <select class="select select-bordered" name="doctor_category" id="doctor_category"
                onchange="this.form.submit()">
                <option value="">All Doctor Category</option>
                <?php foreach ($doctor_category as $group): ?>
                    <option value="<?= $group->id ?>" <?= $params->doctor_category == $group->id ? 'selected' : '' ?>>
                        <?= $group->name ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-control w-full md:w-1/6">
            <select name="perPage" class="select select-bordered" onchange="this.form.submit()">
                <option value="2" <?= ($params->perPage == 2) ? 'selected' : '' ?>>2 per Page</option>
                <option value="5" <?= ($params->perPage == 5) ? 'selected' : '' ?>>5 per Page</option>
                <option value="10" <?= ($params->perPage == 10) ? 'selected' : '' ?>>10 per Page</option>
                <option value="25" <?= ($params->perPage == 25) ? 'selected' : '' ?>>25 per Page</option>
            </select>
        </div>

        <div class="form-control w-full md:w-auto">
            <a href="<?= $params->getResetUrl($baseUrl) ?>" class="btn btn-primary">Reset</a>
        </div>

        <input type="hidden" name="sort" value="<?= $params->sort; ?>">
        <input type="hidden" name="order" value="<?= $params->order; ?>">
    </form>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="table table-zebra w-full">
            <thead>
                <tr>
                    <th>
                        <a href="<?= $params->getSortUrl('id', $baseUrl) ?>" class="link link-hover">
                            ID
                            <?= $params->isSortedBy('id') ? ($params->getSortDirection() == 'asc' ? '↑' : '↓') : '↕' ?>
                        </a>
                    </th>

                    <th>
                        <a href="<?= $params->getSortUrl('doctor_id', $baseUrl) ?>" class="link link-hover">
                            Doctor Name
                            <?= $params->isSortedBy('doctor_id') ? ($params->getSortDirection() == 'asc' ? '↑' : '↓') : '↕' ?>
                        </a>
                    </th>
                    <th>
                        <a href="<?= $params->getSortUrl('doctor_email', $baseUrl) ?>" class="link link-hover">
                            Doctor Email
                            <?= $params->isSortedBy('doctor_email') ? ($params->getSortDirection() == 'asc' ? '↑' : '↓') : '↕' ?>
                        </a>
                    </th>
                    <th>
                        <a href="<?= $params->getSortUrl('doctor_category_name', $baseUrl) ?>" class="link link-hover">
                            Doctor Category
                            <?= $params->isSortedBy('doctor_category_name') ? ($params->getSortDirection() == 'asc' ? '↑' : '↓') : '↕' ?>
                        </a>
                    </th>
                    <th>
                        <a href="<?= $params->getSortUrl('room_name', $baseUrl) ?>" class="link link-hover">
                            Room
                            <?= $params->isSortedBy('room_name') ? ($params->getSortDirection() == 'asc' ? '↑' : '↓') : '↕' ?>
                        </a>
                    </th>
                    <th>
                        <a href="<?= $params->getSortUrl('start_time', $baseUrl) ?>" class="link link-hover">
                            Start Time
                            <?= $params->isSortedBy('start_time') ? ($params->getSortDirection() == 'asc' ? '↑' : '↓') : '↕' ?>
                        </a>
                    </th>
                    <th>
                        <a href="<?= $params->getSortUrl('end_time', $baseUrl) ?>" class="link link-hover">
                            End Time
                            <?= $params->isSortedBy('end_time') ? ($params->getSortDirection() == 'asc' ? '↑' : '↓') : '↕' ?>
                        </a>
                    </th>
                    <th>
                        <a href="<?= $params->getSortUrl('max_patient', $baseUrl) ?>" class="link link-hover">
                            Max Patient
                            <?= $params->isSortedBy('max_patient') ? ($params->getSortDirection() == 'asc' ? '↑' : '↓') : '↕' ?>
                        </a>
                    </th>
                    <th>
                        <a href="<?= $params->getSortUrl('status', $baseUrl) ?>" class="link link-hover">
                            Status
                            <?= $params->isSortedBy('status') ? ($params->getSortDirection() == 'asc' ? '↑' : '↓') : '↕' ?>
                        </a>
                    </th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($doctor_schedule as $schedule): ?>
                    <tr>
                        <td><?= $schedule->id ?></td>
                        <td><?= $schedule->doctor_first_name ?> <?= $schedule->doctor_last_name ?></td>
                        <td><?= $schedule->doctor_email ?></td>
                        <td><?= $schedule->doctor_category_name ?></td>
                        <td><?= $schedule->room_name ?></td>
                        <td><?= $schedule->start_time ?></td>
                        <td><?= $schedule->end_time ?></td>
                        <td><?= $schedule->max_patient ?></td>
                        <td><?= $schedule->status ?></td>
                        <td>
                            <a href="/admin/doctor-schedule/update/<?= $schedule->id ?>"
                                class="btn btn-warning btn-sm">Edit</a>
                            <form action="/admin/doctor-schedule/delete/<?= $schedule->id ?>" method="post" class="inline">
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="btn btn-error btn-sm"
                                    onclick="return confirm('Are you sure want to delete this user?');">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-8 text-center">
        <?= $pager->links('doctor_absent', 'custom_pager') ?>
        <div class="mt-2">
            <small>Show <?= count($doctor_schedule) ?> of <?= $total ?> total data (Page <?= $params->page ?>)</small>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>
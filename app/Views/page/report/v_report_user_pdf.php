<?= $this->extend('layouts/admin_layout'); ?>

<?= $this->section('content'); ?>
<h2 class="text-2xl font-bold mb-4">Report User</h2>

<div class="bg-base-100 p-6 rounded-md shadow-md">
    <form action="<?= $baseUrl ?>" method="get" class="">
        <div class="flex flex-wrap items-center gap-4 w-full">
            <div class="form-control w-full md:w-1/3">
                <label for="role" class="label">
                    <span class="label-text">Filter by Role</span>
                </label>
                <div class="flex items-center gap-2">
                    <select class="select select-bordered flex-1" name="role" id="role" required
                        onchange="this.form.submit()">
                        <option value="">All Roles</option>
                        <?php foreach ($groups as $group): ?>
                            <option value="<?= $group->id ?>" <?= $params->role == $group->id ? 'selected' : '' ?>>
                                <?= $group->name ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <a href="<?= $params->getResetUrl($baseUrl) ?>" class="btn btn-primary whitespace-nowrap">Reset</a>
                </div>
            </div>

            <a href="<?= base_url('report/user/pdf') . '?' . http_build_query([
                            'role' => $params->role,
                        ]) ?>" class="btn btn-success whitespace-nowrap mt-4 px-4" target="_blank">
                <i class="bi bi-file-earmark-pdf-fill me-1"></i> Export PDF
            </a>
        </div>

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
                    <th>
                        <a href="<?= $params->getSortUrl('user_id', $baseUrl) ?>" class="link link-hover">
                            ID
                            <?= $params->isSortedBy('user_id') ? ($params->getSortDirection() == 'asc' ? '↑' : '↓') : '↕' ?>
                        </a>
                    </th>
                    <th>
                        <a href="<?= $params->getSortUrl('username', $baseUrl) ?>" class="link link-hover">
                            Username
                            <?= $params->isSortedBy('username') ? ($params->getSortDirection() == 'asc' ? '↑' : '↓') : '↕' ?>
                        </a>
                    </th>
                    <th>
                        <a href="<?= $params->getSortUrl('email', $baseUrl) ?>" class="link link-hover">
                            Email
                            <?= $params->isSortedBy('email') ? ($params->getSortDirection() == 'asc' ? '↑' : '↓') : '↕' ?>
                        </a>
                    </th>
                    <th>
                        <a href="<?= $params->getSortUrl('first_name', $baseUrl) ?>" class="link link-hover">
                            Name
                            <?= $params->isSortedBy('first_name') ? ($params->getSortDirection() == 'asc' ? '↑' : '↓') : '↕' ?>
                        </a>
                    </th>
                    <th>
                        <a href="<?= $params->getSortUrl('doctor_category', $baseUrl) ?>" class="link link-hover">
                            Doctor Category
                            <?= $params->isSortedBy('doctor_category') ? ($params->getSortDirection() == 'asc' ? '↑' : '↓') : '↕' ?>
                        </a>
                    </th>
                    <th>
                        <a href="<?= $params->getSortUrl('role', $baseUrl) ?>" class="link link-hover">
                            Role
                            <?= $params->isSortedBy('role') ? ($params->getSortDirection() == 'asc' ? '↑' : '↓') : '↕' ?>
                        </a>
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= $user->user_id ?></td>
                        <td><?= $user->username ?></td>
                        <td><?= $user->email ?></td>
                        <td><?= $user->first_name . ' ' . $user->last_name ?></td>
                        <td><?= ucfirst($user->doctor_category) ?></td>
                        <td><?= ucfirst($user->role) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="mt-8 text-center">
        <?= $pager->links('users', 'custom_pager') ?>
        <div class="mt-2">
            <small>Show <?= count($users) ?> of <?= $total ?> total data (Page <?= $params->page ?>)</small>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>
<?= $this->extend('layouts/admin_layout'); ?>

<?= $this->section('content'); ?>
<div class="container mx-auto mt-4">
    <h2 class="text-2xl font-bold mb-4">User List</h2>

    <div class="flex gap-4 mb-4">
        <a href="/admin/users/doctor/create" class="btn btn-outline btn-success">Add Doctor</a>
        <a href="/admin/users/patient/create" class="btn btn-outline btn-success">Add Patient</a>
    </div>

    <form action="<?= $baseUrl ?>" method="get" class="">
        <div class="flex flex-grow items-center mb-4">
            <input type="text" class="input input-bordered w-full md:w-auto flex-grow" name="search" value="<?= $params->search ?>"
                placeholder="Search...">
            <button type="submit" class="btn btn-primary ml-2">Search</button>
        </div>

        <div class="flex flex-wrap gap-4 mb-4">
            <div class="form-control w-full md:w-1/3">
                <select class="select select-bordered" name="role" id="role" required onchange="this.form.submit()">
                    <option value="">All Role</option>
                    <?php foreach ($groups as $group): ?>
                        <option value="<?= $group->id ?>" <?= $params->role == $group->id ? 'selected' : '' ?>>
                            <?= $group->name ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-control w-full md:w-1/3">
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
        </div>

        <input type="hidden" name="sort" value="<?= $params->sort; ?>">
        <input type="hidden" name="order" value="<?= $params->order; ?>">
    </form>

    <div class="overflow-x-auto">
        <table class="table table-zebra w-full">
            <thead>
                <tr>
                    <th>
                        <a href="<?= $params->getSortUrl('user_id', $baseUrl) ?>" class="link link-hover">
                            ID <?= $params->isSortedBy('user_id') ? ($params->getSortDirection() == 'asc' ? '↑' : '↓') : '↕' ?>
                        </a>
                    </th>
                    <th>
                        <a href="<?= $params->getSortUrl('username', $baseUrl) ?>" class="link link-hover">
                            Username <?= $params->isSortedBy('username') ? ($params->getSortDirection() == 'asc' ? '↑' : '↓') : '↕' ?>
                        </a>
                    </th>
                    <th>
                        <a href="<?= $params->getSortUrl('email', $baseUrl) ?>" class="link link-hover">
                            Email <?= $params->isSortedBy('email') ? ($params->getSortDirection() == 'asc' ? '↑' : '↓') : '↕' ?>
                        </a>
                    </th>
                    <th>
                        <a href="<?= $params->getSortUrl('first_name', $baseUrl) ?>" class="link link-hover">
                            Name <?= $params->isSortedBy('first_name') ? ($params->getSortDirection() == 'asc' ? '↑' : '↓') : '↕' ?>
                        </a>
                    </th>
                    <th>
                        <a href="<?= $params->getSortUrl('doctor_category', $baseUrl) ?>" class="link link-hover">
                            Category <?= $params->isSortedBy('doctor_category') ? ($params->getSortDirection() == 'asc' ? '↑' : '↓') : '↕' ?>
                        </a>
                    </th>
                    <th>
                        <a href="<?= $params->getSortUrl('role', $baseUrl) ?>" class="link link-hover">
                            Role <?= $params->isSortedBy('role') ? ($params->getSortDirection() == 'asc' ? '↑' : '↓') : '↕' ?>
                        </a>
                    </th>
                    <th>Action</th>
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
                        <td>
                            <?php if ($user->role == 'patient'): ?>
                                <a href="/admin/users/patient/profile/<?= $user->user_id ?>" class="btn btn-info btn-sm">Detail</a>
                                <a href="/admin/users/patient/update/<?= $user->user_id ?>" class="btn btn-warning btn-sm">Edit</a>
                                <form action="/admin/users/patient/delete/<?= $user->user_id ?>" method="post" class="inline">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button type="submit" class="btn btn-error btn-sm"
                                        onclick="return confirm('Are you sure want to delete this user?');">
                                        Delete
                                    </button>
                                </form>
                            <?php elseif ($user->role == 'doctor'): ?>
                                <a href="/admin/users/doctor/profile/<?= $user->user_id ?>" class="btn btn-info btn-sm">Detail</a>
                                <a href="/admin/users/doctor/update/<?= $user->user_id ?>" class="btn btn-warning btn-sm">Edit</a>
                                <form action="/admin/users/doctor/delete/<?= $user->user_id ?>" method="post" class="inline">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button type="submit" class="btn btn-error btn-sm"
                                        onclick="return confirm('Are you sure want to delete this user?');">
                                        Delete
                                    </button>
                                </form>
                            <?php else: ?>
                                N/A
                            <?php endif; ?>
                        </td>
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
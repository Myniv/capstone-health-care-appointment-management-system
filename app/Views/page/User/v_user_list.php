<div class="container mt-4">
    <h2 class="mb-3">User List</h2>

    <a href="/admin/users/doctor/create" class="btn btn-success mb-3">Add Doctor</a>
    <a href="/admin/users/patient/create" class="btn btn-success mb-3">Add Patient</a>

    <form action="<?= $baseUrl ?>" method="get" class="form-inline mb-3">
        <div class="row mb-4">
            <div class="col-md-5">
                <div class="input-group mr-2">
                    <input type="text" class="form-control" name="search" value="<?= $params->search ?>"
                        placeholder="Search...">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-primary">Search</button>
                    </div>
                </div>
            </div>

            <div class="col-md-2">
                <div class="input-group ml-2">
                    <select class="form-select <?= session('errors.group') ? 'is-invalid' : '' ?>" name="role" id="role"
                        required onchange="this.form.submit()">
                        <option value="">All Role</option>
                        <?php foreach ($groups as $group): ?>
                            <option value=" <?= $group->id ?>" <?= $params->role == $group->id ? 'selected' : '' ?>>
                                <?= $group->name ?>
                            </option>
                        <?php endforeach; ?>
                    </select>

                </div>
            </div>


            <div class="col-md-2">
                <div class="input-group ml-2">
                    <select name="perPage" class="form-select" onchange="this.form.submit()">
                        <option value="2" <?= ($params->perPage == 2) ? 'selected' : '' ?>>
                            2 per Page
                        </option>
                        <option value="5" <?= ($params->perPage == 5) ? 'selected' : '' ?>>
                            5 per Page
                        </option>
                        <option value="10" <?= ($params->perPage == 10) ? 'selected' : '' ?>>
                            10 per Page
                        </option>
                        <option value="25" <?= ($params->perPage == 25) ? 'selected' : '' ?>>
                            25 per Page
                        </option>
                    </select>
                </div>
            </div>

            <div class="col-md-1">
                <a href="<?= $params->getResetUrl($baseUrl) ?>" class="btn btn-secondary ml-2">
                    Reset
                </a>
            </div>

            <input type="hidden" name="sort" value="<?= $params->sort; ?>">
            <input type="hidden" name="order" value="<?= $params->order; ?>">

        </div>
    </form>

    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>
                        <a class="text-white text-decoration-none"
                            href="<?= $params->getSortUrl('users.id', $baseUrl) ?>">
                            ID <?= $params->isSortedBy('users.id') ? ($params->getSortDirection() == 'asc' ?
                                '↑' : '↓') : '↕' ?>
                        </a>
                    </th>
                    <th>
                        <a class="text-white text-decoration-none"
                            href="<?= $params->getSortUrl('users.username', $baseUrl) ?>">
                            Username <?= $params->isSortedBy('users.username') ? ($params->getSortDirection() == 'asc' ?
                                '↑' : '↓') : '↕' ?>
                        </a>
                    </th>
                    <th>
                        <a class="text-white text-decoration-none"
                            href="<?= $params->getSortUrl('users.email', $baseUrl) ?>">
                            Email <?= $params->isSortedBy('users.email') ? ($params->getSortDirection() == 'asc' ?
                                '↑' : '↓') : '↕' ?>
                        </a>
                    </th>
                    <th>
                        <a class="text-white text-decoration-none"
                            href="<?= $params->getSortUrl('users.first_name', $baseUrl) ?>">
                            Name <?= $params->isSortedBy('users.first_name') ? ($params->getSortDirection() == 'asc' ?
                                '↑' : '↓') : '↕' ?>
                        </a>
                    </th>
                    <th>
                        <a class="text-white text-decoration-none"
                            href="<?= $params->getSortUrl('users.first_name', $baseUrl) ?>">
                            Phone <?= $params->isSortedBy('users.first_name') ? ($params->getSortDirection() == 'asc' ?
                                '↑' : '↓') : '↕' ?>
                        </a>
                    </th>
                    <th>
                        <a class="text-white text-decoration-none"
                            href="<?= $params->getSortUrl('users.first_name', $baseUrl) ?>">
                            Address <?= $params->isSortedBy('users.first_name') ? ($params->getSortDirection() == 'asc' ?
                                '↑' : '↓') : '↕' ?>
                        </a>
                    </th>
                    <th>
                        <a class="text-white text-decoration-none"
                            href="<?= $params->getSortUrl('users.first_name', $baseUrl) ?>">
                            Sex <?= $params->isSortedBy('users.first_name') ? ($params->getSortDirection() == 'asc' ?
                                '↑' : '↓') : '↕' ?>
                        </a>
                    </th>
                    <th>
                        <a class="text-white text-decoration-none"
                            href="<?= $params->getSortUrl('users.first_name', $baseUrl) ?>">
                            Dob <?= $params->isSortedBy('users.first_name') ? ($params->getSortDirection() == 'asc' ?
                                '↑' : '↓') : '↕' ?>
                        </a>
                    </th>
                    <th>
                        <a class="text-white text-decoration-none"
                            href="<?= $params->getSortUrl('users.first_name', $baseUrl) ?>">
                            Doctor Category <?= $params->isSortedBy('users.first_name') ? ($params->getSortDirection() == 'asc' ?
                                '↑' : '↓') : '↕' ?>
                        </a>
                    </th>
                    <th>
                        <a class="text-white text-decoration-none"
                            href="<?= $params->getSortUrl('auth_groups.name', $baseUrl) ?>">
                            Role <?= $params->isSortedBy('auth_groups.name') ? ($params->getSortDirection() == 'asc' ?
                                '↑' : '↓') : '↕' ?>
                        </a>
                    </th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= $user->userId ?></td>
                        <td><?= $user->username ?></td>
                        <td><?= $user->email ?></td>
                        <td><?= $user->front_name . ' ' . $user->last_name ?></td>
                        <td><?= $user->phone ?></td>
                        <td><?= $user->address ?></td>
                        <td><?= $user->sex ?></td>
                        <td><?= $user->dob ?></td>
                        <td><?= $user->doctor_category ?></td>
                        <td><?= $user->role ?></td>
                        <td>
                            <a href="/admin/customer/profile-parser/<?= $user->id ?>" class="btn btn-info btn-sm">Detail</a>
                            <a href="/admin/customer/update/<?= $user->id ?>" class="btn btn-warning btn-sm">Edit</a>
                            <form action="/admin/customer/delete/<?= $user->id ?>" method="post" class="d-inline">
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Are you sure want to delete this user?');">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?= $pager->links('users', 'custom_pager') ?>
        <div class="text-center mt-2">
            <small>Show <?= count($users) ?> of <?= $total ?> total data (Page
                <?= $params->page ?>)</small>
        </div>
    </div>
</div>
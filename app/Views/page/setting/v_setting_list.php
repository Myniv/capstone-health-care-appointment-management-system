<?= $this->extend('layouts/admin_layout'); ?>

<?= $this->section('content'); ?>

<h2 class="text-2xl font-bold mb-4">Setting List</h2>

<div class="bg-base-100 p-6 rounded-md shadow-md">
    <div class="flex gap-4 mb-4">
        <a href="/admin/setting/create" class="btn btn-outline btn-success">Add Setting</a>
    </div>

    <!-- Search and Filters -->
    <form action="<?= $baseUrl ?>" method="get" class="flex flex-wrap items-center gap-4 mb-4">
        <div class="flex flex-grow items-center">
            <input type="text" class="input input-bordered w-full md:w-auto flex-grow" name="search"
                value="<?= $params->search ?>" placeholder="Search...">
            <button type="submit" class="btn btn-primary ml-2">Search</button>
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
                        <a href="<?= $params->getSortUrl('settings.id', $baseUrl) ?>" class="link link-hover">
                            No.
                            <?= $params->isSortedBy('settings.id') ? ($params->getSortDirection() == 'asc' ? '↑' : '↓') : '↕' ?>
                        </a>
                    </th>

                    <th>
                        <a href="<?= $params->getSortUrl('settings.key', $baseUrl) ?>" class="link link-hover">
                            Key
                            <?= $params->isSortedBy('settings.key') ? ($params->getSortDirection() == 'asc' ? '↑' : '↓') : '↕' ?>
                        </a>
                    </th>
                    <th>
                        <a href="<?= $params->getSortUrl('settings.value', $baseUrl) ?>" class="link link-hover">
                            Value
                            <?= $params->isSortedBy('settings.value') ? ($params->getSortDirection() == 'asc' ? '↑' : '↓') : '↕' ?>
                        </a>
                    </th>
                    <th>
                        <a href="<?= $params->getSortUrl('settings.description', $baseUrl) ?>" class="link link-hover">
                            Description
                            <?= $params->isSortedBy('settings.description') ? ($params->getSortDirection() == 'asc' ? '↑' : '↓') : '↕' ?>
                        </a>
                    </th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $total = $total ?? 0;
                $start = ($params->page - 1) * $params->perPage;

                $i = $params->order === 'asc'
                    ? $total - $start
                    : $start + 1;
                ?>
                <?php foreach ($settings as $setting): ?>
                    <tr>
                        <td><?= $i ?><?php $params->order === 'asc' ? $i-- : $i++; ?></td>
                        <td><?= $setting->key ?></td>
                        <td><?= $setting->value ?></td>
                        <td><?= $setting->description ?></td>
                        <td>
                            <!-- <a href="/admin/setting/detail/<?= $setting->id ?>" class="btn btn-primary btn-sm">Detail</a> -->
                            <a href="/admin/setting/update/<?= $setting->id ?>" class="btn btn-warning btn-sm">Edit</a>
                            <form action="/admin/setting/delete/<?= $setting->id ?>" method="post" class="inline">
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
        <?= $pager->links('settings', 'custom_pager') ?>
        <div class="mt-2">
            <small>Show <?= count($settings) ?> of <?= $total ?> total data (Page <?= $params->page ?>)</small>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>
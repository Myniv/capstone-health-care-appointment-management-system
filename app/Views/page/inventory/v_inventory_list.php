<?= $this->extend('layouts/admin_layout'); ?>

<?= $this->section('content'); ?>
<h2 class="text-2xl font-bold mb-4">Inventory List</h2>

<div class="bg-base-100 p-6 rounded-md shadow-md">
    <!-- Add Button -->
    <div class="flex gap-4 mb-4">
        <a href="/admin/inventory/create" class="btn btn-outline btn-success">Add inventory</a>
    </div>

    <!-- Search and Filters -->
    <form action="<?= $baseUrl ?>" method="get" class="flex flex-wrap items-center gap-4 mb-4">
        <div class="flex flex-grow items-center">
            <input type="text" class="input input-bordered w-full md:w-auto flex-grow" name="search"
                value="<?= $params->search ?>" placeholder="Search...">
            <button type="submit" class="btn btn-primary ml-2">Search</button>
        </div>

        <div class="form-control w-full md:w-1/6">
            <select class="select select-bordered" name="status" id="role" onchange="this.form.submit()">
                <option value="">Status</option>
                <option value="Available" <?= ($params->status == 'Available') ? 'selected' : '' ?>>Available</option>
                <option value="In Use" <?= ($params->status == 'In Use') ? 'selected' : '' ?>>In Use</option>
                <option value="Maintenance" <?= ($params->status == 'Maintenance') ? 'selected' : '' ?>>Maintenance
                </option>
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
                        <a href="<?= $params->getSortUrl('inventories.id', $baseUrl) ?>" class="link link-hover">
                            ID
                            <?= $params->isSortedBy('inventories.id') ? ($params->getSortDirection() == 'asc' ? '↑' : '↓') : '↕' ?>
                        </a>
                    </th>
                    <th>
                        <a href="<?= $params->getSortUrl('inventories.serial_number', $baseUrl) ?>"
                            class="link link-hover">
                            Serial Number
                            <?= $params->isSortedBy('inventories.serial_number') ? ($params->getSortDirection() == 'asc' ? '↑' : '↓') : '↕' ?>
                        </a>
                    </th>
                    <th>
                        <a href="<?= $params->getSortUrl('inventories.name', $baseUrl) ?>" class="link link-hover">
                            Name
                            <?= $params->isSortedBy('inventories.name') ? ($params->getSortDirection() == 'asc' ? '↑' : '↓') : '↕' ?>
                        </a>
                    </th>
                    <th>
                        <a href="<?= $params->getSortUrl('inventories.function', $baseUrl) ?>" class="link link-hover">
                            Function
                            <?= $params->isSortedBy('inventories.function') ? ($params->getSortDirection() == 'asc' ? '↑' : '↓') : '↕' ?>
                        </a>
                    </th>
                    <th>
                        <a href="<?= $params->getSortUrl('inventories.status', $baseUrl) ?>" class="link link-hover">
                            Status
                            <?= $params->isSortedBy('inventories.status') ? ($params->getSortDirection() == 'asc' ? '↑' : '↓') : '↕' ?>
                        </a>
                    </th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($inventories as $inventory): ?>
                    <tr>
                        <td><?= $inventory->id ?></td>
                        <td><?= $inventory->serial_number ?></td>
                        <td><?= $inventory->name ?></td>
                        <td><?= $inventory->function ?></td>
                        <td><?= $inventory->status ?></td>
                        <td>
                            <a href="/admin/inventory/update/<?= $inventory->id ?>" class="btn btn-warning btn-sm">Edit</a>
                            <form action="/admin/inventory/delete/<?= $inventory->id ?>" method="post" class="inline">
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
        <?= $pager->links('inventories', 'custom_pager') ?>
        <div class="mt-2">
            <small>Show <?= count($inventories) ?> of <?= $total ?> total data (Page <?= $params->page ?>)</small>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>
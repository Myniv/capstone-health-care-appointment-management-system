<?= $this->extend('layouts/admin_layout'); ?>

<?= $this->section('content'); ?>
<div class="container mx-auto mt-4">
    <h2 class="text-2xl font-bold mb-4">Doctor Category List</h2>

    <!-- Add Category Button -->
    <div class="flex gap-4 mb-4">
        <a href="/admin/doctor-category/create" class="btn btn-outline btn-success">Add Category</a>
    </div>

    <!-- Search and Filters -->
    <form action="<?= $baseUrl ?>" method="get" class="flex flex-wrap items-center gap-4 mb-4">
        <div class="flex flex-grow items-center">
            <input type="text" class="input input-bordered w-full md:w-auto flex-grow" name="search" value="<?= $params->search ?>"
                placeholder="Search...">
            <button type="submit" class="btn btn-primary ml-2">Search</button>
        </div>

        <div class="form-control w-full md:w-1/4">
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
                            ID <?= $params->isSortedBy('id') ? ($params->getSortDirection() == 'asc' ? '↑' : '↓') : '↕' ?>
                        </a>
                    </th>
                    <th>
                        <a href="<?= $params->getSortUrl('name', $baseUrl) ?>" class="link link-hover">
                            Name <?= $params->isSortedBy('name') ? ($params->getSortDirection() == 'asc' ? '↑' : '↓') : '↕' ?>
                        </a>
                    </th>
                    <th>
                        <a href="<?= $params->getSortUrl('description', $baseUrl) ?>" class="link link-hover">
                            Description <?= $params->isSortedBy('description') ? ($params->getSortDirection() == 'asc' ? '↑' : '↓') : '↕' ?>
                        </a>
                    </th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($doctor_category as $category): ?>
                    <tr>
                        <td><?= $category->id ?></td>
                        <td><?= $category->name ?></td>
                        <td><?= $category->description ?></td>
                        <td>
                            <a href="/admin/doctor-category/update/<?= $category->id ?>" class="btn btn-warning btn-sm">Edit</a>
                            <form action="/admin/doctor-category/delete/<?= $category->id ?>" method="post" class="inline">
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="btn btn-error btn-sm"
                                    onclick="return confirm('Are you sure want to delete this category?');">
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
        <?= $pager->links('doctor_category', 'custom_pager') ?>
        <div class="mt-2">
            <small>Show <?= count($doctor_category) ?> of <?= $total ?> total data (Page <?= $params->page ?>)</small>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>
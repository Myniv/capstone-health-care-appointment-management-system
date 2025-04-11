<div class="container mt-4">
    <h2 class="mb-3">Doctor Category List</h2>

    <a href="/admin/doctor-category/create" class="btn btn-success mb-3">Add Category</a>

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
                            href="<?= $params->getSortUrl('id', $baseUrl) ?>">
                            ID <?= $params->isSortedBy('id') ? ($params->getSortDirection() == 'asc' ?
                                '↑' : '↓') : '↕' ?>
                        </a>
                    </th>
                    <th>
                        <a class="text-white text-decoration-none" href="<?= $params->getSortUrl('name', $baseUrl) ?>">
                            Name <?= $params->isSortedBy('name') ? ($params->getSortDirection() == 'asc' ?
                                '↑' : '↓') : '↕' ?>
                        </a>
                    </th>
                    <th>
                        <a class="text-white text-decoration-none"
                            href="<?= $params->getSortUrl('description', $baseUrl) ?>">
                            Description <?= $params->isSortedBy('description') ? ($params->getSortDirection() == 'asc' ?
                                '↑' : '↓') : '↕' ?>
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
                            <a href="/admin/doctor-category/update/<?= $category->id ?>"
                                class="btn btn-warning btn-sm">Edit</a>

                            <form action="/admin/doctor-category/delete/<?= $category->id ?>" method="post"
                                class="d-inline">
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
        <?= $pager->links('doctor_category', 'custom_pager') ?>
        <div class="text-center mt-2">
            <small>Show <?= count($doctor_category) ?> of <?= $total ?> total data (Page
                <?= $params->page ?>)</small>
        </div>
    </div>
</div>
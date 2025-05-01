<?= $this->extend('layouts/admin_layout'); ?>

<?= $this->section('content'); ?>
<h2 class="text-2xl font-bold mb-4">Doctor Absent List</h2>

<div class="bg-base-100 p-6 rounded-md shadow-md mb-4">
  <!-- Add Button -->
  <div class="flex gap-4 mb-4">
    <a href="/doctor/absent/create" class="btn btn-outline btn-success">Add Doctor Absent</a>
  </div>

  <!-- Search and Filters -->
  <form action="<?= $baseUrl ?>" method="get" class="flex flex-wrap items-center gap-4 mb-4">
    <div class="flex flex-grow items-center gap-2">
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
</div>

<div class="bg-base-100 p-6 rounded-md shadow-md">
  <!-- Table -->
  <div class="overflow-x-auto">
    <table class="table table-zebra w-full">
      <thead>
        <tr>
          <th>
            <a href="<?= $params->getSortUrl('date', $baseUrl) ?>" class="link link-hover">
              Date <?= $params->isSortedBy('date') ? ($params->getSortDirection() == 'asc' ? '↑' : '↓') : '↕' ?>
            </a>
          </th>
          <th>Reason</th>
          <!-- <th>Action</th> -->
        </tr>
      </thead>
      <tbody>
        <?php foreach ($doctor_absent as $absent): ?>
          <tr>
            <td><?= date('F j, Y', strtotime($absent->date)) ?></td>
            <td class="w-2/3"><?= $absent->reason ?></td>
            <!-- <td> <a href="" class="btn btn-warning btn-sm">Button</a>
              <form action="" method="post" class="inline">
                <input type="hidden" name="_method" value="DELETE">
                <button type="submit" class="btn btn-error btn-sm"
                  onclick="return confirm('Are you sure want to delete this category?');">
                  Button
                </button>
              </form>
            </td> -->
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

  <!-- Pagination -->
  <div class="mt-8 text-center">
    <?= $pager->links('doctor_absent', 'custom_pager') ?>
    <div class="mt-2">
      <small>Show <?= count($doctor_absent) ?> of <?= $total ?> total data (Page <?= $params->page ?>)</small>
    </div>
  </div>
</div>
<?= $this->endSection(); ?>
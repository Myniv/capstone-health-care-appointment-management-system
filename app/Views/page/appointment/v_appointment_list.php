<?= $this->extend('layouts/admin_layout'); ?>

<?= $this->section('content'); ?>
<div class="container mx-auto mt-4">
  <h2 class="text-2xl font-bold mb-4">Appointment List</h2>

  <!-- Add Button -->
  <div class="flex gap-4 mb-4">
    <a href="/appointment/create" class="btn btn-outline btn-success">Create Appointment</a>
  </div>

  <!-- Search and Filters -->
  <form action="<?= $baseUrl ?>" method="get" class="flex flex-wrap items-center gap-4 mb-4">
    <div class="flex flex-grow items-center gap-2">
      <input type="text" class="input input-bordered w-full md:w-auto flex-grow" name="search" value="<?= $params->search ?>"
        placeholder="Search...">
      <input type="date"
        name="date"
        class="input input-bordered <?= session('errors.date') ? 'input-error' : '' ?>"
        value="<?= $params->date ?>"
        placeholder="Select Date" />
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
        </tr>
      </thead>
      <tbody>
        <?php foreach ($appointment as $row): ?>
          <tr>
            <td><?= $row->id ?></td>

          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

  <!-- Pagination -->
  <div class="mt-8 text-center">
    <?= $pager->links('appointment', 'custom_pager') ?>
    <div class="mt-2">
      <small>Show <?= count($appointment) ?> of <?= $total ?> total data (Page <?= $params->page ?>)</small>
    </div>
  </div>
</div>
<?= $this->endSection(); ?>
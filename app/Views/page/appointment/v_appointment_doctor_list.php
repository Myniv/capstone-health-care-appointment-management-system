<?= $this->extend('layouts/admin_layout'); ?>

<?= $this->section('content'); ?>
<div class="container mx-auto mt-4">
  <!-- <h2 class="text-2xl font-bold mb-4"></h2> -->
  <h2 class="text-2xl font-bold mb-4"><?= 'Find Doctor'; ?></h2>

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



  <p class="text-gray-500/75 font-semibold mb-4">Doctor List</p>
  <div class="grid grid-cols-3">
    <?php foreach ($doctors as $row): ?>
      <div class="card card-border bg-base-100 w-full">
        <div class="card-body">
          <div class="flex gap-4">
            <div class="avatar">
              <div class="w-24 rounded-full">
                <img src="<?= base_url('profile-picture?path=' . $row->profile_picture); ?>" alt="Profile Picture <?= $row->first_name . ' ' . $row->last_name; ?>">
              </div>
            </div>
            <div class="">
              <h2 class="card-title"><?= $row->first_name ?> <?= $row->last_name ?></h2>
              <p class="text-gray-500/75"><?= ucfirst($row->categoryName) ?></p>
              <p class="text-gray-500/75">HealthCare Hospital</p>
            </div>
          </div>

          <form action="/appointment/create/form">
            <div class="card-actions justify-end">
              <button type="submit" class="btn btn-primary w-full">Create Appointment</button>
            </div>
            <input type="text" name="id" hidden value="<?= $row->id ?>">
          </form>
        </div>
      </div>
    <?php endforeach; ?>

  </div>


  <!-- Pagination -->
  <div class="mt-8 text-center">
    <?= $pager->links('doctors', 'custom_pager') ?>
    <div class="mt-2">
      <small>Show <?= count($doctors) ?> of <?= $total ?> total data (Page <?= $params->page ?>)</small>
    </div>
  </div>
</div>
<?= $this->endSection(); ?>
<?= $this->extend('layouts/admin_layout'); ?>

<?= $this->section('content'); ?>
<div class="container mx-auto mt-4">
  <h2 class="text-2xl font-bold mb-4">Doctor Absent List</h2>

  <!-- Add Button -->


  <!-- Search and Filters -->

  <!-- Table -->
  <div class="overflow-x-auto">
    <table class="table table-zebra w-full">
      <thead>
        <tr>
          <th>ID</th>
          <th>Doctor ID</th>
          <th>Date</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($doctor_absent as $absent): ?>
          <tr>
            <td><?= $absent->id ?></td>
            <td><?= $absent->doctor_id ?></td>
            <td><?= $absent->date ?></td>
            <td>-- ACTION --</td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

  <!-- Pagination -->

</div>
<?= $this->endSection(); ?>
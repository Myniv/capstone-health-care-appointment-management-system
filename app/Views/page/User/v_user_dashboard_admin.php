<?= $this->extend('layouts/admin_layout'); ?>

<?= $this->section('content'); ?>
<div class="grid grid-cols-1 md:grid-cols-2 md:grid-rows-[auto_1fr] gap-4 h-full">
    <div class="stats shadow-md bg-base-100">
        <div class="stat">
            <div class="stat-title">Total Doctors</div>
            <div class="stat-value"><?= $doctors; ?></div>
            <div class="stat-desc"></div>
        </div>
    </div>

    <div class="stats shadow-md bg-base-100">
        <div class="stat">
            <div class="stat-title">Total Patients</div>
            <div class="stat-value"><?= $patients; ?></div>
            <div class="stat-desc"></div>
        </div>
    </div>

    <div class="card bg-base-100 shadow-md p-4">
        <h3 class="card-title mb-4">Appointments in the Last 7 Days</h3>
        <canvas id="appointmentChart" height="200"></canvas>
    </div>

    <div class="card bg-base-100 shadow-md p-4">
        <h3 class="card-title mb-4">Patient Distribution by Doctor Category</h3>
        <canvas id="patientDistributionChart" height="100"></canvas>
    </div>
</div>
<?= $this->endSection(); ?>

<?= $this->section('scripts'); ?>
<script>
    const appointmentChartData = <?= json_encode($appointmentChartData); ?>;
    const patientDistributionChartData = <?= json_encode($patientDistributionChartData); ?>;

    // Bar Chart
    const barChart = document.getElementById('appointmentChart').getContext('2d');
    new Chart(barChart, {
        type: 'bar',
        data: {
            labels: appointmentChartData.labels,
            datasets: appointmentChartData.datasets
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: true,
                    position: 'top'
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Pie Chart
    const pieChart = document.getElementById('patientDistributionChart').getContext('2d');
    new Chart(pieChart, {
        type: 'pie',
        data: {
            labels: patientDistributionChartData.labels,
            datasets: patientDistributionChartData.datasets
        },
        options: {
            responsive: true,
            maintainAspectRatio: true, // Pastikan rasio aspek dipertahankan
            aspectRatio: 2, // Atur rasio aspek (contoh: 2 berarti lebar 2x tinggi)
            plugins: {
                legend: {
                    display: true,
                    position: 'top'
                }
            }
        }
    });
</script>
<?= $this->endSection(); ?>
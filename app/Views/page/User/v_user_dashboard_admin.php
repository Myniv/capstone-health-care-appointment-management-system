<?= $this->extend('layouts/admin_layout'); ?>

<?= $this->section('content'); ?>
<div class="grid grid-cols-1 md:grid-cols-4 md:grid-rows-[auto_1fr] gap-4 h-full">
    <div class="stats shadow-md bg-base-100 text-secondary">
        <div class="stat">
            <div class="stat-title">Total Users</div>
            <div class="stat-value"><?= $users; ?></div>
            <div class="stat-desc"></div>
        </div>
    </div>

    <div class="stats shadow-md bg-base-100 text-secondary">
        <div class="stat">
            <div class="stat-title">Total Rooms Available</div>
            <div class="stat-value"><?= $rooms; ?></div>
            <div class="stat-desc"></div>
        </div>
    </div>

    <div class="stats shadow-md bg-base-100 text-primary">
        <div class="stat">
            <div class="stat-title">Total Doctors</div>
            <div class="stat-value"><?= $doctors; ?></div>
            <div class="stat-desc"></div>
        </div>
    </div>

    <div class="stats shadow-md bg-base-100 text-primary">
        <div class="stat">
            <div class="stat-title">Total Patients</div>
            <div class="stat-value"><?= $patients; ?></div>
            <div class="stat-desc"></div>
        </div>
    </div>

    <div class="col-span-2 card bg-base-100 shadow-md p-4">
        <h3 class="card-title mb-4">Appointments in the Next 7 Days</h3>
        <canvas id="appointmentChart" class="h-full"></canvas>
    </div>

    <div class="col-span-2 card bg-base-100 shadow-md p-4">
        <h3 class="card-title mb-4">Patient Distribution by Doctor Category</h3>
        <canvas id="patientDistributionChart" class="h-full"></canvas>
    </div>
</div>
<?= $this->endSection(); ?>

<?= $this->section('scripts'); ?>
<script>
    const appointmentChartData = <?= json_encode($appointmentChartData); ?>;
    const patientDistributionChartData = <?= json_encode($patientDistributionChartData); ?>;
    console.table(patientDistributionChartData);

    // Bar Chart
    const barChart = document.getElementById('appointmentChart');
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
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Total Appointments'
                    },
                    ticks: {
                        callback: function(value) {
                            return Number.isInteger(value) ? value : null; // Hanya tampilkan bilangan bulat
                        },
                        stepSize: 1
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Date'
                    }
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
            maintainAspectRatio: true,
            aspectRatio: 2,
            plugins: {
                legend: {
                    position: 'right'
                }
            }
        }
    });
</script>
<?= $this->endSection(); ?>
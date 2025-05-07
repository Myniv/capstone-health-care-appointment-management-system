<?= $this->extend('layouts/admin_layout'); ?>

<?= $this->section('content'); ?>
<div class="grid grid-cols-1 md:grid-cols-4 md:grid-rows-[auto_1fr] gap-4 h-full statistics">
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
<script src="https://cdn.jsdelivr.net/npm/driver.js@latest/dist/driver.js.iife.js"></script>
<script>
    const appointmentChartData = <?= json_encode($appointmentChartData); ?>;
    const patientDistributionChartData = <?= json_encode($patientDistributionChartData); ?>;

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

    const isOnboardingAdmin = sessionStorage.getItem('isOnboardingAdmin');

    if (!isOnboardingAdmin) {
        const driver = window.driver.js.driver;

        const driverObj = driver({
            showProgress: true,
            steps: [{
                element: ".user-management",
                popover: {
                    title: 'User Management',
                    description: "Mengelola akun pasien dan dokter."
                }
            }, {
                element: ".override-appointment",
                popover: {
                    title: 'Override Appointment Scheduling',
                    description: "Mengatur ulang janji temu pasien secara manual jika dibutuhkan."
                }
            }, {
                element: ".system-settings",
                popover: {
                    title: 'System Settings',
                    description: "Mengatur parameter sistem seperti notifikasi, batas durasi rescheduling, dan lainnya."
                }
            }, {
                element: ".doctor-management",
                popover: {
                    title: 'Doctor Management',
                    description: "Mengelola kategori dokter dan mengatur ulang jadwal dokter."
                }
            }, {
                element: ".facility-management",
                popover: {
                    title: 'Facility Management',
                    description: "Mengelola sumber daya fasilitas seperti ruangan, peralatan medis, dan stok inventory."
                }
            }, {
                element: ".operational-reports",
                popover: {
                    title: "Operational Reports",
                    description: "Menghasilkan laporan user, resources, appointment,atau history untuk kebutuhan operasional."
                }
            }, {
                element: ".statistics",
                popover: {
                    title: "Data Statistics",
                    description: "Menampilkan data statistik antara lain total users, rooms available, total doctors, total patients, appointment in the next 7 days, patient distribution by doctor category."
                }
            }]
        });

        driverObj.drive();

        sessionStorage.setItem('isOnboardingAdmin', 'true');
    }
</script>
<?= $this->endSection(); ?>
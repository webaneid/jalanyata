<script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.0/dist/chart.min.js"></script>
<script>
const productWeightLabels = <?= json_encode($productWeightData['labels'] ?? []) ?>;
const productWeightValues = <?= json_encode($productWeightData['data'] ?? []) ?>;
const productGrowthLabels = <?= json_encode($productGrowthData['labels'] ?? []) ?>;
const productGrowthValues = <?= json_encode($productGrowthData['data'] ?? []) ?>;

const weightCtx = document.getElementById('productWeightChart').getContext('2d');
new Chart(weightCtx, {
    type: 'bar',
    data: {
        labels: productWeightLabels,
        datasets: [{
            label: 'Jumlah Produk',
            data: productWeightValues,
            backgroundColor: 'rgba(37, 99, 235, 0.78)',
            borderColor: 'rgba(29, 78, 216, 1)',
            borderWidth: 1,
            borderRadius: 6
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true,
                grid: { drawOnChartArea: false },
                border: { display: false }
            },
            x: {
                grid: { drawOnChartArea: false },
                border: { display: false }
            }
        },
        plugins: {
            legend: { display: false }
        }
    }
});

const growthCtx = document.getElementById('productGrowthChart').getContext('2d');
const growthGradient = growthCtx.createLinearGradient(0, 0, 0, 400);
growthGradient.addColorStop(0, 'rgba(37, 99, 235, 0.35)');
growthGradient.addColorStop(1, 'rgba(37, 99, 235, 0)');

new Chart(growthCtx, {
    type: 'line',
    data: {
        labels: productGrowthLabels,
        datasets: [{
            label: 'Jumlah Produk Ditambahkan',
            data: productGrowthValues,
            borderColor: 'rgba(37, 99, 235, 1)',
            backgroundColor: growthGradient,
            fill: true,
            tension: 0.35,
            pointBackgroundColor: 'rgba(37, 99, 235, 1)',
            pointBorderColor: '#fff',
            pointHoverBackgroundColor: '#fff',
            pointHoverBorderColor: 'rgba(37, 99, 235, 1)'
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true,
                title: {
                    display: true,
                    text: 'Jumlah Produk'
                }
            },
            x: {
                title: {
                    display: true,
                    text: 'Tahun-Bulan'
                }
            }
        },
        plugins: {
            legend: { display: false }
        }
    }
});
</script>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grafik Keuangan</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-gray-100 p-6">

<div class="max-w-4xl mx-auto bg-white rounded-xl shadow-md p-8">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">Grafik Keuangan (Live dari Database)</h2>

    <canvas id="grafikKeuangan" height="120"></canvas>
</div>

<script>
    const ctx = document.getElementById('grafikKeuangan').getContext('2d');

    const chart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: [],
            datasets: [{
                label: 'Pergerakan Keuangan',
                data: [],
                borderColor: 'rgba(0, 200, 83, 1)',
                backgroundColor: 'rgba(0, 200, 83, 0.2)',
                borderWidth: 2,
                pointRadius: 0,
                tension: 0.3,
            }]
        },
        options: {
            responsive: true,
            animation: false,
            plugins: {
                legend: { display: true }
            },
            scales: {
                x: { display: true },
                y: { display: true, beginAtZero: true }
            }
        }
    });

    // 🔥 Ambil data real-time dari Laravel API setiap 5 detik
    async function fetchData() {
        const res = await fetch("{{ route('keuangan.live') }}");
        const data = await res.json();

        chart.data.labels = data.map(item => item.tanggal);
        chart.data.datasets[0].data = data.map(item => item.jumlah);

        chart.update();
    }

    // Panggil pertama kali
    fetchData();

    // Update setiap 5 detik
    setInterval(fetchData, 5000);
</script>

</body>
</html>

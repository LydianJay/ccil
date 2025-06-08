<x-basecomponent>

    <div class="container py-4">
        <div class="row g-4">

            <div class="col-md-6">
                <div class="card shadow-sm h-100">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Age Group and Gender Distribution</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="ageGroupChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card shadow-sm h-100">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0">IP Group Distribution</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="ipGroupPie"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0">Age Distribution (Line Chart)</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="ageLineChart"></canvas>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {

            const ageFrequency = {!! json_encode($ageFrequency) !!};
            const ipGroupData = {!! json_encode($ipGroupData) !!};
            const ageGenderGroups = {!! json_encode($ageGenderGroups) !!};

            // Line Chart - Age Distribution
            new Chart(document.getElementById('ageLineChart').getContext('2d'), {
                type: 'line',
                data: {
                    labels: Object.keys(ageFrequency),
                    datasets: [{
                        label: 'Number of Individuals',
                        data: Object.values(ageFrequency),
                        fill: false,
                        borderColor: '#36A2EB',
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    plugins: { title: { display: true, text: 'Age Distribution' } },
                    scales: { y: { beginAtZero: true } }
                }
            });

            // Pie Chart - IP Group Distribution
            new Chart(document.getElementById('ipGroupPie').getContext('2d'), {
                type: 'pie',
                data: {
                    labels: Object.keys(ipGroupData),
                    datasets: [{
                        label: 'IP Group Distribution',
                        data: Object.values(ipGroupData),
                        backgroundColor: [
                            '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40'
                        ]
                    }]
                },
                options: {
                    responsive: true,
                    plugins: { title: { display: true, text: 'IP Group Distribution' } }
                }
            });

            // Pie Chart - Age Group and Gender Distribution
            new Chart(document.getElementById('ageGroupChart').getContext('2d'), {
                type: 'pie',
                data: {
                    labels: Object.keys(ageGenderGroups),
                    datasets: [{
                        label: 'Age Group and Gender Distribution',
                        data: Object.values(ageGenderGroups),
                        backgroundColor: [
                            '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0',
                            '#9966FF', '#FF9F40', '#C9CBCF'
                        ],
                        hoverOffset: 30
                    }]
                },
                options: {
                    responsive: true,
                    plugins: { title: { display: true, text: 'Age Group and Gender Distribution' } }
                }
            });

        });
    </script>

</x-basecomponent>
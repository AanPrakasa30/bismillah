@extends('layouts.app')

@section('body')
    <header>
        <x-main-header title="Ini dashboard utama" />
    </header>

    <section>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="w-full p-4 shadow rounded-lg border border-gray-100">
                <span class="text-blue-600">Lorem ipsum dolor sit amet.</span>
                <div class="text-lg sm:text-2xl font-bold mt-2 flex justify-end">
                    10123123132
                </div>
            </div>
            <div class="w-full p-4 shadow rounded-lg border border-gray-100">
                <span class="text-orange-400">Lorem ipsum dolor sit amet.</span>
                <div class="text-lg sm:text-2xl font-bold mt-2 flex justify-end">
                    10
                </div>
            </div>
            <div class="w-full p-4 shadow rounded-lg border border-gray-100">
                <span class="text-red-500">Lorem ipsum dolor sit amet.</span>
                <div class="text-lg sm:text-2xl font-bold mt-2 flex justify-end">
                    10
                </div>
            </div>
            <div class="w-full p-4 shadow rounded-lg border border-gray-100">
                <span class="text-green-500">Lorem ipsum dolor sit amet.</span>
                <div class="text-lg sm:text-2xl font-bold mt-2 flex justify-end">
                    10
                </div>
            </div>
            <div class="w-full p-4 shadow rounded-lg border border-gray-100">
                <span class="text-yellow-500">Lorem ipsum dolor sit amet.</span>
                <div class="text-lg sm:text-2xl font-bold mt-2 flex justify-end">
                    10
                </div>
            </div>
        </div>
    </section>

    <section class="mt-10">
        <div id="chart"></div>
    </section>
@endsection

@push('script')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    var options = {
          series: [44, 55, 13, 43, 22],
          chart: {
          width: 380,
          type: 'pie',
        },
        labels: ['Kelas A', 'Kelas B', 'Kelas C', 'Kelas D', 'Kelas E'],
        responsive: [{
          breakpoint: 480,
          options: {
            chart: {
              width: 200
            },
            legend: {
              position: 'bottom'
            }
          }
        }]
    };

    var chart = new ApexCharts(document.querySelector("#chart"), options);
    chart.render();
</script>
@endpush
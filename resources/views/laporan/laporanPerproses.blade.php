@extends('template.master')
@section('chart')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.6.2/chart.min.js"
        integrity="sha512-tMabqarPtykgDtdtSqCL3uLVM0gS1ZkUAVhRFu1vSEFgvB73niFQWJuvviDyBGBH22Lcau4rHB5p2K2T0Xvr6Q=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@endsection
@section('content')

    <div id="main-content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-12">
                        <h2 class="float-left">Laporan Berkas Perproses</h2>

                        {{-- <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html"><i class="fa fa-dashboard"></i></a>
                            </li>
                            <li class="breadcrumb-item">Dashboard</li>
                            <li class="breadcrumb-item active">Analytical</li>
                        </ul> --}}
                    </div>
                    {{-- <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="d-flex flex-row-reverse">
                            <div class="page_action">
                                <button type="button" class="btn btn-primary"><i class="fa fa-download"></i>
                                    Download report</button>
                                <button type="button" class="btn btn-secondary"><i class="fa fa-send"></i> Send
                                    report</button>
                            </div>
                            <div class="p-2 d-flex">

                            </div>
                        </div>
                    </div> --}}
                </div>
            </div>

            <div class="row justify-content-center clearfix row-deck">
                <div class="col-md-6 col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Laporan Berkas</h4>
                        </div>
                        <div class="card-body">
                            <table class="table table-sm">
                                <thead>
                                    <th>Proses</th>
                                    <th>Jumlah</th>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Berkas Masuk</td>
                                        <td>{{ $berkas_masuk }}</td>
                                    </tr>
                                    <tr>
                                        <td>Menunggu Penjadwalan</td>
                                        <td>{{ $menunggu_penjadwalan }}</td>
                                    </tr>
                                    <tr>
                                        <td>Sudah Dapat Jadwal</td>
                                        <td>{{ $sudah_penjadwalan }}</td>
                                    </tr>
                                    <tr>
                                        <td>Sudah Diukur</td>
                                        <td>{{ $sudah_dikur }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Chart Berkas Perproses</h4>
                        </div>
                        <div class="card-body">
                            <canvas id="persentase" width="300" height="300" class="bg-light"></canvas>
                        </div>
                    </div>
                </div>


            </div>

        </div>
    </div>


@section('script')
    <script>
        const dataPersen = {
            labels: [
                'Menunggu Penjadwalan',
                'Sudah Dapat Jadwal',
                'Sudah Diukur'
            ],
            datasets: [{
                label: 'Chart Berkas Perproses',
                data: [{{ $menunggu_penjadwalan }}, {{ $sudah_penjadwalan }}, {{ $sudah_dikur }}],
                backgroundColor: [
                    'rgb(0,62,105)',
                    'rgb(186,97,38)',
                    'rgb(254,199,61)'
                ],
                hoverOffset: 4
            }]
        };

        const ctx2 = document.getElementById('persentase');
        const myChart2 = new Chart(ctx2, {
            type: 'pie',
            data: dataPersen
        });
    </script>

    <script>
        $(document).ready(function() {

            <?php if(session('success')): ?>
            // notification popup
            toastr.options.closeButton = true;
            toastr.options.positionClass = 'toast-top-right';
            toastr.options.showDuration = 1000;
            toastr['success']('<?= session('success') ?>');
            <?php endif; ?>





            <?php if(session('errors')): ?>
            @foreach ($errors->all() as $error)
                // notification popup
                toastr.options.closeButton = true;
                toastr.options.positionClass = 'toast-top-right';
                toastr.options.showDuration = 1000;
                toastr['error']('<?= $error ?>');
            @endforeach
            <?php endif; ?>



        });
    </script>
@endsection
@endsection

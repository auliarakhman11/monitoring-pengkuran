@extends('template.master')
@section('content')

    <script src='{{ asset('fullcalendar') }}/dist/index.global.js'></script>



    <style>
        body {
            margin: 40px 10px;
            padding: 0;
            font-family: Arial, Helvetica Neue, Helvetica, sans-serif;
            font-size: 14px;
        }

        #calendar {
            max-width: 1100px;
            margin: 0 auto;
        }
    </style>

    <div id="main-content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-12">
                        <h2 class="float-left">Laporan Petugas Ukur</h2>

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
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-6">
                                    <p class="float-left">Periode :  {{ date('M Y', strtotime($tgl)) }}</p>
                                </div>
                                <div class="col-6">
                                    <button type="button" class="btn btn-sm btn-primary ml-2 float-right" data-toggle="modal"
                                        data-target="#modal_view">
                                        <i class="fa fa-eye"></i>
                                        View
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered text-center">
                                    <thead>
                                        <tr>
                                            <th>Petugas</th>
                                            @foreach ($dt_periode as $dr)
                                                <th>{{ $dr }}</th>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($dt_pengukuran as $d)
                                            <tr>
                                                <td class="text-left">{{ $d['petugas'] }}</td>
                                                @foreach ($d['dt_tgl'] as $dt)
                                                    <td>
                                                        @if ($dt['keluar'] == 1)
                                                            <p>Bussy</p>
                                                        @endif
                                                    </td>
                                                @endforeach
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>


            </div>

        </div>
    </div>



    <form action="" method="get">
        <div class="modal fade" id="modal_view" tabindex="-1" role="dialog" aria-labelledby="exampleModalView"
        aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalView">View</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="">Bulan</label>
                                    <select name="bulan" class="form-control" required>
                                        <option value="01" {{ $bulan == '01' ? 'selected' : '' }}>Januari</option>
                                        <option value="02" {{ $bulan == '02' ? 'selected' : '' }}>Februari</option>
                                        <option value="03" {{ $bulan == '03' ? 'selected' : '' }}>Maret</option>
                                        <option value="04" {{ $bulan == '04' ? 'selected' : '' }}>April</option>
                                        <option value="05" {{ $bulan == '05' ? 'selected' : '' }}>Mei</option>
                                        <option value="06" {{ $bulan == '06' ? 'selected' : '' }}>Juni</option>
                                        <option value="07" {{ $bulan == '07' ? 'selected' : '' }}>Juli</option>
                                        <option value="08" {{ $bulan == '08' ? 'selected' : '' }}>Agustus</option>
                                        <option value="09" {{ $bulan == '09' ? 'selected' : '' }}>September</option>
                                        <option value="10" {{ $bulan == '10' ? 'selected' : '' }}>Oktober</option>
                                        <option value="11" {{ $bulan == '11' ? 'selected' : '' }}>November</option>
                                        <option value="12" {{ $bulan == '12' ? 'selected' : '' }}>Desember</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="">Tahun</label>
                                    <input type="number" name="tahun" class="form-control" value="{{ $tahun }}" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">View</button>
                    </div>
                </div>
            </div>
        </div>
    </form>



@section('script')
    
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

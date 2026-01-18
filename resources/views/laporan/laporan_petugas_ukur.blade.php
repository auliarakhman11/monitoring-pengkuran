@extends('template.master')
@section('content')
    <style>
        .tableFixHead {
            overflow: auto;
            height: 500px;
        }

        .tableFixHead thead th {
            position: sticky;
            top: 0;
            z-index: 11;
        }

        /* Just common table stuff. Really. */
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            padding: 8px 16px;
        }

        th {
            background: #eee;
        }


        /* Custom CSS for sticky left column */
        .sticky-left {
            position: sticky;
            left: 0;
            background-color: #f8f9fa;
            /* Optional: adds a background color for visibility */
            z-index: 10;
            /* Ensures the sticky column appears above other table content */
        }

        /* Optional: Ensure table borders display correctly with sticky columns */
        .table-bordered .sticky-left {
            border-right: 1px solid #dee2e6;
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
                                    <p class="float-left">Periode : {{ date('M Y', strtotime($tgl)) }}</p>
                                </div>
                                <div class="col-6">
                                    <button type="button" class="btn btn-sm btn-primary ml-2 float-right"
                                        data-toggle="modal" data-target="#modal_view">
                                        <i class="fa fa-eye"></i>
                                        View
                                    </button>
                                    @if (session()->get('role_id') != 3)
                                        <button type="button" class="btn btn-sm btn-primary ml-2 float-right"
                                            data-toggle="modal" data-target="#modal_add_status">
                                            <i class="fa fa-plus"></i>
                                            Status
                                        </button>
                                    @endif

                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive tableFixHead">
                                <table class="table table-sm table-bordered text-center">
                                    <thead>
                                        <tr>
                                            <th class="sticky-left">Petugas</th>
                                            @foreach ($dt_periode as $dr)
                                                <th>{{ $dr }}</th>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($dt_pengukuran as $d)
                                            <tr>
                                                <td class="text-left sticky-left">{{ $d['petugas'] }}</td>
                                                @foreach ($d['dt_tgl'] as $dt)
                                                    <td>
                                                        @if ($dt['status'] == 'Sibuk')
                                                            <span class='badge badge-danger'>Sibuk</span>
                                                        @else
                                                            @if ($dt['status'] == 'Cuti')
                                                                <span class='badge badge-warning'>Cuti</span>
                                                            @else
                                                                @if ($dt['status'] == 'Minggu' || $dt['status'] == 'Sabtu')
                                                                    <span
                                                                        class='badge bg-danger text-light'>{{ $dt['status'] }}</span>
                                                                @else
                                                                    <p class="text-success" style="font-size: 10px;">
                                                                        TERSEDIA</p>
                                                                @endif
                                                            @endif
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
                                    <input type="number" name="tahun" class="form-control" value="{{ $tahun }}"
                                        required>
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

    <form action="{{ route('addStatusPu') }}" method="post">
        @csrf
        <div class="modal fade" id="modal_add_status" tabindex="-1" role="dialog" aria-labelledby="exampleModalStatus"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalStatus">Status Petugas Ukur</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Tanggal</th>
                                        <th>Petugas</th>
                                        <th>Status</th>
                                        <th>Hapus</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($list_status as $index => $d)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ date('d/m/Y', strtotime($d->tgl)) }}</td>
                                            <td>{{ $d->petugas->name }}</td>
                                            <td>{{ $d->status == 1 ? 'Tersedia' : ($d->status == 2 ? 'Sibuk' : 'Cuti') }}
                                            </td>
                                            <td><a href="{{ route('dropStatusPu', $d->id) }}"
                                                    onclick="return confirm('Apakah anda yakin ingin menghapus status?')"
                                                    class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="row mt-2">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="">Tanggal</label>
                                    <input type="date" name="tgl" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="">Petugas</label>
                                    <select name="petugas_id" class="form-control" required>
                                        <option value="">Pilih Petugas</option>
                                        @foreach ($petugas as $p)
                                            <option value="{{ $p->id }}">{{ $p->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="">Status</label>
                                    <select name="status" class="form-control" required>
                                        <option value="1">Tersedia</option>
                                        <option value="2">Sibuk</option>
                                        <option value="3">Cuti</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
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

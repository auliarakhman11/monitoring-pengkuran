@extends('template.master')
@section('content')
    <div id="main-content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-12">
                        <h2 class="float-left">Loket Pengukuran</h2>
                        <button type="button" class="btn btn-sm btn-primary float-right ml-2" data-toggle="modal"
                            data-target="#modal_tambah">
                            <i class="fa fa-plus-circle"></i>
                            Tambah Data
                        </button>
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
                    <div class="table-responsive">
                        <table class="table js-basic-example dataTable table-custom" id="table"
                            style="font-size: 12px;">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Berkas</th>
                                    <th>Pemohon</th>
                                    <th>Kelurahan</th>
                                    <th>Alamat</th>
                                    <th>No WA</th>
                                    <th>Tanggal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = 1;
                                @endphp
                                @foreach ($berkas as $d)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $d->no_berkas }} / {{ $d->tahun }}</td>
                                        <td>{{ $d->nm_pemohon }}</td>
                                        <td>{{ $d->kelurahan }}</td>
                                        <td>{{ $d->alamat }}</td>
                                        <td>{{ $d->no_tlp }}</td>
                                        <td>{{ date('d/m/Y', strtotime($d->tgl)) }}</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <button type="button" class="btn btn-sm btn-primary dropdown-toggle"
                                                    data-toggle="dropdown" aria-expanded="false">
                                                    Aksi
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="#model_penjadwalan{{ $d->id }}"
                                                        data-toggle="modal"><i class="fa fa-calendar-check-o"
                                                            aria-hidden="true"></i> Penjadwalan</a>
                                                    <a class="dropdown-item" href="#model_edit{{ $d->id }}"
                                                        data-toggle="modal"><i class="fa fa-edit"></i> Edit</a>
                                                    @if ($d->file_name)
                                                        <a class="dropdown-item btn_lihat_file" href="#model_lihat_file"
                                                            data-toggle="modal" file_name="{{ $d->file_name }}"
                                                            jenis_file="{{ $d->jenis_file }}"><i class="fa fa-eye"></i>
                                                            Lihat File</a>
                                                    @endif
                                                </div>
                                            </div>
                                            {{-- <button type="button" class="btn btn-sm btn-primary" data-toggle="modal"
                                                data-target="#model_penjadwalan{{ $d->id }}">
                                                <i class="fa fa-calendar-check-o" aria-hidden="true"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-primary" data-toggle="modal"
                                                data-target="#model_edit{{ $d->id }}">
                                                <i class="fa fa-edit"></i>
                                            </button>

                                            @if ($d->file_name)
                                                <button type="button" class="btn btn-sm btn-primary btn_lihat_file"
                                                    data-toggle="modal" file_name="{{ $d->file_name }}"
                                                    jenis_file="{{ $d->jenis_file }}" data-target="#model_lihat_file">
                                                    <i class="fa fa-eye"></i>
                                                </button>
                                            @endif --}}

                                            <form class="d-inline-block" action="{{ route('dropBerkas') }}" method="post">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $d->id }}">
                                                <button type="submit"
                                                    onclick="return confirm('Apakah anda yakin ingin menghapus berkas?')"
                                                    class="btn btn-sm btn-danger">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>


            </div>

        </div>
    </div>


    <form action="{{ route('addBerkas') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="modal fade" id="modal_tambah" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Tambah Berkas</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="row">

                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label for="">Tanggal Input</label>
                                    <input type="date" value="{{ date('Y-m-d') }}" class="form-control" name="tgl"
                                        required>
                                </div>
                            </div>

                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label for="">Nomor Berkas</label>
                                    <input type="text" class="form-control" name="no_berkas" required>
                                </div>
                            </div>

                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label for="">Tahun</label>
                                    <input type="text" class="form-control" name="tahun" required>
                                </div>
                            </div>

                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label for="">Nama Pemohon</label>
                                    <input type="text" class="form-control" name="nm_pemohon" required>
                                </div>
                            </div>

                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label for="">Kelurahan</label>
                                    <input type="text" class="form-control" name="kelurahan" required>
                                </div>
                            </div>

                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label for="">Nomor WA</label>
                                    <input type="number" class="form-control" name="no_tlp" required>
                                </div>
                            </div>

                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label for="">Alamat Bidang Tanah</label>
                                    <textarea class="form-control" name="alamat" cols="30" rows="3"></textarea>
                                </div>
                            </div>

                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label for="">Upload File</label>
                                    <input type="file" name="file_name" class="form-control"
                                        accept="application/pdf, image/png, image/jpeg">
                                </div>
                            </div>


                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Tambah</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    @foreach ($berkas as $d)
        <form action="{{ route('editBerkas') }}" method="post">
            @csrf
            @method('patch')
            <div class="modal fade" id="model_edit{{ $d->id }}" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Edit Berkas</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">

                            <div class="row">

                                <input type="hidden" name="id" value="{{ $d->id }}">

                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="">Tanggal Input</label>
                                        <input type="date" class="form-control" name="tgl"
                                            value="{{ $d->tgl }}" required>
                                    </div>
                                </div>

                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="">Nomor Berkas</label>
                                        <input type="text" class="form-control" name="no_berkas"
                                            value="{{ $d->no_berkas }}" required>
                                    </div>
                                </div>

                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="">Tahun</label>
                                        <input type="text" class="form-control" name="tahun"
                                            value="{{ $d->tahun }}" required>
                                    </div>
                                </div>

                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="">Nama Pemohon</label>
                                        <input type="text" class="form-control" name="nm_pemohon"
                                            value="{{ $d->nm_pemohon }}" required>
                                    </div>
                                </div>

                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="">Kelurahan</label>
                                        <input type="text" class="form-control" name="kelurahan"
                                            value="{{ $d->kelurahan }}" required>
                                    </div>
                                </div>

                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="">Nomor WA</label>
                                        <input type="number" class="form-control" name="no_tlp"
                                            value="{{ $d->no_tlp }}" required>
                                    </div>
                                </div>

                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="">Alamat Bidang Tanah</label>
                                        <textarea class="form-control" name="alamat" cols="30" rows="3">{{ $d->alamat }}</textarea>
                                    </div>
                                </div>

                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Edit</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        @if (session()->get('role_id') == 3)
        @else
            <form action="{{ route('editBerkas') }}" method="post">
                @csrf
                @method('patch')
                <div class="modal fade" id="model_penjadwalan{{ $d->id }}" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Penjadwalan Oleh Admin</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">

                                <div class="row">

                                    <input type="hidden" name="id" value="{{ $d->id }}">

                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="">Tanggal Pengukuran</label>
                                            <input type="date" class="form-control" name="tgl_pengukuran"
                                                value="{{ $d->tgl_pengukuran }}" required>
                                        </div>
                                    </div>

                                    @if ($d->pengukuran)
                                        @foreach ($d->pengukuran as $p)
                                            <div class="col-12">
                                                {{-- <div class="col-8">
                                                    <p><b>{{ $p->petugas->name }}</b></p>
                                                </div>
                                                <div class="col-2">
                                                    <input type="checkbox" class="fr">
                                                </div> --}}

                                                <div class="fancy-checkbox">
                                                    <label><span>{{ $p->petugas->name }}</span><input type="checkbox"
                                                            value="{{ $p->id }}"></label>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif

                                </div>



                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Edit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        @endif
    @endforeach

    <div class="modal fade" id="model_lihat_file" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Detail File</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="table_file">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    {{-- @foreach ($errors->all() as $error)
        
    @endforeach --}}



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

            $(document).on('click', '.btn_lihat_file', function() {

                var url = "{{ asset('file_upload') }}/";
                var file_name = $(this).attr('file_name');
                var jenis_file = file_name.split(".");

                if (jenis_file[1] == 'pdf') {
                    var pdf = '<object data="' + url + file_name +
                        '" type="application/pdf" width="750" height="500"></object>';
                    $("#table_file").html(pdf);
                } else {
                    var image = '<img src="' + url + file_name + '" class="img-fluid">';
                    $("#table_file").html(image);
                }

            });


        });
    </script>
@endsection
@endsection

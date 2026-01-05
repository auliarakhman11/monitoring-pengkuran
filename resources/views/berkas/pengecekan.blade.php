@extends('template.master')
@section('content')
    <div id="main-content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-12">
                        <h2 class="float-left">Pengecekan</h2>

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
                        <table class="table js-basic-example dataTable table-custom" id="table" style="font-size: 12px;">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>No Sistem</th>
                                    <th>Pemohon</th>
                                    <th>Kelurahan</th>
                                    <th>Alamat</th>
                                    <th>No WA</th>
                                    <th>Tanggal<br>Input</th>
                                    <th>Pengecekan</th>
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
                                        <td>{{ $d->no_sistem }}</td>
                                        <td>{{ $d->nm_pemohon }}</td>
                                        <td>{{ $d->kelurahan }}</td>
                                        <td>{{ $d->alamat }}</td>
                                        <td><a href="https://api.whatsapp.com/send?phone=62{{ substr($d->no_tlp, 1) }}"
                                                target="_blank">{{ $d->no_tlp }}</a></td>
                                        <td>{{ date('d/m/Y', strtotime($d->tgl)) }}</td>
                                        <td>
                                            @if (count($d->uploadFile) > 0)
                                                @foreach ($d->uploadFile as $u)
                                                    <a class="btn_lihat_file" href="#model_lihat_file" data-toggle="modal"
                                                        file_name="{{ $u->file_name }}"
                                                        jenis_file="{{ $u->jenis_file }}">{{ $u->nm_file }} <i
                                                            class="fa fa-check-circle text-success"
                                                            aria-hidden="true"></i></a> <br>
                                                @endforeach
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <button type="button" class="btn btn-sm btn-primary dropdown-toggle"
                                                    data-toggle="dropdown" aria-expanded="false">
                                                    Aksi
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="#model_edit{{ $d->id }}"
                                                        data-toggle="modal"><i class="fa fa-edit"></i> Edit</a>
                                                    <a class="dropdown-item" href="#model_upload{{ $d->id }}"
                                                        data-toggle="modal"><i class="fa fa-upload"></i> Upload</a>
                                                    {{-- @if ($d->file_name)
                                                        <a class="dropdown-item btn_lihat_file" href="#model_lihat_file"
                                                            data-toggle="modal" file_name="{{ $d->file_name }}"
                                                            jenis_file="{{ $d->jenis_file }}"><i class="fa fa-eye"></i>
                                                            Lihat File</a>
                                                    @endif --}}
                                                    <a class="dropdown-item" href="#model_tutup_berkas{{ $d->id }}"
                                                        data-toggle="modal"><i class="fa fa-times-circle"
                                                            aria-hidden="true"></i> Tutup Berkas</a>
                                                    <a class="dropdown-item" href="{{ route('dropBerkas', $d->id) }}"
                                                        onclick="return confirm('Apakah anda yakin ingin menghapus berkas?')"><i
                                                            class="fa fa-trash"></i> Hapus</a>

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

                                            {{-- <form class="d-inline-block" action="{{ route('dropBerkas') }}" method="post">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $d->id }}">
                                                <button type="submit"
                                                    onclick="return confirm('Apakah anda yakin ingin menghapus berkas?')"
                                                    class="btn btn-sm btn-danger">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form> --}}
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

    @foreach ($berkas as $d)
        <form action="{{ route('editBerkas') }}" method="post">
            @csrf
            @method('patch')
            <div class="modal fade" id="model_edit{{ $d->id }}" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalEditBerkas" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalEditBerkas">Edit Berkas</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">

                            <div class="row">

                                <input type="hidden" name="id" value="{{ $d->id }}">

                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="">Tanggal Input</label>
                                        <input type="date" class="form-control" name="tgl"
                                            value="{{ $d->tgl }}" required>
                                    </div>
                                </div>

                                {{-- <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="">Nomor Berkas</label>
                                        <input type="text" class="form-control" name="no_berkas"
                                            value="{{ $d->no_berkas }}" required>
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="">Tahun</label>
                                        <input type="text" class="form-control" name="tahun"
                                            value="{{ $d->tahun }}" required>
                                    </div>
                                </div> --}}

                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="">Nama Pemohon</label>
                                        <input type="text" class="form-control" name="nm_pemohon"
                                            value="{{ $d->nm_pemohon }}" required>
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="">Kelurahan</label>
                                        <input type="text" class="form-control" name="kelurahan"
                                            value="{{ $d->kelurahan }}" required>
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="">Nomor WA</label>
                                        <input type="number" class="form-control" name="no_tlp"
                                            value="{{ $d->no_tlp }}" required>
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
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


        <form action="{{ route('tutupBerkas') }}" method="post">
            @csrf
            <div class="modal fade" id="model_tutup_berkas{{ $d->id }}" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalTutupBerkas" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalTutupBerkas">Tutup Berkas</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">

                            <div class="row">

                                <input type="hidden" name="id" value="{{ $d->id }}">

                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="">Alasan Penutupan Berkas</label>
                                        <input type="text" class="form-control" name="ket" required>
                                    </div>
                                </div>

                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Tutup Berkas</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <form action="{{ route('uplaodBerkas') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="modal fade" id="model_upload{{ $d->id }}" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalUploadBerkas" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalUploadBerkas">Upload Berkas</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">

                            <input type="hidden" name="id" value="{{ $d->id }}">

                            <table class="table table-sm" width="100%">
                                <thead>
                                    <tr>
                                        <td>Berkas</td>
                                        <td>File</td>
                                        <td>Aksi</td>
                                    </tr>
                                </thead>
                                <tbody id="table_file{{ $d->id }}">
                                    <tr>
                                        <td><input type="text" name="nm_file[]" class="form-control form-control-sm"
                                                required>
                                        </td>
                                        <td><input type="file" name="file_name[]" class="form-control form-control-sm"
                                                accept="application/pdf, image/png, image/jpeg" required></td>
                                        <td><button type="button" class="btn btn-sm btn-primary btn_tambah_file"
                                                berkas_id="{{ $d->id }}"><i class="fa fa-plus"
                                                    aria-hidden="true"></i></button></td>

                                    </tr>
                                </tbody>
                            </table>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Uplaod File</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    @endforeach

    <div class="modal fade" id="model_lihat_file" tabindex="-1" role="dialog" aria-labelledby="exampleModalLihatFile"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLihatFile">Detail File</h5>
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

            var count_file = 1;
            $(document).on('click', '.btn_tambah_file', function() {
                let berkas_id = $(this).attr('berkas_id');
                count_file = count_file + 1;
                var html_code = '<tr id="row' + count_file + '">';

                html_code +=
                    '<td><input type="text" name="nm_file[]" class="form-control form-control-sm" required></td>';
                html_code +=
                    '<td><input type="file" name="file_name[]" class="form-control form-control-sm" accept="application/pdf, image/png, image/jpeg" required></td>';

                html_code +=
                    '<td><button type="button" class="btn btn-sm btn-danger remove_file" data-row="row' +
                    count_file + '"><i class="fa fa-trash" aria-hidden="true"></i></button></td>';

                html_code += "</tr>";

                $('#table_file' + berkas_id).append(html_code);
                // $('.select2bs4').select2({
                //     theme: 'bootstrap4',
                //     tags: true,
                // });
            });

            $(document).on('click', '.remove_file', function() {
                var delete_row = $(this).data("row");
                $('#' + delete_row).remove();
            });


        });
    </script>
@endsection
@endsection

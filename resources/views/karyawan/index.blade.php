@extends('template.master')
@section('content')
    <div id="main-content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-12">
                        <h2 class="float-left">Karyawan</h2>
                        <button type="button" class="btn btn-sm btn-primary float-right ml-2" data-toggle="modal"
                            data-target="#add-karyawan">
                            <i class="fa fa-plus-circle"></i>
                            Tambah Karyawan
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
                        <table class="table js-basic-example dataTable table-custom" id="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama</th>
                                    <th>Status</th>
                                    <th>No Tlp</th>
                                    <th>Alamat</th>
                                    <th>Tgl_masuk</th>
                                    <th>Gapok</th>
                                    <th>Outlet</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = 1;
                                @endphp
                                @foreach ($karyawan as $k)
                                    <tr>
                                        {{-- <td><img src="{{ asset('') }}{{ $k->foto }}" alt="" height="40px"></td> --}}
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $k->nama }}</td>
                                        <td>{{ $k->status }}</td>
                                        <td>{{ $k->no_tlp }}</td>
                                        <td>{{ $k->alamat }}</td>
                                        <td>{{ $k->tgl_masuk ? date('d M Y', strtotime($k->tgl_masuk)) : '-' }}</td>
                                        <td>{{ number_format($k->gapok, 0) }}</td>
                                        <td>{{ $k->cabang->nama }}</td>

                                        <td>
                                            <button type="button" class="btn btn-sm btn-primary" data-toggle="modal"
                                                data-target="#edit-karyawan{{ $k->id }}">
                                                <i class="fa fa-edit"></i>
                                            </button>

                                            <form class="d-inline-block" action="{{ route('dropKaryawan') }}"
                                                method="post">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $k->id }}">
                                                <button type="submit"
                                                    onclick="return confirm('Apakah anda yakin ingin menghapus data karyawan?')"
                                                    class="btn btn-sm btn-primary">
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


    <form action="{{ route('addKaryawan') }}" method="post">
        @csrf
        <div class="modal fade" id="add-karyawan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Tambah Karyawan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="row">

                            <div class="col-12 col-md-6">
                                <label>Nama</label>
                                <input type="text" name="nama" class="form-control" placeholder="Masukan nama"
                                    required>
                            </div>

                            <div class="col-12 col-md-6">
                                <label>Status</label>
                                <select name="status" class="form-control" required>
                                    <option value="">- Pilih Status -</option>
                                    <option value="Leader">Leader</option>
                                    <option value="Rolling">Rolling</option>
                                    <option value="Training">Training</option>
                                </select>
                            </div>

                            <div class="col-12 col-md-6">
                                <label>No Telephon</label>
                                <input type="number" name="no_tlp" class="form-control" placeholder="Masukan nomor">
                            </div>

                            <div class="col-12 col-md-6">
                                <label>Tanggal Masuk</label>
                                <input type="date" name="tgl_masuk" style="font-size: 12px;" class="form-control"
                                    placeholder="Masukan tanggal masuk">
                            </div>

                            <div class="col-12 col-md-6">
                                <label>Gapok Perbulan</label>
                                <input type="number" name="gapok" style="font-size: 12px;" class="form-control"
                                    placeholder="Masukan gapok">
                            </div>

                            <div class="col-12 col-md-6">
                                <label>Outlet</label>
                                <select name="cabang_id" class="form-control" required>
                                    @foreach ($cabang as $d)
                                        <option value="{{ $d->id }}">{{ $d->nama }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-12 col-md-12">
                                <label>Alamat</label>
                                <textarea class="form-control" name="alamat" rows="5"></textarea>
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


    @foreach ($karyawan as $k)
        <form action="{{ route('editKaryawan') }}" method="post">
            @csrf
            @method('patch')
            <div class="modal fade" id="edit-karyawan{{ $k->id }}" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Edit Karyawan</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">

                            <div class="row">
                                <input type="hidden" name="id" value="{{ $k->id }}">
                                <div class="col-12 col-md-6">
                                    <label>Nama</label>
                                    <input type="text" name="nama" value="{{ $k->nama }}"
                                        class="form-control" placeholder="Masukan nama" required>
                                </div>

                                <div class="col-12 col-md-6">
                                    <label>Status</label>
                                    <select name="status" class="form-control" required>
                                        <option value="">- Pilih Status -</option>
                                        <option value="Leader" {{ $k->status == 'Leader' ? 'selected' : '' }}>Leader
                                        </option>
                                        <option value="Rolling" {{ $k->status == 'Rolling' ? 'selected' : '' }}>Rolling
                                        </option>
                                        <option value="Training" {{ $k->status == 'Training' ? 'selected' : '' }}>Training
                                        </option>
                                    </select>
                                </div>

                                <div class="col-12 col-md-6">
                                    <label>No Telephon</label>
                                    <input type="number" name="no_tlp" value="{{ $k->no_tlp }}"
                                        class="form-control" placeholder="Masukan nomor">
                                </div>

                                <div class="col-12 col-md-6">
                                    <label>Tanggal Masuk</label>
                                    <input type="date" name="tgl_masuk" value="{{ $k->tgl_masuk }}"
                                        style="font-size: 12px;" class="form-control"
                                        placeholder="Masukan tanggal masuk">
                                </div>

                                <div class="col-12 col-md-6">
                                    <label>Cabang</label>
                                    <select name="cabang_id" class="form-control" required>
                                        @foreach ($cabang as $d)
                                            <option {{ $k->cabang_id == $d->id ? 'selected' : '' }}
                                                value="{{ $d->id }}">{{ $d->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-12 col-md-6">
                                    <label>Gapok Perbulan</label>
                                    <input type="number" name="gapok" style="font-size: 12px;"
                                        value="{{ $k->gapok }}" class="form-control" placeholder="Masukan gapok">
                                </div>

                                <div class="col-12 col-md-12">
                                    <label>Alamat</label>
                                    <textarea class="form-control" name="alamat" rows="5">{{ $k->alamat }}</textarea>
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
    @endforeach

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


        });
    </script>
@endsection
@endsection

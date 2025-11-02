@extends('template.master')
@section('content')
    <div id="main-content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-12">
                        <h2 class="float-left">Akun</h2>
                        <button type="button" class="btn btn-sm btn-primary float-right" data-toggle="modal"
                            data-target="#add-akun">
                            <i class="fa fa-plus-circle"></i>
                            Tambah Akun
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

            <div class="row clearfix row-deck">

                <div class="table-responsive">
                    <table class="table js-basic-example dataTable table-custom" id="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Akun</th>
                                <th>Jenis Akun</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $i = 1;
                            @endphp
                            @foreach ($akun as $a)
                                <tr>
                                    {{-- <td><img src="{{ asset('') }}{{ $a->foto }}" alt="" height="40px"></td> --}}
                                    <td>{{ $i++ }}</td>
                                    <td>{{ $a->nm_akun }}</td>
                                    <td>{{ $a->jenisAkun->jenis_akun }}</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-primary" data-toggle="modal"
                                            data-target="#edit-akun{{ $a->id }}">
                                            <i class="fa fa-edit"></i>
                                        </button>

                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>

            </div>


        </div>
    </div>


    <form action="{{ route('addAkun') }}" method="post">
        @csrf
        <div class="modal fade" id="add-akun" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Tambah Akun</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="row">

                            <div class="col-12">
                                <label>Nama Akun</label>
                                <input type="text" name="nm_akun" class="form-control" placeholder="Masukan barang"
                                    required>
                            </div>

                            <div class="col-12">
                                <label>Jenis Akun</label>
                                <select class="form-control select2bs4" name="jenis_akun_id" required>
                                    <option value="">-Pilih Jenis-</option>
                                    @foreach ($jenis_akun as $j)
                                        <option value="{{ $j->id }}">{{ $j->jenis_akun }}</option>
                                    @endforeach
                                </select>
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

    @foreach ($akun as $a)
        <form action="{{ route('editAkun') }}" method="post">
            @csrf
            @method('patch')
            <div class="modal fade" id="edit-akun{{ $a->id }}" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Tambah Akun</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">

                            <div class="row">
                                <input type="hidden" name="id" value="{{ $a->id }}">
                                <div class="col-12">
                                    <label>Nama Akun</label>
                                    <input type="text" name="nm_akun" class="form-control" placeholder="Masukan barang"
                                        value="{{ $a->nm_akun }}" required>
                                </div>

                                <div class="col-12">
                                    <label>Jenis Akun</label>
                                    <select class="form-control select2bs4" name="jenis_akun_id" required>
                                        @foreach ($jenis_akun as $j)
                                            <option value="{{ $j->id }}"
                                                {{ $a->jenis_akun_id == $j->id ? 'selected' : '' }}>{{ $j->jenis_akun }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>

                            @if ($a->jenis_akun_id == 3 || $a->jenis_akun_id == 5)
                                <table class="table-sm" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Cabang</th>
                                            <th>Jenis</th>
                                            <th>Jumlah</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($cabang as $index => $k)
                                            <tr>
                                                <td>{{ $k->nama }}</td>

                                                @if ($a->persenPengeluaran)
                                                    @php
                                                        $data_persen = $a->persenPengeluaran
                                                            ->where('cabang_id', $k->id)
                                                            ->first();
                                                    @endphp
                                                    @if ($data_persen)
                                                        <input type="hidden" name="persen_id[]"
                                                            value="{{ $data_persen->id }}">
                                                        <td>
                                                            <select name="jenis_edit[]" class="form-control form-control-sm"
                                                                required>

                                                                <option value="1"
                                                                    {{ $data_persen->jenis == 1 ? 'selected' : '' }}>Persen
                                                                </option>
                                                                <option value="2"
                                                                    {{ $data_persen->jenis == 2 ? 'selected' : '' }}>Rupiah
                                                                </option>
                                                            </select>

                                                        </td>
                                                        <td>
                                                            <input type="text" name="jumlah_edit[]"
                                                                class="form-control form-control-sm"
                                                                value="{{ $data_persen->jumlah }}" required>
                                                        </td>
                                                    @else
                                                        <input type="hidden" name="cabang_id[]"
                                                            value="{{ $k->id }}">
                                                        <td>
                                                            <select name="jenis[]" class="form-control form-control-sm"
                                                                required>
                                                                <option value="1">Persen</option>
                                                                <option value="2">Rupiah</option>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <input type="text" name="jumlah[]"
                                                                class="form-control form-control-sm">
                                                        </td>
                                                    @endif
                                                @else
                                                    <input type="hidden" name="cabang_id[]"
                                                        value="{{ $k->id }}">
                                                    <td>
                                                        <select name="jenis[]" class="form-control form-control-sm"
                                                            required>
                                                            <option value="1">Persen</option>
                                                            <option value="2">Rupiah</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="jumlah[]"
                                                            class="form-control form-control-sm">
                                                    </td>
                                                @endif

                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            @endif


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

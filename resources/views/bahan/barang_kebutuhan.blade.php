@extends('template.master')
@section('content')
    <div id="main-content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-12">
                        <h2 class="float-left">Barang Kebutuhan</h2>
                        <button type="button" class="btn btn-sm btn-primary float-right ml-2" data-toggle="modal"
                            data-target="#add-bahan">
                            <i class="fa fa-plus-circle"></i>
                            Tambah Barang Kebutuhan
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
                <div class="col-8">
                    <div class="table-responsive">
                        <table class="table table-hover js-basic-example dataTable table-custom">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Bahan</th>
                                    <th>Satuan</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = 1;
                                @endphp
                                @foreach ($bahan as $b)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $b->bahan }}</td>
                                        <td>{{ $b->satuan->satuan }}</td>

                                        <td>
                                            <button type="button" class="btn btn-sm btn-primary" data-toggle="modal"
                                                data-target="#edit-bahan{{ $b->id }}">
                                                <i class="fa fa-edit"></i>
                                            </button>

                                            <form class="d-inline-block" action="{{ route('dropDataBahan') }}"
                                                method="post">
                                                @csrf
                                                @method('patch')
                                                <input type="hidden" name="id" value="{{ $b->id }}">
                                                <button class="btn btn-sm ml-2 btn-danger" type="submit"
                                                    onclick="return confirm('Apakah anda yakin ingin menghapus data bahan?')"><i
                                                        class="fa fa-trash"></i> </button>
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

    <form action="{{ route('addBarangKebutuhan') }}" method="post">
        @csrf
        <div class="modal fade" id="add-bahan" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Tambah Barang Kebutuhan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="row">

                            <div class="col-12">
                                <label>Barang Kebutuhan</label>
                                <input type="text" name="bahan" class="form-control" placeholder="Masukan nama barang"
                                    required>
                            </div>

                            <div class="col-12">
                                <label>Satuan</label>
                                <select class="form-control select2bs4" name="satuan_id" required>
                                    <option value="">-Pilih Satuan-</option>
                                    @foreach ($satuan as $s)
                                        <option value="{{ $s->id }}">{{ $s->satuan }}</option>
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


    @foreach ($bahan as $b)
        <form action="{{ route('editBarangKebutuhan') }}" method="post">
            @csrf
            @method('patch')
            <div class="modal fade" id="edit-bahan{{ $b->id }}" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Edit Bahan</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">

                            <div class="row">
                                <input type="hidden" name="id" value="{{ $b->id }}">
                                <div class="col-12">
                                    <label>Bahan</label>
                                    <input type="text" name="bahan" class="form-control" placeholder="Masukan bahan"
                                        value="{{ $b->bahan }}" required>
                                </div>

                                <div class="col-12">
                                    <label>Satuan</label>
                                    <select class="form-control select2bs4" name="satuan_id" required>
                                        @foreach ($satuan as $s)
                                            <option value="{{ $s->id }}"
                                                {{ $s->id == $b->satuan_id ? 'selected' : '' }}>{{ $s->satuan }}
                                            </option>
                                        @endforeach
                                    </select>
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

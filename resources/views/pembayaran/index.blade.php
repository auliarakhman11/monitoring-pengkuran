@extends('template.master')
@section('content')
    <div id="main-content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-12">
                        <h2 class="float-left">Pembayaran</h2>
                        <button type="button" class="btn btn-primary btn-sm float-right" data-toggle="modal"
                            data-target="#add-pembayaran">
                            <i class="fa fa-plus-circle"></i>
                            Tambah Pembayaran
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
                        <table class="table js-basic-example dataTable table-custom">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Pembayaran</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = 1;
                                @endphp
                                @foreach ($pembayaran as $pb)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $pb->pembayaran }}</td>
                                        <td class="{{ $pb->aktif == '1' ? 'text-success' : 'text-danger' }}">
                                            {{ $pb->aktif == '1' ? 'Aktif' : 'Non Aktif' }}</td>


                                        <td>
                                            <button type="button" class="btn btn-sm btn-primary" data-toggle="modal"
                                                data-target="#edit-pembayaran{{ $pb->id }}">
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
    </div>

    <form action="{{ route('addPembayaran') }}" method="post">
        @csrf
        <div class="modal fade" id="add-pembayaran" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Tambah Pembayaran</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="row">

                            <div class="col-6">
                                <label>Pembayaran</label>
                                <input type="text" name="pembayaran" class="form-control"
                                    placeholder="Masukan Pembayaran" required>
                            </div>

                            <div class="col-6 mb-2">
                                <label for="">
                                    <dt>Status</dt>
                                </label>
                                <select name="aktif" class="form-control" required>

                                    <option value="1">Aktif</option>
                                    <option value="0">Non Aktif</option>

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


    @foreach ($pembayaran as $pb)
        <form action="{{ route('editPembayaran') }}" method="post">
            @csrf
            @method('patch')
            <div class="modal fade" id="edit-pembayaran{{ $pb->id }}" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Edit Pembayaran</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">

                            <div class="row">
                                <input type="hidden" name="id" value="{{ $pb->id }}">
                                <div class="col-6">
                                    <label>Pembayaran</label>
                                    <input type="text" name="pembayaran" value="{{ $pb->pembayaran }}"
                                        class="form-control" placeholder="Masukan Pembayaran" required>
                                </div>

                                <div class="col-6 mb-2">
                                    <label for="">
                                        <dt>Status</dt>
                                    </label>
                                    <select name="aktif" class="form-control" required>

                                        <option value="1" {{ $pb->aktif == 1 ? 'selected' : '' }}>Aktif</option>
                                        <option value="0" {{ $pb->aktif == 0 ? 'selected' : '' }}>Non Aktif</option>

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

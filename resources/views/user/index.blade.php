@extends('template.master')
@section('content')
    <div id="main-content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-12">
                        <h2 class="float-left">Manajemen User</h2>
                        <button type="button" class="btn btn-sm btn-primary float-right ml-2" data-toggle="modal"
                            data-target="#modal_tambah">
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
                                    <th>Username</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = 1;
                                @endphp
                                @foreach ($user as $d)
                                    <tr>
                                        {{-- <td><img src="{{ asset('') }}{{ $k->foto }}" alt="" height="40px"></td> --}}
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $d->name }}</td>
                                        <td>{{ $d->username }}</td>
                                        <td>{{ $d->role->nm_role }}</td>
                                        <td>
                                            @if ($d->aktif == 1)
                                                <p class="text-success">Aktif</p>
                                            @else
                                                <p class="text-danger">Tidak Aktif</p>
                                            @endif
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-primary" data-toggle="modal"
                                                data-target="#model_edit{{ $d->id }}">
                                                <i class="fa fa-edit"></i>
                                            </button>

                                            {{-- <form class="d-inline-block" action="{{ route('dropKaryawan') }}"
                                                method="post">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $k->id }}">
                                                <button type="submit"
                                                    onclick="return confirm('Apakah anda yakin ingin menghapus data karyawan?')"
                                                    class="btn btn-sm btn-primary">
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


    <form action="{{ route('addUser') }}" method="post">
        @csrf
        <div class="modal fade" id="modal_tambah" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Tambah User</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="row">

                            <div class="col-12">
                                <div class="form-group">
                                    <label for="">Nama</label>
                                    <input type="text" class="form-control" name="name" required>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="">Username</label>
                                    <input type="text" class="form-control" name="username" required>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="">Role User</label>
                                    <select name="role_id" class="form-control" required>
                                        <option value="">Pilih Role</option>
                                        @foreach ($role as $r)
                                            <option value="{{ $r->id }}">{{ $r->nm_role }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="">Password</label>
                                    <input type="password" class="form-control" name="password" required>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="">Ulangi Password</label>
                                    <input type="password" class="form-control" name="password_confirmation" required>
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

    @foreach ($user as $d)
        <form action="{{ route('editUser') }}" method="post">
        @csrf
        @method('patch')
        <div class="modal fade" id="model_edit{{ $d->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit User</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="row">

                            <input type="hidden" name="id" value="{{ $d->id }}">

                            <div class="col-12">
                                <div class="form-group">
                                    <label for="">Nama</label>
                                    <input type="text" class="form-control" name="name" value="{{ $d->name }}" required>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="">Role User</label>
                                    <select name="role_id" class="form-control" required>
                                        @foreach ($role as $r)
                                            <option value="{{ $r->id }}" {{ $r->id == $d->role_id ? 'selected' : '' }}>{{ $r->nm_role }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="">Status</label>
                                    <select name="aktif" class="form-control" required>
                                        <option value="1" {{ $d->aktif == 1 ? 'selected' : '' }}>Aktif</option>
                                        <option value="0" {{ $d->aktif == 0 ? 'selected' : '' }}>Tidak Aktif</option>
                                    </select>
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
    @endforeach

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


        });
    </script>
@endsection
@endsection

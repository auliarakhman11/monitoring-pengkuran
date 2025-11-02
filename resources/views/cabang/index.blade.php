@extends('template.master')
@section('content')
    <div id="main-content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-12">
                        <h2 class="float-left">Outlet</h2>
                        <button type="button" class="btn btn-primary btn-sm float-right ml-2" data-toggle="modal"
                            data-target="#add-product">
                            <i class="fa fa-plus-circle"></i>
                            Tambah Outlet
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
                                <th>Outlet</th>
                                <th>Alamat</th>
                                <th>No Telpon</th>
                                <th>Email</th>
                                <th>Event</th>
                                <th>Persen Gaji</th>
                                <th>Aktif</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $i = 1;
                            @endphp
                            @foreach ($outlet as $o)
                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td>{{ $o->nama }}</td>
                                    <td class="text-center">{{ $o->alamat }}</td>
                                    </td>
                                    <td>{{ $o->no_tlpn }}</td>
                                    <td>
                                        @foreach ($o->emailCabang as $e)
                                            {{ $e->email }} <br>
                                        @endforeach
                                    </td>

                                    <td>
                                        @if ($o->event == 1)
                                            <p class="text-danger">OFF</p>
                                        @else
                                            <p class="text-success">ON</p>
                                        @endif
                                    </td>
                                    <td>{{ $o->persen_gaji }}%</td>
                                    <td>
                                        @if ($o->off == 1)
                                            <p class="text-danger">OFF</p>
                                        @else
                                            <p class="text-success">ON</p>
                                        @endif
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-primary mr-2" data-toggle="modal"
                                            data-target="#edit{{ $o->id }}">
                                            <i class="fa fa-edit"></i>
                                        </button>

                                        <button type="button" class="btn btn-sm btn-primary" data-toggle="modal"
                                            data-target="#harga{{ $o->id }}">
                                            <i class="fa fa-money" aria-hidden="true"></i>
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

    <form action="{{ route('addOutlet') }}" method="post">
        @csrf
        <div class="modal fade" id="add-product" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Tambah Outlet</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row form-group ">

                            <div class="col-12">
                                <div class="form-group row">
                                    <div class=" col-6 mb-2">
                                        <label for="">
                                            <dt>Nama Outlet</dt>
                                        </label>
                                        <input type="text" name="nama" class="form-control" placeholder="Nama Outlet"
                                            required>
                                    </div>

                                    <div class="col-6 mb-2">
                                        <label>Zona Waktu</label>
                                        <select name="time_zone" class="form-control" required>

                                            <option value="Asia/Makassar">WITA</option>
                                            <option value="Asia/Jakarta">WIB</option>

                                        </select>
                                    </div>

                                    <div class="col-lg-6 mb-2">
                                        <label for="">
                                            <dt>Alamat Outlet</dt>
                                        </label>
                                        {{-- <input type="text" name="nama" class="form-control" placeholder="Nama Outlet" required> --}}
                                        <textarea class="form-control" name="alamat" rows="5"></textarea>
                                    </div>

                                    <div class="col-lg-6 mb-2">
                                        <label for="">
                                            <dt>Url Google Map</dt>
                                        </label>
                                        {{-- <input type="text" name="nama" class="form-control" placeholder="Nama Outlet" required> --}}
                                        <textarea class="form-control" name="map" rows="5"></textarea>
                                    </div>



                                    <div class="col-6 mb-2">
                                        <label>Aktif</label>
                                        <select name="off" class="form-control" required>

                                            <option value="0">ON</option>
                                            <option value="1">OFF</option>

                                        </select>
                                    </div>

                                    <div class=" col-6 mb-2">
                                        <label for="">
                                            <dt>Nomor Telpon</dt>
                                        </label>
                                        <input type="number" name="no_tlpn" class="form-control">
                                    </div>


                                    <div class="col-6 mb-2">
                                        <label>Event</label>
                                        <select name="event" class="form-control select2bs4" required>
                                            <option value="0">Tidak</option>
                                            <option value="1">Ya</option>
                                        </select>
                                    </div>

                                    <div class="col-6 mb-2">
                                        <label>Persen gaji</label>
                                        <input type="text" name="persen_gaji" class="form-control" max="100"
                                            required>
                                    </div>

                                    <div class="col-12">
                                        <hr>
                                    </div>


                                    <div class="col-4 mb-2">
                                        <label>Email</label>
                                        <input type="email" name="email[]" class="form-control">
                                    </div>

                                    <div class="col-3 mb-2">
                                        <label>Password</label>
                                        <input type="text" name="password[]" class="form-control">
                                    </div>

                                    <div class="col-4 mb-2">
                                        <label>Keterangan</label>
                                        <input type="text" name="ket[]" class="form-control">
                                    </div>

                                    <div class="col-1 mt-2">
                                        <button type="button" class="btn btn-sm btn-success mt-4" id="tambah-email"><i
                                                class="fa fa-plus"></i></button>
                                    </div>

                                    <div class="col-12 mb-2" id="table_email"></div>

                                    <div class="col-12">
                                        <hr>
                                    </div>

                                    @foreach ($akun as $index => $d)
                                        <div class="col-8 mb-1">
                                            <input type="hidden" name="akun_id[]" value="{{ $d->id }}">
                                            <label for="">{{ $d->nm_akun }}</label>
                                        </div>
                                        <div class="col-4 mb-1">
                                            <input type="number" name="harga[]" class="form-control" value="0"
                                                required>
                                        </div>
                                        <div class="col-12">
                                            <hr>
                                        </div>
                                    @endforeach

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

    @foreach ($outlet as $o)
        <!-- Modal -->
        <form action="{{ route('editOutlet') }}" method="post">

            @method('patch')
            @csrf
            <div class="modal fade" id="edit{{ $o->id }}" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Edit Outlet</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row form-group ">
                                <input type="hidden" name="id" value="{{ $o->id }}">
                                <div class="col-12">
                                    <div class="form-group row">
                                        <div class=" col-6 mb-2">
                                            <label for="">
                                                <dt>Nama Outlet</dt>
                                            </label>
                                            <input type="text" name="nama" class="form-control"
                                                placeholder="Nama Outlet" value="{{ $o->nama }}" required>
                                        </div>

                                        <div class="col-6 mb-2">
                                            <label>Zona Waktu</label>
                                            <select name="time_zone" class="form-control" required>
                                                @if ($o->time_zone == 'Asia/Makassar')
                                                    <option value="Asia/Makassar" selected>WITA</option>
                                                    <option value="Asia/Jakarta">WIB</option>
                                                @else
                                                    <option value="Asia/Makassar">WITA</option>
                                                    <option value="Asia/Jakarta" selected>WIB</option>
                                                @endif
                                            </select>
                                        </div>

                                        <div class="col-lg-6 mb-2">
                                            <label for="">
                                                <dt>Alamat Outlet</dt>
                                            </label>
                                            {{-- <input type="text" name="nama" class="form-control" placeholder="Nama Outlet" required> --}}
                                            <textarea class="form-control" name="alamat" rows="5">{{ $o->alamat }}</textarea>
                                        </div>

                                        <div class="col-lg-6 mb-2">
                                            <label for="">
                                                <dt>Url Google Map</dt>
                                            </label>
                                            {{-- <input type="text" name="nama" class="form-control" placeholder="Nama Outlet" required> --}}
                                            <textarea class="form-control" name="map" rows="5">{{ $o->map }}</textarea>
                                        </div>



                                        <div class="col-6 mb-2">
                                            <label>Aktif</label>
                                            <select name="off" class="form-control" required>
                                                @if ($o->off == 1)
                                                    <option value="1" selected>OFF</option>
                                                    <option value="0">ON</option>
                                                @else
                                                    <option value="1">OFF</option>
                                                    <option value="0" selected>ON</option>
                                                @endif
                                            </select>
                                        </div>

                                        <div class="col-12">
                                            <hr>
                                        </div>

                                        <div class="col-4 mb-2">
                                            <label>Email</label>
                                        </div>

                                        <div class="col-3 mb-2">
                                            <label>Password</label>
                                        </div>

                                        <div class="col-4 mb-2">
                                            <label>Keterangan</label>
                                        </div>


                                        <div class="col-1 mt-2">
                                            <label>Hapus</label>
                                        </div>

                                        @foreach ($o->emailCabang as $e)
                                            <div class="col-4 mb-2">
                                                <input type="email" name="email_edit[]" class="form-control"
                                                    value="{{ $e->email }}" required>
                                            </div>

                                            <div class="col-3 mb-2">
                                                <input type="text" name="password_edit[]" value="{{ $e->password }}"
                                                    class="form-control">
                                            </div>

                                            <div class="col-4 mb-2">
                                                <input type="text" name="ket_edit[]" class="form-control"
                                                    value="{{ $e->ket }}">
                                            </div>

                                            <input type="hidden" name="email_id_edit[]" value="{{ $e->id }}">

                                            <div class="col-1">
                                                <a href="{{ route('deleteEmailCabang', $e->id) }}"
                                                    onclick="return confirm('Apakah anda yakin ingin menghapus data email?')"
                                                    class="btn btn-sm btn-danger mt-2"><i class="fa fa-trash"></i></a>
                                            </div>
                                        @endforeach



                                        <div class="col-12 mb-2" id="table_email_edit"></div>


                                        <div class="col-11"></div>
                                        <div class="col-1 mt-2">
                                            <button type="button" class="btn btn-sm btn-success mt-4"
                                                id="tambah_email_edit"><i class="fa fa-plus"></i></button>
                                        </div>

                                        <div class="col-12">
                                            <hr>
                                        </div>

                                        <div class="col-6 mb-2">
                                            <label>Event</label>
                                            <select name="event" class="form-control select2bs4" required>
                                                <option value="0" {{ $o->event != 1 ? 'selected' : '' }}>Tidak
                                                </option>
                                                <option value="1" {{ $o->event == 1 ? 'selected' : '' }}>Ya</option>
                                            </select>
                                        </div>

                                        <div class="col-6 mb-2">
                                            <label>Persen gaji</label>
                                            <input type="text" name="persen_gaji" class="form-control" max="100"
                                                value="{{ $o->persen_gaji }}" required>
                                        </div>



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

        <form action="{{ route('editHargaPengeluaran') }}" method="post">
            @csrf
            <div class="modal fade" id="harga{{ $o->id }}" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Harga</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <input type="hidden" name="cabang_id" value="{{ $o->id }}">
                                @foreach ($akun as $d)
                                    @php
                                        $ada = 0;
                                    @endphp

                                    @foreach ($o->hargaPengeluaran as $oh)
                                        @if ($oh->akun_id == $d->id)
                                            <input type="hidden" name="akun_id[]" value="{{ $d->id }}">
                                            <div class="col-8 mb-1">
                                                <label for="">{{ $d->nm_akun }}</label>
                                            </div>
                                            <div class="col-4 mb-1">
                                                <input type="number" name="harga[]" class="form-control"
                                                    value="{{ $oh->harga }}">
                                            </div>
                                            <div class="col-12">
                                                <hr>
                                            </div>
                                            @php
                                                $ada++;
                                            @endphp
                                        @endif
                                    @endforeach

                                    @if (!$ada)
                                        <input type="hidden" name="akun_id[]" value="{{ $d->id }}">
                                        <div class="col-8 mb-1">
                                            <label for="">{{ $d->nm_akun }}</label>
                                        </div>
                                        <div class="col-4 mb-1">
                                            <input type="number" name="harga[]" class="form-control" value="0">
                                        </div>
                                        <div class="col-12">
                                            <hr>
                                        </div>
                                    @endif
                                @endforeach

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



            var count_email = 1;
            $(document).on('click', '#tambah-email', function() {
                count_email = count_email + 1;
                var html_code = '<div class="row" id="row' + count_email + '">';

                html_code +=
                    '<div class="col-4 mb-2"><input type="email" name="email[]" class="form-control"></div>';

                html_code +=
                    '<div class="col-3 mb-2"><input type="text" name="password[]" class="form-control"></div>';

                html_code +=
                    '<div class="col-4 mb-2"><input type="text" name="ket[]" class="form-control"></div>';

                html_code += '<div class="col-1"><button type="button" data-row="row' + count_email +
                    '" class="btn btn-danger btn-sm remove_email">-</button></div>';

                html_code += "</div>";

                $('#table_email').append(html_code);

            });

            $(document).on('click', '.remove_email', function() {
                var delete_row = $(this).data("row");
                $('#' + delete_row).remove();
            });


            var count_email_edit = 1;
            $(document).on('click', '#tambah_email_edit', function() {
                count_email_edit = count_email_edit + 1;
                var html_code = '<div class="row" id="row' + count_email_edit + '">';

                html_code +=
                    '<div class="col-4 mb-2"><input type="email" name="email[]" class="form-control"></div>';

                html_code +=
                    '<div class="col-3 mb-2"><input type="text" name="password[]" class="form-control"></div>';

                html_code +=
                    '<div class="col-4 mb-2"><input type="text" name="ket[]" class="form-control"></div>';

                html_code += '<div class="col-1"><button type="button" data-row="row' + count_email_edit +
                    '" class="btn btn-danger btn-sm remove_email_edit">-</button></div>';

                html_code += "</div>";

                $('#table_email_edit').append(html_code);

            });

            $(document).on('click', '.remove_email_edit', function() {
                var delete_row = $(this).data("row");
                $('#' + delete_row).remove();
            });

        });
    </script>
@endsection
@endsection

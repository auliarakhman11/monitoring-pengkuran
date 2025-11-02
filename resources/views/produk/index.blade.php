@extends('template.master')
@section('content')
    <div id="main-content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-12">
                        <h2 class="float-left">List Produk & Kategori</h2>
                        <button type="button" class="btn btn-sm btn-primary float-right ml-2" data-toggle="modal"
                            data-target="#add-product">
                            <i class="fa fa-plus-circle"></i>
                            Tambah Produk
                        </button>
                        <button type="button" class="btn btn-sm btn-primary float-right ml-2" data-toggle="modal"
                            data-target="#add-kategori">
                            <i class="fa fa-plus-circle"></i>
                            Tambah Kategori
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
                        <table class="table table-hover js-basic-example dataTable table-custom" id="table_produk">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Produk</th>
                                    <th>Kategori</th>
                                    <th>Diskon</th>
                                    <th>Harga</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = 1;
                                @endphp
                                @foreach ($produk as $p)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $p->nm_produk }}</td>
                                        <td>{{ $p->kategori->kategori }}</td>
                                        <td>{{ $p->diskon }}%</td>
                                        <td>
                                            @if ($p->getHarga)
                                                @foreach ($p->getHarga as $h)
                                                    {{ $h->delivery->delivery }} :
                                                    {{ number_format($h->harga, 0) }} <br>
                                                @endforeach
                                            @endif
                                        </td>
                                        <td class="{{ $p->status == 'ON' ? 'text-success' : 'text-danger' }}">
                                            {{ $p->status }}</td>

                                        <td>
                                            <button type="button" class="btn btn-sm btn-warning resep" data-toggle="modal"
                                                data-target="#resep" produk-id="{{ $p->id }}"
                                                nm-produk="{{ $p->nm_produk }}">
                                                Resep
                                            </button>
                                            <button type="button" class="btn btn-sm btn-primary" data-toggle="modal"
                                                data-target="#edit-product{{ $p->id }}">
                                                <i class="fa fa-edit"></i>
                                            </button>
                                            <a href="{{ route('deleteProduk', $p->id) }}"
                                                onclick="return confirm('Aoakah yakin ingin menghapus produk?')"
                                                class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="col-12">
                    <div class="table-responsive">
                        <table class="table table-hover js-basic-example dataTable table-custom">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Kategori</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = 1;
                                @endphp
                                @foreach ($kategori as $k)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $k->kategori }}</td>

                                        <td>

                                            <button type="button" class="btn btn-sm btn-primary" data-toggle="modal"
                                                data-target="#edit-kategori{{ $k->id }}">
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

    <form action="{{ route('addProduct') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="modal fade" id="add-product" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Tambah Produk</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row form-group ">
                            <div class="col-sm-4">
                                <label for="">Masukkan Gambar</label>
                                <input type="file" class="dropify text-sm"
                                    data-default-file="{{ asset('img') }}/kebabyasmin.jpeg" name="foto"
                                    placeholder="Image" required>
                            </div>
                            <div class="col-lg-8">
                                <div class="form-group row">
                                    <div class="col-lg-6 mb-2">
                                        <label for="">
                                            <dt>Nama Produk</dt>
                                        </label>
                                        <input type="text" name="nm_produk" class="form-control"
                                            placeholder="Nama Produk" required>
                                    </div>

                                    <div class="col-lg-6 mb-2">
                                        <label for="">
                                            <dt>Kategori</dt>
                                        </label>
                                        <select name="kategori_id" class="form-control" required>
                                            @foreach ($kategori as $k)
                                                <option value="{{ $k->id }}">{{ $k->kategori }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-lg-6 mb-2">
                                        <label for="">
                                            <dt>Status</dt>
                                        </label>
                                        <select name="status" class="form-control" required>
                                            <option value="ON">ON</option>
                                            <option value="OFF">OFF</option>
                                        </select>
                                    </div>

                                    <div class="col-lg-6 mb-2">
                                        <label for="">
                                            <dt>Tampil Varian</dt>
                                        </label>
                                        <select name="tampil_varian" class="form-control" required>
                                            <option value="1">Ya</option>
                                            <option value="0">Tidak</option>
                                        </select>
                                    </div>

                                    <div class="col-4"></div>
                                    <div class="col-4 text-center"><label for="">
                                            <dt>Harga</dt>
                                        </label></div>
                                    <div class="col-4"></div>

                                    @foreach ($delivery as $d)
                                        <div class="col-lg-4 mb-2 text-center">
                                            <label for="">
                                                <dt>{{ $d->delivery }}</dt>
                                            </label>
                                            <input type="hidden" name="delivery_id[]" value="{{ $d->id }}">
                                            <input type="number" class="form-control" name="harga[]" value="0">
                                        </div>
                                    @endforeach

                                    <div class="col-12 text-center"><label for="">
                                            <dt>Outlet</dt>
                                        </label></div>

                                    @foreach ($cabang as $k)
                                        <div class="col-4">
                                            <label for="{{ $k->nama . $k->id }}"><input type="checkbox"
                                                    id="{{ $k->nama . $k->id }}" value="{{ $k->id }}"
                                                    name="cabang_id[]"> {{ $k->nama }}</label>
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

    @foreach ($produk as $p)
        <form action="{{ route('editProduk') }}" method="post" enctype="multipart/form-data">
            @method('patch')
            @csrf
            <div class="modal fade" id="edit-product{{ $p->id }}" role="dialog"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Edit Produk</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <input type="hidden" name="id" value="{{ $p->id }}">
                        <div class="modal-body">
                            <div class="row form-group ">
                                <div class="col-sm-4">
                                    <label for="">Masukkan Gambar</label>
                                    <input type="file" class="dropify text-sm"
                                        data-default-file="{{ asset('') }}{{ $p->foto }}" name="foto"
                                        placeholder="Image">
                                </div>
                                <div class="col-lg-8">
                                    <div class="form-group row">
                                        <div class="col-lg-6 mb-2">
                                            <label for="">
                                                <dt>Nama Produk</dt>
                                            </label>
                                            <input type="text" name="nm_produk" value="{{ $p->nm_produk }}"
                                                class="form-control" placeholder="Nama Produk" required>
                                        </div>

                                        <div class="col-lg-6 mb-2">
                                            <label for="">
                                                <dt>Kategori</dt>
                                            </label>
                                            <select name="kategori_id" class="form-control" required>
                                                @foreach ($kategori as $k)
                                                    <option value="{{ $k->id }}"
                                                        {{ $k->id == $p->kategori->id ? 'selected' : '' }}>
                                                        {{ $k->kategori }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        {{-- <div class="col-lg-4 mb-2">
                          <label for="">
                              <dt>Diskon</dt>
                          </label>
                          <input type="number" class="form-control" name="diskon" value="{{ $p->diskon }}" placeholder="cth : 5" required>
                      </div> --}}

                                        <div class="col-lg-6 mb-2">
                                            <label for="">
                                                <dt>Status</dt>
                                            </label>
                                            <select name="status" class="form-control" required>
                                                <option value="ON" {{ $p->status == 'ON' ? 'selected' : '' }}>ON
                                                </option>
                                                <option value="OFF" {{ $p->status == 'OFF' ? 'selected' : '' }}>OFF
                                                </option>
                                            </select>
                                        </div>

                                        <div class="col-lg-6 mb-2">
                                            <label for="">
                                                <dt>Tampil Varian</dt>
                                            </label>
                                            <select name="tampil_varian" class="form-control" required>
                                                <option value="1" {{ $p->tampil_varian == '1' ? 'selected' : '' }}>Ya
                                                </option>
                                                <option value="0" {{ $p->tampil_varian == '0' ? 'selected' : '' }}>
                                                    Tidak</option>
                                            </select>
                                        </div>

                                        <div class="col-4"></div>
                                        <div class="col-4 text-center"><label for="">
                                                <dt>Harga</dt>
                                            </label></div>
                                        <div class="col-4"></div>

                                        @foreach ($delivery as $index => $d)
                                            <div class="col-lg-4 mb-2 text-center">
                                                <label for="">
                                                    <dt>{{ $d->delivery }}</dt>
                                                </label>
                                                <input type="hidden" name="delivery_id[]" value="{{ $d->id }}">

                                                <input type="number" class="form-control" name="harga[]"
                                                    value="{{ $index + 1 > count($p->getHarga) ? 0 : $p->getHarga[$index]->harga }}">
                                            </div>
                                        @endforeach

                                        <div class="col-12 text-center"><label for="">
                                                <dt>Outlet</dt>
                                            </label></div>
                                        @php
                                            $dtProdukCabang = [];
                                        @endphp
                                        @if ($p->produkCabang)
                                            @foreach ($p->produkCabang as $pk)
                                                @php
                                                    $dtProdukCabang[] = $pk->cabang_id;
                                                @endphp
                                            @endforeach
                                        @endif


                                        @foreach ($cabang as $k)
                                            <div class="col-4">
                                                <label for="{{ $k->nama . $k->id . $p->id }}"><input
                                                        id="{{ $k->nama . $k->id . $p->id }}" type="checkbox"
                                                        value="{{ $k->id }}" name="cabang_id[]"
                                                        {{ in_array($k->id, $dtProdukCabang) ? 'checked' : '' }}>
                                                    {{ $k->nama }}</label>
                                            </div>
                                        @endforeach




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

    <!-- Modal -->
    <form id="input_resep">
        @csrf
        <div class="modal fade" id="resep" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="header-resep"></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <input type="hidden" name="produk_id" id="produk_id">
                    <div class="modal-body" id="form-resep">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Tambah</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <form action="{{ route('tambahKategori') }}" method="post">
        @csrf
        <div class="modal fade" id="add-kategori" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Tambah Kategori</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="">Nama Kategori</label>
                                <input type="text" name="kategori" class="form-control" required>
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

    @foreach ($kategori as $k)
        <form action="{{ route('editKategori') }}" method="post">
            @csrf
            <div class="modal fade" id="edit-kategori{{ $k->id }}" role="dialog"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Edit Kategori {{ $k->kategori }}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="">Nama Kategori</label>
                                    <input type="hidden" name="id" value="{{ $k->id }}">
                                    <input type="text" name="kategori" class="form-control"
                                        value="{{ $k->kategori }}" required>
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
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        });

        $(document).ready(function() {

            <?php if(session('success')): ?>
            // notification popup
            toastr.options.closeButton = true;
            toastr.options.positionClass = 'toast-top-right';
            toastr.options.showDuration = 1000;
            toastr['success']('<?= session('success') ?>');
            <?php endif; ?>

            <?php if(session('error')): ?>
            // notification popup
            toastr.options.closeButton = true;
            toastr.options.positionClass = 'toast-top-right';
            toastr.options.showDuration = 1000;
            toastr['error']('<?= session('error') ?>');
            <?php endif; ?>


            function getResep(id) {
                $('#form-resep').html(
                    '<div class="spinner-border text-secondary" role="status"><span class="visually-hidden"></span></div>'
                );
                $.get('getHargaResep/' + id, function(data) {
                    $('#form-resep').html(data);

                    $('.select2bs4').select2({
                        theme: 'bootstrap4'
                    });

                });

            }

            $(document).on('click', '.resep', function() {
                var id = $(this).attr("produk-id");
                var nm_produk = $(this).attr("nm-produk");

                $('#header-resep').html('Resep ' + nm_produk);
                $('#produk_id').val(id);

                getResep(id);



            });

            var count_bahan = 1;
            $(document).on('click', '#tambah-bahan', function() {
                count_bahan = count_bahan + 1;
                var html_code = '<div class="row" id="row' + count_bahan + '">';

                html_code +=
                    '<div class="col-6"><div class="form-group"><select name="bahan_id[]"  class="form-control select2bs4" required><option value="">-Pilih Bahan-</option><?php foreach ($bahan as $b) : ?><option value="<?= $b->id ?>"><?= $b->bahan ?></option><?php endforeach; ?> </select></div></div>';

                html_code +=
                    '<div class="col-5"><div class="form-group"><input type="number" name="takaran[]" class="form-control" required></div></div>';

                html_code += '<div class="col-1"><button type="button" data-row="row' + count_bahan +
                    '" class="btn btn-danger btn-sm remove_bahan">-</button></div>';

                html_code += "</div>";

                $('#tambah-resep').append(html_code);
                $('.select2bs4').select2({
                    theme: 'bootstrap4',
                    tags: true,
                });
            });

            $(document).on('click', '.remove_bahan', function() {
                var delete_row = $(this).data("row");
                $('#' + delete_row).remove();
            });

            $(document).on('submit', '#input_resep', function(event) {
                event.preventDefault();
                var id = $('#produk_id').val();
                $.ajax({
                    url: "{{ route('addResep') }}",
                    method: 'POST',
                    data: new FormData(this),
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        getResep(id);
                        toastr.options.closeButton = true;
                        toastr.options.positionClass = 'toast-top-right';
                        toastr.options.showDuration = 1000;
                        toastr['success']('Resep berhasil dibuat');
                    }
                });

            });

            $(document).on('click', '.hapus-resep', function() {
                var produk_id = $(this).attr("produk-id");
                var id = $(this).attr("id-resep");


                $.ajax({
                    url: "{{ route('dropResep') }}",
                    method: "POST",
                    data: {
                        id: id
                    },
                    success: function(data) {
                        getResep(produk_id);
                        toastr.options.closeButton = true;
                        toastr.options.positionClass = 'toast-top-right';
                        toastr.options.showDuration = 1000;
                        toastr['success']('Resep berhasi dihapus');
                    },
                    error: function(err) { //jika error tampilkan error pada console
                        console.log(err);
                    }

                });



            });


        });
    </script>
@endsection
@endsection

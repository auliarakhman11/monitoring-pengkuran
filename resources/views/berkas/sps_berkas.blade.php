@extends('template.master')
@section('content')

    <style>
        .blink {
            animation: blink 1.5s linear infinite;
        }

        @keyframes blink {
            0% {
                background-color: rgb(245, 103, 103);
                color: black;
            }

            50% {
                background-color: rgb(252, 197, 96);
                color: black;
            }

            100% {
                background-color: rgb(219, 205, 109);
                color: black;
            }
        }
    </style>

    <div id="main-content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-12">
                        <h2 class="float-left">SPS Berkas</h2>

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
                                    <th>Proses</th>
                                    <th>No Sistem</th>
                                    <th>Berkas</th>
                                    <th>Pemohon/<br>Kuasa</th>
                                    <th>Jumlah<br>Bidang</th>
                                    <th>Kelurahan</th>
                                    <th>Alamat</th>
                                    <th>Penjadwalan</th>
                                    <th>No WA</th>
                                    <th>Tanggal<br>Input</th>
                                    <th>File<br>Berkas</th>
                                    <th>Kendala</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = 1;
                                @endphp
                                @foreach ($berkas as $d)
                                    <tr class="{{ $d->lama_tgl >= 2 ? 'blink' : '' }}">
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $d->proses->nm_proses }}</td>
                                        <td>{{ $d->no_sistem }}</td>
                                        <td>{{ $d->no_berkas }}/{{ $d->tahun }}</td>
                                        <td>{{ $d->nm_pemohon }}<br>{{ $d->kuasa }}</td>
                                        <td>{{ $d->jml_bidang > 0 ? $d->jml_bidang . ' Bidang' : '-' }}</td>
                                        <td>{{ $d->kelurahan }}</td>
                                        <td>{{ $d->alamat }}</td>
                                        <td>
                                            @if ($d->tgl_pengukuran)
                                                {{ date('d/m/Y', strtotime($d->tgl_pengukuran)) }}<br>
                                            @else
                                                -<br>
                                            @endif
                                            @if ($d->pengukuran)
                                                @foreach ($d->pengukuran as $pe)
                                                    {{ $pe->petugas->name }}<br>
                                                @endforeach
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            @php
                                                $text =
                                                    'Halo%20Yth.%20Pemohon%20Layanan%20Pengukuran%20Pertanahan%20Kabupaten%20Banjar%0A%0A';
                                                $text .=
                                                    'Jadwal%20pengukuran%20bidang%20tanah%20Anda%20telah%20ditentukan.%0A';
                                                $text .=
                                                    'Silahkan%20melakukan%20pendaftaran%20berkas%20dan%20pembayaran%20SPS%20di%20Loket%20Pendaftaran%20Kantor%20Pertanahan%20Kabupaten%20Banjar%20maksimal%203%20(tiga)%20hari%20kerja%20setelah%20Anda%20menerima%20pesan%20ini.%0A%0A';
                                                $text .= 'Demikian%20kami%20sampaikan.%20Terima kasih.';
                                            @endphp
                                            {{-- <a href="https://api.whatsapp.com/send?phone=62{{ substr($d->no_tlp, 1) }}"
                                                target="_blank">{{ $d->no_tlp }}</a> --}}
                                            <a href="https://wa.me/62{{ substr($d->no_tlp, 1) }}?text={{ $text }}"
                                                target="_blank">{{ $d->no_tlp }}</a>
                                        </td>
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
                                        <td>{{ $d->kendala }}</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <button type="button" class="btn btn-sm btn-primary dropdown-toggle"
                                                    data-toggle="dropdown" aria-expanded="false">
                                                    Aksi
                                                </button>
                                                <div class="dropdown-menu">
                                                    @if ($d->proses_id == 2)
                                                        <a class="dropdown-item"
                                                            href="#modal_pembayaran_sps{{ $d->id }}"
                                                            data-toggle="modal"><i class="fa fa-check-circle"
                                                                aria-hidden="true"></i>
                                                            Pembayaran SPS</a>
                                                    @else
                                                        <a class="dropdown-item"
                                                            href="{{ route('cetakSpsBerkas', $d->id) }}"
                                                            onclick="return confirm('Apakah anda yakin ingin mencetak SPS?')"><i
                                                                class="fa fa-print" aria-hidden="true"></i> Cetak SPS</a>
                                                    @endif

                                                    <a class="dropdown-item" href="#model_edit{{ $d->id }}"
                                                        data-toggle="modal"><i class="fa fa-edit"></i> Edit</a>
                                                    @if ($d->file_name)
                                                        <a class="dropdown-item btn_lihat_file" href="#model_lihat_file"
                                                            data-toggle="modal" file_name="{{ $d->file_name }}"
                                                            jenis_file="{{ $d->jenis_file }}"><i class="fa fa-eye"></i>
                                                            Lihat File</a>
                                                    @endif
                                                    <a class="dropdown-item" href="#model_tutup_berkas{{ $d->id }}"
                                                        data-toggle="modal"><i class="fa fa-times-circle"
                                                            aria-hidden="true"></i> Tutup Berkas</a>
                                                    <a class="dropdown-item" href="{{ route('dropBerkas', $d->id) }}"
                                                        onclick="return confirm('Apakah anda yakin ingin menghapus berkas?')"><i
                                                            class="fa fa-trash"></i> Hapus</a>

                                                </div>
                                            </div>

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
                                        <label for="">Kuasa</label>
                                        <input type="text" class="form-control" name="kuasa"
                                            value="{{ $d->kuasa }}">
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="">Jumlah Bidang</label>
                                        <input type="number" class="form-control" name="jml_bidang"
                                            value="{{ $d->jml_bidang }}">
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

        <form action="{{ route('kendalaBerkas') }}" method="post">
            @csrf
            <div class="modal fade" id="model_kendala{{ $d->id }}" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalKendala" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalKendala">Kendala Berkas</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">

                            <div class="row">

                                <input type="hidden" name="id" value="{{ $d->id }}">

                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="">Kendala</label>
                                        <input type="text" class="form-control" name="kendala"
                                            value="{{ $d->kendala }}" placeholder="Masukan kendala..">
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

        <form action="{{ route('pembayaranSpsBerkas') }}" method="post">
            @csrf
            <div class="modal fade" id="modal_pembayaran_sps{{ $d->id }}" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalPembayaranSPS" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalPembayaranSPS">Pembayaran SPS</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">

                            <div class="row">

                                <input type="hidden" name="id" value="{{ $d->id }}">

                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="">Nomor Berkas</label>
                                        <input type="text" class="form-control" name="no_berkas"
                                            value="{{ $d->no_berkas }}" required>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="">Tahun</label>
                                        <input type="text" class="form-control" name="tahun"
                                            value="{{ $d->tahun }}" required>
                                    </div>
                                </div>

                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Bayar SPS</button>
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

        });
    </script>
@endsection
@endsection

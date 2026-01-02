<table class="table table-sm">
    <thead>
        <tr>
            <td>Tanggal</td>
            <td>{{ date('d/m/Y', strtotime($berkas->tgl_pengukuran)) }}</td>
        </tr>
        <tr>
            <td>Pemohon</td>
            <td>{{ $berkas->nm_pemohon }}</td>
        </tr>
        <tr>
            <td>Kelurahan/Desa</td>
            <td>{{ $berkas->kelurahan }}</td>
        </tr>
        <tr>
            <td>Alamat</td>
            <td>{{ $berkas->alamat }}</td>
        </tr>
        <tr>
            <td>No WA</td>
            <td><a href="https://api.whatsapp.com/send?phone=62{{ substr($berkas->no_tlp, 1) }}"
                                                target="_blank">{{ $berkas->no_tlp }}</a></td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Petugas Ukur</td>
            <td>
                @foreach ($berkas->pengukuran as $p)
                    - {{ $p->petugas->name }}<br>
                @endforeach
            </td>
        </tr>
    </tbody>
</table>
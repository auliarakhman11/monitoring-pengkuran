<div class="row">

    <div class="col-6">
        <div class="form-group">
            <label>Bahan</label>
            <select name="bahan_id[]" class="form-control select2bs4" required>
                <option value="">-Pilih Bahan-</option>
                @foreach ($bahan as $b)
                    <option value="{{ $b->id }}">{{ $b->bahan }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="col-5">
        <div class="form-group">
            <label>Takaran</label>
            <input type="text" name="takaran[]" class="form-control" required>
        </div>
    </div>

    <div class="col-1">
        <label>Aksi</label>
        <button type="button" id="tambah-bahan" class="btn btn-sm btn-primary">+</button>
    </div>

</div>

<div id="tambah-resep"></div>
<table class="table table-sm">
    <thead>
        <tr>
            <th>#</th>
            <th>Bahan</th>
            <th>Takaran</th>
            <th>Harga</th>
            <th>Total</th>
            <th>Hapus</th>
        </tr>
    </thead>
    <tbody>
        @php
            $i = 1;
            $tot_harga = 0;
        @endphp
        @foreach ($resep as $d)
            @php
                if ($d->ttl_harga > 0 && $d->ttl_qty > 0) {
                    $harga_beli = $d->ttl_harga / $d->ttl_qty;
                    $harga_jual = $harga_beli + ($harga_beli * 20) / 100;
                    // $harga_jual = $d->harga_beli + ($d->harga_beli * 20) / 100;
                } else {
                    $harga_jual = 0;
                }
                $tot_harga += $d->takaran * $harga_jual;
            @endphp
            <tr>
                <td>{{ $i++ }}</td>
                <td>{{ $d->bahan }}</td>
                <td>{{ $d->takaran }}</td>
                <td>{{ number_format($harga_jual, 0) }}</td>
                <td>{{ number_format($d->takaran * $harga_jual, 0) }}</td>
                <td><a href="javascript:void(0)" produk-id = "{{ $produk_id }}" id-resep="{{ $d->id }}"
                        onclick="return confirm('Apakah anda yakin ingin menghapus data resep?')"
                        class="btn btn-sm btn-danger hapus-resep">x</a></td>
            </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td colspan="4"><b>Total</b></td>
            <td><b>{{ number_format($tot_harga, 0) }}</b></td>
            <td></td>
        </tr>
    </tfoot>
</table>

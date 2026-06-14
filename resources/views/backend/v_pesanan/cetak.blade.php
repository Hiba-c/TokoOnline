<style>
    table {
        border-collapse: collapse;
        width: 100%;
        border: 1px solid #ccc;
    }

    table tr td {
        padding: 6px;
        font-weight: normal;
        border: 1px solid #ccc;
    }

    table th {
        border: 1px solid #ccc;
    }
</style>
<table>
    <!-- <tr>
        <td align="center">
            <img src="{{ asset('images/header.png') }}" width="50%">
        </td>
    </tr> -->
    <tr>
        <td align="left">
            Perihal : {{ $judul }} <br>
            Tanggal Awal: {{ $tanggalAwal }} s/d Tanggal Akhir: {{ $tanggalAkhir }}
        </td>
    </tr>
</table>
<p></p>
<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Status</th>
            <th>No. Resi</th>
            <th>Kurir</th>
            <th>Layanan</th>
            <th>Ongkir</th>
            <th>Estimasi</th>
            <th>Berat</th>
            <th>Total</th>
            <th>Alamat Pengiriman</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($cetak as $row)
        <tr>
            <td style="text-align:center;"> {{ $loop->iteration }} </td>
            <td style="text-align:center;"> {{$row->customer->user->nama}} </td>
            <td style="text-align:center;"> {{$row->status}} </td>
            <td style="text-align:center;"> {{$row->noresi}} </td>
            <td style="text-align:center;"> {{$row->kurir}} </td>
            <td style="text-align:center;"> {{$row->layanan_ongkir}} </td>
            <td> Rp. {{ number_format($row->biaya_ongkir, 0, ',', '.') }} </td>
            <td style="text-align:center;"> {{$row->estimasi_ongkir}} Hari</td>
            <td style="text-align:center;"> {{$row->total_berat}} Gram</td>
            <td> Rp. {{ number_format($row->total_harga, 0, ',', '.') }} </td>
            <td> {!!$row->alamat .' '. $row->pos!!}</td>
            <!-- strip_tags ($row->alamat)-->
        </tr>
        </tr>
        @endforeach

    </tbody>
</table>

<script>
    window.onload = function() {
        printStruk();
    }

    function printStruk() {
        window.print();
    }
</script>

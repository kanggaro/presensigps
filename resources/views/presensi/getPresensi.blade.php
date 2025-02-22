<?php
function selisih($jam_masuk, $jam_keluar)
{
    // Pastikan format waktu benar
    if (empty($jam_masuk) || empty($jam_keluar)) {
        return '00:00'; // Jika ada yang kosong, return 00:00
    }

    // Pastikan format waktu sesuai HH:MM:SS
    $jam_masuk = str_pad($jam_masuk, 8, '0', STR_PAD_LEFT);
    $jam_keluar = str_pad($jam_keluar, 8, '0', STR_PAD_LEFT);

    $waktu_masuk = explode(':', $jam_masuk);
    $waktu_keluar = explode(':', $jam_keluar);

    // Cek apakah hasil explode valid (minimal ada 3 elemen)
    if (count($waktu_masuk) < 3 || count($waktu_keluar) < 3) {
        return '00:00'; // Jika format salah, return 00:00
    }

    [$h1, $m1, $s1] = $waktu_masuk;
    [$h2, $m2, $s2] = $waktu_keluar;

    $dtAwal = mktime($h1, $m1, $s1, 1, 1, 1);
    $dtAkhir = mktime($h2, $m2, $s2, 1, 1, 1);
    $dtSelisih = $dtAkhir - $dtAwal;

    if ($dtSelisih < 0) {
        return '00:00'; // Jika selisih negatif, return 00:00
    }

    $totalmenit = $dtSelisih / 60;
    $jam = floor($totalmenit / 60);
    $sisamenit = round($totalmenit % 60);

    return str_pad($jam, 2, '0', STR_PAD_LEFT) . ':' . str_pad($sisamenit, 2, '0', STR_PAD_LEFT);
}
?>
@if ($monitoring->isEmpty())
    <tr>
        <td colspan="9" class="text-center">Data Not Found</td>
    </tr>
@else
    @foreach ($monitoring as $d)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $d->p_nik }}</td>
            <td>{{ $d->k_nama_lengkap }}</td>
            <td>{{ $d->d_nama_dept }}</td>
            <td>{{ $d->p_jam_in ?? '00:00:00' }}</td>
            <td>
                @if (!empty($d->p_foto_in))
                    <img src="{{ asset('storage/uploads/absensi/' . $d->p_foto_in) }}" alt="foto_in" class="avatar">
                @else
                    <span class="badge bg-warning">Foto Tidak Ada</span>
                @endif
            </td>
            <td>
                {!! !empty($d->p_jam_out) ? $d->p_jam_out : '<span class="badge bg-danger">Belum Absen</span>' !!}
            </td>
            <td>
                @if (!empty($d->p_jam_out))
                    <img src="{{ asset('storage/uploads/absensi/' . $d->p_foto_out) }}" alt="foto_out" class="avatar">
                @else
                    <span class="center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round"
                            class="icon icon-tabler icons-tabler-outline icon-tabler-circle-dotted">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M7.5 4.21l0 .01" />
                            <path d="M4.21 7.5l0 .01" />
                            <path d="M3 12l0 .01" />
                            <path d="M4.21 16.5l0 .01" />
                            <path d="M7.5 19.79l0 .01" />
                            <path d="M12 21l0 .01" />
                            <path d="M16.5 19.79l0 .01" />
                            <path d="M19.79 16.5l0 .01" />
                            <path d="M21 12l0 .01" />
                            <path d="M19.79 7.5l0 .01" />
                            <path d="M16.5 4.21l0 .01" />
                            <path d="M12 3l0 .01" />
                        </svg>
                    </span>
                @endif
            </td>
            <td>
                @if (!empty($d->p_jam_in) && $d->p_jam_in > '07:00:00')
                    @php
                        $terlambat = selisih('07:00:00', $d->p_jam_in);
                    @endphp
                    <span class="badge bg-danger">Terlambat {{ $terlambat }} jam</span>
                @else
                    <span class="badge bg-success">Tepat Waktu</span>
                @endif
            </td>
            <td>
                <a class="btn btn-primary show-lokasi" id="showLokasiPresensi" p_id="{{ $d->p_id }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="icon icon-tabler icons-tabler-outline icon-tabler-map-pin-2">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M12 18.5l-3 -1.5l-6 3v-13l6 -3l6 3l6 -3v7" />
                        <path d="M9 4v13" />
                        <path d="M15 7v5" />
                        <path
                            d="M21.121 20.121a3 3 0 1 0 -4.242 0c.418 .419 1.125 1.045 2.121 1.879c1.051 -.89 1.759 -1.516 2.121 -1.879z" />
                        <path d="M19 18v.01" />
                    </svg>
                </a>
            </td>
        </tr>
    @endforeach
@endif

{{-- @push('myscript') --}}
    <script>
        $(function(){
            $('.show-lokasi').click(function(e){
                var p_id = $(this).attr('p_id');
                $.ajax({
                    type: 'POST',
                    url: 'showMaps',
                    cache: false,
                    data:{
                        _token: '{{ csrf_token() }}',
                        p_id: p_id
                    },
                    success : function(respond){
                        $('#load-maps').html(respond);
                    }
                })
                $("#modalLokasiPresensi").modal("show");
            });
        })
    </script>
{{-- @endpush --}}

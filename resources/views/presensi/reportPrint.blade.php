<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>ReportPresensi{{ $karyawan->k_nik }}</title>

    <!-- Normalize or reset CSS with your favorite library -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.min.css">

    <!-- Load paper.css for happy printing -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.4.1/paper.css">

    {{-- bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>

    <!-- Set page size here: A5, A4 or A3 -->
    <!-- Set also "landscape" if you need -->
    <style>
        @page {
            size: A4 portrait;
            margin: 10mm;
        }

        /* *{
          border:1px solid red;
        } */
    </style>
</head>

<!-- Set "A5", "A4" or "A3" for class name -->
<!-- Set also "landscape" if you need -->

<body class="A4 potrait">

    <?php
    function selisih($jam_masuk, $jam_keluar)
    {
        if (empty($jam_masuk) || empty($jam_keluar)) {
            return '00:00';
        }
        $jam_masuk = str_pad($jam_masuk, 8, '0', STR_PAD_LEFT);
        $jam_keluar = str_pad($jam_keluar, 8, '0', STR_PAD_LEFT);
        $waktu_masuk = explode(':', $jam_masuk);
        $waktu_keluar = explode(':', $jam_keluar);
    
        if (count($waktu_masuk) < 3 || count($waktu_keluar) < 3) {
            return '00:00';
        }
        [$h1, $m1, $s1] = $waktu_masuk;
        [$h2, $m2, $s2] = $waktu_keluar;
        $dtAwal = mktime($h1, $m1, $s1, 1, 1, 1);
        $dtAkhir = mktime($h2, $m2, $s2, 1, 1, 1);
        $dtSelisih = $dtAkhir - $dtAwal;
    
        if ($dtSelisih < 0) {
            return '00:00';
        }
        $totalmenit = $dtSelisih / 60;
        $jam = floor($totalmenit / 60);
        $sisamenit = round($totalmenit % 60);
    
        return str_pad($jam, 2, '0', STR_PAD_LEFT) . ':' . str_pad($sisamenit, 2, '0', STR_PAD_LEFT);
    }
    ?>

    <!-- Each sheet element should have the class "sheet" -->
    <!-- "padding-**mm" is optional: you can set 10, 15, 20 or 25 -->
    <section class="sheet padding-10mm">
        <div class="row">
            <div class="col-2">
                <img src="{{ asset('assets/img/logoQ.png') }}" alt="" height="100px">
            </div>
            <div class="col-10">
                <h5 class="mt-2">LAPORAN PRESENSI KARYAWAN PERIODE {{ strtoupper($monthName[$bulan]) }}
                    {{ $tahun }}</h5>
                <H5>PT ABQU TERBAIK MASSE</H5>
                <p>Jln Arief Rahman Hakim No 1, Kode Pos 111</p>
            </div>
        </div>

        <hr>

        <div class="row mt-5">
            <div class="col-3">
                @if ($karyawan->k_foto != null)
                    <img src="{{ asset('storage/uploads/karyawan/' . $karyawan->k_foto) }}" class="ps-4"
                        height="170" width="150" alt="">
                @else
                    <img src="{{ asset('storage/uploads/karyawan/noimgprofile.png') }}" class="ps-4"
                        height="170" width="150" alt="">
                @endif
            </div>
            <div class="col-9">
                <div class="row mt-2 mb-2">
                    <div class="col-3 fw-bold">NIK</div>
                    <div class="col">: &emsp;{{ $karyawan->k_nik }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-3 fw-bold">Nama</div>
                    <div class="col">: &emsp;{{ $karyawan->k_nama_lengkap }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-3 fw-bold">Jabatan</div>
                    <div class="col">: &emsp;{{ $karyawan->k_jabatan }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-3 fw-bold">Departement</div>
                    <div class="col">: &emsp;{{ $karyawan->d_nama_dept }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-3 fw-bold">No HP</div>
                    <div class="col">: &emsp;{{ $karyawan->k_no_hp }}</div>
                </div>
            </div>
        </div>

        <div class="row mt-5">
            <table class="table table-bordered table-striped table-hover text-center" style="font-size: 14px">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Jam Masuk</th>
                        <th>Foto</th>
                        <th>Jam Keluar</th>
                        <th>Foto</th>
                        <th>Jumlah Jam</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($reportPresensi as $d)
                        <tr style="text-size:1px;">
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ date('d-M-Y', strtotime($d->p_tgl_presensi)) }}</td>
                            <td>{{ $d->p_jam_in }}</td>
                            <td>
                                <img src="{{ asset('storage/uploads/absensi/' . $d->p_foto_in) }}" alt=""
                                    class="rounded" width="40" height="50">
                            </td>
                            <td>
                                @if ($d->p_jam_out != null)
                                    {{ $d->p_jam_out }}
                                @else
                                    <p>Belum absen</p>
                                @endif
                            </td>
                            <td>
                                @if ($d->p_jam_out != null)
                                    <img src="{{ asset('storage/uploads/absensi/' . $d->p_foto_out) }}" alt=""
                                        class="rounded" width="40" height="50">
                                @else
                                    <p>...</p>
                                @endif
                            </td>
                            <td>
                                @if ($d->p_jam_out != null)
                                    <p>{{ selisih($d->p_jam_in, $d->p_jam_out) }}</p>
                                @else
                                    <p>...</p>
                                @endif
                            </td>
                            <td>
                                @if ($d->p_jam_in > '07:00')
                                    <p>Terlambat {{ selisih('07:00:00', $d->p_jam_in) }} jam</p>
                                @else
                                    <p>Tepat waktu</p>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="row mt-5">
            <div class="col">
                <div class="row text-center"><br></div>
                <div style="height: 102px"></div>
                <div class="row text-center">
                    <u>Abd. Alfa</u>
                    <i><b>HRD Manager</b></i>
                </div>
            </div>
            <div class="col">
                <div class="row text-center">
                    <h>Kota, {{ date('d F Y') }}</h>
                </div>
                <div style="height: 100px"></div>
                <div class="row text-center">
                    <u>Naila U</u>
                    <i><b>Direktur</b></i>
                </div>
            </div>
        </div>

    </section>

    <script>
        < script src = "https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity = "sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p"
        crossorigin = "anonymous" >
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
    </script>
    </script>
</body>

</html>

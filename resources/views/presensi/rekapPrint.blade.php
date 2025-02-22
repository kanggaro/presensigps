<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Rekap Presensi</title>

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

<body class="A4 landscape">

    <!-- Each sheet element should have the class "sheet" -->
    <!-- "padding-**mm" is optional: you can set 10, 15, 20 or 25 -->
    <section class="sheet padding-10mm">
        <div class="row">
            <div class="col-2">
                <img src="{{ asset('assets/img/logoQ.png') }}" alt="" height="100px">
            </div>
            <div class="col-10">
                <h5 class="mt-2">REKAP PRESENSI KARYAWAN PERIODE {{ strtoupper($monthName[$bulan]) }}
                    {{ $tahun }}</h5>
                <H5>PT ABQU TERBAIK MASSE</H5>
                <p>Jln Arief Rahman Hakim No 1, Kode Pos 111</p>
            </div>
        </div>

        <hr>

        <div class="row mt-5">
            <table class="table table-bordered table-striped table-hover text-center" style="font-size: 8px">
                <thead>
                    <tr>
                        <th rowspan="2">NIK</th>
                        <th rowspan="2">Nama Karyawan</th>
                        <th colspan="31">Tanggal</th>
                        <th rowspan="2">TH</th>
                        <th rowspan="2">TT</th>
                    <tr>
                        @for ($i = 1; $i <= 31; $i++)
                            <th>{{ $i }}</th>
                        @endfor
                    </tr>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($rekap as $d)
                        <tr>
                            <td>{{ $d->p_nik }}</td>
                            <td class="text-start">{{ $d->k_nama_lengkap }}</td>
                            <?php
                            $totalHadir = 0;
                            $totalTerlambat = 0;
                            for($i=1;$i<=31;$i++){
                                $tgl = "tgl_".$i;
                                
                                if(empty($d->$tgl)){
                                    $hadir = ['',''];
                                    $totalHadir += 0;
                                }
                                //jika hadir / absen tidak null
                                else {
                                    $hadir = explode("-",$d->$tgl);
                                    $totalHadir += 1;
                                    if($d->$tgl > '07:00:00')
                                        $totalTerlambat += 1;
                                }
                        ?>
                            <td>
                                <span
                                    class="text{{ $hadir[0] > '07:00:00' ? '-danger' : '-success' }}">{{ substr($hadir[0],0,5) }}</span><br>
                                <span
                                    class="text{{ $hadir[1] < '16:00:00' ? '-danger' : '-success' }}">{{ substr($hadir[1],0,5) }}</span>
                                <?php
                            }
                        ?>
                            <td>{{ $totalHadir }}</td>
                            <td>{{ $totalTerlambat }}</td>
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

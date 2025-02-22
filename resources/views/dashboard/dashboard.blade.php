@extends("layouts.presensi")
@section('content')
    <div class="section" id="user-section">
        <div id="user-detail">
            <div class="avatar">
                @if(empty(Auth::guard("karyawan")->user()->k_foto))
                <img src="assets/img/sample/avatar/avatar1.jpg" alt="avatar" class="imaged w64 rounded">
                @else
                <img src="{{ asset("storage/uploads/karyawan/" . Auth::guard('karyawan')->user()->k_foto) }}" alt="avatar" class="imaged w64 rounded" style="height:60px;">
                @endif
            </div>
            <div id="user-info">
                <h2 id="user-name">{{ Auth::guard('karyawan')->user()->k_nama_lengkap }}</h2>
                <span id="user-role">{{ Auth::guard('karyawan')->user()->k_jabatan }}</span>
            </div>
        </div>
    </div>

    <div class="section" id="menu-section">
        <div class="card">
            <div class="card-body text-center">
                <div class="list-menu">
                    <div class="item-menu text-center">
                        <div class="menu-icon">
                            <a href="/editProfile" class="green" style="font-size: 40px;">
                                <ion-icon name="person-sharp"></ion-icon>
                            </a>
                        </div>
                        <div class="menu-name">
                            <span class="text-center">Profil</span>
                        </div>
                    </div>
                    <div class="item-menu text-center">
                        <div class="menu-icon">
                            <a href="/presensi/izin" class="danger" style="font-size: 40px;">
                                <ion-icon name="calendar-number"></ion-icon>
                            </a>
                        </div>
                        <div class="menu-name">
                            <span class="text-center">Cuti</span>
                        </div>
                    </div>
                    <div class="item-menu text-center">
                        <div class="menu-icon">
                            <a href="presensi/history" class="warning" style="font-size: 40px;">
                                <ion-icon name="document-text"></ion-icon>
                            </a>
                        </div>
                        <div class="menu-name">
                            <span class="text-center">Histori</span>
                        </div>
                    </div>
                    <div class="item-menu text-center">
                        <div class="menu-icon">
                            <a href="" class="orange" style="font-size: 40px;">
                                <ion-icon name="location"></ion-icon>
                            </a>
                        </div>
                        <div class="menu-name">
                            Lokasi
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="section mt-2" id="presence-section">
        <div class="todaypresence">
            <div class="row">
                <div class="col-6">
                    <div class="card gradasigreen">
                        <div class="card-body">
                            <div class="presencecontent">
                                <div class="iconpresence">
                                    @if($presensiToday != null)
                                        @php
                                            $path = Storage::url('uploads/absensi/'. $presensiToday->p_foto_in);
                                            // dd($path);
                                            @endphp
                                        <img src="{{ asset('storage/uploads/absensi/'.$presensiToday->p_foto_in) }}" class="imaged w48">
                                        {{-- <img src="{{ url($path) }}" alt="image" class="image"> --}}
                                    @else
                                        <ion-icon name="camera"></ion-icon>
                                    @endif
                                </div>
                                <div class="presencedetail">
                                    <h4 class="presencetitle">Masuk</h4>
                                    <span>{{ $presensiToday != null ? $presensiToday->p_jam_in : "Belum Absen"  }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card gradasired">
                        <div class="card-body">
                            <div class="presencecontent">
                                <div class="iconpresence">
                                    @if($presensiToday && $presensiToday->p_jam_out != null)
                                        @php
                                            $path = Storage::url('public/uploads/absensi/'.$presensiToday->p_foto_out)
                                        @endphp
                                        {{-- <img src="{{ url($path) }}" class="imaged w64">     --}}
                                        <img src="{{ asset('storage/uploads/absensi/'.$presensiToday->p_foto_out) }}" class="imaged w48">
                                    @else
                                        <ion-icon name="camera"></ion-icon>
                                    @endif
                                </div>
                                <div class="presencedetail">
                                    <h4 class="presencetitle">Pulang</h4>
                                    <span>{{ $presensiToday && $presensiToday->p_jam_out != null ? $presensiToday->p_jam_out : "Belum Absen"  }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        {{-- <div class="rekappresence">
            <div id="chartdiv"></div>
            <!-- <div class="row">
                <div class="col-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="presencecontent">
                                <div class="iconpresence primary">
                                    <ion-icon name="log-in"></ion-icon>
                                </div>
                                <div class="presencedetail">
                                    <h4 class="rekappresencetitle">Hadir</h4>
                                    <span class="rekappresencedetail">0 Hari</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="presencecontent">
                                <div class="iconpresence green">
                                    <ion-icon name="document-text"></ion-icon>
                                </div>
                                <div class="presencedetail">
                                    <h4 class="rekappresencetitle">Izin</h4>
                                    <span class="rekappresencedetail">0 Hari</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-1">
                <div class="col-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="presencecontent">
                                <div class="iconpresence warning">
                                    <ion-icon name="sad"></ion-icon>
                                </div>
                                <div class="presencedetail">
                                    <h4 class="rekappresencetitle">Sakit</h4>
                                    <span class="rekappresencedetail">0 Hari</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="presencecontent">
                                <div class="iconpresence danger">
                                    <ion-icon name="alarm"></ion-icon>
                                </div>
                                <div class="presencedetail">
                                    <h4 class="rekappresencetitle">Terlambat</h4>
                                    <span class="rekappresencedetail">0 Hari</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->
        </div> --}}

        <div id="rekappresence">
            <h3>Rekap Presensi Bulan {{ $monthName[$thisMonth] }} Tahun {{ $thisYear }}</h3>
            <div class="row">
                <div class="col-3">
                    <div class="card">
                        <div class="card-body text-center" style="padding:12px 12px !importan; line-height:0.8rem;">
                            <span class="badge bg-danger" style="position:absolute; top:10px; right:15px; font-size:0.8rem; z-index:999;">{{ $rekapPresence->jmlHadir }}</span>
                            <ion-icon name="accessibility-outline" style="font-size: 1.6rem;" class="text-primary mb-1"></ion-icon>
                            <br>
                            <span style="font-size: 0.8rem; font-weight:500;">Hadir</span>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="card">
                        <div class="card-body text-center" style="padding:12px 12px !importan; line-height:0.8rem;">
                            <span class="badge bg-danger" style="position:absolute; top:10px; right:15px; font-size:0.8rem; z-index:999;">{{ $rekapIzin->jmlIzin }}</span>
                            <ion-icon name="newspaper-outline" style="font-size: 1.6rem;" class="text-success mb-1"></ion-icon>
                            <br>
                            <span style="font-size: 0.8rem; font-weight:500;">Ijin</span>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="card">
                        <div class="card-body text-center" style="padding:12px 12px !importan; line-height:0.8rem;">
                            <span class="badge bg-danger" style="position:absolute; top:10px; right:15px; font-size:0.8rem; z-index:999;">{{ $rekapIzin->jmlSakit }}</span>
                            <ion-icon name="medkit-outline" style="font-size: 1.6rem;" class="text-warning mb-1"></ion-icon>
                            <br>
                            <span style="font-size: 0.8rem; font-weight:500;">Sakit</span>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="card">
                        <div class="card-body text-center" style="padding:12px 12px !importan; line-height:0.8rem;">
                            <span class="badge bg-danger" style="position:absolute; top:10px; right:15px; font-size:0.8rem; z-index:999;">{{ $rekapPresence->jmlTelat }}</span>
                            <ion-icon name="alarm-outline" style="font-size: 1.6rem;" class="text-danger mb-1"></ion-icon>
                            <br>
                            <span style="font-size: 0.8rem; font-weight:500;">Telat</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="presencetab mt-2">
            <div class="tab-pane fade show active" id="pilled" role="tabpanel">
                <ul class="nav nav-tabs style1" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#home" role="tab">
                            Bulan Ini
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#profile" role="tab">
                            Leaderboard
                        </a>
                    </li>
                </ul>
            </div>
            <div class="tab-content mt-2" style="margin-bottom:100px;">
                <div class="tab-pane fade show active" id="home" role="tabpanel">
                    <ul class="listview image-listview">
                        @foreach ($historyThisMonth as $dataHistory)
                            <li>
                                <div class="item">
                                    <div class="icon-box bg-primary">
                                        <ion-icon name="finger-print-outline"></ion-icon>
                                    </div>
                                    <div class="in">
                                        <div>{{ date("d-m-Y", strtotime($dataHistory->p_tgl_presensi)) }}</div>
                                        <span class="badge badge-success">{{ $dataHistory->p_jam_in }}</span>
                                        <span class="badge badge-danger">{{ $presensiToday != null && $dataHistory->p_jam_out != null ? $dataHistory->p_jam_out : 'Belum Absen' }}</span>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div class="tab-pane fade" id="profile" role="tabpanel">
                    <ul class="listview image-listview">
                        @foreach ($leaderboard as $dataLeaderboard)
                            <li>
                                <div class="item">
                                    <img src="assets/img/sample/avatar/avatar1.jpg" alt="image" class="image">
                                    <div class="in">
                                        <div>
                                            {{ $dataLeaderboard->k_nama_lengkap }}
                                            <br>
                                            <small class="text-muted">{{ $dataLeaderboard->k_jabatan }}</small>
                                        </div>
                                        <span class="badge {{ $dataLeaderboard->p_jam_in > "07:00" ? "bg-danger" : "bg-success" }}">{{ $dataLeaderboard->p_jam_in }}</span>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>

            </div>
        </div>
    </div>
@endsection

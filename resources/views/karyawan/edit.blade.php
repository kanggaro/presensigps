<form action="karyawan/{{ $karyawan->k_nik }}/update" method="POST" enctype="multipart/form-data" id="frmEditKaryawan">
    @csrf
        <div class="d-flex m-3">
            <img class="avatar avatar-xl mx-auto"
                src="
                    @if($karyawan->k_foto == null)
                        {{ asset('storage/uploads/karyawan/noimgprofile.png')}}
                    @else
                        {{ asset('storage/uploads/karyawan/'. $karyawan->k_foto)}}
                    @endif
                " alt="karyawan-foto">
        </div>
        <div class="input-icon mb-2">
            <div>
                <span class="input-icon-addon">
                    <!-- Download SVG icon from http://tabler.io/icons/icon/user -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round"
                        class="icon icon-tabler icons-tabler-outline icon-tabler-fingerprint-scan">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M9 11a3 3 0 0 1 6 0c0 1.657 .612 3.082 1 4" />
                        <path d="M12 11v1.75c-.001 1.11 .661 2.206 1 3.25" />
                        <path d="M9 14.25c.068 .58 .358 1.186 .5 1.75" />
                        <path d="M4 8v-2a2 2 0 0 1 2 -2h2" />
                        <path d="M4 16v2a2 2 0 0 0 2 2h2" />
                        <path d="M16 4h2a2 2 0 0 1 2 2v2" />
                        <path d="M16 20h2a2 2 0 0 0 2 -2v-2" />
                    </svg>
                </span>
                <input type="text" name="nik" value="{{ $karyawan->k_nik }}" class="form-control" placeholder="NIK" readonly>
            </div>
        </div>
        <div class="input-icon mb-2">
            <span class="input-icon-addon">
                <!-- Download SVG icon from http://tabler.io/icons/icon/user -->
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round" class="icon icon-1">
                    <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0"></path>
                    <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path>
                </svg>
            </span>
            <input type="text" name="nama_lengkap" value="{{ $karyawan->k_nama_lengkap }}" class="form-control"
                placeholder="Nama Lengkap">
        </div>
        <div class="input-icon mb-2">
            <span class="input-icon-addon">
                <!-- Download SVG icon from http://tabler.io/icons/icon/user -->
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round"
                    class="icon icon-tabler icons-tabler-outline icon-tabler-device-desktop-analytics">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path
                        d="M3 4m0 1a1 1 0 0 1 1 -1h16a1 1 0 0 1 1 1v10a1 1 0 0 1 -1 1h-16a1 1 0 0 1 -1 -1z" />
                    <path d="M7 20h10" />
                    <path d="M9 16v4" />
                    <path d="M15 16v4" />
                    <path d="M9 12v-4" />
                    <path d="M12 12v-1" />
                    <path d="M15 12v-2" />
                    <path d="M12 12v-1" />
                </svg>
            </span>
                <input type="text" name="jabatan" value="{{ $karyawan->k_jabatan }}" class="form-control"
                placeholder="Jabatan">                                
        </div>
        <div class="input-icon mb-2">
            <span class="input-icon-addon">
                <!-- Download SVG icon from http://tabler.io/icons/icon/user -->
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round"
                    class="icon icon-tabler icons-tabler-outline icon-tabler-phone">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path
                        d="M5 4h4l2 5l-2.5 1.5a11 11 0 0 0 5 5l1.5 -2.5l5 2v4a2 2 0 0 1 -2 2a16 16 0 0 1 -15 -15a2 2 0 0 1 2 -2" />
                </svg>
            </span>
            <input type="text" name="nohp" value="{{ $karyawan->k_no_hp }}" class="form-control"
                placeholder="No HP">
        </div>
        <div class="mb-2">
            <input type="file" name="foto" class="form-control">
            {{-- <input type="hidden" name="foto" value="{{ $karyawan->k_foto }}"> --}}
        </div>
        <div class="mb-4">
            <select name="kode_dept" id="" class="form-control" list="datalistOptions"
                aria-placeholder="Departement">
                <option value="">Departement</option>
                @foreach ($departement as $d)
                    <option {{ $karyawan->k_kode_dept == $d->d_kode_dept ? 'selected' : '' }}
                        value="{{ $d->d_kode_dept }}">{{ $d->d_nama_dept }}</option>
                @endforeach
            </select>                            
        </div>
        
        <button type="submit" class="btn btn-primary w-full">Perbarui</button>
</form>
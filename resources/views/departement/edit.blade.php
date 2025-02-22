<form action="departement/{{ $departement->d_kode_dept }}/update" method="POST" enctype="multipart/form-data" id="frmEdiDept">
    @csrf
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
                <input type="text" name="kode_dept" value="{{ $departement->d_kode_dept }}" class="form-control" placeholder="Kode Departement" >
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
            <input type="text" name="nama_dept" value="{{ $departement->d_nama_dept }}" class="form-control"
                placeholder="Nama Departement">
        </div>
 
        <button type="submit" class="btn btn-primary w-full">Perbarui</button>
</form>
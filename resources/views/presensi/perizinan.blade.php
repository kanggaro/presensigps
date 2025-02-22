@extends('layouts.admin.tabler')
@section('content')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <!-- Page pre-title -->
                    <h2 class="page-title">
                        Monitoring Perizinan
                    </h2>
                </div>
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                {{-- <div class="col-10"> --}}
                                    <form action="perizinan" method="GET">
                                        <div class="row">
                                            <div class="col-2">
                                                <div class="input-icon mb-2">
                                                    <input class="form-control datepicker" name="from" placeholder="From Date"
                                                        id="datepickerfrom" value="{{ Request('') }}" autocomplete="off">
                                                    <span class="input-icon-addon">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                            height="24" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round" class="icon icon-1">
                                                            <path
                                                                d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12z">
                                                            </path>
                                                            <path d="M16 3v4"></path>
                                                            <path d="M8 3v4"></path>
                                                            <path d="M4 11h16"></path>
                                                            <path d="M11 15h1"></path>
                                                            <path d="M12 15v3"></path>
                                                        </svg>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-2">
                                                <div class="input-icon mb-2">
                                                    <input class="form-control datepicker" name="to" placeholder="To Date"
                                                        id="datepickerto" value="{{ Request('') }}" autocomplete="off">
                                                    <span class="input-icon-addon">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                            height="24" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round" class="icon icon-1">
                                                            <path
                                                                d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12z">
                                                            </path>
                                                            <path d="M16 3v4"></path>
                                                            <path d="M8 3v4"></path>
                                                            <path d="M4 11h16"></path>
                                                            <path d="M11 15h1"></path>
                                                            <path d="M12 15v3"></path>
                                                        </svg>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-2">
                                                <input type="text" name="nik" class="form-control" placeholder="NIK"
                                                    value="{{ Request('') }}">
                                            </div>
                                            <div class="col-2">
                                                <input type="text" name="nama" class="form-control" placeholder="Nama"
                                                    value="{{ Request('') }}">
                                            </div>
                                            <div class="col-2">
                                                <select name="status" id="" class="form-control" >
                                                    <option value="">Status Perizinan</option>
                                                    <option value="0">Waiting...</option>
                                                    <option value="1">Disetujui</option>
                                                    <option value="2">Ditolak</option>
                                                </select>
                                            </div>
                                            <div class="col-2 form-group">
                                                <button class="form-control btn btn-primary"><svg
                                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        class="icon icon-tabler icons-tabler-outline icon-tabler-search">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" />
                                                        <path d="M21 21l-6 -6" />
                                                    </svg>Cari</button>
                                            </div>
                                        </div>
                                    </form>
                                {{-- </div> --}}
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>Status</th>
                                        <th>NIK</th>
                                        <th>Nama Karyawan</th>
                                        <th>Jabatan</th>
                                        <th>Jenis</th>
                                        <th>Keterangan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($perizinan -> isEmpty())
                                        <tr>
                                            <td colspan="9" class="text-center">Data Not Found</td>
                                        </tr>
                                    @else
                                        @foreach ($perizinan as $d)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ ($d->pz_tgl_izin) }}</td>
                                                <td>
                                                    @if ($d->pz_status_approved == 1)
                                                        <span class="badge bg-success">Disetujui</span>
                                                    @elseif ($d->pz_status_approved == 2)
                                                        <span class="badge bg-danger">Ditolak</span>
                                                    @elseif ($d->pz_status_approved == 0)
                                                        <span class="badge bg-warning">Waiting...</span>
                                                    @endif
                                                </td>
                                                <td>{{ $d->k_nik }}</td>
                                                <td>{{ $d->k_nama_lengkap }}</td>
                                                <td>{{ $d->k_jabatan }}</td>
                                                <td>{{ $d->pz_status }}</td>
                                                <td>{{ $d->pz_keterangan }}</td>
                                                <td class="d-flex justify-content-around">
                                                    @if ($d->pz_status_approved == 0)
                                                        <a href="perizinan/{{ $d->pz_id }}/status/1"
                                                            class="btn btn-success accPZ" value="1" name="acc">
                                                            Setujui
                                                        </a>
                                                        <a href="perizinan/{{ $d->pz_id }}/status/2"
                                                            class="btn btn-danger rejectPZ" value="2" name="reject">
                                                            Tolak
                                                        </a>
                                                    @else
                                                        <a href="perizinan/{{ $d->pz_id }}/status/0"
                                                            class="btn btn-warning cancelPZ" value="0" name="cancel">
                                                            Batalkan
                                                        </a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                        
                                    @endif
                                </tbody>
                            </table>
                            {{ $perizinan->links('vendor.pagination.bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('myscript')
    <script>
        $(document).ready(function() {
            // Inisialisasi Litepicker
            if (typeof Litepicker !== "undefined") {
                $(".datepicker").each(function(){
                    new Litepicker({
                        element: this, // Ambil elemen DOM dari jQuery
                        format: "YYYY-MM-DD",
                        autoApply: true,
                        buttonText: {
                            previousMonth: `
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-1">
                                <path d="M15 6l-6 6l6 6"></path>
                            </svg>`,
                            nextMonth: `
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-1">
                                <path d="M9 6l6 6l-6 6"></path>
                            </svg>`,
                        },
                        setup: (picker) => {
                            picker.on("selected", (date) => {
                                let selectedDate = date.format("YYYY-MM-DD"); // Format tanggal
                                dateInput.val(selectedDate).trigger(
                                    "change"); // Set nilai & trigger event
                            });
                        }
                    });
                });
            } else {
                console.error("Litepicker tidak dimuat.");
            }
        });
    </script>
@endpush

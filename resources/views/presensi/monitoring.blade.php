@extends('layouts.admin.tabler')
@section('content')
{{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/litepicker/dist/css/litepicker.css"> --}}
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <!-- Page pre-title -->
                    <h2 class="page-title">
                        Monitoring
                    </h2>
                    <p class="page-pretitle">Pantau Presensi Karyawan disini</p>
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
                            <div class="input-icon mb-2">
                                <input class="form-control" placeholder="Select a date" id="datepicker"
                                    value="{{ date('Y-m-d')  }}">
                                <span class="input-icon-addon">
                                    <!-- Download SVG icon from http://tabler.io/icons/icon/calendar -->
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" class="icon icon-1">
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
                            <div class="row">
                                <div class="col-12">
                                    <table class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>NIK</th>
                                                <th>Nama Karyawan</th>
                                                <th>Departement</th>
                                                <th>Jam Masuk</th>
                                                <th>Foto Masuk</th>
                                                <th>Jam Keluar</th>
                                                <th>Foto Keluar</th>
                                                <th>Keterangan</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody id="load-presensi"></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal modal-blur fade" id="modalLokasiPresensi" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Lokasi Presensi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="load-maps">
                </div>
            </div>
        </div>
    </div>
@endsection

@push('myscript')
<script>
    $(document).ready(function () {
        // Inisialisasi Litepicker
        if (typeof Litepicker !== "undefined") {
            let dateInput = $("#datepicker");

            new Litepicker({
                element: dateInput[0], // Ambil elemen DOM dari jQuery
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
                        dateInput.val(selectedDate).trigger("change"); // Set nilai & trigger event
                    });
                }
            });
        } else {
            console.error("Litepicker tidak dimuat.");
        }

        // Event handler ketika tanggal berubah
        $("#datepicker").on("change", function () {
            loadPresensi();
        });
        //saat buka halaman
        loadPresensi();

        function loadPresensi(){        
            var tanggal = $('#datepicker').val();
            // alert("Tanggal dipilih: " + tanggal);

            $.ajax({
                type: "POST",
                url: "getPresensi",
                data: {
                    _token: "{{ csrf_token() }}",
                    tanggal: tanggal
                },
                cache: false,
                success: function (respond) {
                    $("#load-presensi").html(respond);
                },
                error: function (xhr, status, error) {
                    console.error("Terjadi kesalahan: ", error);
                }
            });
        }
    });

</script>
@endpush

@extends('layouts.admin.tabler')
@section('content')
    <div class="page-header d-print-none">
        <div class="container-xl">
            {{-- alert --}}
            <div class="row alertContainer">
                @php
                    $messageSuccess = Session::get('success');
                    $messageError = Session::get('error');
                @endphp
                @if (Session::get('success'))
                    <div class="alert alert-important alert-success alert-dismissible" role="alert">
                        <div class="d-flex">
                            <div>
                                <!-- Download SVG icon from http://tabler.io/icons/icon/check -->
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="icon alert-icon icon-2">
                                    <path d="M5 12l5 5l10 -10"></path>
                                </svg>
                            </div>
                            <div>
                                {{ $messageSuccess }}
                            </div>
                        </div>
                        <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                    </div>
                @elseif (Session::get('error'))
                    <div class="alert alert-important alert-danger alert-dismissible" role="alert">
                        <div class="d-flex">
                            <div>
                                <!-- Download SVG icon from http://tabler.io/icons/icon/check -->
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="icon alert-icon icon-2">
                                    <path d="M5 12l5 5l10 -10"></path>
                                </svg>
                            </div>
                            <div>
                                {{ $messageError }}
                            </div>
                        </div>
                        <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                    </div>
                @endif
                @if ($errors->any())
                    <div class="alert alert-important alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
            {{-- end alert --}}
            <div class="row g-2 align-items-center">
                <div class="col">
                    <!-- Page pre-title -->
                    <h2 class="page-title">
                        Data Karyawan
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
                                <div class="col-5">
                                    <a href="#modalTambahKaryawan" class="btn btn-primary" id="btnTambahKaryawan"><svg
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-plus">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M12 5l0 14" />
                                            <path d="M5 12l14 0" />
                                        </svg>Tambah Data</a>
                                </div>
                                <div class="col-7">
                                    <form action="karyawan" method="GET">
                                        <div class="row">
                                            <div class="col-5">
                                                <input type="text" name="nama_nik" class="form-control"
                                                    placeholder="Nama Karyawan" value="{{ Request('nama_nik') }}">
                                            </div>
                                            <div class="col-5 form-group">
                                                <select name="kode_dept" id="" class="form-control"
                                                    list="datalistOptions" aria-placeholder="Nama Departement">
                                                    <option value="">Departement</option>
                                                    @foreach ($departement as $d)
                                                        <option
                                                            {{ Request('kode_dept') == $d->d_kode_dept ? 'selected' : '' }}
                                                            value="{{ $d->d_kode_dept }}">{{ $d->d_nama_dept }}</option>
                                                    @endforeach
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
                                                    </svg> Cari</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            {{-- <div class="card-body"> --}}
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>NIK</th>
                                        <th>Nama</th>
                                        <th>No HP</th>
                                        <th>Jabatan</th>
                                        <th>Foto</th>
                                        <th>Departemen</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($dataKaryawan->isEmpty())
                                        <tr>
                                            <td colspan="8" class="text-center">Data Not Found</td>
                                        </tr>
                                    @else
                                        @foreach ($dataKaryawan as $d)
                                            @php
                                                $path = Storage::url('uploads/karyawan/' . $d->k_foto);
                                            @endphp
                                            <tr>
                                                <td>{{ $loop->iteration + $dataKaryawan->firstItem() - 1 }}</td>
                                                <td>{{ $d->k_nik }}</td>
                                                <td>{{ $d->k_nama_lengkap }}</td>
                                                <td>{{ $d->k_no_hp }}</td>
                                                <td>{{ $d->k_jabatan }}</td>
                                                <td>
                                                    @if ($d->k_foto != null)
                                                        <img src="{{ asset('storage/uploads/karyawan/' . $d->k_foto) }}"
                                                            class="avatar" alt="">
                                                    @else
                                                        <img src="{{ asset('storage/uploads/karyawan/noimgprofile.png') }}"
                                                            class="avatar" alt="">
                                                    @endif
                                                </td>
                                                <td>{{ $d->d_nama_dept }}</td>
                                                <td class="d-flex justify-content-around">
                                                    <a href="#" class="btn btn-primary edit" id="btnEditKaryawan"
                                                        data_bs-target="#modalEditKaryawan"
                                                        nik="{{ $d->k_nik }}">edit</a>
                                                    <form action="karyawan/{{ $d->k_nik }}/delete" method="POST">
                                                        @csrf
                                                        <a class="btn btn-danger delete-confirm" id="btnHapusKaryawan"
                                                            nik="{{ $d->k_nik }}">hapus</a>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                            {{ $dataKaryawan->links('vendor.pagination.bootstrap-5') }}
                            {{-- </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- modal --}}
    <div class="modal modal-blur fade @if ($errors->any()) show @endif" id="modalInputKaryawan"
        tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document"
            @if ($errors->any()) style="diplay:block;" @endif>
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Karyawan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="/panel/karyawan/store" method="POST" id="frmTambahKaryawan">
                    @csrf
                    <div class="modal-body">
                        {{-- message input validasi --}}
                        @if ($errors->any())
                            <div class="alert alert-danger mb-3">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        {{-- <div id="error-messages" class="alert alert-danger d-none">
                                <ul id="error-list"></ul>
                            </div> --}}
                        {{-- end message --}}
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
                                <input type="text" name="nik" value="" class="form-control"
                                    placeholder="NIK">
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
                            <input type="text" name="nama_lengkap" value="" class="form-control"
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
                            <input type="text" name="jabatan" value="" class="form-control"
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
                            <input type="text" name="nohp" value="" class="form-control"
                                placeholder="No HP">
                        </div>
                        <div class="mb-2">
                            <input type="file" name="foto" class="form-control">
                        </div>
                        <div class="mb-2">
                            <select name="kode_dept" id="" class="form-control" list="datalistOptions"
                                aria-placeholder="Departement">
                                <option value="">Departement</option>
                                @foreach ($departement as $d)
                                    <option {{ Request('kode_dept') == $d->d_kode_dept ? 'selected' : '' }}
                                        value="{{ $d->d_kode_dept }}">{{ $d->d_nama_dept }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Tambah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal modal-blur fade" id="modalEditKaryawan" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Karyawan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="load-edit-form">
                    {{-- karyawan/edit using AJAX --}}
                </div>
            </div>
        </div>
    </div>

@endsection
@push('myscript')
    <script>
        $(() => {
            $("#btnTambahKaryawan").click(() => {
                $("#modalInputKaryawan").modal("show");
            });

            $(".edit").click(function() {
                var nik = $(this).attr('nik');
                $.ajax({
                    type: 'POST',
                    url: 'karyawan/edit',
                    cache: false,
                    data: {
                        _token: "{{ csrf_token() }}",
                        nik: nik
                    },
                    success: function(respond) {
                        $('#load-edit-form').html(respond)
                    }
                });
                $("#modalEditKaryawan").modal("show");
            });

            $('.delete-confirm').click(function(e) {
                var form = $(this).closest('form');
                var nik = $(this).attr('nik');
                // e.preventDefaul();
                Swal.fire({
                    title: "Yakin?",
                    text: `Karyawan [NIK : ${nik}] akan dihappus`,
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                        // Swal.fire({
                        //     title: "Deleted!",
                        //     text: `nik : ${nik} berhasil dihapus`,
                        //     icon: "success"
                        // });
                    }
                });

            });

            // AJAX untuk menangani submit form
            // $("#frmTambahKaryawan").submit(function(e) {
            //     e.preventDefault(); // Mencegah reload halaman

            //     let formData = new FormData(this); // Ambil data dari form
            //     let formAction = $(this).attr("action"); // Ambil URL dari form

            //     $.ajax({
            //         url: formAction,
            //         type: "POST",
            //         data: formData,
            //         processData: false,
            //         contentType: false,
            //         beforeSend: function() {
            //             $(".error-message").remove(); // Hapus pesan error sebelumnya

            //             // $("#error-list").empty(); // Kosongkan error list sebelumnya
            //             // $("#error-messages").addClass("d-none"); // Sembunyikan error dulu
            //         },
            //         success: function(response) {
            //             alert(response);
            //             if (response.success) {
            //                 $("#modalInputKaryawan").modal("hide"); // Tutup modal jika berhasil
            //                 location.reload(); // Refresh tabel karyawan (opsional)
            //             }
            //         },
            //         error: function(xhr) {
            //             if (xhr.status === 422) { // Jika validasi gagal
            //                 let errors = xhr.responseJSON.errors;

            //                 // $("#error-messages").removeClass(
            //                 //     "d-none"); // Tampilkan error container
            //                 // $.each(errors, function(key, value) {
            //                 //     $("#error-list").append("<li>" + value[0] + "</li>");
            //                 // });

            //                 $.each(errors, function(key, value) {
            //                     // Tambahkan pesan error di bawah input yang sesuai

            //                     $("input[name='" + key + "'], select[name='" + key +
            //                             "']")
            //                         .closest(".input-icon", ".mb-1")
            //                         // .next(".error-mesage")
            //                         .after('<div class="text-danger error-message mb-2">' +
            //                             value[0] + '</div>');
            //                 });
            //                 $("#modalInputKaryawan").modal("show"); // Tetap buka modal
            //             }
            //         }
            //     });
            // });
        })
    </script>
@endpush

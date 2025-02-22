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
                        Data Departement
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
                                    <a href="#modalTambahKaryawan" class="btn btn-primary" id="btnTambahDept"><svg
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
                                    <form action="departement" method="GET">
                                        <div class="row">
                                            <div class="col-5">
                                            </div>
                                            <div class="col-5">
                                                <input type="text" name="nama_kode" class="form-control"
                                                    placeholder="Nama/Kode Departement" value="{{ Request('nama_kode') }}">
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
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kode Departement</th>
                                        <th>Nama Departement</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($departement->isEmpty())
                                        <tr>
                                            <td colspan="8" class="text-center">Data Not Found</td>
                                        </tr>
                                    @else
                                        @foreach ($departement as $d)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $d->d_kode_dept }}</td>
                                            <td>{{ $d->d_nama_dept }}</td>
                                            <td class="d-flex justify-content-start">
                                                <a class="btn btn-primary me-2 edit-dept" id="btnEditDept"
                                                    kode_dept="{{ $d->d_kode_dept }}">
                                                    edit
                                                </a>
                                                <form action="departement/{{ $d->d_kode_dept }}/delete" method="POST">
                                                    @csrf
                                                    <a class="btn btn-danger delete-confirm" id="btnHapusDept"
                                                        kode_dept="{{ $d->d_kode_dept }}">
                                                        hapus
                                                    </a>
                                                </form>
                                            </td>
                                        </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                            {{-- {{ $departement->links('vendor.pagination.bootstrap-5') }} --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- modal --}}
    <div class="modal modal-blur fade @if ($errors->any()) show @endif" id="modalInputDept"
        tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document"
            @if ($errors->any()) style="diplay:block;" @endif>
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Departement</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="/panel/departement/store" method="POST" id="frmTambahDept">
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
                                <input type="text" name="kode_dept" value="" class="form-control"
                                    placeholder="Kode Departement">
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
                            <input type="text" name="nama_dept" value="" class="form-control"
                                placeholder="Nama Departement">
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

    <div class="modal modal-blur fade" id="modalEditDept" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Departement</h5>
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
            $("#btnTambahDept").click(() => {
                $("#modalInputDept").modal("show");
            });

            $(".edit-dept").click(function() {
                var kode_dept = $(this).attr('kode_dept');
                $.ajax({
                    type: 'POST',
                    url: 'departement/edit',
                    cache: false,
                    data: {
                        _token: "{{ csrf_token() }}",
                        kode_dept: kode_dept
                    },
                    success: function(respond) {
                        $('#load-edit-form').html(respond)
                    }
                });
                $("#modalEditDept").modal("show");
            });

            $('.delete-confirm').click(function(e) {
                var form = $(this).closest('form');
                var kode_dept = $(this).attr('kode_dept');
                // e.preventDefaul();
                Swal.fire({
                    title: "Yakin?",
                    text: `Departement [ ${kode_dept} ] akan dihappus`,
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });

            });
        })
    </script>
@endpush

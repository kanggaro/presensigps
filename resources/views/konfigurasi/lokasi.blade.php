@extends('layouts.admin.tabler')
@section('content')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <!-- Page pre-title -->
                    <h2 class="page-title">
                        Konfigurasi Lokasi Kantor
                    </h2>
                </div>
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">
            <div class="row">
                <div class="col-6">
                    <div class="card">
                        <div class="card-body">
                            {{-- alert --}}
                            @php
                                $messageSuccess = Session::get('success');
                                $messageError = Session::get('error');
                            @endphp
                            @if (Session::get('success'))
                                <div class="alert alert-success alert-dismissible" role="alert">
                                    <div class="d-flex">
                                        <div>
                                            {{ $messageSuccess }}
                                        </div>
                                    </div>
                                    <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                                </div>
                            @elseif(Session::get('error'))
                                <div class="alert alert-danger alert-dismissible" role="alert">
                                    <div class="d-flex">
                                        <div>
                                            {{ $messageError }}
                                        </div>
                                    </div>
                                    <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                                </div>
                            @elseif($errors->has('koordinat'))
                                {{-- <div class="alert alert-danger">{{ $errors->first('koordinat') }}</div> --}}
                                <div class="alert alert-danger alert-dismissible" role="alert">
                                    <div class="d-flex">
                                        <div>
                                            {{ $errors->first('koordinat') }}
                                        </div>
                                    </div>
                                    <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                                </div>
                            @endif
                            {{-- endalert --}}
                            <form action="updateLokasi" method="post">
                                @csrf
                                <div class="row mb-2">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <div class="input-icon mb-2">
                                                <span class="input-icon-addon">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        class="icon icon-tabler icons-tabler-outline icon-tabler-map-pin">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path d="M9 11a3 3 0 1 0 6 0a3 3 0 0 0 -6 0" />
                                                        <path
                                                            d="M17.657 16.657l-4.243 4.243a2 2 0 0 1 -2.827 0l-4.244 -4.243a8 8 0 1 1 11.314 0z" />
                                                    </svg>
                                                </span>
                                                <input class="form-control" type="text" name="koordinat" autocomplete="ON"
                                                    placeholder="curent office coordinate : {{ $loc_kantor->l_koordinat }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <div class="input-icon mb-2">
                                                <span class="input-icon-addon">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        class="icon icon-tabler icons-tabler-outline icon-tabler-radar-2">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path d="M12 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
                                                        <path d="M15.51 15.56a5 5 0 1 0 -3.51 1.44" />
                                                        <path d="M18.832 17.86a9 9 0 1 0 -6.832 3.14" />
                                                        <path d="M12 12v9" />
                                                    </svg>
                                                </span>
                                                <input class="form-control" type="text" name="radius" autocomplete="ON"
                                                    placeholder="curent radius : {{ $loc_kantor->l_radius }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary w-100">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="icon icon-tabler icons-tabler-outline icon-tabler-refresh">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path d="M20 11a8.1 8.1 0 0 0 -15.5 -2m-.5 -4v4h4" />
                                                    <path d="M4 13a8.1 8.1 0 0 0 15.5 2m.5 4v-4h-4" />
                                                </svg>  
                                                Update
                                            </button>
                                        </div>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

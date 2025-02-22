@extends('layouts.admin.tabler')
@section('content')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <!-- Page pre-title -->
                    <h2 class="page-title">
                        Rekap Presensi
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
                            <form action="cetakRekap" method="post" target="_blank">
                                @csrf
                                <div class="row mb-2">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <select name="bulan" id="bulan" class="form-control">
                                                <option value="">Bulan</option>
                                                @for ($i = 1; $i <= 12; $i++)
                                                    <option value="{{ $i }}"
                                                        {{ date('m') == $i ? 'selected' : '' }}>{{ $monthName[$i] }}
                                                    </option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <select name="tahun" id="tahun" class="form-control">
                                                <option value="">Tahun</option>
                                                @php
                                                    $tahunMulai = 2022;
                                                    $tahunSekarang = date('Y');
                                                @endphp
                                                @for ($tahun = $tahunMulai; $tahun <= $tahunSekarang; $tahun++)
                                                    <option value="{{ $tahun }}"
                                                        {{ date('Y') == $tahun ? 'selected' : '' }}>{{ $tahun }}</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary w-100">Print</button>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <button class="btn btn-success w-100">Export to Excel</button>
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

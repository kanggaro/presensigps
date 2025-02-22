@extends('layouts.presensi')

@section('header')
    <div class="appHeader bg-primary text-light">
        <div class="left">
            <a href="javascript:;" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">Data Izin / Sakit</div>
        <div class="right"></div>
    </div>
@endsection

@section('content')
    <div class="row" style="margin-top: 65px">
        <div class="col">
            @php
                $messageSuccess = Session::get("success");
                $messageError = Session::get("error");
            @endphp
            @if(Session::get("success"))
                <div class="alert alert-success">
                    {{ $messageSuccess }}
                </div>
            @endif
            @if(Session::get("error"))
                <div class="alert alert-danger">
                    {{ $messageError }}
                </div>
            @endif
        </div>
    </div>

    <div class="row">
        <div class="col">
            @foreach ($dataIzin as $d)
                <ul class="listview image-listview">
                    <li>
                        <div class="item">
                            <div class="in">
                                <div>
                                    <b>{{ date("d/M/Y", strtotime($d->pz_tgl_izin)) }} - {{ $d->pz_status == "s" ? "Sakit" : "Izin" }}</b><br>
                                    <small class="text-muted">{{ $d->pz_keterangan }}</small>
                                </div>
                                @if ($d->pz_status_approved == 0)
                                    <span class="badge bg-warning">Waiting</span>
                                @elseif ($d->pz_status_approved == 1)
                                    <span class="badge bg-success">ACC</span>
                                @elseif ($d->pz_status_approved == 2)
                                    <span class="badge bg-danger">REJECT</span>
                                @endif
                                {{-- <span class="badge {{ $d->p_jam_in > "07:00" ? "bg-danger" : "bg-success" }}">{{ $d->p_jam_in }}</span>
                                <span class="badge bg-primary">{{ $d->p_jam_out }}</span> --}}
                            </div>
                        </div>
                    </li>
                </ul>
            @endforeach
        </div>
    </div>

    <div class="fab-button bottom-right" style="margin-bottom: 65px">
        <a href="/presensi/createIzin" class="fab"> 
            <ion-icon name="add-outline" role="img" class="md hydrated" aria-label="add outline"></ion-icon>
        </a>
    </div>
@endsection
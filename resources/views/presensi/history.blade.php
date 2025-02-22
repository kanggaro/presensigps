@extends('layouts.presensi')
@section("header")
<div class="appHeader bg-primary text-light">
    <div class="left">
        <a href="javascript:;" class="headerButton goBack">
            <ion-icon name="chevron-back-outline"></ion-icon>
        </a>
    </div>
    <div class="pageTitle">History Presensi</div>
    <div class="right"></div>
</div>
@endsection

@section('content')
    <di class="row" style="margin-top: 4rem">
        <div class="col">
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <select name="bulan" id="bulan" class="form-control">
                            <option value="">Bulan</option>
                            @for ($i = 1 ; $i <= 12 ; $i++)
                                <option value="{{ $i }}" {{ date("m") == $i ? "selected" : "" }}>{{ $monthName[$i] }}</option>
                            @endfor
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <select name="tahun" id="tahun" class="form-control">
                            <option value="">Tahun</option>
                            @php
                                $tahunMulai = 2022;
                                $tahunSekarang = date("Y");
                            @endphp
                            @for ($tahun = $tahunMulai ; $tahun <= $tahunSekarang ; $tahun++)
                                <option value="{{ $tahun }}" {{ date("Y") == $tahun ? "selected" : "" }}>{{ $tahun }}</option>
                            @endfor
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <button class="btn btn-primary btn-block" id="getData">Search</button>
                    </div>
                </div>
            </div>
        </div>
    </di>
    <div class="row">
        <div class="col" id="showHistory">

        </div>
    </div>
@endsection

@push('myscript')
    <script>
        $(()=>{
            $("#getData").click((e)=>{
                var bulan = $("#bulan").val(); 
                var tahun = $("#tahun").val(); 
                // alert(bulan + "dan" + tahun);
                $.ajax({
                    type: 'POST',
                    url: '/getHistory',
                    data:{
                        _token: "{{ csrf_token() }}",
                        bulan: bulan,
                        tahun: tahun
                    },
                    cache: false,
                    success: (respond)=>{
                        // console.log(respond)
                        $("#showHistory").html(respond);
                    }
                })
            });
        });
    </script>
@endpush
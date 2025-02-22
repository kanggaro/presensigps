@extends('layouts.presensi')

@section('header')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/css/materialize.min.css">
    <style>
        .datepicker-modal {
            max-height: 430px !important;
        }

        .datepicker-date-display {
            background-color: #007bff;
        }

        .datepicker-table td.is-selected {
            background-color: #007bff;
            color: #fff;
        }

        .datepicker-cancel,
        .datepicker-clear,
        .datepicker-today,
        .datepicker-done {
            color: #007bff;
            padding: 0 1rem;
        }
    </style>

    <div class="appHeader bg-primary text-light">
        <div class="left">
            <a href="javascript:;" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">Form Izin</div>
        <div class="right"></div>
    </div>
@endsection

@section('content')
    <div class="row" style="margin-top: 6rem;">
        <div class="col">
            <form action="/presensi/storeIzin" method="POST" id="formIzin">
                @csrf
                <div class="form-group">
                    <input type="text" class="form-control datepicker" id="tgl_izin" name="tgl_izin"
                        placeholder="Tanggal Izin/Sakit">
                </div>
                <div class="form-group">
                    <select name="status" id="status" class="form-control">
                        <option value="">Izin / Sakit</option>
                        <option value="i">Izin</option>
                        <option value="s">Sakit</option>
                    </select>
                </div>
                <div class="form-group">
                    <textarea name="keterangan" id="keterangan" cols="30" rows="5" class="form-control"
                        placeholder="Keterangan Izin/Sakit"></textarea>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary btn-block">Submit</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('myscript')
    <script>
        var currYear = (new Date()).getFullYear();

        $(document).ready(function() {
            $(".datepicker").datepicker({
                // defaultDate: new Date(currYear-5,1,31),
                // setDefaultDate: new Date(2000,01,31),
                // maxDate: new Date(currYear-5,12,31),
                // yearRange: [1928, currYear-5],
                format: "yyyy-mm-dd"
            });
        });

        // cek apakah sudah izin
        $('#tgl_izin').change(function(){
            var tgl_izin = $(this).val();
            $.ajax({
                type: 'POST',
                url: 'isIzin',
                data:{
                    _token : "{{ csrf_token() }}",
                    tgl_izin : tgl_izin
                },
                cache: false,
                success : function(respond){
                    if(respond > 0){
                        Swal.fire({
                            title: "Oops !",
                            text: "Kamu sudah izin tanggal tersebut",
                            icon: "warning"
                        }).then((result)=>{
                            $('#tgl_izin').val("");
                        });
                    }
                },
            });
        });

        $("#formIzin").submit(() => {
            var tgl_izin = $("#tgl_izin").val();
            var status = $("#status").val();
            var keterangan = $("#keterangan").val();
            // console.log(tgl_izin);

            if (tgl_izin == "" || status == "" || keterangan == "") {
                Swal.fire({
                    title: "Oops !",
                    text: "Semua input harus diisi",
                    icon: "warning"
                });
                return false
            }
        });
    </script>
@endpush

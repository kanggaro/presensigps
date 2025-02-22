@extends('layouts.presensi')
@section('header')
    <!-- App Header -->
    <div class="appHeader bg-primary text-light">
        <div class="left">
            <a href="javascript:;" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">E-Presensi</div>
        <div class="right"></div>
    </div>
    <!-- * App Header -->
    <style>
        .webcam-capture, 
        .webcam-capture video{
            display:inline-block;
            width:100% !important;
            height: auto !important;
            margin: auto;
            border-radius: 15px;
        }
        #map{
            height: 180px;
        }
    </style>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
    integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
    crossorigin=""/>
    <!-- Make sure you put this AFTER Leaflet's CSS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
    integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
    crossorigin=""></script>
@endsection

@section('content')
        <!-- App Capsule -->
        <div id="appCapsule">
            <div class="row" style="margin-top: 65px">
                <div class="col">
                    <input type="hidden" id="lokasi" >
                    <div class="webcam-capture"></div>
                </div>
            </div>
            <div class="row">
                @if ($isPresent > 0)
                    <div class="col">
                        <button id="takeabsen" class="btn btn-danger btn-block"><ion-icon name="camera-outline"></ion-icon>Absen Pulang</button>
                    </div>
                @else
                    <div class="col">
                        <button id="takeabsen" class="btn btn-primary btn-block"><ion-icon name="camera-outline"></ion-icon>Absen Masuk</button>
                    </div>
                @endif
            </div>
            <div class="row mt-2">
                <div class="col">
                    <div id="map"></div>
                </div>
            </div>
        </div>
        <!-- * App Capsule -->

        <audio id="notifikasi_in">
            <source src="{{ asset('assets/sound/notifikasi_in.mp3')}}" type="audio/mp3">
        </audio>
        <audio id="notifikasi_out">
            <source src="{{ asset('assets/sound/notifikasi_out.mp3')}}" type="audio/mp3">
        </audio>
        <audio id="notifikasi_radius">
            <source src="{{ asset('assets/sound/notifikasi_radius.mp3')}}" type="audio/mp3">
        </audio>
@endsection

@push('myscript')
    <script>

        var notifikasi_in = document.getElementById('notifikasi_in');
        var notifikasi_out = document.getElementById('notifikasi_out');
        var notifikasi_radius = document.getElementById('notifikasi_radius');
        
        Webcam.set({
            height: 480,
            width: 640,
            image_format: 'jpeg',
            jpeg_quality: 80
        });
        Webcam.attach('.webcam-capture');

        var lokasi = document.getElementById('lokasi');
        if(navigator.geolocation){
            navigator.geolocation.getCurrentPosition(succesCallback, errorCallback, {
                enableHighAccuracy: true, // Gunakan GPS untuk akurasi tinggi
                timeout: 10000, // Timeout jika tidak dapat lokasi dalam 10 detik
                maximumAge: 0 // Selalu ambil data baru, jangan pakai cache
            });
        }
        else {
            alert('geolocation not supported!')
        }

        function succesCallback(position){
            lokasi.value = position.coords.latitude + ',' + position.coords.longitude;
            // var map = L.map('map').setView([-6.1747,106.827], 13);

            var map = L.map('map').setView([position.coords.latitude, position.coords.longitude], 18);
            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(map);

            var loc_kantor = "{{ $loc_kantor->l_koordinat }}";
            var split_loc_kantor = loc_kantor.split(',');
            var lat_kantor = split_loc_kantor[0];
            var lng_kantor = split_loc_kantor[1];
            var radius = "{{ $loc_kantor->l_radius }}";

            var marker = L.marker([position.coords.latitude, position.coords.longitude]).addTo(map);
            var circle = L.circle([lat_kantor, lng_kantor], {
                color: 'red',
                fillColor: '#f03',
                fillOpacity: 0.5,
                radius: radius
            }).addTo(map);
        }

        function errorCallback(){

        }

        $('#takeabsen').click((e)=>{
            Webcam.snap((uri)=>{
                image = uri;
            });
            var lokasi = $('#lokasi').val();
            // alert(lokasi);
            $.ajax({
                type:'POST',
                url:'/presensi/store',
                data: {
                    _token: "{{ csrf_token() }}",
                    image: image,
                    lokasi: lokasi
                },
                cache: false,
                success: (response)=>{
                    var status = response.split('|');
                    if(status[0] == "success"){

                        if(status[2] == "in"){
                            notifikasi_in.play();
                        }else{
                            notifikasi_out.play();
                        }

                        Swal.fire({
                            title: 'Success!',
                            text: status[1],
                            icon: 'success',
                            showConfirmButton: false
                        })
                        setTimeout("location.href='/dashboard'",2000);
                        
                    } else {
                        if(status[2] == "radius"){
                            notifikasi_radius.play();
                        }
                        Swal.fire({
                            // title: 'Error!',
                            text: status[1],
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                },
                error: (xhr, status, error) => { 
                    console.error("Server Error:", xhr.responseText);
                    alert("Terjadi kesalahan server. Lihat konsol untuk detailnya.");
                }
            })
        });


    </script>    
@endpush
<style>
    #map {
        height: 250px;
    }
</style>
<div id="map"></div>
<script>
    var lokasi = '{{ $coordinate->p_lokasi_in }}';
    var loc = lokasi.split(',');
    var lat = loc[0];
    var lng = loc[1];

    var lokasi_kantor = '{{ $coordinate_kantor->l_koordinat }}';
    var loc_kantor = lokasi_kantor.split(',');
    var lat_kantor = loc_kantor[0];
    var lng_kantor = loc_kantor[1];
    var radius = '{{ $coordinate_kantor->l_radius }}';

    var map = L.map('map').setView([lat, lng], 16);
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);

    var marker = L.marker([lat, lng]).addTo(map);
    // var circle = L.circle([0.12652362633316988, 117.47786561467571], {
    var circle = L.circle([lat_kantor, lng_kantor], {
        color: 'red',
        fillColor: '#f03',
        fillOpacity: 0.5,
        radius: radius
    }).addTo(map);

    marker.bindPopup("{{ $coordinate->k_nama_lengkap }}").openPopup();
</script>

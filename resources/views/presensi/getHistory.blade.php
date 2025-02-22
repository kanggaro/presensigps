@if ($history->isEmpty())
    <div class="alert alert-warning">
        <p>Data Not Found</p>
    </div>    
@endif
@foreach ($history as $d)
    <ul class="listview image-listview">
        <li>
            <div class="item">
                @php
                    $path = Storage::url('uploads/absensi'. $d->p_foto_in);
                @endphp
                <img src="{{ asset('storage/uploads/absensi/'.$d->p_foto_in) }}" class="imaged w48">
                {{-- <img src="{{ url($path) }}" alt="image" class="image"> --}}
                <div class="in">
                    <div>
                        <b>{{ date("d-m-Y", strtotime($d->p_tgl_presensi)) }}</b>
                    </div>
                    <span class="badge {{ $d->p_jam_in > "07:00" ? "bg-danger" : "bg-success" }}">{{ $d->p_jam_in }}</span>
                    <span class="badge bg-primary">{{ $d->p_jam_out }}</span>
                </div>
            </div>
        </li>
    </ul>
@endforeach
{{-- Latihan Ngetik Program dan Logic --}}
@php
    function selisih($jam_masuk, $jam_real){
        // pastikan format masuk benar
        if(empty($jam_masuk) || empty($jam_real)){
            return '00:00';
        }
        // pastikan format hh:mm:ss
        // jadi kalo ada 7 dijadikan 07
        $jam_masuk = str_pad($jam_masuk, 8, '0', STR_PAD_LEFT);
        $jam_real = str_pad($jam_real, 8, '0', STR_PAD_LEFT);

        $waktu_masuk = explode(':', $jam_masuk);
        $waktu_real = explode(':', $jam_real);

        if(count($waktu_masuk) < 3 || count($waktu_real) <3){
            return '00:00';
        }

        [$h1, $m1, $s1] = $waktu_masuk;
        [$h1, $m1, $s1] = $waktu_real;

        $dtAwal = mktime($h1, $m1, $s1, 1,1,1);
        $dtAkhir = mktime($h1, $m1, $s1, 1,1,1);

        if($dtSelisih < 0){
            return '00:00'; //tidak ada selih negatif
        }

        $totalMenit = $dtSelisih/60;
        $jam = floor($totalMenit / 60);
        $sisaMenit = round($totalMenit % 60);

        return str_pad($jam, 2, '0', STR_PAD_LEFT). ':' . str_pad($sisaMenit, 2, '0', STR_PAD_LEFT);
    }
@endphp
<script>
    $(function(){
        $('.show-lokasi').click(function(e){
            var p_id = $(this).attr('p_id');
            $.ajax({
                type: 'post',
                url: 'showMaps',
                data: {
                    _token: '{{ csrf_token() }}',
                    p_id: p_id
                }
                cache: false,
                success: (respond)=>{
                    ('#load-maps').html(respond);
                }
            });
            $('#modalLokasiPresensi').modal('show');
        });
    });
    $(document).ready(function(){
        if(typeof Litepicker !== undefined){
            let dateInput = $('#datepicker');

            new Litepicker({
                element :dateInput[0],
                format: 'YYYY-MM-DD',
                autoApply: true,
                buttonText: {
                    previousMonth:`
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-1">
                        <path d="M15 6l-6 6l6 6"></path>
                    </svg>`,
                    nextMonth:`
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-1">
                        <path d="M9 6l6 6l-6 6"></path>
                    </svg>`,
                },
                setup: (picker) => {
                    picker.on('selected', (date) => {
                        let selectedDate = date.format('YYYY-MM-DD');
                        dateInput.val(selectedDAte).trigger('change');
                    });
                }
            })
        } else {
            console.error('Litepicker tidak dimuat');
        }

        function loadPresensi(){
            var tanggal = $('#datepicker').val();

            $.ajax({
                type: 'post',
                url: 'getPresensi',
                data:{
                    _token: '{{ csrf_token() }}',
                    tanggal: tanggal
                },
                cache: false,
                success: function(respond){
                    $('#load-presensi').html(respond);
                }
                error: function(xhr, status, error){
                    console.error('terjadi kesalahan: ', error);
                }
            })
        }
    })
</script>
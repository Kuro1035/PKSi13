@extends('layout.userlayouts')

@section('title', 'Dashboard Mahasiswa')

@section('content')
<div class="container mt-4">

    <!-- Halo user -->
    <div class="mb-4">
        <h1><i class="fa fa-user"></i> Dashboard Mahasiswa</h1>
        <p>Selamat datang, {{ Auth::user()?->nama_user ?? 'Mahasiswa' }}!</p>

    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-white bg-primary mb-3">
                <div class="card-body">
                    <h5 class="card-title"><i class="fa fa-calendar"></i> Jadwal Hari Ini</h5>
                    <p class="card-text display-4">{{ $jumlahJadwal }}</p>
                </div>
            </div>
        </div>
        <!-- contoh card lain, ganti angka dengan data nyata bila tersedia -->
        <div class="col-md-3">
            <div class="card text-white bg-success mb-3">
                <div class="card-body">
                    <h5 class="card-title"><i class="fa fa-bell"></i> Pengingat Aktif</h5>
                    <p class="card-text display-4">{{ $jumlahPengingat }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-warning mb-3">
                <div class="card-body">
                    <h5 class="card-title"><i class="fa fa-book"></i> Mata Kuliah</h5>
                    <p class="card-text display-4">{{ $jumlahMatkul }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Jadwal Hari Ini -->
    <div class="mb-4">
        <h4><i class="fa fa-calendar-alt"></i> Jadwal Hari {{ $hariInText }}</h4>

        @if($jadwalHariIni->isEmpty())
            <div class="alert alert-info">Belum ada jadwal untuk hari ini.</div>
        @else
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Jam</th>
                        <th>Mata Kuliah</th>
                        <th>Ruang</th>
                        <th>Dosen</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($jadwalHariIni as $jadwal)
                        <tr class="{{ $loop->first ? 'table-info' : '' }}">
                            <td>{{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }}
                                - {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}</td>
                            <td>{{ $jadwal->mataKuliah->nama_matkul ?? '-' }}</td>
                            <td>{{ $jadwal->ruang->nama_ruang ?? '-' }}</td>
                            <td>{{ $jadwal->mataKuliah->nama_dosen ?? '—' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    <!-- Daftar Pengingat -->
  <div class="mb-4">
    <h4><i class="fa fa-bell"></i> Pengingat Mendatang</h4>

    @if($pengingatMendatang->isEmpty())
        <p class="text-muted">Tidak ada pengingat mendatang</p>
    @else
        <ul class="list-group">
            @foreach($pengingatMendatang as $pengingat)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    {{ $pengingat->judul }}

                    <span class="badge badge-primary rounded-pill">
                        {{-- tampilkan hari jika ada --}}
                        @if($pengingat->nama_hari)
                            {{ $pengingat->nama_hari }}
                        @endif

                        {{-- tampilkan waktu jika ada --}}
                        @if($pengingat->waktu_carbon)
                            , {{ $pengingat->waktu_carbon->format('H:i') }}
                        @endif

                        {{-- jika dua-duanya kosong --}}
                        @if(!$pengingat->nama_hari && !$pengingat->waktu_carbon)
                            —
                        @endif
                    </span>
                </li>
            @endforeach
        </ul>
    @endif
</div>

</div>
@endsection

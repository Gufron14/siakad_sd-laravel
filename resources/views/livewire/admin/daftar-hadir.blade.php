<div>
    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h2 class="card-title mb-0">
                Daftar Hadir Santri
            </h2>
        </div>
        
        <div class="card-body">
            {{-- Flash Messages --}}
            @if (session()->has('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label">Kelas</label>
                    <select class="form-select" wire:model.live="kelas_id" {{ count($kelas) <= 1 ? 'disabled' : '' }}>
                        <option value="">-- Pilih Kelas --</option>
                        @foreach ($kelas as $k)
                            <option value="{{ $k->id }}">{{ $k->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Semester</label>
                    <select class="form-select" wire:model.live="semester">
                        <option value="ganjil">Ganjil</option>
                        <option value="genap">Genap</option>
                    </select>
                </div>
            </div>
        </div>

        @if($kelas_id && count($murids) > 0)
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama Santri</th>
                            <th class="text-center">Hadir</th>
                            <th class="text-center">Sakit</th>
                            <th class="text-center">Izin</th> 
                            <th class="text-center">Alfa</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($murids as $index => $murid)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $murid->nama }}</td>
                                <td class="text-center">
                                    {{ $absensiData[$murid->id]['hadir'] ?? 0 }}
                                </td>
                                <td class="text-center">
                                    {{ $absensiData[$murid->id]['sakit'] ?? 0 }}
                                </td>
                                <td class="text-center">
                                    {{ $absensiData[$murid->id]['izin'] ?? 0 }}
                                </td>
                                <td class="text-center">
                                    {{ $absensiData[$murid->id]['alpa'] ?? 0 }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-5">
                <div class="alert alert-info">
                    <i class="bx bx-info-circle"></i>
                    {{ $kelas_id ? 'Tidak ada data santri di kelas ini' : 'Silakan pilih kelas terlebih dahulu' }}
                </div>
            </div>
        @endif
    </div>
</div>

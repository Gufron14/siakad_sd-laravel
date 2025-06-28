<div>
    <style>
        .time-input {
            width: 70px !important;
            font-size: 11px !important;
            padding: 2px 4px !important;
            text-align: center;
        }

        .time-separator {
            font-weight: bold;
            color: #6c757d;
            margin: 0 2px;
        }
    </style>

    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (session()->has('info'))
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            {{ session('info') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h2 class="card-title mb-0">
                Jadwal Pelajaran
            </h2>
            <div class="d-flex gap-2">
                @if ($isAdmin && $canEditJadwal && !$editMode)
                    <button type="button" class="btn btn-primary" wire:click="toggleEditMode">
                        <i class="bx bx-edit"></i> Edit Jadwal
                    </button>
                @endif
                
                @if ($editMode && $canEditJadwal && $isAdmin)
                    <button type="button" class="btn btn-success" wire:click="simpanJadwal">
                        <i class="bx bx-save"></i> Simpan Jadwal
                    </button>
                    <div class="btn-group">
                        <button type="button" class="btn btn-outline-info btn-sm" wire:click="fillEmptySlots"
                            title="Isi slot kosong otomatis">
                            <i class="bx bx-magic-wand"></i> Auto Fill
                        </button>
                        <button type="button" class="btn btn-outline-warning btn-sm" wire:click="clearAllJadwal"
                            title="Kosongkan semua jadwal">
                            <i class="bx bx-trash"></i> Clear All
                        </button>
                        <button type="button" class="btn btn-outline-secondary btn-sm" wire:click="resetWaktuDefault"
                            title="Reset waktu ke default">
                            <i class="bx bx-time"></i> Reset Waktu
                        </button>
                    </div>
                    <button type="button" class="btn btn-secondary" wire:click="toggleEditMode">
                        <i class="bx bx-x"></i> Batal
                    </button>
                @endif
            </div>
        </div>
        <div class="card-body">
            {{-- Filter Section --}}
            <div class="row g-3 mb-3">
                {{-- Filter kelas --}}
                @if ($isGuru && $userKelas)
                    <!-- Guru: Show class info only -->
                    <div class="col-md-4">
                        <label class="form-label">Kelas</label>
                        <div class="form-control bg-light">
                            <strong>{{ $userKelas->nama }}</strong>
                            <small class="text-muted">(Kelas Anda)</small>
                        </div>
                    </div>
                @else
                    <!-- Admin/Staff: Show class dropdown -->
                    <div class="col-md-4">
                        <label class="form-label">Kelas</label>
                        <select class="form-select" wire:model.live="kelas_id">
                            <option value="">-- Pilih Kelas --</option>
                            @foreach ($kelas as $k)
                                <option value="{{ $k->id }}">{{ $k->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                @endif

                {{-- Filter Tahun Ajaran untuk Staff --}}
                @if ($isStaff)
                    <div class="col-md-4">
                        <label class="form-label">Tahun Ajaran</label>
                        <select class="form-select" wire:model.live="filterTahunAjaran">
                            <option value="2025/2026">2025/2026</option>
                            <option value="2024/2025">2024/2025</option>
                            <option value="2023/2024">2023/2024</option>
                        </select>
                    </div>
                @endif
            </div>

            <hr class="my-3">

            @if ($kelas_id)
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr class="text-center bg-light">
                                <th width="8%">Jam Ke</th>
                                <th width="15%">Waktu</th>
                                <th width="12%">Senin</th>
                                <th width="12%">Selasa</th>
                                <th width="12%">Rabu</th>
                                <th width="12%">Kamis</th>
                                <th width="12%">Jumat</th>
                                <th width="12%">Sabtu</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($defaultJamList as $jam => $waktu)
                                <tr>
                                    <td class="text-center fw-bold">{{ $jam }}</td>
                                    <td class="text-center">
                                        @if ($editMode && $isAdmin)
                                            <div class="d-flex align-items-center justify-content-center">
                                                <input type="time" class="form-control time-input"
                                                    wire:model="jamWaktu.{{ $jam }}.jam_mulai">
                                                <span class="time-separator">-</span>
                                                <input type="time" class="form-control time-input"
                                                    wire:model="jamWaktu.{{ $jam }}.jam_selesai">
                                            </div>
                                        @else
                                            <small>
                                                {{ $jamWaktu[$jam]['jam_mulai'] ?? $waktu['jam_mulai'] }} -
                                                {{ $jamWaktu[$jam]['jam_selesai'] ?? $waktu['jam_selesai'] }}
                                            </small>
                                        @endif
                                    </td>

                                    @foreach ($hari as $day)
                                        <td class="text-center">
                                            @if ($editMode && $canEditJadwal && $isAdmin)
                                                <select class="form-select form-select-sm"
                                                    wire:model="jadwal.{{ $jam }}.{{ $day }}">
                                                    <option value="">-- Kosong --</option>
                                                    @foreach ($mataPelajaran as $mp)
                                                        <option value="{{ $mp->id }}">{{ $mp->nama }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            @else
                                                @if (!empty($jadwal[$jam][$day]))
                                                    @php
                                                        $mp = $mataPelajaran->find($jadwal[$jam][$day]);
                                                    @endphp
                                                    @if ($mp)
                                                        <div class="badge bg-primary text-wrap">
                                                            {{ $mp->nama }}
                                                        </div>
                                                    @endif
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            @endif
                                        </td>
                                    @endforeach
                                </tr>
                                @if ($jam == 4)
                                    <tr>
                                        <td class="text-center fw-bold">Istirahat</td>
                                        <td class="text-center">
                                            @if ($editMode && $isAdmin)
                                                <div class="d-flex align-items-center justify-content-center">
                                                    <input type="time" class="form-control time-input"
                                                        wire:model="jamWaktu.istirahat.jam_mulai">
                                                    <span class="time-separator">-</span>
                                                    <input type="time" class="form-control time-input"
                                                        wire:model="jamWaktu.istirahat.jam_selesai">
                                                </div>
                                            @else
                                                <small>
                                                    {{ $jamWaktu['istirahat']['jam_mulai'] ?? '09:40' }} -
                                                    {{ $jamWaktu['istirahat']['jam_selesai'] ?? '10:00' }}
                                                </small>
                                            @endif
                                        </td>
                                        <td colspan="6" class="text-center bg-warning-subtle">
                                            <strong>ISTIRAHAT ({{ $jamWaktu['istirahat']['jam_mulai'] ?? '09:40' }} -
                                                {{ $jamWaktu['istirahat']['jam_selesai'] ?? '10:00' }})</strong>
                                        </td>
                                    </tr>
                                @endif

                                @if ($jam == 8)
                                    <tr>
                                        <td class="text-center fw-bold">Ishoma</td>
                                        <td class="text-center">
                                            @if ($editMode && $isAdmin)
                                                <div class="d-flex align-items-center justify-content-center">
                                                    <input type="time" class="form-control time-input"
                                                        wire:model="jamWaktu.ishoma.jam_mulai">
                                                    <span class="time-separator">-</span>
                                                    <input type="time" class="form-control time-input"
                                                        wire:model="jamWaktu.ishoma.jam_selesai">
                                                </div>
                                            @else
                                                <small>
                                                    {{ $jamWaktu['ishoma']['jam_mulai'] ?? '12:00' }} -
                                                    {{ $jamWaktu['ishoma']['jam_selesai'] ?? '13:00' }}
                                                </small>
                                            @endif
                                        </td>
                                        <td colspan="6" class="text-center bg-info-subtle">
                                            <strong>ISHOMA {{ $jamWaktu['ishoma']['jam_mulai'] ?? '12:00' }} -
                                                {{ $jamWaktu['ishoma']['jam_selesai'] ?? '13:00' }}
                                            </strong>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <div class="alert alert-info">
                        <i class="bx bx-info-circle"></i>
                        Silakan pilih kelas terlebih dahulu untuk melihat jadwal pelajaran
                    </div>
                </div>
            @endif
        </div>

    </div>
</div>

<div>
    @if (session()->has('message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="d-flex gap-3">
        <div class="col">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h2 class="card-title mb-0">
                        Pembagian Kelas
                    </h2>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr class="text-center">
                                    <th>Kelas</th>
                                    <th>Wali Kelas</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($kelas as $k)
                                <tr>
                                    <td class="text-center">{{ $k->nama }}</td>
                                    <td>
                                        <select class="form-select" 
                                                wire:change="updateWaliKelas('{{ $k->nama }}', $event.target.value)">
                                            <option value="">-- Pilih Wali Kelas --</option>
                                            @foreach($allGuru as $guru)
                                                <option value="{{ $guru->id }}" 
                                                        {{ $k->guru_id == $guru->id ? 'selected' : '' }}>
                                                    {{ $guru->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="2" class="text-center">Belum ada data kelas</td>
                                </tr>
                                @endforelse
                            </tbody>

                        </table>
                        {{-- <button class="btn btn-primary" wire:click="saveAllPembagian">
                            <i class="fas fa-save me-1"></i>
                            Simpan Semua
                        </button> --}}
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h2 class="card-title mb-0">
                        Daftar Guru
                    </h2>
                    <button type="button" class="btn btn-primary fw-bold" 
                            wire:click="openModal('create')">
                        <i class="fas fa-plus me-1"></i>
                        Tambah Guru
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center">No.</th>
                                    <th>Nama Guru</th>
                                    {{-- <th>NIP</th> --}}
                                    <th>Kelas</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($guruList as $index => $guru)
                                <tr>
                                    <td class="text-center">{{ $guruList->firstItem() + $index }}</td>
                                    <td>{{ $guru->name }}</td>
                                    {{-- <td>{{ $guru->nip }}</td> --}}
                                    <td>
                                        @if($guru->kelas)
                                            <span class="badge bg-success">Kelas {{ $guru->kelas->nama }}</span>
                                        @else
                                            <span class="badge bg-secondary">Belum Ada Kelas</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-sm btn-warning" 
                                                    wire:click="openModal('edit', {{ $guru->id }})"
                                                    title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-danger" 
                                                    wire:click="deleteGuru({{ $guru->id }})"
                                                    wire:confirm='Apakah Anda yakin ingin menghapus guru ini?'
                                                    
                                                    title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center">Belum ada data guru</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                        
                        <!-- Pagination -->
                        <div class="d-flex justify-content-center">
                            {{ $guruList->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal CRUD Guru -->
    @if($showModal)
    <div class="modal fade show" style="display: block;" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        {{ $modalType === 'create' ? 'Tambah Guru' : 'Edit Guru' }}
                    </h5>
                    <button type="button" class="btn-close" wire:click="closeModal"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="saveGuru">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   wire:model="name" placeholder="Masukkan nama lengkap">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- <div class="mb-3">
                            <label for="nip" class="form-label">NIP <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nip') is-invalid @enderror" 
                                   wire:model="nip" placeholder="Masukkan NIP">
                            @error('nip')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div> --}}

                        <div class="mb-3">
                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   wire:model="email" placeholder="Masukkan email">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- <div class="mb-3">
                            <label for="phone" class="form-label">No. Telepon</label>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                                   wire:model="phone" placeholder="Masukkan no. telepon">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div> --}}

                        {{-- <div class="mb-3">
                            <label for="address" class="form-label">Alamat</label>
                            <textarea class="form-control @error('address') is-invalid @enderror" 
                                      wire:model="address" rows="3" placeholder="Masukkan alamat"></textarea>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div> --}}

                        <div class="mb-3">
                            <label for="password" class="form-label">
                                Password 
                                @if($modalType === 'create')
                                    <span class="text-danger">*</span>
                                @else
                                    <small class="text-muted">(Kosongkan jika tidak ingin mengubah)</small>
                                @endif
                            </label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                   wire:model="password" placeholder="Masukkan password">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" wire:click="closeModal">Tutup</button>
                    <button type="button" class="btn btn-primary" wire:click="saveGuru">
                        <i class="fas fa-save me-1"></i>
                        {{ $modalType === 'create' ? 'Simpan' : 'Update' }}
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-backdrop fade show"></div>
    @endif
</div>

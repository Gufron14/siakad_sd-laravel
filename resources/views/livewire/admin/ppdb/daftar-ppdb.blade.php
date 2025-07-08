<div>
    @if (session()->has('success'))
        <div class="alert bg-success">
            {{ session('success') }}
        </div>
    @elseif (session()->has('error'))
        <div class="alert bg-danger">
            {{ session('error') }}
        </div>
    @endif
    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h2 class="card-title mb-0">
                Daftar PPDB
            </h3>
            <a href="{{ route('ppdb.create') }}" class="btn btn-primary fw-bold">
                <i class="fas fa-plus me-1"></i>
                Tambah Data</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</td>
                            <th>Calon Peserta Didik</td>
                            <th class="text-center">Tanggal Mendaftar</td>
                            <th class="text-center">Status</td>
                            <th class="text-center">Aksi</td>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($ppdb as $item)
                            
                        <tr class="align-middle">
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->nama_lengkap }}</td>
                            <td class="text-center">{{ $item->created_at->format('d-m-Y') }}</td>
                            <td class="text-center">
                                <span class="badge bg-{{ $item->status == 'diterima' ? 'success' : 'danger' }}">
                                    {{ $item->status }}
                                </span>
                            </td>
                            <td class="text-center">
                               <div class="btn-group">
                                   <a href="{{ route('ppdb.detail', $item->id) }}" class="btn btn-warning">
                                       <i class="fa fa-eye"></i>
                                   </a>
                                   <a href="{{ route('ppdb.update', $item->id) }}" class="btn btn-info">
                                       <i class="fa fa-edit"></i>
                                   </a>
                               </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">Tidak ada data</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div>
    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h2 class="card-title mb-0">
                Laporan Peserta Didik
            </h2>
        </div>
        <div class="card-body">
            @if (Auth::user()->hasRole('admin'))                
                <div class="alert alert-danger text-center">
                    <i class="fas fa-exclamation-circle"></i>
                    <strong>Anda login sebagai Admin.</strong><br>
                    Admin tidak bertugas untuk mengelola Raport.
                </div>
            @else
                
            @endif
        </div>
    </div>
</div>

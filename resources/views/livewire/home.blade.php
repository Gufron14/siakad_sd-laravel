<div>
    @if (session()->has('success'))
        <div class="container mt-3 alert alert-success">
            {{ session('success') }}
        </div>
    @endif
</div>

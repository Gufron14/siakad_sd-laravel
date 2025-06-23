@if (!Request::is('login'))
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container px-3">
            <a class="navbar-brand" href="{{ route('/') }}">MDTA Fathul Uluum</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">PPDB</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-disabled="true">Santri</a>
                    </li>
                </ul>
                @auth
                    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-danger">
                            Logout
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn btn-success fw-bold">Login</a>
                @endauth
                {{-- <form class="d-flex" role="search">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" />
                <button class="btn btn-outline-success" type="submit">Search</button>
            </form> --}}
            </div>
        </div>
    </nav>
@endif

<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

    <!-- LOGO -->
    <div class="navbar-brand-box">
        <a href="{{ route('dashboard') }}" class="logo logo-dark">
            <span class="logo-sm">
                <img src="{{ URL::asset('/assets/images/logo-sm.png') }}" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{ URL::asset('/assets/images/logo-dark.png') }}" alt="" height="20">
            </span>
        </a>

        <a href="{{ url('index') }}" class="logo logo-light">
            <span class="logo-sm">
                <img src="{{ URL::asset('/assets/images/logo-sm.png') }}" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{ URL::asset('/assets/images/logo-light.png') }}" alt="" height="20">
            </span>
        </a>
    </div>

    <button type="button" class="btn btn-sm px-3 font-size-16 header-item waves-effect vertical-menu-btn">
        <i class="fa fa-fw fa-bars"></i>
    </button>

    <div data-simplebar class="sidebar-menu-scroll">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title">@lang('translation.Menu')</li>

                <li>
                    <a href="{{ route('dashboard') }}" class="waves-effect">
                        <i class="uil-home-alt"></i>
                        <span>@lang('translation.Dashboard')</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route(name: 'inputNilai') }}" class="waves-effect">
                        <i class="uil-comment-alt-edit"></i>
                        <span>Input Nilai</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('raport') }}" class="waves-effect">
                        <i class="uil-file-check"></i>
                        <span>Raport</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('absensi') }}" class="waves-effect">
                        <i class="uil-list-ul"></i>
                        <span>Absensi Santri</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('jadwalPelajaran') }}" class="waves-effect">
                        <i class="uil-table"></i>
                        <span>Jadwal Pelajaran</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('mataPelajaran') }}" class="waves-effect">
                        <i class="uil-books"></i>
                        <span>Kelas</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('ppdb') }}" class="waves-effect">
                        <i class="uil-users-alt"></i> <span class="badge rounded-pill bg-primary float-end">01</span>
                        <span>PPDB</span>
                    </a>
                </li>
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->

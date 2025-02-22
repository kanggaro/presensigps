        <aside class="navbar navbar-vertical navbar-expand-lg navbar-dark">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidebar-menu"
                    aria-controls="sidebar-menu" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <h1 class="navbar-brand navbar-brand-autodark">
                    <a href=".">
                        <img src="{{ asset('tabler/static/logo-white.svg') }}" width="110" height="32"
                            alt="Tabler" class="navbar-brand-image">
                    </a>
                </h1>
                <div class="collapse navbar-collapse" id="sidebar-menu">
                    <ul class="navbar-nav pt-lg-3">
                        <li class="nav-item">
                            <a class="nav-link" href="./">
                                <span
                                    class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/home -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M5 12l-2 0l9 -9l9 9l-2 0" />
                                        <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" />
                                        <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" />
                                    </svg>
                                </span>
                                <span class="nav-link-title">
                                    Home
                                </span>
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#navbar-base" data-bs-toggle="dropdown"
                                data-bs-auto-close="false" role="button" aria-expanded="false">
                                <span
                                    class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/package -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M12 3l8 4.5l0 9l-8 4.5l-8 -4.5l0 -9l8 -4.5" />
                                        <path d="M12 12l8 -4.5" />
                                        <path d="M12 12l0 9" />
                                        <path d="M12 12l-8 -4.5" />
                                        <path d="M16 5.25l-8 4.5" />
                                    </svg>
                                </span>
                                <span class="nav-link-title">
                                    Data Master
                                </span>
                            </a>
                            <div class="dropdown-menu">
                                <div class="dropdown-menu-columns">
                                    <div class="dropdown-menu-column">
                                        <a class="dropdown-item" href="/panel/karyawan">
                                            Data Karyawan
                                        </a>
                                        <a class="dropdown-item" href="/panel/departement">
                                            Data Departement
                                        </a>
                                        <div class="dropend">
                                            <a class="dropdown-item dropdown-toggle" href="#sidebar-cards"
                                                data-bs-toggle="dropdown" data-bs-auto-close="false" role="button"
                                                aria-expanded="false">
                                                Cards
                                                <span
                                                    class="badge badge-sm bg-green-lt text-uppercase ms-auto">New</span>
                                            </a>
                                            <div class="dropdown-menu">
                                                <a href="./cards.html" class="dropdown-item">
                                                    Sample cards
                                                </a>
                                                <a href="./card-actions.html" class="dropdown-item">
                                                    Card actions
                                                    <span
                                                        class="badge badge-sm bg-green-lt text-uppercase ms-auto">New</span>
                                                </a>
                                                <a href="./cards-masonry.html" class="dropdown-item">
                                                    Cards Masonry
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/panel/monitoring">
                                <span
                                    class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/checkbox -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M9 11l3 3l8 -8" />
                                        <path d="M20 12v6a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h9" />
                                    </svg>
                                </span>
                                <span class="nav-link-title">
                                    Monitoring
                                </span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/panel/perizinan">
                                <span
                                    class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/checkbox -->
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-mood-sick">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M12 21a9 9 0 1 1 0 -18a9 9 0 0 1 0 18z" />
                                        <path d="M9 10h-.01" />
                                        <path d="M15 10h-.01" />
                                        <path d="M8 16l1 -1l1.5 1l1.5 -1l1.5 1l1.5 -1l1 1" />
                                    </svg>
                                </span>
                                <span class="nav-link-title">
                                    Perizinan
                                </span>
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#navbar-base" data-bs-toggle="dropdown"
                                data-bs-auto-close="false" role="button" aria-expanded="false">
                                <span
                                    class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/package -->
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-file-analytics">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                        <path
                                            d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
                                        <path d="M9 17l0 -5" />
                                        <path d="M12 17l0 -1" />
                                        <path d="M15 17l0 -3" />
                                    </svg>
                                </span>
                                <span class="nav-link-title">
                                    Laporan
                                </span>
                            </a>
                            <div class="dropdown-menu">
                                <div class="dropdown-menu-columns">
                                    <div class="dropdown-menu-column">
                                        <a class="dropdown-item" href="/panel/laporanPresensi">
                                            Presensi
                                        </a>
                                        <a class="dropdown-item" href="/panel/rekapPresensi">
                                            Rekap Presensi
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#navbar-base" data-bs-toggle="dropdown"
                                data-bs-auto-close="false" role="button" aria-expanded="false">
                                <span
                                    class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/package -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24"
                                        height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                        fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M12 3l8 4.5l0 9l-8 4.5l-8 -4.5l0 -9l8 -4.5" />
                                        <path d="M12 12l8 -4.5" />
                                        <path d="M12 12l0 9" />
                                        <path d="M12 12l-8 -4.5" />
                                        <path d="M16 5.25l-8 4.5" />
                                    </svg>
                                </span>
                                <span class="nav-link-title">
                                    Konfigurasi
                                </span>
                            </a>
                            <div class="dropdown-menu">
                                <div class="dropdown-menu-columns">
                                    <div class="dropdown-menu-column">
                                        <a class="dropdown-item" href="/panel/konfigurasi">
                                            Lokasi Kantor
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </aside>

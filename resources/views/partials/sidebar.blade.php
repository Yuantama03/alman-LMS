<div class="main-sidebar">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand mt-3">
            <img src="{{ URL::asset($pengaturan->logo) ?? 'https://via.placeholder.com/300' }}" alt="" style="width: 50px">
            <a href="">{{ $pengaturan->name ?? config('app.name') }}</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="#">{{ strtoupper(substr(config('app.name'), 0, 2)) }}</a>
        </div>
        <ul class="sidebar-menu">
            @if (Auth::check() && Auth::user()->roles == 'admin')
            <li class="{{ request()->routeIs('admin.dashboard.*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin.dashboard') }}"><i class="fas fa-columns"></i> <span>Dashboard</span></a></li>
            <li class="menu-header">Master Data</li>

            {{-- <li class="{{ request()->routeIs('jurusan.*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('jurusan.index') }}"><i class="fas fa-book"></i> <span>Jurusan</span></a></li> --}}

            <li class="{{ request()->routeIs('mapel.*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('mapel.index') }}"><i class="fas fa-book"></i> <span>Mata Pelajaran</span></a></li>

            <li class="{{ request()->routeIs('guru.*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('guru.index') }}"><i class="fas fa-user"></i> <span>Guru</span></a></li>

            <li class="{{ request()->routeIs('kelas.*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('kelas.index') }}"><i class="far fa-building"></i> <span>Kelas</span></a></li>

            <li class="{{ request()->routeIs('siswa.*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('siswa.index') }}"><i class="fas fa-users"></i> <span>Siswa</span></a></li>

            <li class="{{ request()->routeIs('jadwal.*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('jadwal.index') }}"><i class="fas fa-calendar"></i> <span>Jadwal</span></a></li>

            <li class="{{ request()->routeIs('semester.*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('semester.index') }}"><i class="fas fa-calendar-alt"></i> <span>Semester</span></a></li>

            <li class="{{ request()->routeIs('silabus.*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('silabus.index') }}"><i class="fas fa-file-alt"></i> <span>Silabus</span></a></li>

            <li class="{{ request()->routeIs('admin.tugas.*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin.tugas.index') }}"><i class="fas fa-tasks"></i> <span>Tugas & Nilai</span></a></li>

            <li class="{{ request()->routeIs('admin.presensi.*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin.presensi.index') }}"><i class="fas fa-user-check"></i> <span>Presensi</span></a></li>

            <li class="{{ request()->routeIs('admin.poin.*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin.poin.index') }}"><i class="fas fa-star"></i> <span>Poin Siswa</span></a></li>

            <li class="{{ request()->routeIs('admin.kalender.*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin.kalender.index') }}"><i class="fas fa-calendar-day"></i> <span>Kalender Akademik</span></a></li>

            <li class="{{ request()->routeIs('user.*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('user.index') }}"><i class="fas fa-user"></i> <span>User</span></a></li>

            <li class="{{ request()->routeIs('pengumuman-sekolah.*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('pengumuman-sekolah.index') }}"><i class="fas fa-bullhorn"></i> <span>Pengumuman</span></a></li>

            <li class="{{ request()->routeIs('pengaturan.*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('pengaturan.index') }}"><i class="fas fa-cog"></i> <span>Pengaturan</span></a></li>

            @elseif (Auth::check() && Auth::user()->roles == 'guru')
            <li class="{{ request()->routeIs('guru.dashboard.*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('guru.dashboard') }}"><i class="fas fa-columns"></i> <span>Dashboard</span></a></li>
            <li class="menu-header">Master Data</li>
            <li class="{{ request()->routeIs('materi.*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('materi.index') }}"><i class="fas fa-book"></i> <span>Materi</span></a></li>
            <li class="{{ request()->routeIs('tugas.*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('tugas.index') }}"><i class="fas fa-list"></i> <span>Tugas</span></a></li>
            <li class="{{ request()->routeIs('guru.presensi.*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('guru.presensi.index') }}"><i class="fas fa-user-check"></i> <span>Presensi</span></a></li>
            <li class="{{ request()->routeIs('guru.poin.*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('guru.poin.index') }}"><i class="fas fa-star"></i> <span>Poin Siswa</span></a></li>
            <li class="{{ request()->routeIs('guru.kalender.*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('guru.kalender.index') }}"><i class="fas fa-calendar-day"></i> <span>Kalender Akademik</span></a></li>

            @elseif (Auth::check() && Auth::user()->roles == 'siswa')
            <li class="{{ request()->routeIs('siswa.dashboard.*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('siswa.dashboard') }}"><i class="fas fa-columns"></i> <span>Dashboard</span></a></li>
            <li class="{{ request()->routeIs('materi.*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('siswa.materi') }}"><i class="fas fa-book"></i> <span>Materi</span></a></li>
            <li class="{{ request()->routeIs('tugas.*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('siswa.tugas') }}"><i class="fas fa-list"></i> <span>Tugas</span></a></li>
            <li class="{{ request()->routeIs('siswa.presensi.*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('siswa.presensi.index') }}"><i class="fas fa-user-check"></i> <span>Presensi</span></a></li>
            <li class="{{ request()->routeIs('siswa.poin.*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('siswa.poin.index') }}"><i class="fas fa-star"></i> <span>Poin Saya</span></a></li>
            <li class="{{ request()->routeIs('siswa.kalender.*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('siswa.kalender.index') }}"><i class="fas fa-calendar-day"></i> <span>Kalender Akademik</span></a></li>

            @else
            <li class="{{ request()->routeIs('orangtua.dashboard.*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('orangtua.dashboard') }}"><i class="fas fa-columns"></i> <span>Dashboard</span></a></li>
            <li class="{{ request()->routeIs('orangtua.tugas.siswa') ? 'active' : '' }}"><a class="nav-link" href="{{ route('orangtua.tugas.siswa') }}"><i class="fas fa-list"></i> <span>Tugas</span></a></li>
            <li class="{{ request()->routeIs('orangtua.presensi.*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('orangtua.presensi.index') }}"><i class="fas fa-user-check"></i> <span>Presensi</span></a></li>
            <li class="{{ request()->routeIs('orangtua.poin.*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('orangtua.poin.index') }}"><i class="fas fa-star"></i> <span>Poin Anak</span></a></li>
            <li class="{{ request()->routeIs('orangtua.kalender.*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('orangtua.kalender.index') }}"><i class="fas fa-calendar-day"></i> <span>Kalender Akademik</span></a></li>
            @endif

        </ul>
    </aside>
</div>

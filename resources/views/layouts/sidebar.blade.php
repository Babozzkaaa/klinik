<div id="sidebar" class="bg-gradient-to-b from-blue-900 to-blue-800 text-white w-64 min-h-screen h-screen fixed left-0 top-0 transform sidebar-transition z-50 flex flex-col overflow-hidden">
    <div class="flex items-center justify-between p-4 border-b border-blue-700 flex-shrink-0">
        <div class="flex items-center space-x-3">
            <div class="bg-white rounded-full p-2">
                <i class="fas fa-hospital text-blue-800 text-xl"></i>
            </div>
            <h1 class="text-lg font-bold">Klinik Sehat</h1>
        </div>
        <button id="closeSidebar" class="lg:hidden text-white hover:text-gray-300">
            <i class="fas fa-times text-xl"></i>
        </button>
    </div>

    <nav class="flex-1 overflow-y-auto overflow-x-hidden">
        <div class="py-4">
            <ul class="space-y-2 px-4">
                <li>
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-blue-700 transition-colors duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-blue-700' : '' }}">
                        <i class="fas fa-tachometer-alt text-lg flex-shrink-0"></i>
                        <span class="truncate">Dashboard</span>
                    </a>
                </li>

                <li class="pt-4">
                    <div class="border-t border-blue-700 mb-2"></div>
                    <p class="text-xs text-blue-200 uppercase tracking-wider px-3 pb-2 font-semibold">Manajemen Data</p>
                </li>

                @if(auth()->user() && auth()->user()->hasPermission('obat.read'))
                <li>
                    <a href="{{ route('obat.index') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-blue-700 transition-colors duration-200 {{ request()->routeIs('obat.*') ? 'bg-blue-700' : '' }}">
                        <i class="fas fa-pills text-lg flex-shrink-0"></i>
                        <span class="truncate">Obat</span>
                    </a>
                </li>
                @endif

                @if(auth()->user() && auth()->user()->hasPermission('provinsi.read'))
                <li>
                    <a href="{{ route('provinsi.index') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-blue-700 transition-colors duration-200 {{ request()->routeIs('provinsi.*') ? 'bg-blue-700' : '' }}">
                        <i class="fas fa-map-marked-alt text-lg flex-shrink-0"></i>
                        <span class="truncate">Provinsi</span>
                    </a>
                </li>
                @endif

                @if(auth()->user() && auth()->user()->hasPermission('kabupaten.read'))
                <li>
                    <a href="{{ route('kabupaten.index') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-blue-700 transition-colors duration-200 {{ request()->routeIs('kabupaten.*') ? 'bg-blue-700' : '' }}">
                        <i class="fas fa-city text-lg flex-shrink-0"></i>
                        <span class="truncate">Kabupaten/Kota</span>
                    </a>
                </li>
                @endif

                @if(auth()->user() && auth()->user()->hasPermission('pegawai.read'))
                <li>
                    <a href="{{ route('pegawai.index') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-blue-700 transition-colors duration-200 {{ request()->routeIs('pegawai.*') ? 'bg-blue-700' : '' }}">
                        <i class="fas fa-user-tie text-lg flex-shrink-0"></i>
                        <span class="truncate">Pegawai</span>
                    </a>
                </li>
                @endif

                @if(auth()->user() && auth()->user()->hasPermission('tindakan.read'))
                <li>
                    <a href="{{ route('tindakan.index') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-blue-700 transition-colors duration-200 {{ request()->routeIs('tindakan.*') ? 'bg-blue-700' : '' }}">
                        <i class="fas fa-stethoscope text-lg flex-shrink-0"></i>
                        <span class="truncate">Tindakan</span>
                    </a>
                </li>
                @endif

                @if(auth()->user() && auth()->user()->hasPermission('pasien.read'))
                <li>
                    <a href="{{ route('pasien.index') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-blue-700 transition-colors duration-200 {{ request()->routeIs('pasien.*') ? 'bg-blue-700' : '' }}">
                        <i class="fas fa-user-injured text-lg flex-shrink-0"></i>
                        <span class="truncate">Pasien</span>
                    </a>
                </li>
                @endif

                <li class="pt-4">
                    <div class="border-t border-blue-700 mb-2"></div>
                    <p class="text-xs text-blue-200 uppercase tracking-wider px-3 pb-2 font-semibold">Operasional</p>
                </li>

                @if(auth()->user() && auth()->user()->hasPermission('kunjungan.read'))
                <li>
                    <a href="{{ route('kunjungan.index') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-blue-700 transition-colors duration-200 {{ request()->routeIs('kunjungan.*') ? 'bg-blue-700' : '' }}">
                        <i class="fas fa-calendar-check text-lg flex-shrink-0"></i>
                        <span class="truncate">Kunjungan</span>
                    </a>
                </li>
                @endif

                @if(auth()->user() && auth()->user()->hasPermission('kunjungan-tindakan.read'))
                <li>
                    <a href="{{ route('kunjungan-tindakan.index') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-blue-700 transition-colors duration-200 {{ request()->routeIs('kunjungan-tindakan.*') ? 'bg-blue-700' : '' }}">
                        <i class="fas fa-clipboard-list text-lg flex-shrink-0"></i>
                        <span class="truncate">Kunjungan Tindakan</span>
                    </a>
                </li>
                @endif

                @if(auth()->user() && auth()->user()->hasPermission('kunjungan-obat.read'))
                <li>
                    <a href="{{ route('kunjungan-obat.index') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-blue-700 transition-colors duration-200 {{ request()->routeIs('kunjungan-obat.*') ? 'bg-blue-700' : '' }}">
                        <i class="fas fa-pills text-lg flex-shrink-0"></i>
                        <span class="truncate">Kunjungan Obat</span>
                    </a>
                </li>
                @endif

                @if(auth()->user() && auth()->user()->hasPermission('pembayaran.read'))
                <li>
                    <a href="{{ route('pembayaran.index') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-blue-700 transition-colors duration-200 {{ request()->routeIs('pembayaran.*') ? 'bg-blue-700' : '' }}">
                        <i class="fas fa-credit-card text-lg flex-shrink-0"></i>
                        <span class="truncate">Pembayaran</span>
                    </a>
                </li>
                @endif
                <li>
                    <a href="{{ route('laporan.index') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-blue-700 transition-colors duration-200 {{ request()->routeIs('laporan.*') ? 'bg-blue-700' : '' }}">
                        <i class="fas fa-chart-bar text-lg flex-shrink-0"></i>
                        <span class="truncate">Laporan</span>
                    </a>
                </li>


            @if(auth()->user() && auth()->user()->hasPermission('admin_dashboard'))
            <li>
                <div class="border-t border-blue-700 my-2"></div>
                <p class="text-xs text-blue-200 uppercase tracking-wider px-3 pb-2">Admin Settings</p>
            </li>
            <li>
                <a href="{{ route('admin.users.index') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-blue-700 transition-colors duration-200 {{ request()->routeIs('admin.users.*') ? 'bg-blue-700' : '' }}">
                    <i class="fas fa-user text-lg"></i>
                    <span>User Management</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.roles.index') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-blue-700 transition-colors duration-200 {{ request()->routeIs('admin.roles.*') ? 'bg-blue-700' : '' }}">
                    <i class="fas fa-user-tag text-lg"></i>
                    <span>Role Management</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.permissions.index') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-blue-700 transition-colors duration-200 {{ request()->routeIs('admin.permissions.*') ? 'bg-blue-700' : '' }}">
                    <i class="fas fa-key text-lg"></i>
                    <span>Permission Management</span>
                </a>
            </li>
            <li class="mb-4">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-red-600 transition-colors duration-200 w-full text-left bg-red-500">
                        <i class="fas fa-sign-out-alt text-lg"></i>
                        <span>Log out</span>
                    </button>
                </form>
            </li>
            @endif

        </ul>
        </div>
    </nav>

</div>

<div id="sidebarOverlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 lg:hidden hidden"></div>
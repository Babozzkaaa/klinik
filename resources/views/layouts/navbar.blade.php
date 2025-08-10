<header class="bg-white shadow-sm border-b border-gray-200 fixed top-0 left-0 right-0 z-30 content-transition" id="navbar">
    <div class="flex items-center justify-between p-4">
        <div class="flex items-center">
            <button id="toggleSidebar" class="p-2 rounded-md text-gray-600 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <i class="fas fa-bars text-xl"></i>
            </button>
            
        </div>


        <div class="flex items-center space-x-3">
             <div class="hidden sm:block text-right">
                <div class="text-gray-700 font-medium">{{ auth()->user()->name }}</div>
                <div class="text-xs text-gray-500">
                    {{ optional(auth()->user()->role)->name ?? 'Staff Klinik' }}
                </div>
            </div>
            
            <div class="relative">
                <button id="userMenuButton" class="flex items-center space-x-2 p-2 rounded-full hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center text-white font-medium">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <i class="fas fa-chevron-down text-gray-400 text-sm"></i>
                </button>
                
                <div id="userMenu" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50 hidden">
                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        <i class="fas fa-user mr-2"></i>Profile
                    </a>
                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        <i class="fas fa-cog mr-2"></i>Settings
                    </a>
                    <div class="border-t border-gray-100"></div>
                    <form action="{{ route('logout') }}" method="POST" class="block">
                        @csrf
                        <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                            <i class="fas fa-sign-out-alt mr-2"></i>Sign out
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>
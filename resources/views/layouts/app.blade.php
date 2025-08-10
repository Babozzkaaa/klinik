<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Klinik Sehat') }} | @yield('title')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        .sidebar-transition {
            transition: transform 0.3s ease-in-out;
        }
        .content-transition {
            transition: margin-left 0.3s ease-in-out;
        }
        
        #sidebar {
            z-index: 1000;
        }
        
        #sidebar.sidebar-hidden {
            transform: translateX(-100%) !important;
        }
        
        #sidebar.sidebar-visible {
            transform: translateX(0) !important;
        }
        
        @media (max-width: 1023px) {
            #sidebar {
                transform: translateX(-100%);
            }
            #navbar, #mainContent {
                margin-left: 0 !important;
            }
        }
        
        @media (min-width: 1024px) {
            #sidebar {
                transform: translateX(0);
            }
            #navbar, #mainContent {
                margin-left: 256px;
            }
        }
    </style>
    @stack('styles')
</head>
<body class="bg-gray-50 font-sans">
    @include('layouts.sidebar')

    <div class="min-h-screen">
        @include('layouts.navbar')

        <main class="pt-20 p-4 bg-gray-50 content-transition" id="mainContent">
            @yield('content')
        </main>
    </div>

    @stack('scripts')
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleButton = document.getElementById('toggleSidebar');
            const closeButton = document.getElementById('closeSidebar');
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            const userMenuButton = document.getElementById('userMenuButton');
            const userMenu = document.getElementById('userMenu');
            const navbar = document.getElementById('navbar');
            const mainContent = document.getElementById('mainContent');

            let isDesktop = window.innerWidth >= 1024;
            let sidebarOpen = isDesktop; 


            function updateLayout() {
                isDesktop = window.innerWidth >= 1024;
                
                if (isDesktop) {
                    overlay.classList.add('hidden');
                    
                    if (sidebarOpen) {
                        sidebar.classList.remove('sidebar-hidden', '-translate-x-full');
                        sidebar.classList.add('sidebar-visible');
                        navbar.style.marginLeft = '256px';
                        mainContent.style.marginLeft = '256px';
                    } else {
                        sidebar.classList.remove('sidebar-visible');
                        sidebar.classList.add('sidebar-hidden', '-translate-x-full');
                        navbar.style.marginLeft = '0px';
                        mainContent.style.marginLeft = '0px';
                    }
                } else {
                    navbar.style.marginLeft = '0px';
                    mainContent.style.marginLeft = '0px';
                    
                    if (sidebarOpen) {
                        sidebar.classList.remove('sidebar-hidden', '-translate-x-full');
                        sidebar.classList.add('sidebar-visible');
                        overlay.classList.remove('hidden');
                    } else {
                        sidebar.classList.remove('sidebar-visible');
                        sidebar.classList.add('sidebar-hidden', '-translate-x-full');
                        overlay.classList.add('hidden');
                    }
                }
            }

            updateLayout();

            function toggleSidebar() {
                sidebarOpen = !sidebarOpen;
                updateLayout();
            }

            function closeSidebar() {
                sidebarOpen = false;
                updateLayout();
            }

            if (toggleButton) {
                toggleButton.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    toggleSidebar();
                });
            } else {
            }

            if (closeButton) {
                closeButton.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    closeSidebar();
                });
            }

            if (overlay) {
                overlay.addEventListener('click', function(e) {
                    e.preventDefault();
                    closeSidebar();
                });
            }

            if (userMenuButton && userMenu) {
                userMenuButton.addEventListener('click', function(e) {
                    e.stopPropagation();
                    userMenu.classList.toggle('hidden');
                });

                document.addEventListener('click', function(e) {
                    if (!userMenuButton.contains(e.target) && !userMenu.contains(e.target)) {
                        userMenu.classList.add('hidden');
                    }
                });
            }

            window.addEventListener('resize', function() {
                const wasDesktop = isDesktop;
                isDesktop = window.innerWidth >= 1024;
                
                
                if (!wasDesktop && isDesktop) {
                    sidebarOpen = true;
                }
                
                updateLayout();
            });

            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    if (userMenu && !userMenu.classList.contains('hidden')) {
                        userMenu.classList.add('hidden');
                    }
                    if (!isDesktop && sidebarOpen) {
                        closeSidebar();
                    }
                }
            });

        });
    </script>
</body>
</html>
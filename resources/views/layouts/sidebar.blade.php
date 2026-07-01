<style>
    .custom-scrollbar::-webkit-scrollbar {
        width: 4px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: transparent;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.08);
        border-radius: 999px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: rgba(255, 255, 255, 0.25);
    }
</style>

<aside x-data="{ activeTooltip: null }"
       class="fixed left-0 top-0 h-screen bg-gradient-to-b from-blue-950 via-blue-900 to-cyan-700 text-white flex flex-col transition-all duration-300 z-50 shadow-2xl w-[240px]"
       :class="{ 'w-[240px]': !sidebarCollapsed, 'w-[70px]': sidebarCollapsed }">

    <!-- Logo & Toggle Header -->
    <div class="pt-8 pb-6 border-b border-white/10 shrink-0 flex transition-all duration-300"
         :class="sidebarCollapsed ? 'flex-col gap-4 items-center justify-center px-2' : 'flex-row items-center justify-between px-6'">
        <!-- Expanded Title -->
        <div class="flex flex-col select-none" x-show="!sidebarCollapsed" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100">
            <h1 class="text-2xl font-black tracking-wider text-cyan-300 leading-none">MEKAR</h1>
            <p class="text-[10px] text-cyan-100/70 font-semibold tracking-widest mt-0.5 uppercase">Pharmacy</p>
        </div>
        <!-- Collapsed Title -->
        <div x-show="sidebarCollapsed" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" class="flex items-center justify-center">
            <h1 class="text-2xl font-black text-cyan-300 select-none">M</h1>
        </div>
        <!-- Toggle Button -->
        <button @click="sidebarCollapsed = !sidebarCollapsed" 
                class="p-1.5 rounded-lg bg-white/10 hover:bg-white/20 text-cyan-200 hover:text-white transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-cyan-400 focus:ring-offset-2 focus:ring-offset-blue-950 flex items-center justify-center"
                :aria-label="sidebarCollapsed ? 'Expand Sidebar' : 'Collapse Sidebar'">
            <!-- Left double arrow icon (collapse) -->
            <svg x-show="!sidebarCollapsed" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M18.75 19.5l-7.5-7.5 7.5-7.5m-6 15L5.25 12l7.5-7.5" />
            </svg>
            <!-- Right double arrow icon (expand) -->
            <svg x-show="sidebarCollapsed" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="display: none;">
                <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 4.5l7.5 7.5-7.5 7.5m-6-15l7.5 7.5-7.5 7.5" />
            </svg>
        </button>
    </div>

    <!-- Navigation Menu (scrollable area) -->
    <nav class="flex-grow overflow-y-auto custom-scrollbar px-3 pt-8"
         :class="sidebarCollapsed ? 'space-y-4 pb-6' : 'space-y-2 pb-4'">
        
        <!-- Dashboard Link -->
        <div class="relative group" @mouseenter="activeTooltip = 'dashboard'" @mouseleave="activeTooltip = null">
            @php
                $isDashboardActive = request()->routeIs('dashboard') || request()->routeIs('kasir.dashboard') || request()->routeIs('apoteker.dashboard');
            @endphp
            <a href="{{ Auth::user()->getDashboardUrl() }}"
               class="h-12 flex items-center rounded-xl transition-all duration-200 relative border group {{ $isDashboardActive ? 'bg-white/15 text-white font-semibold shadow-[0_0_15px_rgba(34,211,238,0.25)] border-white/15' : 'hover:bg-white/10 text-cyan-100 hover:text-white border-transparent' }}"
               :class="sidebarCollapsed ? 'justify-center px-0' : 'justify-between px-4'">
                <div class="flex items-center gap-3 min-w-0" :class="sidebarCollapsed ? 'mx-auto justify-center' : ''">
                    <span class="text-cyan-200 group-hover:text-white transition-all duration-200 group-hover:scale-110 shrink-0">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                    </span>
                    <span x-show="!sidebarCollapsed" x-transition class="text-sm font-medium tracking-wide transition-transform duration-200 group-hover:translate-x-1 truncate">Dashboard</span>
                </div>
                
                @if($isDashboardActive)
                    <div class="absolute left-0 top-2 bottom-2 w-1 bg-cyan-400 rounded-r-md"></div>
                @endif
            </a>
            <!-- Collapsed Tooltip -->
            <div x-show="sidebarCollapsed && activeTooltip === 'dashboard'" 
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 translate-x-2"
                 x-transition:enter-end="opacity-100 translate-x-0"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 translate-x-0"
                 x-transition:leave-end="opacity-0 translate-x-2"
                 class="absolute left-full top-1/2 -translate-y-1/2 ml-4 px-3.5 py-2 bg-slate-950/90 backdrop-blur-md text-white text-xs font-semibold rounded-xl shadow-2xl pointer-events-none whitespace-nowrap z-50 border border-white/15"
                 style="display: none;">
                Dashboard
            </div>
        </div>

        <!-- MASTER DATA SECTION -->
        @if(auth()->user()->can('Lihat Kategori') || auth()->user()->can('Tambah Kategori') || auth()->user()->can('Lihat Supplier') || auth()->user()->can('Tambah Supplier') || auth()->user()->can('Lihat Obat') || auth()->user()->can('Tambah Obat') || auth()->user()->can('Lihat Stok Obat'))
            <div class="px-4 mt-10 mb-4 text-[10px] font-bold text-cyan-200/40 uppercase tracking-widest select-none" x-show="!sidebarCollapsed" x-transition>
                Master Data
            </div>
            <div class="w-full border-t border-white/5 my-6" x-show="sidebarCollapsed" x-transition></div>

            <!-- Kategori Accordion -->
            @if(auth()->user()->can('Lihat Kategori') || auth()->user()->can('Tambah Kategori'))
                <div x-data="{ open: {{ request()->routeIs('kategori.*') ? 'true' : 'false' }} }" class="mb-1 relative group" @mouseenter="activeTooltip = 'kategori'" @mouseleave="activeTooltip = null">
                    <button @click="sidebarCollapsed ? (sidebarCollapsed = false, open = true) : (open = !open)"
                            class="h-12 w-full flex items-center rounded-xl transition-all duration-200 group relative border {{ request()->routeIs('kategori.*') ? 'bg-white/15 text-white font-semibold shadow-[0_0_15px_rgba(34,211,238,0.25)] border-white/15' : 'hover:bg-white/10 text-cyan-100 hover:text-white border-transparent' }}"
                            :class="sidebarCollapsed ? 'justify-center px-0' : 'justify-between px-4'">
                        <div class="flex items-center gap-3 min-w-0" :class="sidebarCollapsed ? 'mx-auto justify-center' : ''">
                            <span class="text-cyan-200 group-hover:text-white transition-all duration-200 group-hover:scale-110 shrink-0">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                                </svg>
                            </span>
                            <span x-show="!sidebarCollapsed" x-transition class="text-sm font-medium tracking-wide transition-transform duration-200 group-hover:translate-x-1 truncate">Kategori</span>
                        </div>
                        <span x-show="!sidebarCollapsed" x-transition class="text-cyan-300/70 group-hover:text-white transition-transform duration-200 shrink-0" :class="open ? 'rotate-180' : ''">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </span>
                        @if(request()->routeIs('kategori.*'))
                            <div class="absolute left-0 top-2 bottom-2 w-1 bg-cyan-400 rounded-r-md"></div>
                        @endif
                    </button>
                    <!-- Collapsed Tooltip -->
                    <div x-show="sidebarCollapsed && activeTooltip === 'kategori'" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 translate-x-2"
                         x-transition:enter-end="opacity-100 translate-x-0"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 translate-x-0"
                         x-transition:leave-end="opacity-0 translate-x-2"
                         class="absolute left-full top-1/2 -translate-y-1/2 ml-4 px-3.5 py-2 bg-slate-955/90 backdrop-blur-md text-white text-xs font-semibold rounded-xl shadow-2xl pointer-events-none whitespace-nowrap z-50 border border-white/15"
                         style="display: none;">
                        Kategori
                    </div>
                    
                    <div x-show="open && !sidebarCollapsed" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 -translate-y-1 scale-95"
                         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                         class="pl-11 pr-3 py-1.5 flex flex-col gap-1 select-none">
                         @can('Lihat Kategori')
                             <a href="{{ route('kategori.index') }}" class="h-9 flex items-center px-3.5 rounded-lg text-xs transition-colors duration-150 {{ request()->routeIs('kategori.index') ? 'text-cyan-300 font-bold bg-white/10 shadow-inner border border-white/5' : 'text-cyan-100/70 hover:text-white hover:bg-white/5' }}">
                                 Daftar Kategori
                             </a>
                         @endcan
                         @can('Tambah Kategori')
                             <a href="{{ route('kategori.create') }}" class="h-9 flex items-center px-3.5 rounded-lg text-xs transition-colors duration-150 {{ request()->routeIs('kategori.create') ? 'text-cyan-300 font-bold bg-white/10 shadow-inner border border-white/5' : 'text-cyan-100/70 hover:text-white hover:bg-white/5' }}">
                                 Tambah Kategori
                             </a>
                         @endcan
                    </div>
                </div>
            @endif

            <!-- Supplier Accordion -->
            @if(auth()->user()->can('Lihat Supplier') || auth()->user()->can('Tambah Supplier'))
                <div x-data="{ open: {{ request()->routeIs('supplier.*') ? 'true' : 'false' }} }" class="mb-1 relative group" @mouseenter="activeTooltip = 'supplier'" @mouseleave="activeTooltip = null">
                    <button @click="sidebarCollapsed ? (sidebarCollapsed = false, open = true) : (open = !open)"
                            class="h-12 w-full flex items-center rounded-xl transition-all duration-200 group relative border {{ request()->routeIs('supplier.*') ? 'bg-white/15 text-white font-semibold shadow-[0_0_15px_rgba(34,211,238,0.25)] border-white/15' : 'hover:bg-white/10 text-cyan-100 hover:text-white border-transparent' }}"
                            :class="sidebarCollapsed ? 'justify-center px-0' : 'justify-between px-4'">
                        <div class="flex items-center gap-3 min-w-0" :class="sidebarCollapsed ? 'mx-auto justify-center' : ''">
                            <span class="text-cyan-200 group-hover:text-white transition-all duration-200 group-hover:scale-110 shrink-0">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17h2m10 0h2"/>
                                </svg>
                            </span>
                            <span x-show="!sidebarCollapsed" x-transition class="text-sm font-medium tracking-wide transition-transform duration-200 group-hover:translate-x-1 truncate">Supplier</span>
                        </div>
                        <span x-show="!sidebarCollapsed" x-transition class="text-cyan-300/70 group-hover:text-white transition-transform duration-200 shrink-0" :class="open ? 'rotate-180' : ''">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </span>
                        @if(request()->routeIs('supplier.*'))
                            <div class="absolute left-0 top-2 bottom-2 w-1 bg-cyan-400 rounded-r-md"></div>
                        @endif
                    </button>
                    <!-- Collapsed Tooltip -->
                    <div x-show="sidebarCollapsed && activeTooltip === 'supplier'" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 translate-x-2"
                         x-transition:enter-end="opacity-100 translate-x-0"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 translate-x-0"
                         x-transition:leave-end="opacity-0 translate-x-2"
                         class="absolute left-full top-1/2 -translate-y-1/2 ml-4 px-3.5 py-2 bg-slate-950/90 backdrop-blur-md text-white text-xs font-semibold rounded-xl shadow-2xl pointer-events-none whitespace-nowrap z-50 border border-white/15"
                         style="display: none;">
                        Supplier
                    </div>
                    
                    <div x-show="open && !sidebarCollapsed" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 -translate-y-1 scale-95"
                         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                         class="pl-11 pr-3 py-1.5 flex flex-col gap-1 select-none">
                         @can('Lihat Supplier')
                             <a href="{{ route('supplier.index') }}" class="h-9 flex items-center px-3.5 rounded-lg text-xs transition-colors duration-150 {{ request()->routeIs('supplier.index') ? 'text-cyan-300 font-bold bg-white/10 shadow-inner border border-white/5' : 'text-cyan-100/70 hover:text-white hover:bg-white/5' }}">
                                 Daftar Supplier
                             </a>
                         @endcan
                         @can('Tambah Supplier')
                             <a href="{{ route('supplier.create') }}" class="h-9 flex items-center px-3.5 rounded-lg text-xs transition-colors duration-150 {{ request()->routeIs('supplier.create') ? 'text-cyan-300 font-bold bg-white/10 shadow-inner border border-white/5' : 'text-cyan-100/70 hover:text-white hover:bg-white/5' }}">
                                 Tambah Supplier
                             </a>
                         @endcan
                    </div>
                </div>
            @endif

            <!-- Obat Accordion -->
            @if(auth()->user()->can('Lihat Obat') || auth()->user()->can('Tambah Obat') || auth()->user()->can('Lihat Stok Obat'))
                @php
                    $isObatActive = request()->routeIs('obat.*') || request()->routeIs('apoteker.obat.*');
                @endphp
                <div x-data="{ open: {{ $isObatActive ? 'true' : 'false' }} }" class="mb-1 relative group" @mouseenter="activeTooltip = 'obat'" @mouseleave="activeTooltip = null">
                    <button @click="sidebarCollapsed ? (sidebarCollapsed = false, open = true) : (open = !open)"
                            class="h-12 w-full flex items-center rounded-xl transition-all duration-200 group relative border {{ $isObatActive ? 'bg-white/15 text-white font-semibold shadow-[0_0_15px_rgba(34,211,238,0.25)] border-white/15' : 'hover:bg-white/10 text-cyan-100 hover:text-white border-transparent' }}"
                            :class="sidebarCollapsed ? 'justify-center px-0' : 'justify-between px-4'">
                        <div class="flex items-center gap-3 min-w-0" :class="sidebarCollapsed ? 'mx-auto justify-center' : ''">
                            <span class="text-cyan-200 group-hover:text-white transition-all duration-200 group-hover:scale-110 shrink-0">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.485 12c.38.381.578.892.578 1.404s-.197 1.023-.578 1.404L14.83 19.485c-.381.38-.892.578-1.404.578s-1.023-.197-1.404-.578L4.515 12c-.38-.381-.578-.892-.578-1.404s.197-1.023.578-1.404L9.17 4.515c.381-.38.892-.578 1.404-.578s1.023.197 1.404.578l7.508 7.507z"/><path stroke-linecap="round" stroke-linejoin="round" d="M7 17l10-10"/>
                                </svg>
                            </span>
                            <span x-show="!sidebarCollapsed" x-transition class="text-sm font-medium tracking-wide transition-transform duration-200 group-hover:translate-x-1 truncate">Obat</span>
                        </div>
                        <span x-show="!sidebarCollapsed" x-transition class="text-cyan-300/70 group-hover:text-white transition-transform duration-200 shrink-0" :class="open ? 'rotate-180' : ''">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </span>
                        @if($isObatActive)
                            <div class="absolute left-0 top-2 bottom-2 w-1 bg-cyan-400 rounded-r-md"></div>
                        @endif
                    </button>
                    <!-- Collapsed Tooltip -->
                    <div x-show="sidebarCollapsed && activeTooltip === 'obat'" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 translate-x-2"
                         x-transition:enter-end="opacity-100 translate-x-0"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 translate-x-0"
                         x-transition:leave-end="opacity-0 translate-x-2"
                         class="absolute left-full top-1/2 -translate-y-1/2 ml-4 px-3.5 py-2 bg-slate-955/90 backdrop-blur-md text-white text-xs font-semibold rounded-xl shadow-2xl pointer-events-none whitespace-nowrap z-50 border border-white/15"
                         style="display: none;">
                        Obat
                    </div>
                    
                    <div x-show="open && !sidebarCollapsed" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 -translate-y-1 scale-95"
                         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                         class="pl-11 pr-3 py-1.5 flex flex-col gap-1 select-none">
                         @can('Lihat Obat')
                              <a href="{{ route('obat.index') }}" class="h-9 flex items-center px-3.5 rounded-lg text-xs transition-colors duration-150 {{ request()->routeIs('obat.index') ? 'text-cyan-300 font-bold bg-white/10 shadow-inner border border-white/5' : 'text-cyan-100/70 hover:text-white hover:bg-white/5' }}">
                                  Daftar Obat
                              </a>
                         @endcan
                         @can('Tambah Obat')
                              <a href="{{ route('obat.create') }}" class="h-9 flex items-center px-3.5 rounded-lg text-xs transition-colors duration-150 {{ request()->routeIs('obat.create') ? 'text-cyan-300 font-bold bg-white/10 shadow-inner border border-white/5' : 'text-cyan-100/70 hover:text-white hover:bg-white/5' }}">
                                  Tambah Obat
                              </a>
                              <a href="{{ route('obat.download-template') }}" class="h-9 flex items-center px-3.5 rounded-lg text-xs transition-colors duration-150 {{ request()->routeIs('obat.download-template') ? 'text-cyan-300 font-bold bg-white/10 shadow-inner border border-white/5' : 'text-cyan-100/70 hover:text-white hover:bg-white/5' }}">
                                  Download Template
                              </a>
                         @endcan
                         @can('Lihat Stok Obat')
                              @if(!auth()->user()->can('Lihat Obat'))
                                  <a href="{{ route('apoteker.obat.index') }}" class="h-9 flex items-center px-3.5 rounded-lg text-xs transition-colors duration-150 {{ request()->routeIs('apoteker.obat.index') ? 'text-cyan-300 font-bold bg-white/10 shadow-inner border border-white/5' : 'text-cyan-100/70 hover:text-white hover:bg-white/5' }}">
                                      Stok Obat
                                  </a>
                              @endif
                         @endcan
                    </div>
                </div>
            @endif
        @endif

        <!-- PENGGUNA SECTION -->
        @if(auth()->user()->can('Lihat Pelanggan') || auth()->user()->can('Tambah Pelanggan') || auth()->user()->can('Lihat User') || auth()->user()->can('Tambah User') || auth()->user()->can('Lihat Role') || auth()->user()->can('Tambah Role') || auth()->user()->can('Lihat Permission') || auth()->user()->can('Tambah Permission'))
            <div class="px-4 mt-10 mb-4 text-[10px] font-bold text-cyan-200/40 uppercase tracking-widest select-none" x-show="!sidebarCollapsed" x-transition>
                Pengguna
            </div>
            <div class="w-full border-t border-white/5 my-6" x-show="sidebarCollapsed" x-transition></div>

            <!-- Pelanggan Accordion -->
            @if(auth()->user()->can('Lihat Pelanggan') || auth()->user()->can('Tambah Pelanggan'))
                <div x-data="{ open: {{ request()->routeIs('customer.*') ? 'true' : 'false' }} }" class="mb-1 relative group" @mouseenter="activeTooltip = 'pelanggan'" @mouseleave="activeTooltip = null">
                    <button @click="sidebarCollapsed ? (sidebarCollapsed = false, open = true) : (open = !open)"
                            class="h-12 w-full flex items-center rounded-xl transition-all duration-200 group relative border {{ request()->routeIs('customer.*') ? 'bg-white/15 text-white font-semibold shadow-[0_0_15px_rgba(34,211,238,0.25)] border-white/15' : 'hover:bg-white/10 text-cyan-100 hover:text-white border-transparent' }}"
                            :class="sidebarCollapsed ? 'justify-center px-0' : 'justify-between px-4'">
                        <div class="flex items-center gap-3 min-w-0" :class="sidebarCollapsed ? 'mx-auto justify-center' : ''">
                            <span class="text-cyan-200 group-hover:text-white transition-all duration-200 group-hover:scale-110 shrink-0">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5V4H2v16h5m10 0v-2a4 4 0 00-8 0v2m8 0H9m4-10a4 4 0 11-8 0 4 4 0 018 0z"/>
                                </svg>
                            </span>
                            <span x-show="!sidebarCollapsed" x-transition class="text-sm font-medium tracking-wide transition-transform duration-200 group-hover:translate-x-1 truncate">Pelanggan</span>
                        </div>
                        <span x-show="!sidebarCollapsed" x-transition class="text-cyan-300/70 group-hover:text-white transition-transform duration-200 shrink-0" :class="open ? 'rotate-180' : ''">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </span>
                        @if(request()->routeIs('customer.*'))
                            <div class="absolute left-0 top-2 bottom-2 w-1 bg-cyan-400 rounded-r-md"></div>
                        @endif
                    </button>
                    <!-- Collapsed Tooltip -->
                    <div x-show="sidebarCollapsed && activeTooltip === 'pelanggan'" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 translate-x-2"
                         x-transition:enter-end="opacity-100 translate-x-0"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 translate-x-0"
                         x-transition:leave-end="opacity-0 translate-x-2"
                         class="absolute left-full top-1/2 -translate-y-1/2 ml-4 px-3.5 py-2 bg-slate-950/90 backdrop-blur-md text-white text-xs font-semibold rounded-xl shadow-2xl pointer-events-none whitespace-nowrap z-50 border border-white/15"
                         style="display: none;">
                        Pelanggan
                    </div>
                    
                    <div x-show="open && !sidebarCollapsed" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 -translate-y-1 scale-95"
                         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                         class="pl-11 pr-3 py-1.5 flex flex-col gap-1 select-none">
                         @can('Lihat Pelanggan')
                             <a href="{{ route('customer.index') }}" class="h-9 flex items-center px-3.5 rounded-lg text-xs transition-colors duration-150 {{ request()->routeIs('customer.index') ? 'text-cyan-300 font-bold bg-white/10 shadow-inner border border-white/5' : 'text-cyan-100/70 hover:text-white hover:bg-white/5' }}">
                                 Daftar Pelanggan
                             </a>
                         @endcan
                         @can('Tambah Pelanggan')
                             <a href="{{ route('customer.create') }}" class="h-9 flex items-center px-3.5 rounded-lg text-xs transition-colors duration-150 {{ request()->routeIs('customer.create') ? 'text-cyan-300 font-bold bg-white/10 shadow-inner border border-white/5' : 'text-cyan-100/70 hover:text-white hover:bg-white/5' }}">
                                 Tambah Pelanggan
                             </a>
                         @endcan
                    </div>
                </div>
            @endif

            <!-- User Management Accordion -->
            @if(auth()->user()->can('Lihat User') || auth()->user()->can('Tambah User'))
                <div x-data="{ open: {{ request()->routeIs('user.*') ? 'true' : 'false' }} }" class="mb-1 relative group" @mouseenter="activeTooltip = 'user'" @mouseleave="activeTooltip = null">
                    <button @click="sidebarCollapsed ? (sidebarCollapsed = false, open = true) : (open = !open)"
                            class="h-12 w-full flex items-center rounded-xl transition-all duration-200 group relative border {{ request()->routeIs('user.*') ? 'bg-white/15 text-white font-semibold shadow-[0_0_15px_rgba(34,211,238,0.25)] border-white/15' : 'hover:bg-white/10 text-cyan-100 hover:text-white border-transparent' }}"
                            :class="sidebarCollapsed ? 'justify-center px-0' : 'justify-between px-4'">
                        <div class="flex items-center gap-3 min-w-0" :class="sidebarCollapsed ? 'mx-auto justify-center' : ''">
                            <span class="text-cyan-200 group-hover:text-white transition-all duration-200 group-hover:scale-110 shrink-0">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </span>
                            <span x-show="!sidebarCollapsed" x-transition class="text-sm font-medium tracking-wide transition-transform duration-200 group-hover:translate-x-1 truncate">Users</span>
                        </div>
                        <span x-show="!sidebarCollapsed" x-transition class="text-cyan-300/70 group-hover:text-white transition-transform duration-200 shrink-0" :class="open ? 'rotate-180' : ''">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </span>
                        @if(request()->routeIs('user.*'))
                            <div class="absolute left-0 top-2 bottom-2 w-1 bg-cyan-400 rounded-r-md"></div>
                        @endif
                    </button>
                    <!-- Collapsed Tooltip -->
                    <div x-show="sidebarCollapsed && activeTooltip === 'user'" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 translate-x-2"
                         x-transition:enter-end="opacity-100 translate-x-0"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 translate-x-0"
                         x-transition:leave-end="opacity-0 translate-x-2"
                         class="absolute left-full top-1/2 -translate-y-1/2 ml-4 px-3.5 py-2 bg-slate-950/90 backdrop-blur-md text-white text-xs font-semibold rounded-xl shadow-2xl pointer-events-none whitespace-nowrap z-50 border border-white/15"
                         style="display: none;">
                        Users
                    </div>
                    
                    <div x-show="open && !sidebarCollapsed" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 -translate-y-1 scale-95"
                         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                         class="pl-11 pr-3 py-1.5 flex flex-col gap-1 select-none">
                         @can('Lihat User')
                             <a href="{{ route('user.index') }}" class="h-9 flex items-center px-3.5 rounded-lg text-xs transition-colors duration-150 {{ request()->routeIs('user.index') ? 'text-cyan-300 font-bold bg-white/10 shadow-inner border border-white/5' : 'text-cyan-100/70 hover:text-white hover:bg-white/5' }}">
                                 Daftar User
                             </a>
                         @endcan
                         @can('Tambah User')
                             <a href="{{ route('user.create') }}" class="h-9 flex items-center px-3.5 rounded-lg text-xs transition-colors duration-150 {{ request()->routeIs('user.create') ? 'text-cyan-300 font-bold bg-white/10 shadow-inner border border-white/5' : 'text-cyan-100/70 hover:text-white hover:bg-white/5' }}">
                                 Tambah User
                             </a>
                         @endcan
                    </div>
                </div>
            @endif

            <!-- Role Management Accordion -->
            @if(auth()->user()->can('Lihat Role') || auth()->user()->can('Tambah Role'))
                <div x-data="{ open: {{ request()->routeIs('role.*') ? 'true' : 'false' }} }" class="mb-1 relative group" @mouseenter="activeTooltip = 'role'" @mouseleave="activeTooltip = null">
                    <button @click="sidebarCollapsed ? (sidebarCollapsed = false, open = true) : (open = !open)"
                            class="h-12 w-full flex items-center rounded-xl transition-all duration-200 group relative border {{ request()->routeIs('role.*') ? 'bg-white/15 text-white font-semibold shadow-[0_0_15px_rgba(34,211,238,0.25)] border-white/15' : 'hover:bg-white/10 text-cyan-100 hover:text-white border-transparent' }}"
                            :class="sidebarCollapsed ? 'justify-center px-0' : 'justify-between px-4'">
                        <div class="flex items-center gap-3 min-w-0" :class="sidebarCollapsed ? 'mx-auto justify-center' : ''">
                            <span class="text-cyan-200 group-hover:text-white transition-all duration-200 group-hover:scale-110 shrink-0">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                            </span>
                            <span x-show="!sidebarCollapsed" x-transition class="text-sm font-medium tracking-wide transition-transform duration-200 group-hover:translate-x-1 truncate">Roles</span>
                        </div>
                        <span x-show="!sidebarCollapsed" x-transition class="text-cyan-300/70 group-hover:text-white transition-transform duration-200 shrink-0" :class="open ? 'rotate-180' : ''">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </span>
                        @if(request()->routeIs('role.*'))
                            <div class="absolute left-0 top-2 bottom-2 w-1 bg-cyan-400 rounded-r-md"></div>
                        @endif
                    </button>
                    <!-- Collapsed Tooltip -->
                    <div x-show="sidebarCollapsed && activeTooltip === 'role'" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 translate-x-2"
                         x-transition:enter-end="opacity-100 translate-x-0"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 translate-x-0"
                         x-transition:leave-end="opacity-0 translate-x-2"
                         class="absolute left-full top-1/2 -translate-y-1/2 ml-4 px-3.5 py-2 bg-slate-950/90 backdrop-blur-md text-white text-xs font-semibold rounded-xl shadow-2xl pointer-events-none whitespace-nowrap z-50 border border-white/15"
                         style="display: none;">
                        Roles
                    </div>
                    
                    <div x-show="open && !sidebarCollapsed" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 -translate-y-1 scale-95"
                         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                         class="pl-11 pr-3 py-1.5 flex flex-col gap-1 select-none">
                         @can('Lihat Role')
                             <a href="{{ route('role.index') }}" class="h-9 flex items-center px-3.5 rounded-lg text-xs transition-colors duration-150 {{ request()->routeIs('role.index') ? 'text-cyan-300 font-bold bg-white/10 shadow-inner border border-white/5' : 'text-cyan-100/70 hover:text-white hover:bg-white/5' }}">
                                 Daftar Role
                             </a>
                         @endcan
                         @can('Tambah Role')
                             <a href="{{ route('role.create') }}" class="h-9 flex items-center px-3.5 rounded-lg text-xs transition-colors duration-150 {{ request()->routeIs('role.create') ? 'text-cyan-300 font-bold bg-white/10 shadow-inner border border-white/5' : 'text-cyan-100/70 hover:text-white hover:bg-white/5' }}">
                                 Tambah Role
                             </a>
                         @endcan
                    </div>
                </div>
            @endif

            <!-- Permission Management Accordion -->
            @if(auth()->user()->can('Lihat Permission') || auth()->user()->can('Tambah Permission'))
                <div x-data="{ open: {{ request()->routeIs('permission.*') ? 'true' : 'false' }} }" class="mb-1 relative group" @mouseenter="activeTooltip = 'permission'" @mouseleave="activeTooltip = null">
                    <button @click="sidebarCollapsed ? (sidebarCollapsed = false, open = true) : (open = !open)"
                            class="h-12 w-full flex items-center rounded-xl transition-all duration-200 group relative border {{ request()->routeIs('permission.*') ? 'bg-white/15 text-white font-semibold shadow-[0_0_15px_rgba(34,211,238,0.25)] border-white/15' : 'hover:bg-white/10 text-cyan-100 hover:text-white border-transparent' }}"
                            :class="sidebarCollapsed ? 'justify-center px-0' : 'justify-between px-4'">
                        <div class="flex items-center gap-3 min-w-0" :class="sidebarCollapsed ? 'mx-auto justify-center' : ''">
                            <span class="text-cyan-200 group-hover:text-white transition-all duration-200 group-hover:scale-110 shrink-0">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 7a2 2 0 012 2m-5 4a3 3 0 10-6 0 3 3 0 006 0zm7-5a2 2 0 11-4 0 2 2 0 014 0zM12 11l4.5 4.5M16.5 15.5l1.5-1.5M15.5 16.5l1.5 1.5" />
                                </svg>
                            </span>
                            <span x-show="!sidebarCollapsed" x-transition class="text-sm font-medium tracking-wide transition-transform duration-200 group-hover:translate-x-1 truncate">Permissions</span>
                        </div>
                        <span x-show="!sidebarCollapsed" x-transition class="text-cyan-300/70 group-hover:text-white transition-transform duration-200 shrink-0" :class="open ? 'rotate-180' : ''">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </span>
                        @if(request()->routeIs('permission.*'))
                            <div class="absolute left-0 top-2 bottom-2 w-1 bg-cyan-400 rounded-r-md"></div>
                        @endif
                    </button>
                    <!-- Collapsed Tooltip -->
                    <div x-show="sidebarCollapsed && activeTooltip === 'permission'" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 translate-x-2"
                         x-transition:enter-end="opacity-100 translate-x-0"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 translate-x-0"
                         x-transition:leave-end="opacity-0 translate-x-2"
                         class="absolute left-full top-1/2 -translate-y-1/2 ml-4 px-3.5 py-2 bg-slate-950/90 backdrop-blur-md text-white text-xs font-semibold rounded-xl shadow-2xl pointer-events-none whitespace-nowrap z-50 border border-white/15"
                         style="display: none;">
                        Permissions
                    </div>
                    
                    <div x-show="open && !sidebarCollapsed" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 -translate-y-1 scale-95"
                         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                         class="pl-11 pr-3 py-1.5 flex flex-col gap-1 select-none">
                         @can('Lihat Permission')
                             <a href="{{ route('permission.index') }}" class="h-9 flex items-center px-3.5 rounded-lg text-xs transition-colors duration-150 {{ request()->routeIs('permission.index') ? 'text-cyan-300 font-bold bg-white/10 shadow-inner border border-white/5' : 'text-cyan-100/70 hover:text-white hover:bg-white/5' }}">
                                 Daftar Permission
                             </a>
                         @endcan
                         @can('Tambah Permission')
                             <a href="{{ route('permission.create') }}" class="h-9 flex items-center px-3.5 rounded-lg text-xs transition-colors duration-150 {{ request()->routeIs('permission.create') ? 'text-cyan-300 font-bold bg-white/10 shadow-inner border border-white/5' : 'text-cyan-100/70 hover:text-white hover:bg-white/5' }}">
                                 Tambah Permission
                             </a>
                         @endcan
                    </div>
                </div>
            @endif
        @endif

        <!-- TRANSAKSI SECTION -->
        @if(auth()->user()->can('Lihat Transaksi') || auth()->user()->can('Tambah Transaksi') || auth()->user()->can('Verifikasi Resep') || auth()->user()->can('Kelola Pesanan Online') || auth()->user()->can('Kelola Laporan'))
            <div class="px-4 mt-10 mb-4 text-[10px] font-bold text-cyan-200/40 uppercase tracking-widest select-none" x-show="!sidebarCollapsed" x-transition>
                Transaksi
            </div>
            <div class="w-full border-t border-white/5 my-6" x-show="sidebarCollapsed" x-transition></div>

            <!-- Transaksi Accordion -->
            @if(auth()->user()->can('Lihat Transaksi') || auth()->user()->can('Tambah Transaksi'))
                <div x-data="{ open: {{ request()->routeIs('transaksi.*') ? 'true' : 'false' }} }" class="mb-1 relative group" @mouseenter="activeTooltip = 'transaksi'" @mouseleave="activeTooltip = null">
                    <button @click="sidebarCollapsed ? (sidebarCollapsed = false, open = true) : (open = !open)"
                            class="h-12 w-full flex items-center rounded-xl transition-all duration-200 group relative border {{ request()->routeIs('transaksi.*') ? 'bg-white/15 text-white font-semibold shadow-[0_0_15px_rgba(34,211,238,0.25)] border-white/15' : 'hover:bg-white/10 text-cyan-100 hover:text-white border-transparent' }}"
                            :class="sidebarCollapsed ? 'justify-center px-0' : 'justify-between px-4'">
                        <div class="flex items-center gap-3 min-w-0" :class="sidebarCollapsed ? 'mx-auto justify-center' : ''">
                            <span class="text-cyan-200 group-hover:text-white transition-all duration-200 group-hover:scale-110 shrink-0">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                            </span>
                            <span x-show="!sidebarCollapsed" x-transition class="text-sm font-medium tracking-wide transition-transform duration-200 group-hover:translate-x-1 truncate">Transaksi (POS)</span>
                        </div>
                        <span x-show="!sidebarCollapsed" x-transition class="text-cyan-300/70 group-hover:text-white transition-transform duration-200 shrink-0" :class="open ? 'rotate-180' : ''">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </span>
                        @if(request()->routeIs('transaksi.*'))
                            <div class="absolute left-0 top-2 bottom-2 w-1 bg-cyan-400 rounded-r-md"></div>
                        @endif
                    </button>
                    <!-- Collapsed Tooltip -->
                    <div x-show="sidebarCollapsed && activeTooltip === 'transaksi'" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 translate-x-2"
                         x-transition:enter-end="opacity-100 translate-x-0"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 translate-x-0"
                         x-transition:leave-end="opacity-0 translate-x-2"
                         class="absolute left-full top-1/2 -translate-y-1/2 ml-4 px-3.5 py-2 bg-slate-955/90 backdrop-blur-md text-white text-xs font-semibold rounded-xl shadow-2xl pointer-events-none whitespace-nowrap z-50 border border-white/15"
                         style="display: none;">
                        Transaksi (POS)
                    </div>
                    
                    <div x-show="open && !sidebarCollapsed" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 -translate-y-1 scale-95"
                         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                         class="pl-11 pr-3 py-1.5 flex flex-col gap-1 select-none">
                         @can('Tambah Transaksi')
                             <a href="{{ route('transaksi.create') }}" class="h-9 flex items-center px-3.5 rounded-lg text-xs transition-colors duration-150 {{ request()->routeIs('transaksi.create') ? 'text-cyan-300 font-bold bg-white/10 shadow-inner border border-white/5' : 'text-cyan-100/70 hover:text-white hover:bg-white/5' }}">
                                 POS Baru
                             </a>
                         @endcan
                         @can('Lihat Transaksi')
                             <a href="{{ route('transaksi.index') }}" class="h-9 flex items-center px-3.5 rounded-lg text-xs transition-colors duration-150 {{ request()->routeIs('transaksi.index') ? 'text-cyan-300 font-bold bg-white/10 shadow-inner border border-white/5' : 'text-cyan-100/70 hover:text-white hover:bg-white/5' }}">
                                 Riwayat Transaksi
                             </a>
                         @endcan
                    </div>
                </div>
            @endif


            <!-- Laporan Link -->
            @can('Kelola Laporan')
                <div class="relative group" @mouseenter="activeTooltip = 'laporan'" @mouseleave="activeTooltip = null">
                    <a href="{{ route('laporan.index') }}"
                       class="h-12 flex items-center rounded-xl transition-all duration-200 relative border group {{ request()->routeIs('laporan.*') ? 'bg-white/15 text-white font-semibold shadow-[0_0_15px_rgba(34,211,238,0.25)] border-white/15' : 'hover:bg-white/10 text-cyan-100 hover:text-white border-transparent' }}"
                       :class="sidebarCollapsed ? 'justify-center px-0' : 'justify-between px-4'">
                        <div class="flex items-center gap-3 min-w-0" :class="sidebarCollapsed ? 'mx-auto justify-center' : ''">
                            <span class="text-cyan-200 group-hover:text-white transition-all duration-200 group-hover:scale-110 shrink-0">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 002 2h2a2 2 0 002-2z"/>
                                </svg>
                            </span>
                            <span x-show="!sidebarCollapsed" x-transition class="text-sm font-medium tracking-wide transition-transform duration-200 group-hover:translate-x-1 truncate">Laporan</span>
                        </div>
                        
                        @if(request()->routeIs('laporan.*'))
                            <div class="absolute left-0 top-2 bottom-2 w-1 bg-cyan-400 rounded-r-md"></div>
                        @endif
                    </a>
                    <!-- Collapsed Tooltip -->
                    <div x-show="sidebarCollapsed && activeTooltip === 'laporan'" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 translate-x-2"
                         x-transition:enter-end="opacity-100 translate-x-0"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 translate-x-0"
                         x-transition:leave-end="opacity-0 translate-x-2"
                         class="absolute left-full top-1/2 -translate-y-1/2 ml-4 px-3.5 py-2 bg-slate-950/90 backdrop-blur-md text-white text-xs font-semibold rounded-xl shadow-2xl pointer-events-none whitespace-nowrap z-50 border border-white/15"
                         style="display: none;">
                        Laporan
                    </div>
                </div>
            @endcan

            <!-- Resep Dokter Link -->
            @if(auth()->user()->can('Verifikasi Resep'))
                @php
                    $isResepActive = request()->routeIs('admin.resep.*') || request()->routeIs('apoteker.resep.*') || request()->routeIs('resep.proses');
                    $resepUrl = auth()->user()->can('Kelola Pesanan Online') ? route('admin.resep.index') : route('apoteker.resep.index');
                @endphp
                <div class="relative group" @mouseenter="activeTooltip = 'resep'" @mouseleave="activeTooltip = null">
                    <a href="{{ $resepUrl }}"
                       class="h-12 flex items-center rounded-xl transition-all duration-200 relative border group {{ $isResepActive ? 'bg-white/15 text-white font-semibold shadow-[0_0_15px_rgba(34,211,238,0.25)] border-white/15' : 'hover:bg-white/10 text-cyan-100 hover:text-white border-transparent' }}"
                       :class="sidebarCollapsed ? 'justify-center px-0' : 'justify-between px-4'">
                        <div class="flex items-center gap-3 min-w-0" :class="sidebarCollapsed ? 'mx-auto justify-center' : ''">
                            <span class="text-cyan-200 group-hover:text-white transition-all duration-200 group-hover:scale-110 shrink-0">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </span>
                            <span x-show="!sidebarCollapsed" x-transition class="text-sm font-medium tracking-wide transition-transform duration-200 group-hover:translate-x-1 truncate">Resep Dokter</span>
                        </div>
                        
                        @if($isResepActive)
                            <div class="absolute left-0 top-2 bottom-2 w-1 bg-cyan-400 rounded-r-md"></div>
                        @endif
                    </a>
                    <!-- Collapsed Tooltip -->
                    <div x-show="sidebarCollapsed && activeTooltip === 'resep'" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 translate-x-2"
                         x-transition:enter-end="opacity-100 translate-x-0"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 translate-x-0"
                         x-transition:leave-end="opacity-0 translate-x-2"
                         class="absolute left-full top-1/2 -translate-y-1/2 ml-4 px-3.5 py-2 bg-slate-950/90 backdrop-blur-md text-white text-xs font-semibold rounded-xl shadow-2xl pointer-events-none whitespace-nowrap z-50 border border-white/15"
                         style="display: none;">
                        Resep Dokter
                    </div>
                </div>
            @endif

            <!-- Pesanan Online Link -->
            @can('Kelola Pesanan Online')
                @php
                    $pendingVerificationCount = \App\Models\Transaksi::where('status', 'Menunggu Verifikasi')->count();
                @endphp
                <div class="relative group" @mouseenter="activeTooltip = 'pesanan'" @mouseleave="activeTooltip = null">
                    <a href="{{ route('admin.transaksi-online.index') }}"
                       class="h-12 flex items-center rounded-xl transition-all duration-200 relative border group {{ request()->routeIs('admin.transaksi-online.*') ? 'bg-white/15 text-white font-semibold shadow-[0_0_15px_rgba(34,211,238,0.25)] border-white/15' : 'hover:bg-white/10 text-cyan-100 hover:text-white border-transparent' }}"
                       :class="sidebarCollapsed ? 'justify-center px-0' : 'justify-between px-4'">
                        <div class="flex items-center gap-3 min-w-0" :class="sidebarCollapsed ? 'mx-auto justify-center' : ''">
                            <span class="text-cyan-200 group-hover:text-white transition-all duration-200 group-hover:scale-110 shrink-0 relative">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 008 11a4 4 0 118 0c0 1.017-.07 2.019-.203 3m-2.118 6.844A21.88 21.88 0 0015.171 17m3.839 1.132c.645-2.266.99-4.659.99-7.132A8 8 0 008 4.07M3 15.364c.64-1.319 1-2.8 1-4.364 0-1.457.39-2.823 1.07-4"/>
                                </svg>
                                @if($pendingVerificationCount > 0)
                                    <span class="absolute -top-1 -right-1 flex h-2 w-2">
                                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                                        <span class="relative inline-flex rounded-full h-2 w-2 bg-red-500"></span>
                                    </span>
                                @endif
                            </span>
                            <span x-show="!sidebarCollapsed" x-transition class="text-sm font-medium tracking-wide transition-transform duration-200 group-hover:translate-x-1 truncate flex items-center gap-1.5">
                                Pesanan Online
                                @if($pendingVerificationCount > 0)
                                    <span class="inline-flex items-center justify-center px-2 py-0.5 text-[10px] font-bold leading-none text-white bg-red-500 rounded-full">
                                        {{ $pendingVerificationCount }}
                                    </span>
                                @endif
                            </span>
                        </div>
                        
                        @if(request()->routeIs('admin.transaksi-online.*'))
                            <div class="absolute left-0 top-2 bottom-2 w-1 bg-cyan-400 rounded-r-md"></div>
                        @endif
                    </a>
                    <!-- Collapsed Tooltip -->
                    <div x-show="sidebarCollapsed && activeTooltip === 'pesanan'" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 translate-x-2"
                         x-transition:enter-end="opacity-100 translate-x-0"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 translate-x-0"
                         x-transition:leave-end="opacity-0 translate-x-2"
                         class="absolute left-full top-1/2 -translate-y-1/2 ml-4 px-3.5 py-2 bg-slate-950/90 backdrop-blur-md text-white text-xs font-semibold rounded-xl shadow-2xl pointer-events-none whitespace-nowrap z-50 border border-white/15"
                         style="display: none;">
                        Pesanan Online
                    </div>
                </div>
            @endcan

            <!-- Penilaian Layanan Link -->
            @can('Kelola Pesanan Online')
                <div class="relative group" @mouseenter="activeTooltip = 'penilaian'" @mouseleave="activeTooltip = null">
                    <a href="{{ route('admin.feedback-layanan.index') }}"
                       class="h-12 flex items-center rounded-xl transition-all duration-200 relative border group {{ request()->routeIs('admin.feedback-layanan.*') ? 'bg-white/15 text-white font-semibold shadow-[0_0_15px_rgba(34,211,238,0.25)] border-white/15' : 'hover:bg-white/10 text-cyan-100 hover:text-white border-transparent' }}"
                       :class="sidebarCollapsed ? 'justify-center px-0' : 'justify-between px-4'">
                        <div class="flex items-center gap-3 min-w-0" :class="sidebarCollapsed ? 'mx-auto justify-center' : ''">
                            <span class="text-cyan-200 group-hover:text-white transition-all duration-200 group-hover:scale-110 shrink-0">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z"/>
                                </svg>
                            </span>
                            <span x-show="!sidebarCollapsed" x-transition class="text-sm font-medium tracking-wide transition-transform duration-200 group-hover:translate-x-1 truncate">Penilaian Layanan</span>
                        </div>
                        
                        @if(request()->routeIs('admin.feedback-layanan.*'))
                            <div class="absolute left-0 top-2 bottom-2 w-1 bg-cyan-400 rounded-r-md"></div>
                        @endif
                    </a>
                    <!-- Collapsed Tooltip -->
                    <div x-show="sidebarCollapsed && activeTooltip === 'penilaian'" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 translate-x-2"
                         x-transition:enter-end="opacity-100 translate-x-0"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 translate-x-0"
                         x-transition:leave-end="opacity-0 translate-x-2"
                         class="absolute left-full top-1/2 -translate-y-1/2 ml-4 px-3.5 py-2 bg-slate-950/90 backdrop-blur-md text-white text-xs font-semibold rounded-xl shadow-2xl pointer-events-none whitespace-nowrap z-50 border border-white/15"
                         style="display: none;">
                        Penilaian Layanan
                    </div>
                </div>
            @endcan
        @endif

        <!-- SYSTEM SECTION -->
        @if(auth()->user()->can('Lihat User'))
            <div class="px-4 mt-10 mb-4 text-[10px] font-bold text-cyan-200/40 uppercase tracking-widest select-none" x-show="!sidebarCollapsed" x-transition>
                System
            </div>
            <div class="w-full border-t border-white/5 my-6" x-show="sidebarCollapsed" x-transition></div>

            <!-- System Accordion -->
            <div x-data="{ open: {{ request()->routeIs('admin.whatsapp-diagnostic') ? 'true' : 'false' }} }" class="mb-1 relative group" @mouseenter="activeTooltip = 'system'" @mouseleave="activeTooltip = null">
                <button @click="sidebarCollapsed ? (sidebarCollapsed = false, open = true) : (open = !open)"
                        class="h-12 w-full flex items-center rounded-xl transition-all duration-200 group relative border {{ request()->routeIs('admin.whatsapp-diagnostic') ? 'bg-white/15 text-white font-semibold shadow-[0_0_15px_rgba(34,211,238,0.25)] border-white/15' : 'hover:bg-white/10 text-cyan-100 hover:text-white border-transparent' }}"
                        :class="sidebarCollapsed ? 'justify-center px-0' : 'justify-between px-4'">
                    <div class="flex items-center gap-3 min-w-0" :class="sidebarCollapsed ? 'mx-auto justify-center' : ''">
                        <span class="text-cyan-200 group-hover:text-white transition-all duration-200 group-hover:scale-110 shrink-0">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </span>
                        <span x-show="!sidebarCollapsed" x-transition class="text-sm font-medium tracking-wide transition-transform duration-200 group-hover:translate-x-1 truncate">System</span>
                    </div>
                    <span x-show="!sidebarCollapsed" x-transition class="text-cyan-300/70 group-hover:text-white transition-transform duration-200 shrink-0" :class="open ? 'rotate-180' : ''">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </span>
                    @if(request()->routeIs('admin.whatsapp-diagnostic'))
                        <div class="absolute left-0 top-2 bottom-2 w-1 bg-cyan-400 rounded-r-md"></div>
                    @endif
                </button>
                <!-- Collapsed Tooltip -->
                <div x-show="sidebarCollapsed && activeTooltip === 'system'" 
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 translate-x-2"
                     x-transition:enter-end="opacity-100 translate-x-0"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100 translate-x-0"
                     x-transition:leave-end="opacity-0 translate-x-2"
                     class="absolute left-full top-1/2 -translate-y-1/2 ml-4 px-3.5 py-2 bg-slate-950/90 backdrop-blur-md text-white text-xs font-semibold rounded-xl shadow-2xl pointer-events-none whitespace-nowrap z-50 border border-white/15"
                     style="display: none;">
                    System
                </div>
                
                <div x-show="open && !sidebarCollapsed" 
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 -translate-y-1 scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                     class="pl-11 pr-3 py-1.5 flex flex-col gap-1 select-none">
                     <a href="{{ route('admin.whatsapp-diagnostic') }}" class="h-9 flex items-center px-3.5 rounded-lg text-xs transition-colors duration-150 {{ request()->routeIs('admin.whatsapp-diagnostic') ? 'text-cyan-300 font-bold bg-white/10 shadow-inner border border-white/5' : 'text-cyan-100/70 hover:text-white hover:bg-white/5' }}">
                         WhatsApp Diagnostic
                     </a>
                </div>
            </div>
        @endif

    </nav>

    <!-- User Card (Footer Section) -->
    <div class="mt-auto shrink-0 border-t border-white/10" :class="sidebarCollapsed ? 'p-2 py-6' : 'p-4 py-6'">
        @php
            $initials = collect(explode(' ', Auth::user()->name))
                ->map(fn($n) => strtoupper(substr($n, 0, 1)))
                ->take(2)
                ->implode('');
            $roleName = Auth::user()->roles->first()?->name ?? Auth::user()->role ?? 'pelanggan';
        @endphp

        <!-- Expanded View: Glassmorphic User Card -->
        <div x-show="!sidebarCollapsed" 
             x-data="{ showUserMenu: false }" 
             class="bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl p-4 flex flex-col gap-3 transition-all duration-200 shadow-xl select-none relative">
            
            <div class="flex items-center justify-between gap-2.5">
                <div class="flex items-center gap-3 min-w-0">
                    <div class="w-11 h-11 rounded-full bg-cyan-400/30 text-cyan-200 font-bold text-sm flex items-center justify-center shrink-0 border border-cyan-400/40 select-none shadow-md">
                        {{ $initials }}
                    </div>
                    <div class="min-w-0">
                        <h4 class="font-bold text-white text-[13px] truncate leading-tight">{{ Auth::user()->name }}</h4>
                        <p class="text-[11px] text-cyan-200/75 truncate mt-0.5">{{ Auth::user()->email }}</p>
                        <span class="inline-block mt-1.5 px-2 py-0.5 text-[9px] font-bold bg-cyan-400/20 text-cyan-300 rounded-md uppercase tracking-wider select-none leading-none border border-cyan-400/20">
                            {{ $roleName }}
                        </span>
                    </div>
                </div>
                
                <!-- Menu Toggle Button -->
                <button @click="showUserMenu = !showUserMenu" 
                        class="p-1.5 rounded-lg hover:bg-white/15 text-cyan-200 hover:text-white transition-colors duration-150 focus:outline-none"
                        aria-label="User Options">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"/>
                    </svg>
                </button>
            </div>

            <!-- Inline Options with transition -->
            <div x-show="showUserMenu" 
                 x-transition:enter="transition ease-out duration-150"
                 x-transition:enter-start="opacity-0 -translate-y-2 scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                 x-transition:leave="transition ease-in duration-100"
                 x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                 x-transition:leave-end="opacity-0 -translate-y-2 scale-95"
                 class="border-t border-white/10 pt-2.5 flex flex-col gap-1 select-none"
                 style="display: none;">
                 
                <a href="{{ route('profile.edit') }}" class="text-xs text-cyan-100 hover:text-white transition-colors duration-150 flex items-center gap-2.5 py-2 px-2.5 rounded-xl hover:bg-white/5">
                    <svg class="w-4 h-4 text-cyan-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                    </svg>
                    Edit Profil
                </a>
                
                <form method="POST" action="{{ route('logout') }}" class="m-0">
                    @csrf
                    <button type="submit" class="w-full text-left text-xs text-red-300 hover:text-red-200 transition-colors duration-150 flex items-center gap-2.5 py-2 px-2.5 rounded-xl hover:bg-white/5 focus:outline-none">
                        <svg class="w-4 h-4 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                        </svg>
                        Logout
                    </button>
                </form>
            </div>
        </div>

        <!-- Collapsed View: Just Avatar & Logout Icons -->
        <div x-show="sidebarCollapsed" class="flex flex-col items-center gap-4 py-2" style="display: none;">
            <div class="relative group" x-data="{ hovered: false }" @mouseenter="hovered = true" @mouseleave="hovered = false">
                <div class="w-11 h-11 rounded-full bg-cyan-400/30 text-cyan-200 font-bold text-sm flex items-center justify-center border border-cyan-400/40 select-none shadow-md">
                    {{ $initials }}
                </div>
                <div x-show="hovered" 
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 translate-x-2"
                     x-transition:enter-end="opacity-100 translate-x-0"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100 translate-x-0"
                     x-transition:leave-end="opacity-0 translate-x-2"
                     class="absolute left-full top-1/2 -translate-y-1/2 ml-4 px-3.5 py-2 bg-slate-900/90 backdrop-blur-md text-white text-xs font-semibold rounded-xl shadow-2xl pointer-events-none whitespace-nowrap z-50 border border-white/15"
                     style="display: none;">
                    <p class="font-bold mb-0.5 leading-none">{{ Auth::user()->name }}</p>
                    <p class="text-[10px] text-cyan-300 leading-none mt-1.5">{{ strtoupper($roleName) }}</p>
                </div>
            </div>
            
            <div class="relative group" x-data="{ hovered: false }" @mouseenter="hovered = true" @mouseleave="hovered = false">
                <form method="POST" action="{{ route('logout') }}" class="m-0">
                    @csrf
                    <button type="submit" class="p-2.5 rounded-xl bg-white/5 hover:bg-red-500/20 text-cyan-200 hover:text-red-300 transition-all duration-200 focus:outline-none flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                        </svg>
                    </button>
                </form>
                <div x-show="hovered" 
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 translate-x-2"
                     x-transition:enter-end="opacity-100 translate-x-0"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100 translate-x-0"
                     x-transition:leave-end="opacity-0 translate-x-2"
                     class="absolute left-full top-1/2 -translate-y-1/2 ml-4 px-3.5 py-2 bg-slate-900/90 backdrop-blur-md text-white text-xs font-semibold rounded-xl shadow-2xl pointer-events-none whitespace-nowrap z-50 border border-white/15"
                     style="display: none;">
                    Logout
                </div>
            </div>
        </div>

    </div>

</aside>
